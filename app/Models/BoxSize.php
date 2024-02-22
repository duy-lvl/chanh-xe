<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\BoxSize
 *
 * @property int $id
 * @property int $max_width
 * @property int $max_length
 * @property int $max_height
 * @property int $max_weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BoxSizePrice> $prices
 * @property-read int|null $prices_count
 *
 * @method static \Database\Factories\BoxSizeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class BoxSize extends Model
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
    protected $table = 'box_sizes';

    protected $casts = [
        // 'max_weight' => 'int',
        // 'max_height' => 'int',
        // 'max_length' => 'int',
        // 'max_width' => 'int',
    ];

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function prices(): HasMany
    {
        return $this->hasMany(
            related: BoxSizePrice::class,
            foreignKey: 'box_size_id',
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

    #endregion
}
