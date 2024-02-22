<?php

declare(strict_types=1);

namespace App\Models;

use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Hub
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $endPlace
 * @property-read int|null $end_place_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Staff> $staffs
 * @property-read int|null $staffs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Trip> $startPlace
 * @property-read int|null $start_place_count
 *
 * @method static \Database\Factories\HubFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Hub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hub query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hub whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class Hub extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    protected array $postgisColumns = [
        'geography' => [
            'type' => 'geography',
            'srid' => 4326,
        ],
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    public function staffs(): HasMany
    {
        return $this->hasMany(
            related: Staff::class,
            foreignKey: 'hub_id',
            localKey: 'id',
        );
    }

    public function partnerRouteMilestones(): HasMany
    {
        return $this->hasMany(
            related: RouteMilestone::class,
            foreignKey: 'hub_id',
            localKey: 'id'
        );
    }
    public function temporaryOrderRouteCheckpoints(): MorphMany
    {
        return $this->morphMany(TemporaryOrderRouteCheckpoint::class, 'checkpoint');
    }

    public function orderRouteCheckpoints(): MorphMany
    {
        return $this->morphMany(OrderRouteCheckpoint::class, 'checkpoint');
    }

}
