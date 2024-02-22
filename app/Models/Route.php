<?php

declare(strict_types=1);

namespace App\Models;

use Domain\CustomerFacing\Enums\PackageType;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Route
 *
 * @property int $id
 * @property int $partner_id
 * @property int $start_city_code
 * @property int $end_city_code
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RouteSegment> $segments
 * @property-read int|null $segments_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereEndCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereStartCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class Route extends Model
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
    protected $table = 'partner_routes';

    protected $casts = [
        'package_types' => AsEnumCollection::class . ':' . PackageType::class,
        'created_at' => 'datetime',
    ];

    public function milestones(): HasMany
    {
        return $this->hasMany(
            related: RouteMilestone::class,
            foreignKey : 'partner_route_id',
            localKey: 'id',
        );
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(
            related: Partner::class,
            foreignKey : 'partner_id',
            ownerKey: 'id',
        );
    }
}
