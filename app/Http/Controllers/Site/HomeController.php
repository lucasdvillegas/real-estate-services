<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Property;
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
        ]);
    }
}
