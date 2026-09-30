<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperationType extends Model
{
    /** @use HasFactory<\Database\Factories\OperationTypeFactory> */
    use HasFactory;

    protected $table = 'operation_types';

    protected $fillable = [
        'name',
        'code',
    ];

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_operations');
    }
}
