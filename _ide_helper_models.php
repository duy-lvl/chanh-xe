<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $username
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\AdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BoxSize
 *
 * @property int $id
 * @property float $max_width
 * @property float $max_length
 * @property float $max_height
 * @property float $max_weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BoxSizePrice> $prices
 * @property-read int|null $prices_count
 * @method static \Database\Factories\BoxSizeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereMaxWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSize whereUpdatedAt($value)
 */
	final class BoxSize extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BoxSizePrice
 *
 * @property int $id
 * @property int $box_size_id
 * @property string $apply_from
 * @property string $apply_to
 * @property string|null $name
 * @property int $priority
 * @property string|null $note
 * @property \Domain\CustomerFacing\Enums\PriceStatus $status 0 - Inactive
 * 1-Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BoxSize $boxSize
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PriceItem> $priceItems
 * @property-read int|null $price_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice active()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice current()
 * @method static \Database\Factories\BoxSizePriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice valid()
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereApplyFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereApplyTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereBoxSizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoxSizePrice whereUpdatedAt($value)
 */
	final class BoxSizePrice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property mixed $password
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Domain\CustomerFacing\Enums\AccountStatus $status 0-Inactive
 *  1-Active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderStatusHistory> $authoredOrderStatuses
 * @property-read int|null $authored_order_statuses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 */
	final class Customer extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Staff> $staffs
 * @property-read int|null $staffs_count
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
 */
	final class Hub extends \Eloquent {}
}

namespace App\Models{
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
 * @property \Illuminate\Support\Collection<PackageType> $package_types 0 - Normal
 * 1 - Food
 * 2 - Chemical
 * 3 - Document
 * 4 - Electronic
 * 5 - Fragile
 * @property \Domain\CustomerFacing\Enums\PaymentMethod $payment_method 0 - Cash
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
 * @method static \Illuminate\Database\Eloquent\Builder|Order createdBetween($dateFrom, $dateTo)
 * @method static \Illuminate\Database\Eloquent\Builder|Order deliveryPriceBetween($priceFrom, $priceTo)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order paymentStatus(int $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order status(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCollectOnDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEndStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackageTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiverEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReceiverPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSenderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSenderPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStartStationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWidth($value)
 */
	final class Order extends \Eloquent {}
}

namespace App\Models{
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
 */
	final class OrderRoute extends \Eloquent {}
}

namespace App\Models{
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
 */
	final class OrderRouteSegment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatusHistory
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $authorable_type
 * @property int|null $authorable_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Domain\CustomerFacing\Enums\OrderStatus $status 0 - Created
 * 1 - Confirmed
 * 2 - Delivering
 * 3 - Delivered
 * 4 - Done
 * 5 - Cancel
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $author
 * @property-read \App\Models\Order $order
 * @method static \Database\Factories\OrderStatusHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereAuthorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereAuthorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereStatus($value)
 */
	final class OrderStatusHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $username
 * @property mixed $password
 * @property string $name
 * @property string|null $email
 * @property \Domain\Shared\Enums\AccountStatus $status 0-Inactive
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
 */
	final class Partner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PartnerPhone
 *
 * @property int $id
 * @property int $partner_id
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PartnerPhoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartnerPhone whereUpdatedAt($value)
 */
	class PartnerPhone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $order_id
 * @property int $value
 * @property string|null $vnpay_transaction_code
 * @property \Domain\CustomerFacing\Enums\PaymentMethod $payment_method 0 - Cash
 * 1 - VNPay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereVnpayTransactionCode($value)
 */
	final class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PriceItem
 *
 * @property int $id
 * @property int $price_id
 * @property float $from_kilometer
 * @property float $to_kilometer
 * @property int $price_per_kilometer
 * @property int $min_amount
 * @property int $max_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BoxSizePrice $price
 * @method static \Database\Factories\PriceItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereFromKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem wherePriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem wherePricePerKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereToKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceItem whereUpdatedAt($value)
 */
	final class PriceItem extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Route extends \Eloquent {}
}

namespace App\Models{
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
 */
	final class RouteSegment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Staff
 *
 * @property int $id
 * @property int|null $hub_id
 * @property string $username
 * @property string|null $email
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Hub|null $hub
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereHubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUsername($value)
 */
	class Staff extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RouteSegment> $endRouteSegments
 * @property-read int|null $end_route_segments_count
 * @property-read \App\Models\Partner $partner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RouteSegment> $startRouteSegments
 * @property-read int|null $start_route_segments_count
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
 */
	final class Station extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $amount
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction amountBetween(int $amountFrom, int $amountTo)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction createdBetween(string $dateFrom, string $dateTo)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction type(int $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereWalletId($value)
 */
	final class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Trip
 *
 * @property int $id
 * @property string $start_place_type
 * @property int $start_place_id
 * @property string $end_place_type
 * @property int $end_place_id
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property string|null $vehicle_plate_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $endPlace
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $startPlace
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereEndPlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereEndPlaceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStartPlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStartPlaceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereVehiclePlateNumber($value)
 */
	class Trip extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string $phone
 * @property mixed $password
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Domain\CustomerFacing\Enums\AccountStatus $status 0-Inactive\n 1-Active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property int $partner_id
 * @property int $balance
 * @property \Domain\Partner\Enums\WalletType $type 0 - Cash
 * 1 - Revenue
 * 2 - CollectionOnBehalf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Partner $partner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 */
	final class Wallet extends \Eloquent {}
}

