<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 *
 * @method static Builder|Transaction amountBetween(int $amountFrom, int $amountTo)
 * @method static Builder|Transaction createdBetween(string $dateFrom, string $dateTo)
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction type(int $type)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereDescription($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereWalletId($value)
 *
 * @mixin \Eloquent
 */
final class Transaction extends Model
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
    protected $table = 'transactions';

    protected $casts = [
        'created_at' => 'datetime',
    ];

    #endregion

    #region Relationships

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(TransactionRequest::class);
    }

    #endregion

    #region Scopes

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeAmountBetween(Builder $query, int $amountFrom, int $amountTo): Builder
    {
        return $query->whereBetween('amount', [$amountFrom, $amountTo]);
    }

    public function scopeCreatedBetween(Builder $query, string $dateFrom, string $dateTo): Builder
    {
        return $query->whereBetween('transactions.created_at', [$dateFrom, $dateTo]);
    }

    public function scopeType(Builder $query, int $type): Builder
    {
        return $query->where('wallets.type', $type);
    }
}
