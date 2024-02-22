<?php

declare(strict_types=1);

namespace App\Models;

use Domain\CustomerFacing\Enums\PriceStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\BoxSizePrice
 *
 * @property int $id
 * @property int $box_size_id
 * @property Carbon|null $apply_from
 * @property Carbon|null $apply_to
 * @property string|null $name
 * @property int $priority
 * @property string|null $note
 * @property PriceStatus $status 0 - Inactive
 * 1-Active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\BoxSize $boxSize
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PriceItem> $priceItems
 * @property-read int|null $price_items_count
 *
 * @method static Builder|BoxSizePrice active()
 * @method static Builder|BoxSizePrice current()
 * @method static \Database\Factories\BoxSizePriceFactory factory($count = null, $state = [])
 * @method static Builder|BoxSizePrice newModelQuery()
 * @method static Builder|BoxSizePrice newQuery()
 * @method static Builder|BoxSizePrice query()
 * @method static Builder|BoxSizePrice valid()
 * @method static Builder|BoxSizePrice whereApplyFrom($value)
 * @method static Builder|BoxSizePrice whereApplyTo($value)
 * @method static Builder|BoxSizePrice whereBoxSizeId($value)
 * @method static Builder|BoxSizePrice whereCreatedAt($value)
 * @method static Builder|BoxSizePrice whereId($value)
 * @method static Builder|BoxSizePrice whereName($value)
 * @method static Builder|BoxSizePrice whereNote($value)
 * @method static Builder|BoxSizePrice wherePriority($value)
 * @method static Builder|BoxSizePrice whereStatus($value)
 * @method static Builder|BoxSizePrice whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class BoxSizePrice extends Model
{
    use HasFactory;

    #region Properties
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prices';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => PriceStatus::class,
        'apply_from' => 'datetime',
        'apply_to' => 'datetime',
    ];

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function boxSize(): BelongsTo
    {
        return $this->belongsTo(
            related: BoxSize::class,
            foreignKey: 'box_size_id',
            ownerKey: 'id',
        );
    }

    public function priceItems(): HasMany
    {
        return $this->hasMany(
            related: PriceItem::class,
            foreignKey: 'price_id',
            localKey: 'id',
        );
    }

    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include Active Pricetable
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', PriceStatus::Active);
    }

    /**
     * Scope a query to only include Pricetable that is in apply time
     */
    public function scopeCurrent(Builder $query): void
    {
        $query->where('apply_from', '<=', Carbon::now())
            ->where('apply_to', '>=', Carbon::now());
    }

    /**
     * Scope a query to only include Pricetable that is both in apply time and is active
     */
    public function scopeValid(Builder $query): void
    {
        $query->active()->current();
    }
    #endregion
}
