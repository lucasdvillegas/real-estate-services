<?php

namespace App\Http\Controllers;

use App\Models\OperationType;
use App\Http\Requests\OperationTypeRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OperationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('OperationType/Index', [
            'operationTypes' => OperationType::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('OperationType/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperationTypeRequest $request): RedirectResponse
    {
        OperationType::create(
            $request->validated()
        );

        return redirect()
            ->route('operationTypes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperationType $operationType): Response
    {
        return Inertia::render('OperationType/Update', [
            'operationType' => $operationType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperationTypeRequest $request, OperationType $operationType): RedirectResponse
    {
        $operationType->update(
            $request->validated()
        );

        return redirect()
            ->route('operationTypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperationType $operationType): RedirectResponse
    {
        $operationType->delete();

        return redirect()
            ->route('operationTypes.index');
    }
}
