<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ProceedTopupTransactionRequest extends FormRequest
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
            'request_id' => ['integer', 'required', Rule::exists(table: 'transaction_requests', column: 'id')],
        ];
    }

    public function getRequestId(): int {
        return (int) $this->request_id;
    }
   
    protected function prepareForValidation(): void {
        $this->merge(['request_id' => $this->request_id]);       
    }
}
