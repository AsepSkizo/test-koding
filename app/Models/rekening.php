<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rekening extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Mendapatkan data target yang terkait dengan rekening
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function target(): HasMany
    {
        return $this->hasMany(target::class, 'id', 'rekening_id');
    }

    /**
     * Mendapatkan data harian yang terkait dengan rekening
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function harian(): HasMany
    {
        return $this->hasMany(harian::class, 'id', 'rekening_id');
    }
}
