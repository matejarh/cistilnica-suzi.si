<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the inquiries.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // Fetch inquiries from the database
        $inquiries = Inquiry::filter($request->only(['search', 'trashed']))->latest()->paginate(10);

        // Return the view with inquiries data
        return inertia('Inquiries/Index', [
            'inquiries' => $inquiries,
            'filters' => $request->only(['search', 'trashed']),
        ]);
    }

    /**
     * Show the form for creating a new inquiry.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Return the view for creating a new inquiry
        return inertia('Inquiries/Create');
    }

    /** Send email with inquiry data and link to confirm it
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendConfirmationEmail(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Ime je obvezno.',
            'name.string' => 'Ime mora biti veljaven niz.',
            'name.max' => 'Ime ne sme biti daljše od 255 znakov.',
            'email.required' => 'E-pošta je obvezna.',
            'email.email' => 'E-pošta mora biti veljavna.',
            'email.max' => 'E-pošta ne sme biti daljša od 255 znakov.',
            'phone.string' => 'Telefon mora biti veljaven niz.',
            'phone.max' => 'Telefon ne sme biti daljši od 20 znakov.',
            'company.string' => 'Podjetje mora biti veljaven niz.',
            'company.max' => 'Podjetje ne sme biti daljše od 255 znakov.',
            'address.string' => 'Naslov mora biti veljaven niz.',
            'address.max' => 'Naslov ne sme biti daljše od 255 znakov.',
            'subject.string' => 'Zadeva mora biti veljaven niz.',
            'subject.max' => 'Zadeva ne sme biti daljša od 255 znakov.',
            'message.required' => 'Sporočilo je obvezno.',
            'message.string' => 'Sporočilo mora biti veljaven niz.',
        ]);

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));

        // Store the hashed token and email in the session
        session([
            'inquiry_confirmation' => [
                'data' => $validated,
                'token' => $token,
            ]
        ]);

        // Send confirmation email
        \Mail::send('emails.confirm-inquiry', ['token' => $token, 'email' => encrypt($validated['email']), 'data' => $validated], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite povpraševanje');
        });
        session()->flash('flash.banner', "Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>$email</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svoje povpraševanje.");
        session()->flash('flash.bannerStyle', 'success');
        // Flash success message and redirect back
        return $this->flashAndRedirect("Potrditveno elektronsko sporočilo je bilo poslano na naslov <b>$email</b>. Prosimo, preverite svojo mapo Prejeto in potrdite svoje povpraševanje.");

    }


    /**
     * Store a newly created and confirmed inquiry in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->validateSession('inquiry_confirmation', $request);

        $email = session('inquiry_confirmation.email');
        $data = session('inquiry_confirmation.data');


        // Create a new inquiry
        $inquiry = Inquiry::create($data + [
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Clear the session data
        session()->forget('inquiry_confirmation');

        $adminEmail = "matej.arh@gmail.com";
        // Send email to the admin
        \Mail::send('emails.new-inquiry', ['inquiry' => $inquiry], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                ->subject('Novo povpraševanje');
        });

        session()->flash('flash.banner', 'Uspešno ste oddali poizvedbo. Oglasili se vam bomo v najkrajšem času');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('public.home')->with('success', 'Uspešno ste oddali poizvedbo. Oglasili se vam bomo v najkrajšem času');
        //return $this->flashAndRedirect('Uspešno ste poslali poizvedbo. Oglasili se vam bomo v najkrajšem času');
    }


    /**
     * Show given inquiry details.
     *
     * @param \App\Models\Inquiry $inquiry
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(Inquiry $inquiry)
    {
        // Return the view with the specific inquiry data
        return inertia('Inquiries/Show', [
            'inquiry' => $inquiry,
        ]);
    }
    public function destroy(Inquiry $inquiry)
    {
        // Soft delete the inquiry
        $inquiry->delete();

        // Redirect back with a success message
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }

    /**
     * Validate session data for confirmation or unsubscription.
     *
     * @param string $sessionKey
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateSession($sessionKey, Request $request)
    {
        $sessionData = session()->get($sessionKey);

        if (!$sessionData) {
            session()->flash('flash.banner', 'Seja je potekla ali ni veljavna.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Seja je potekla ali ni veljavna.');
        }

        if (decrypt($request->input('email')) !== $sessionData['data']['email']) {
            session()->flash('flash.banner', 'Elektronski naslov ni veljaven.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Elektronski naslov ni veljaven.');
        }

        if ($request->input('token') !== $sessionData['token']) {
            session()->flash('flash.banner', 'Neveljaven ali potekel potrditveni žeton.');
            session()->flash('flash.bannerStyle', 'danger');
            abort(403, 'Neveljaven ali potekel potrditveni žeton.');
        }
    }

    /**
     * Flash a success message and redirect back.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function flashAndRedirect($message)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back()->with('success', $message);
    }
}
