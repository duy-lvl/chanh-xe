<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\CustomerFacing\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $start_station_id
 * @property int $end_station_id
 * @property int|null $customer_id
 * @property string $code
 * @property string $sender_name
 * @property string $sender_phone
 * @property string|null $sender_email
 * @property string $receiver_name
 * @property string $receiver_phone
 * @property string|null $receiver_email
 * @property string|null $note
 * @property int $package_value unit: VND
 * @property int $delivery_price unit: VND
 * @property int $weight unit: kg
 * @property int $height unit: cm
 * @property int $length unit: cm
 * @property int $width unit: cm
 * @property bool $collect_on_delivery
 * @property \Illuminate\Support\Collection<\Domain\CustomerFacing\Enums\PackageType> $package_types 0 - Normal
 * 1 - Food
 * 2 - Chemical
 * 3 - Document
 * 4 - Electronic
 * 5 - Fragile
 * @property PaymentMethod $payment_method 0 - Cash
 * 1 - VNPay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OrderRoute|null $chosenRoute
 * @property-read \App\Models\OrderStatusHistory|null $currentStatus
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\Station $endStation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderRoute> $routes
 * @property-read int|null $routes_count
 * @property-read \App\Models\Station $startStation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderStatusHistory> $statusHistory
 * @property-read int|null $status_history_count
 *
 * @method static Builder|Order createdBetween($dateFrom, $dateTo)
 * @method static Builder|Order deliveryPriceBetween($priceFrom, $priceTo)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order paymentStatus(int $status)
 * @method static Builder|Order query()
 * @method static Builder|Order status(string $status)
 * @method static Builder|Order whereCode($value)
 * @method static Builder|Order whereCollectOnDelivery($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereDeliveryPrice($value)
 * @method static Builder|Order whereEndStationId($value)
 * @method static Builder|Order whereHeight($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereLength($value)
 * @method static Builder|Order whereNote($value)
 * @method static Builder|Order wherePackageTypes($value)
 * @method static Builder|Order wherePackageValue($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order whereReceiverEmail($value)
 * @method static Builder|Order whereReceiverName($value)
 * @method static Builder|Order whereReceiverPhone($value)
 * @method static Builder|Order whereSenderEmail($value)
 * @method static Builder|Order whereSenderName($value)
 * @method static Builder|Order whereSenderPhone($value)
 * @method static Builder|Order whereStartStationId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereWeight($value)
 * @method static Builder|Order whereWidth($value)
 *
 * @mixin \Eloquent
 */
final class Order extends Model
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
    protected $table = 'orders';

    protected $casts = [
        'weight' => 'integer',
        'height' => 'integer',
        'width' => 'integer',
        'length' => 'integer',
        'is_confirmed' => 'boolean',
        'payment_method' => PaymentMethod::class,
        'package_types' => AsEnumCollection::class . ':' . PackageType::class,
        'created_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'is_cancelled' => 'boolean',
        'is_lost' => 'boolean'
    ];

    #endregion

    #region Relationships
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function routeCheckpoints(): HasMany
    {
        return $this->hasMany(
            related: OrderRouteCheckpoint::class,
            foreignKey: 'order_id',
            localKey: 'id',
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(
            related: Payment::class,
            foreignKey: 'order_id',
            localKey: 'id',
        );
    }

    public function startStation(): BelongsTo
    {
        return $this->belongsTo(
            related: Station::class,
            foreignKey: 'start_station_id',
            ownerKey: 'id'
        );
    }

    public function endStation(): BelongsTo
    {
        return $this->belongsTo(
            related: Station::class,
            foreignKey: 'end_station_id',
            ownerKey: 'id'
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            related: Customer::class,
            foreignKey: 'customer_id',
            ownerKey: 'id'
        );
    }

    public function currentCheckpoint(): HasOne
    {
        return $this->hasOne(OrderRouteCheckpoint::class)
            ->ofMany(
                ['checkpoint_number' => 'max'],
                function (Builder $query) {
                    return $query->whereRelation('permissions', 'achieved_at', '<>', null)
                        ->orwhere('checkpoint_number', 1);
                }
            );
    }

    public function lostIncharge(): MorphTo
    {
        return $this->morphTo();
    }
    public function previousCheckpoint(): HasOne
    {
        return $this->hasOne(OrderRouteCheckpoint::class)
            ->ofMany(
                ['checkpoint_number' => 'min'],
                fn (Builder $query) => $query->whereRelation('permissions', 'achieved_at', '<>', null)
            );
    }

    public function lastCheckpoint(): HasOne
    {
        return $this->hasOne(OrderRouteCheckpoint::class)
            ->ofMany(
                ['checkpoint_number' => 'max'],
            );
    }
    public function firstCheckpoint(): HasOne
    {
        return $this->hasOne(OrderRouteCheckpoint::class)
            ->ofMany(
                ['checkpoint_number' => 'min'],
            );
    }
    public function nextCheckpoint(): HasOne
    {
        return $this->hasOne(OrderRouteCheckpoint::class)
            ->ofMany(
                ['checkpoint_number' => 'min'],
                fn (Builder $query) => $query->whereRelation('permissions', 'achieved_at', null)
            );
    }


    #endregion

    #region Scopes
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeCustomerName(Builder $query, $name): Builder
    {
        return $query->where('sender_name', 'ILIKE', "%$name%")->orWhere('receiver_name', 'ILIKE', "%$name%");
    }

    public function scopeCustomerPhone(Builder $query, $phone): Builder
    {
        return $query->where('sender_phone', 'ILIKE', "%$phone%")->orWhere('receiver_phone', 'ILIKE', "%$phone%");
    }

    public function scopeStartPartnerName(Builder $query, $partnerName): Builder
    {
        return $query->whereRelation('startStation.partner', 'name', 'ILIKE', '%' . $partnerName . '%');
    }

    public function scopeEndPartnerName(Builder $query, $partnerName): Builder
    {
        return $query->whereRelation('endStation.partner', 'name', 'ILIKE', '%' . $partnerName . '%');
    }

    public function scopeHeightBetween(Builder $query, $heightFrom, $heightTo): Builder
    {
        return $query->whereBetween('height', [$heightFrom, $heightTo]);
    }

    public function scopeWeightBetween(Builder $query, $weightFrom, $weightTo): Builder
    {
        return $query->whereBetween('weight', [$weightFrom, $weightTo]);
    }

    public function scopeLengthBetween(Builder $query, $lengthFrom, $lengthTo): Builder
    {
        return $query->whereBetween('length', [$lengthFrom, $lengthTo]);
    }

    public function scopeWidthBetween(Builder $query, $widthFrom, $widthTo): Builder
    {
        return $query->whereBetween('width', [$widthFrom, $widthTo]);
    }

    public function scopeCreatedBetween(Builder $query, $dateFrom, $dateTo): Builder
    {
        return $query->whereBetween('created_at', [Carbon::parse($dateFrom), Carbon::parse($dateTo)]);
    }

    public function scopeDeliveryPriceBetween(Builder $query, $priceFrom, $priceTo): Builder
    {
        return $query->whereBetween('delivery_price', [$priceFrom, $priceTo]);
    }

    public function scopeStatus(Builder $query, int|OrderStatus $status): Builder
    {
        $statusEnum = match(true){
            $status instanceof OrderStatus => $status,
            default => OrderStatus::tryFrom($status),
        };

        return match($statusEnum){
            OrderStatus::Cancelled => $query->where('is_cancelled', true),
            OrderStatus::Created => $query->where('is_confirmed', false)->where('is_cancelled', false),
            OrderStatus::Confirmed => $query
                ->where('is_confirmed', true)
                ->where('is_cancelled', false)
                ->where('is_lost', false)
                ->whereRelation('currentCheckpoint',
                    fn (Builder $query) => $query->where('checkpoint_number', 1)
                        ->whereDoesntHave('permissions', fn (Builder $query) => $query->whereNotNull('achieved_at'))
                ),
            OrderStatus::Accepted => $query
                ->where('is_confirmed', true)
                ->where('is_cancelled', false)
                ->where('is_lost', false)
                ->whereRelation('firstCheckpoint',
                    fn (Builder $query) => $query->whereRelation('permissions',
                        fn (Builder $query) => $query->where([
                            ['permission', '=', OrderStatus::Delivering],
                            ['achieved_at', '=', null]
                        ])
                    )
                )->whereRelation('firstCheckpoint',
                    fn ($query) => $query->whereRelation('permissions',
                        fn (Builder $query) => $query->where([
                            ['permission', '=', OrderStatus::Accepted],
                            ['achieved_at', '<>', null]
                        ])
                    )
                ),
            OrderStatus::Delivering => $query
                ->where('is_confirmed', true)
                ->where('is_cancelled', false)
                ->where('is_lost', false)
                ->whereRelation('lastCheckpoint',
                    fn (Builder $query) => $query->whereDoesntHave('permissions', fn (Builder $query) => $query->whereNotNull('achieved_at'))
                )
                ->whereRelation('firstCheckpoint', fn (Builder $query) => $query->whereRelation('permissions',
                    fn (Builder $query) => $query->where([
                        ['permission', '=', OrderStatus::Delivering],
                        ['achieved_at', '<>', null]
                    ]))
                ),
            OrderStatus::Delivered => $query
                ->where('is_confirmed', true)
                ->where('is_cancelled', false)
                ->where('is_lost', false)
                ->whereRelation('lastCheckpoint',
                    fn (Builder $query) => $query->whereRelation('permissions',
                        fn (Builder $query) => $query
                            ->where([
                                ['permission', '=', OrderStatus::Done],
                                ['achieved_at', '=', null]
                            ])
                            ->where([
                                ['permission', '=', OrderStatus::Delivered],
                                ['achieved_at', '<>', null]
                            ])
                        )
                ),
            OrderStatus::Done => $query
                ->where('is_confirmed', true)
                ->where('is_cancelled', false)
                ->where('is_lost', false)
                ->whereRelation('lastCheckpoint',
                    fn (Builder $query) => $query->whereDoesntHave('permissions', fn ($query) => $query->where('achieved_at', null))
                ),
            default => $query,
        };
    }

    public function scopeIsAtStartCheckpoint(Builder $query) : Builder
    {
        return $query->whereRelation('currentCheckpoint', 'checkpoint_number', '=', 1);
    }

    public function scopeIsPassThroughHub(Builder $query, bool $isPassThroughHub): Builder
    {
        if ($isPassThroughHub) {
            return $query->whereHas('routeCheckpoints', function ($query) {
                $query->where('checkpoint_type', (new Hub())->getMorphClass());
            });
        }
        return $query->whereDoesntHave('routeCheckpoints', function ($query) {
            $query->where('checkpoint_type', (new Hub())->getMorphClass());
        });
    }

    public function scopePaymentStatus(Builder $query, int $status): Builder
    {
        $paymentStatus = PaymentStatus::tryFrom($status);

        return match ($paymentStatus) {
            PaymentStatus::Paid => $query->whereHas(
                relation: 'payments',
                callback: function (Builder $query): void {
                    $query->select('order_id')
                        ->havingRaw('orders.delivery_price = sum(value)')
                        ->groupBy('order_id');
                }
            ),
            PaymentStatus::NotPaid => $query->whereHas(
                relation: 'payments',
                callback: function (Builder $query): void {
                    $query->select('order_id')
                        ->havingRaw('orders.delivery_price > sum(value)')
                        ->groupBy('order_id');
                }
            )->orDoesntHave(
                relation: 'payments'
            ),
            default => $query->whereRaw('1 = 2') //dummy value
        };
    }

    public function scopeCurrentPlateNumber(Builder $query, $plateNumber): Builder
    {
        // return $query->whereRelation('nextCheckpoint.vehicle', 'plate_number', 'ILIKE', "%$plateNumber%");
        return $query->isPassThroughHub(true)->whereHas('routeCheckpoints', function ($query) use ($plateNumber) {
            return $query->where('checkpoint_number', 2)->whereRelation('vehicle', 'plate_number', 'ILIKE', "%$plateNumber%");
        });
    }
    #endregion

    #region Methods
    public static function generateToken(): string
    {
        return sprintf(
            '%s%s',
            $tokenEntropy = Str::random(10),
            hash('crc32b', $tokenEntropy)
        );
    }
    #endregion

    #region Accessors and Mutators
    /*
    |--------------------------------------------------------------------------
    | Accessors and Mutators
    |--------------------------------------------------------------------------
    */

    protected function isPaid(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): bool => (int) ($this->payments()->sum('value')) === $attributes['delivery_price'],
        )->shouldCache();
    }

    protected function canBeAccepted(): Attribute
    {
        // nguoi gui tra, tra online, chua tra => ko accept
        return Attribute::make(
            get: fn (mixed $value, array $attributes): bool => ! ( ! $attributes['collect_on_delivery'] && ($attributes['payment_method'] !== PaymentMethod::Cash->value) && ! $this->isPaid),
        );
    }

    protected function canBeDone(): Attribute
    {
        // nguoi nhan tra, tra online, chua tra => ko done
        return Attribute::make(
            get: fn (mixed $value, array $attributes): bool => ! ($attributes['collect_on_delivery'] && ($attributes['payment_method'] !== PaymentMethod::Cash->value) && ! $this->isPaid),
        );
    }

    protected function totalDistance(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->routeCheckpoints()->sum('distance_from_previous'),
        )->shouldCache();
    }

    protected function latestOrderStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ((bool) $this->is_cancelled) {
                    return OrderStatus::Cancelled;
                }
                $result = $this->currentCheckpoint->permissions()->where('achieved_at', '<>', null)
                    ->orderByDesc('permission_number')->select('permission')
                    ->first()?->permission;

                if ($result === null && (bool) $this->is_confirmed) {
                    return OrderStatus::Confirmed;
                }

                return $result ??= OrderStatus::Created;
            }
        )->shouldCache();
    }
    #endregion
}
