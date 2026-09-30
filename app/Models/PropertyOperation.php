<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyOperation extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyOperationFactory> */
    use HasFactory;

    protected $table = 'property_operations';

    protected $fillable = [
        'operation_type_id',
        'type',
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
}

