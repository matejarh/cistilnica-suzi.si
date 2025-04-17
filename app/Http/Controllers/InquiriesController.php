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
        $perPage = $request->get('per_page', 12);
        // Fetch inquiries from the database
        $inquiries = Inquiry::filter($request->only(['search', 'trashed', 'status']))
        ->latest()
        ->paginate($perPage, ['*'], 'stran')
        ->appends($request->except('page'));

        // Return the view with inquiries data
        return inertia('Inquiries/Index', [
            'inquiries' => $inquiries,
            'filters' => $request->only(['search', 'trashed', 'status', 'per_page' => $perPage]),
            /* 'links' => $inquiries->links('vendor.pagination.tailwind', [
                'onEachSide' => 3,
            ])->toHtml(), */
            /* 'pagination' => [
                'current_page' => $inquiries->currentPage(),
                'last_page' => $inquiries->lastPage(),
                'per_page' => $inquiries->perPage(),
                'total' => $inquiries->total(),
                'links' => $inquiries->linkCollection(), // Use the paginator's link collection
            ], */
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
        $validated = $this->validateInquiry($request);

        $email = $validated['email'];

        // Generate a unique confirmation token
        $token = hash_hmac('sha256', uniqid($email, true), config('app.key'));

        // Store the hashed token and email in the session
        session([
            "inquiry_confirmation_$token" => [
                'data' => $validated,
                'token' => $token,
            ]
        ]);

        // Send confirmation email
        \Mail::send('emails.confirm-inquiry', ['token' => $token, 'email' => encrypt($validated['email']), 'data' => $validated], function ($message) use ($email) {
            $message->to($email)
                ->subject('Potrdite povpraševanje');
        });

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
        $token = $request->input('token');
        $sessionKey = "inquiry_confirmation_$token";

        $this->validateSession($sessionKey, $request);

        $email = session("inquiry_confirmation_$token.email");
        $data = session("inquiry_confirmation_$token.data");


        // Create a new inquiry
        $inquiry = Inquiry::create($data + [
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Clear the session data
        session()->forget($sessionKey);

        $adminEmail = "matej.arh@gmail.com";
        // Send email to the admin
        \Mail::send('emails.new-inquiry', ['inquiry' => $inquiry], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                ->subject('Novo povpraševanje');
        });

        return $this->flashAndRedirect('Uspešno ste poslali poizvedbo. Oglasili se vam bomo v najkrajšem času', 'public.home');
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
        return $this->flashAndRedirect('Povpraševanje uspešno izbrisano.', 'inquiries.index');
        // return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }

    /** Reply to inquiry
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Inquiry $inquiry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(Request $request, Inquiry $inquiry)
    {
        // Validate the request data
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
        ], [
            'reply.required' => 'Odgovor je obvezen.',
            'reply.string' => 'Odgovor mora biti veljaven niz.',
            'reply.max' => 'Odgovor ne sme biti daljši od 1000 znakov.',
        ]);

        // Send email to the inquiry's email address
        /* \Mail::send('emails.reply-inquiry', ['inquiry' => $inquiry, 'data' => $validated], function ($message) use ($inquiry) {
            $message->to($inquiry->email)
                ->subject('Odgovor na vaše povpraševanje');
        });
 */
        // Flash success message and redirect back
        return $this->flashAndRedirect('Uspešno ste poslali odgovor na povpraševanje.');
    }

    /**
     * Validate the request data for creating or updating an inquiry.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateInquiry(Request $request)
    {
        return $request->validate([
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
            abort(403, 'Seja je potekla ali ni veljavna. Zahtevek mora biti oddan in potrjen v istem brskalniku. Če vam povezava v potrditvenem sporočilu odpre drug brskalnik, kot pa je bil ta v katerem ste vnesli svoj email, bo seja neveljavna!');
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
     * @param string|null $route
     * @return \Illuminate\Http\RedirectResponse
     */
    private function flashAndRedirect(string $message, ?string $route = null)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        return $route
            ? redirect()->route($route)->with('success', $message)
            : redirect()->back()->with('success', $message);
    }
}
