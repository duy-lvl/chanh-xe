<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\OrderRoute
 *
 * @property int $id
 * @property int|null $order_id
 * @property int $start_station_id
 * @property int $end_station_id
 * @property int $total_distance
 * @property bool $is_selected
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Station $endStation
 * @property-read \App\Models\OrderRouteSegment|null $firstSegment
 * @property-read \App\Models\OrderRouteSegment|null $lastSegment
 * @property-read \App\Models\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderRouteSegment> $segments
 * @property-read int|null $segments_count
 * @property-read \App\Models\Station $startStation
 *
 * @method static \Database\Factories\OrderRouteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereEndStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereIsSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereStartStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereTotalDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRoute whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class OrderRouteCheckpoint extends Model
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
    protected $table = 'order_route_checkpoints';
    protected $casts = [
        'checkpoint_number' => 'integer',
        'distance_from_previous' => 'integer',
    ];
    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function permissions(): HasMany
    {
        return $this->hasMany(
            related: OrderRoutePermission::class,
            foreignKey: 'order_route_checkpoint_id',
            localKey: 'id'
        );
    }
    public function checkpoint(): MorphTo
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: Order::class,
            foreignKey: 'order_id',
            ownerKey: 'id',
        );
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    #endregion

    #region Accessors and Mutators
    /*
    |--------------------------------------------------------------------------
    | Accessors and Mutators
    |--------------------------------------------------------------------------
    */



    #endregion
}
