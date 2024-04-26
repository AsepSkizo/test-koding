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
        return $this->hasMany(target::class, 'kode_rekening', 'kode_rekening');
    }

    /**
     * Mendapatkan data harian yang terkait dengan rekening
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function harian(): HasMany
    {
        return $this->hasMany(harian::class, 'kode_rekening', 'kode_rekening');
    }
}
