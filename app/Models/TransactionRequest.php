<?php

namespace App\Models;

use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionRequest extends Model
{
    use HasFactory;

    #Region Properties
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
    protected $table = 'transaction_requests';

    protected $casts = [
        'amount' => 'integer',
        'type' => TransactionRequestType::class,
        'created_at' => 'datetime',
    ];

    #endregion

    public function partner(): BelongsTo
    {
        return $this->belongsTo(
            related: Partner::class,
            foreignKey: 'partner_id'
        );
    }
    public function transaction(): HasOne 
    {
        return $this->hasOne(Transaction::class, 'request_id');
    }
    public function scopeAmountBetween(Builder $query, $amountFrom, $amountTo): Builder
    {
        return $query->whereBetween('amount', [$amountFrom, $amountTo]);
    }

    public function scopeBankAccountNumber(Builder $query, $bankAccountNumber): Builder
    {
        return $query->whereRelation('partner', 'bank_account_number', 'LIKE', '%'.$bankAccountNumber.'%');
    }
    public function scopeBankAccountName(Builder $query, $bankAccountName): Builder
    {
        return $query->whereRelation('partner', 'bank_account_name', 'ILIKE', '%'.$bankAccountName.'%');
    }
    public function scopeBankCode(Builder $query, $bankCode): Builder
    {
        return $query->whereRelation('partner', 'bank_code', 'ILIKE', '%'.$bankCode.'%');
    }

    public function scopeIsProceeded(Builder $query, bool $isProceeded): Builder
    {
        if ((bool)$isProceeded) {
            return $query->has('transaction');
        }
        return $query->doesntHave('transaction');
    }

    public function scopeCreatedBetween(Builder $query, string $dateFrom, string $dateTo): Builder
    {
        return $query->whereBetween('transaction_requests.created_at', [$dateFrom, $dateTo]);
    }
}
