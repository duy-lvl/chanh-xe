<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TemporaryOrderRoute extends Model
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
    protected $table = 'temporary_order_routes';

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function checkpoints(): HasMany
    {
        return $this->hasMany(TemporaryOrderRouteCheckpoint::class);
    }

    #endregion


    protected function totalDistance(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->checkpoints()->sum('distance_from_previous');
            }
        )->shouldCache();
    }
}
