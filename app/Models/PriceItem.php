<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PriceItem
 *
 * @property int $id
 * @property int $price_id
 * @property float $from_kilometer
 * @property float $to_kilometer
 * @property int $price_per_kilometer
 * @property int $min_amount
 * @property int $max_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BoxSizePrice $price
 *
 * @method static \Database\Factories\PriceItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereFromKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem wherePricePerKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereToKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class PriceItem extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Attributes Settings
    |--------------------------------------------------------------------------
    |
    | Model attribute setting
    |
    */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'price_items';

    protected $casts = [
        'from_kilometer' => 'double',
        'to_kilometer' => 'double',
    ];

    public function price(): BelongsTo
    {
        return $this->belongsTo(BoxSizePrice::class);
    }
}
