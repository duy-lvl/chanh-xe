<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;
   
    protected $table = 'partner_drivers';
    protected $casts = [
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopePartnerName(Builder $query, $name): Builder
    {
        return $query->whereRelation('partner','name', 'ILIKE', "%$name%");
    }
}
