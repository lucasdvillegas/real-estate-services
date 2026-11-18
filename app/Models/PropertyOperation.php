<?php

namespace App\Models;

use Database\Factories\PropertyOperationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyOperation extends Model
{
    /** @use HasFactory<PropertyOperationFactory> */
    use HasFactory;

    protected $table = 'property_operations';

    protected $fillable = [
        'operation_type_id',
        'price',
        'currency',
        'status',
        'property_id',
    ];

    protected $casts = [];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PropertyStatus::class, 'status', 'code');
    }

    /**
     * Same relation as status() but with a distinct name, so it can be
     * eager loaded and read without colliding with the `status` column.
     */
    public function propertyStatus(): BelongsTo
    {
        return $this->belongsTo(PropertyStatus::class, 'status', 'code');
    }
}
