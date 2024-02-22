<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Auth;

use Domain\CustomerFacing\DataTransferObjects\Auth\LoginData;
use Illuminate\Foundation\Http\FormRequest;

final class GetCustomerAccessTokenRequest extends FormRequest
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
            'indentifier' => ['required', 'string'],
            'password' => 'required',
            'device_name' => 'required',
        ];
    }

    public function toDto(): LoginData
    {
        return new LoginData(
            indentifier: $this->indentifier,
            password: $this->password,
            deviceName: $this->device_name,
        );
    }
}
