<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Public home page: hero, editorial sections and the latest properties.
     */
    public function __invoke(): View
    {
        $properties = Property::query()
            ->with([
                'propertyType',
                'images',
                'operations.operationType',
                'operations.propertyStatus',
            ])
            ->latest()
            ->take(6)
            ->get();

        return view('site.home', [
            'properties' => $properties,
            'stats' => [
                ['value' => (string) Property::count(), 'label' => 'Propiedades publicadas'],
                ['value' => (string) PropertyType::count(), 'label' => 'Tipos de propiedad'],
                ['value' => config('site.metrics.years').'+', 'label' => 'Años de experiencia'],
                ['value' => config('site.metrics.operations').'+', 'label' => 'Operaciones cerradas'],
            ],
        ]);
    }
}
