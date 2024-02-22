<?php

declare(strict_types=1);

namespace App\Models;

use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\CustomerFacing\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $order_id
 * @property int $value
 * @property string|null $vnpay_transaction_code
 * @property PaymentMethod $payment_method 0 - Cash
 * 1 - VNPay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 *
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
 *
 * @mixin \Eloquent
 */
final class Payment extends Model
{
    use HasFactory;

    #region Properties

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    protected $casts = [
        'value' => 'integer',
        'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
        // 'status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    #endregion

    #region Relationships

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            related: Order::class,
            foreignKey: 'order_id',
            ownerKey: 'id'
        );
    }

    #endregion

    #region Scopes

    #endregion
}
