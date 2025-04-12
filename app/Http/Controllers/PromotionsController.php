<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia()->render('Promotions/Index', [
            'promotions' => Promotion::filter($request->get('search'), $request->get('trashed'))
                ->latest()
                ->paginate(10),
            'filters' => $request->only('search', 'trashed'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return inertia()->render('Promotions/Show', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return inertia()->render('Promotions/Edit', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validatePromotion($request);

        Promotion::create($request->all());

        return $this->redirectWithMessage('promotions.index', __('Akcija uspešno ustvarjena'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $this->validatePromotion($request, true);

        $promotion->update($request->all());

        return $this->redirectWithMessage('promotions.index', __('Akcija uspešno posodobljena'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return $this->redirectWithMessage('promotions.index', __('Akcija uspešno izbrisana'));
    }

    /** Send given promotion to all active subscribers
     * @param Promotion $promotion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Promotion $promotion)
    {
        $promotion->sendToSubscribers();

        return $this->redirectWithMessage('promotions.index', __('Akcija se uspešno pošilja vsem aktivnim naročnikom'));
    }

    /**
     * Validate promotion data.
     */
    private function validatePromotion(Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];

        if ($isUpdate) {
            $rules['start_date'] = 'required|date';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        }

        $messages = [
            'start_date.before' => __('Začetni datum mora biti pred končnim datumom.'),
            'start_date.required' => __('Začetni datum je obvezen.'),
            'start_date.date' => __('Začetni datum mora biti veljaven datum.'),
            'end_date.after' => __('Končni datum mora biti po začetnem datumu.'),
            'end_date.required' => __('Končni datum je obvezen.'),
            'end_date.date' => __('Končni datum mora biti veljaven datum.'),
            'name.required' => __('Ime promocije je obvezno.'),
            'name.string' => __('Ime promocije mora biti besedilo.'),
            'name.max' => __('Ime promocije ne sme biti daljše od 255 znakov.'),
            'description.required' => __('Opis promocije je obvezen.'),
            'description.string' => __('Opis promocije mora biti besedilo.'),
        ];

        $request->validate($rules, $messages);
    }

    /**
     * Flash a success message and redirect to a route.
     */
    private function redirectWithMessage($route, $message)
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route($route)->with('success', $message);
    }
}
