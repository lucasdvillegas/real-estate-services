<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyType extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyTypeFactory> */
    use HasFactory;

    protected $table = 'property_types';

    protected $fillable = [
        'name',
        'code',
    ];

    public function properties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function propertyFeatures(): BelongsToMany
    {
        return $this->belongsToMany(PropertyFeature::class, 'property_property_feature');
    }
}
