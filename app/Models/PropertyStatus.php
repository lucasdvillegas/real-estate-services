<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyStatus extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyStatusFactory> */
    use HasFactory;

    protected $table = 'property_statuses';

    protected $fillable = [
        'name',
        'code',
    ];

    public function operations(): HasMany
    {
        return $this->hasMany(PropertyOperation::class, 'status', 'code');
    }

    public function isInUse(): bool
    {
        return $this->operations()->exists();
    }
}
