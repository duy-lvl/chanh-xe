<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Auth;

use Domain\CustomerFacing\DataTransferObjects\Auth\NewCustomerData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:8', 'max:11', Rule::unique(table: 'customers', column: 'phone')],
            'password' => ['required', 'confirmed', Password::defaults()],
            //device_name to create tokens
            'device_name' => ['required'],
            //not required
            'email' => ['string', 'email', 'max:255', Rule::unique(table: 'customers', column: 'email')],
        ];
    }

    public function toDto(): NewCustomerData
    {
        return new NewCustomerData(
            name: $this->name,
            phone: $this->phone,
            password: $this->password,
            email: $this->email,
        );
    }
}
