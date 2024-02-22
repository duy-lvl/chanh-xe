<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Account;

use Domain\Internal\DataTransferObjects\Account\NewPartnerAccountData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class CreatePartnerAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->can('create partner') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique(table: 'partners', column: 'username')],
            'bank_account_number' => ['required', 'string', 'numeric', Rule::unique(table: 'partners', column: 'bank_account_number')],
            'bank_account_name'  => ['required', 'string'],
            'bank_code'  => ['required', 'string'],
            // 'phones' => ['array'],
            // 'phones.*' => ['string', 'min:10', 'max:11']
        ];
    }

    public function getNewPartnerAccountData(): NewPartnerAccountData
    {
        // $phones = collect($this->phones);
        return new NewPartnerAccountData(
            name: $this->name,
            username: $this->username,
            bankCode: $this->bank_code,
            bankAccountNumber: $this->bank_account_number,
            bankAccountName: $this->bank_account_name,
            // phones: $phones
        );
    }
}
