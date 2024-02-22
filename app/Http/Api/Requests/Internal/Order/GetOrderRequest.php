<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Order;

use App\Http\Api\Requests\HasPagingData;
use Illuminate\Foundation\Http\FormRequest;

final class GetOrderRequest extends FormRequest
{
    use HasPagingData;

    /**
     * Determine if the partner is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
        ];
    }
}
