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

    /**
     * Store a newly created inquiry in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new inquiry
        Inquiry::create($request->all());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Inquiry created successfully.');
    }

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
}
