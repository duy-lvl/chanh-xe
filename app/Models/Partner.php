<?php

declare(strict_types=1);

namespace App\Models;


use Domain\Partner\Enums\WalletType;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $username
 * @property mixed $password
 * @property string $name
 * @property string|null $email
 * @property AccountStatus $status 0-Inactive
 *  1-Active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Wallet|null $cobWallet
 * @property-read \App\Models\Wallet|null $mainWallet
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderRoute> $orderRoutesThroughEndStation
 * @property-read int|null $order_routes_through_end_station_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderRoute> $orderRoutesThroughStartStation
 * @property-read int|null $order_routes_through_start_station_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderStatusHistory> $orderStatusHistory
 * @property-read int|null $order_status_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PartnerPhone> $phones
 * @property-read int|null $phones_count
 * @property-read \App\Models\Wallet|null $revenueWallet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Station> $stations
 * @property-read int|null $stations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wallet> $wallets
 * @property-read int|null $wallets_count
 *
 * @method static \Database\Factories\PartnerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereUsername($value)
 *
 * @mixin \Eloquent
 */
final class Partner extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

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
    protected $table = 'partners';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'status' => AccountStatus::class,
    ];

    public function lostOrder(): MorphMany
    {
        return $this->morphMany(Order::class, 'lost_incharge');
    }
    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(
            related: Route::class,
            foreignKey: 'partner_id',
            localKey: 'id',
        );
    }
    public function drivers(): HasMany
    {
        return $this->hasMany(
            related: Driver::class,
            foreignKey: 'partner_id',
            localKey: 'id',
        );
    }
    public function vehicles(): HasMany
    {
        return $this->hasMany(
            related: Vehicle::class,
            foreignKey: 'partner_id',
            localKey: 'id',
        );
    }
    public function transactionRequests(): HasMany
    {
        return $this->hasMany(
            related: TransactionRequest::class,
            foreignKey: 'partner_id',
            localKey: 'id',
        );
    }
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function mainWallet(): HasOne
    {
        return $this->wallets()->one()->ofMany(['created_at' => 'max'], fn ($query) => $query->where('type', WalletType::Cash));
    }

    public function revenueWallet(): HasOne
    {
        return $this->wallets()->one()->ofMany(['created_at' => 'max'], fn ($query) => $query->where('type', WalletType::Revenue));
    }

    public function cobWallet(): HasOne
    {
        return $this->wallets()->one()->ofMany(['created_at' => 'max'], fn ($query) => $query->where('type', WalletType::CollectionOnBehalf));
    }

    public function phones(): HasMany
    {
        return $this->hasMany(
            related: PartnerPhone::class,
            foreignKey: 'partner_id',
            localKey: 'id',
        );
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: function (){
                $wallets = $this->wallets()->select('balance', 'type')->get();
                $result = 0;
                foreach($wallets as $wallet){
                    if ($wallet->type === WalletType::CollectionOnBehalf){
                        $result -= $wallet->balance;
                    }
                    else $result += $wallet->balance;
                }
                return $result;
            },

        )->shouldCache();
    }
}
