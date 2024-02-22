<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Order;

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
            'identifier' => ['string', 'max:255'],
        ];
    }

    /**
     * @return null|string
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier ?? null;
    }
}