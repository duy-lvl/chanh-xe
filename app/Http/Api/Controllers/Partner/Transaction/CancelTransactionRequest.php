<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use Domain\Partner\Actions\Transaction\Write\CancelTransactionRequestContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Partner get transaction
 */
final class CancelTransactionRequest extends Controller
{
    public function __construct(
        private readonly CancelTransactionRequestContract $cancelTransactionRequestAction,
    ) {
    }

    /**
     * Cancel Transaction Request - Handle an incoming cancel transactions request from partner.
     */
    public function __invoke(Request $request, int $id): mixed
    {
        $result = $this->cancelTransactionRequestAction->handle(Auth::id(), $id);
        if (!$result) {
            return abort(message: 'Cancel failed', code: 500);
        }
        return response()->make(status: 204, content: "Cancel successfully");
    }
}
