<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeature;
use App\Http\Requests\PropertyFeatureRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PropertyFeatureController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('PropertyFeature/Index', [
            'propertyFeatures' => PropertyFeature::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('PropertyFeature/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyFeatureRequest $request): RedirectResponse
    {
        PropertyFeature::create(
            $request->validated()
        );

        return redirect()
            ->route('propertyFeatures.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyFeature $propertyFeature): Response
    {
        return Inertia::render('PropertyFeature/Update', [
            'propertyFeature' => $propertyFeature,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyFeatureRequest $request, PropertyFeature $propertyFeature): RedirectResponse
    {
        $propertyFeature->update(
            $request->validated()
        );

        return redirect()
            ->route('propertyFeatures.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyFeature $propertyFeature): RedirectResponse
    {
        $propertyFeature->delete();

        return redirect()
            ->route('propertyFeatures.index');
    }
}
