<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyFeature extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFeatureFactory> */
    use HasFactory;

    protected $table = 'property_features';

    protected $fillable = [
        'name',
        'code',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_property_feature');
    }
}
