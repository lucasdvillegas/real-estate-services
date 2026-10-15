<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function propertyOperations(): HasMany
    {
        return $this->hasMany(PropertyOperation::class, 'operation_type_id');
    }

    public function isInUse(): bool
    {
        return $this->propertyOperations()->exists();
    }
}
