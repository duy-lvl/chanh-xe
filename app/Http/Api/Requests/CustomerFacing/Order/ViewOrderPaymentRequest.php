<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class ViewOrderPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $orderCustomerId = DB::table('orders')->select('customer_id')->where('code', $this->code)->first()->customer_id ?? Auth::id();

        return $orderCustomerId === Auth::id();
    }
}
