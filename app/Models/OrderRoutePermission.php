<?php

declare(strict_types=1);

namespace App\Models;

use Domain\CustomerFacing\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\OrderRouteSegment
 *
 * @property int $id
 * @property int $order_route_id
 * @property int $hub_id
 * @property int $distance unit: meter
 * @property int $sequence_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hub $hub
 * @property-read \App\Models\OrderRoute $route
 *
 * @method static \Database\Factories\OrderRouteSegmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereHubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereOrderRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereSequenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRouteSegment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class OrderRoutePermission extends Model
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
    protected $table = 'order_route_checkpoint_permissions';
    protected $casts = [
        'permission' => OrderStatus::class,
        'permission_number' => 'integer',
        'achieved_at' => 'datetime'
    ];
    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function routeCheckpoint(): BelongsTo
    {
        return $this->belongsTo(
            related: OrderRouteCheckpoint::class,
            foreignKey: 'order_route_checkpoint_id',
        );
    }


    #endregion
}
