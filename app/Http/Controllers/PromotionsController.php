<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;


class PromotionsController extends Controller
{
    #[Middleware('auth', except: ['active', 'akcije'])]

    /**
     * Prikaže seznam promocij za prijavljenega uporabnika.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->get('per_page', 12);
        // Fetch inquiries from the database
        $promotions = Promotion::active()->filter($request->only(['search', 'trashed', 'status']))
        ->latest()
        ->paginate($perPage, ['*'], 'stran')
        ->appends($request->except('page'));

        return Inertia('Promotions/Index', [
            'promotions' => $promotions,
            'filters' => $request->only(['search', 'trashed', 'status', 'per_page' => $perPage]),
        ]);
    }

    /**
     * Prikaže aktivne promocije za obiskovalce
     *
     * @return Response
     */
    public function active(): Response
    {
        return Inertia('Promotions/Active', [
            'promotions' => Promotion::active()->ongoing()->latest()->get(),
        ]);
    }

    /**
     * Prikaže promocije za obiskovalce.
     *
     * @return Response
     */
    public function akcije(Request $request): Response
    {
        return Inertia('Akcije', [
            'active_promotions' => Promotion::active()->ongoing()->get(),
            'upcoming_promotions' => Promotion::active()->upcoming()->get(),
        ]);
    }

    /**
     * Prikaže izbrano promocijo.
     *
     * @param Promotion $promotion
     * @return Response
     */
    public function show(Promotion $promotion): Response
    {
        return Inertia('Promotions/Show', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Prikaže urejevalnik promocije.
     *
     * @param Promotion $promotion
     * @return Response
     */
    public function edit(Promotion $promotion): Response
    {
        return Inertia('Promotions/Edit', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Shrani novo promocijo.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validatePromotion($request);

        Promotion::create($request->all());

        return $this->flashAndRedirect(__('Akcija uspešno ustvarjena'), 'promotions.index');
    }

    /**
     * Posodobi obstoječo promocijo.
     *
     * @param Request $request
     * @param Promotion $promotion
     * @return RedirectResponse
     */
    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $this->validatePromotion($request, true);

        $promotion->update($request->all());

        return $this->flashAndRedirect(__('Akcija uspešno posodobljena'));
    }

    /**
     * Izbriše promocijo.
     *
     * @param Promotion $promotion
     * @return RedirectResponse
     */
    public function destroy(Promotion $promotion): RedirectResponse
    {
        $promotion->delete();

        return $this->flashAndRedirect(__('Akcija uspešno izbrisana'));
    }

    /**
     * Pošlje promocijo vsem aktivnim naročnikom.
     *
     * @param Promotion $promotion
     * @return RedirectResponse
     */
    public function send(Promotion $promotion): RedirectResponse
    {
        $promotion->sendToSubscribers();

        return $this->flashAndRedirect(__('Akcija se uspešno pošilja vsem aktivnim naročnikom'));
    }

    /**
     * Validira podatke promocije.
     *
     * @param Request $request
     * @param bool $isUpdate
     * @return void
     */
    private function validatePromotion(Request $request, bool $isUpdate = false): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => [
                'required',
                'string',
                'max:500',
                function ($attribute, $value, $fail) {
                    if (trim($value) === '<p></p>') {
                        $fail(__('Opis promocije ne sme vsebovati samo praznih oznak <p></p>.'));
                    }
                },
            ],
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
     * Prikaže uspešno sporočilo in preusmeri.
     *
     * @param string $message
     * @param string|null $route
     * @return RedirectResponse
     */
    private function flashAndRedirect(string $message, ?string $route = null): RedirectResponse
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', 'success');

        return $route
            ? redirect()->route($route)->with('success', $message)
            : redirect()->back()->with('success', $message);
    }
}
