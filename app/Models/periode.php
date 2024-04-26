<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class periode extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Mendapatkan data target terkait
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function target(): HasMany
    {
        return $this->hasMany(target::class, 'id', 'periode_id');
    }
}
