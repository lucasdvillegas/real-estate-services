<?php

namespace App\Http\Controllers;

use App\Models\PropertyStatus;
use App\Http\Requests\PropertyStatusRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PropertyStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('PropertyStatus/Index', [
            'propertyStatuses' => PropertyStatus::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('PropertyStatus/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyStatusRequest $request): RedirectResponse
    {
        PropertyStatus::create(
            $request->validated()
        );

        return redirect()
            ->route('propertyStatuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyStatus $propertyStatus): Response
    {
        return Inertia::render('PropertyStatus/Update', [
            'propertyStatus' => $propertyStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyStatusRequest $request, PropertyStatus $propertyStatus): RedirectResponse
    {
        $propertyStatus->update(
            $request->validated()
        );

        return redirect()
            ->route('propertyStatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyStatus $propertyStatus): RedirectResponse
    {
        $propertyStatus->delete();

        return redirect()
            ->route('propertyStatuses.index');
    }
}
