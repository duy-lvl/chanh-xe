<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PartnerPhone
 *
 * @property int $id
 * @property int $partner_id
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\PartnerPhoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class PartnerPhone extends Model
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
    protected $table = 'partner_phones';
}
