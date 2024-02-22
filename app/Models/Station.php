<?php

declare(strict_types=1);

namespace App\Models;

use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Domain\Partner\Enums\StationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Station
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $city_code
 * @property int $partner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $endPlace
 * @property-read int|null $end_place_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RouteSegment> $endRouteSegments
 * @property-read int|null $end_route_segments_count
 * @property-read \App\Models\Partner $partner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $startPlace
 * @property-read int|null $start_place_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RouteSegment> $startRouteSegments
 * @property-read int|null $start_route_segments_count
 *
 * @method static \Database\Factories\StationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Station newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Station newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Station query()
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Station whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class Station extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    protected array $postgisColumns = [
        'geography' => [
            'type' => 'geography',
            'srid' => 4326,
        ],
    ];


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
    protected $table = 'partner_stations';

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'status' => StationStatus::class
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(
            related: RouteMilestone::class,
            foreignKey: 'station_id',
            localKey: 'id',
        );
    }

    public function tempRouteCheckpoints(): MorphMany
    {
        return $this->morphMany(related: TemporaryOrderRouteCheckpoint::class, name: 'checkpoint');
    }

    public function orderRouteCheckpoints(): MorphMany
    {
        return $this->morphMany(related: OrderRouteCheckpoint::class, name: 'checkpoint');
    }
}
