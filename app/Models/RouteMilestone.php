<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\RouteSegment
 *
 * @property int $id
 * @property int $start_station_id
 * @property int $end_station_id
 * @property int $partner_route_id
 * @property int $segment_number
 * @property float $estimated_kilometer_from_start
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Station $endStation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Hub> $hubs
 * @property-read int|null $hubs_count
 * @property-read \App\Models\Route $route
 * @property-read \App\Models\Station $startStation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment query()
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereEndStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereEstimatedKilometerFromStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment wherePartnerRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereSegmentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereStartStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RouteSegment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class RouteMilestone extends Model
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
    protected $table = 'partner_route_milestones';

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class, 'partner_route_id');
    }

    public function hubs(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Hub::class,
            table: 'partner_route_milestone_hubs',
            foreignPivotKey: 'partner_route_milestone_id',
            relatedPivotKey: 'hub_id'
        )->withPivot('distance_from_milestone')->withTimestamps();
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(
            related: Station::class,
            foreignKey: 'station_id',
            ownerKey: 'id'
        );
    }
}
