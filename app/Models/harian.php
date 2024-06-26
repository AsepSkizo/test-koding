<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class harian extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Mendapatkan data rekening terkait
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rekening(): BelongsTo
    {
        return $this->belongsTo(rekening::class, 'rekening_id', 'id');
    }
}
