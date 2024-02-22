<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Order;

use Illuminate\Foundation\Http\FormRequest;

final class CancelOrderRequest extends FormRequest
{
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
            'reason' => ['required', 'string'],
        ];
    }

    public function getCancelledReason(): string
    {
        return $this->reason;
    }

}
