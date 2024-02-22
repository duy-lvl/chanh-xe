<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Transaction;

use Illuminate\Foundation\Http\FormRequest;

final class WithdrawRequest extends FormRequest
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
            'amount' => ['integer', 'min:10000', 'required']
        ];
    }

    public function getAmount() {
        return $this->amount;
    }

}
