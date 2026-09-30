<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use App\Http\Requests\PropertyTypeRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PropertyTypeController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('PropertyType/Index', [
            'propertyTypes' => PropertyType::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('PropertyType/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyTypeRequest $request): RedirectResponse
    {
        PropertyType::create(
            $request->validated()
        );

        return redirect()
            ->route('propertyTypes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyType $propertyType): Response
    {
        return Inertia::render('PropertyType/Update', [
            'propertyType' => $propertyType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyTypeRequest $request, PropertyType $propertyType): RedirectResponse
    {
        $propertyType->update(
            $request->validated()
        );

        return redirect()
            ->route('propertyTypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $propertyType): RedirectResponse
    {
        $propertyType->delete();

        return redirect()
            ->route('propertyTypes.index');
    }
}
