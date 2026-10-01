<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyOperation;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\PropertyImage;
use App\Http\Requests\PropertyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\File;

class PropertyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Property/Index', [
            'properties' => Property::with(['propertyType', 'operations.operationType', 'operations.status'])->latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Property/Create', [
            'propertyTypes' => PropertyType::query()->orderBy('name')->get(['code', 'name']),
            'propertyStatuses' => PropertyStatus::query()->orderBy('name')->get(['code', 'name']),
            'currencies' => \App\Models\Currency::query()->orderBy('code')->get(['code', 'name']),
            'operationTypes' => \App\Models\OperationType::query()->orderBy('name')->get(['id', 'code', 'name']),
        ]);
    }

    public function store(PropertyRequest $request): RedirectResponse
    {
        $data = $request->validatedProperty();
        $slug = Str::slug($data['title'] . '-' . $data['property_type_id']);

        if (Property::where('slug', $slug)->exists()) {
            return Redirect::back()->withErrors(['slug' => 'Ya existe una propiedad con este título y tipo. Por favor, modifica alguno de estos campos.'])->withInput();
        }

        $property = Property::create(array_merge(
            $data,
            ['slug' => $slug]
        ));

        foreach ($request->validatedOperations() as $operationData) {
            PropertyOperation::create([
                'property_id' => $property->id,
                'operation_type_id' => $operationData['operation_type_id'],
                'price' => $operationData['price'],
                'currency' => $operationData['currency'],
                'status' => $operationData['status'],
            ]);
        }

        if ($request->filled('images')) {
            $paths = array_values(array_filter(array_map('trim', explode("\n", $request->input('images')))));
            foreach ($paths as $index => $path) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => $path,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('properties.index');
    }

    public function edit(Property $property): Response
    {
        $operations = $property->operations()->orderBy('id')->get(['operation_type_id', 'price', 'currency', 'status']);
        $images = $property->images()->orderBy('sort_order')->get(['path']);
        $property->load('propertyType');

        return Inertia::render('Property/Update', [
            'property' => $property,
            'propertyTypes' => PropertyType::query()->orderBy('name')->get(['id', 'code', 'name']),
            'propertyStatuses' => PropertyStatus::query()->orderBy('name')->get(['code', 'name']),
            'currencies' => \App\Models\Currency::query()->orderBy('code')->get(['code', 'name']),
            'operationTypes' => \App\Models\OperationType::query()->orderBy('name')->get(['id', 'code', 'name']),
            'operations' => $operations->map(fn($operation) => [
                'operation_type_id' => $operation->operation_type_id,
                'price' => $operation->price,
                'currency' => $operation->currency,
                'status' => $operation->status,
            ]),
            'images' => $images->map(fn($image) => $image->path)->implode("\n"),
            'propertyTypeCode' => $property->propertyType?->code,
        ]);
    }

    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        $data = $request->validatedProperty();
        $slug = Str::slug($data['title'] . '-' . $data['property_type_id']);

        if (Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
            return Redirect::back()->withErrors(['slug' => 'Ya existe una propiedad con este título y tipo. Por favor, modifica alguno de estos campos.'])->withInput();
        }

        $property->update(array_merge(
            $data,
            ['slug' => $slug]
        ));

        $property->operations()->delete();

        foreach ($request->validatedOperations() as $operationData) {
            PropertyOperation::create([
                'property_id' => $property->id,
                'operation_type_id' => $operationData['operation_type_id'],
                'price' => $operationData['price'],
                'currency' => $operationData['currency'],
                'status' => $operationData['status'],
            ]);
        }

        if ($request->has('images')) {
            $imagesInput = $request->input('images');

            $newPaths = is_array($imagesInput)
                ? $imagesInput
                : array_values(array_filter(array_map('trim', explode("\n", $imagesInput))));

            $existingPaths = $property->images()->pluck('path')->all();

            $pathsToDelete = array_diff($existingPaths, $newPaths);
            foreach ($pathsToDelete as $path) {
                $this->deletePublicImage($path);
            }

            $property->images()->delete();

            foreach ($newPaths as $index => $path) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => $path,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('properties.index');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->images()->get()->each(function ($image) {
            $this->deletePublicImage($image->path);
        });

        $property->delete();

        return redirect()->route('properties.index');
    }

    private function deletePublicImage(string $path): void
    {
        $relative = ltrim(parse_url($path, PHP_URL_PATH) ?? '', '/');
        if (str_starts_with($relative, 'images/property-images/')) {
            $file = public_path($relative);
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function uploadImages(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|file|image|max:5120',
        ]);

        $targetDir = public_path('images/property-images');
        if (!is_dir($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $paths = [];
        foreach ($request->file('images', []) as $file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($targetDir, $filename);
            $paths[] = '/images/property-images/' . $filename;
        }

        return response()->json(['paths' => $paths]);
    }
}
