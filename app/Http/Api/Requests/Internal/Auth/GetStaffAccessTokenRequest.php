<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Auth;

use Domain\Internal\DataTransferObjects\Auth\LoginData;
use Illuminate\Foundation\Http\FormRequest;

final class GetStaffAccessTokenRequest extends FormRequest
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
            'username' => ['required', 'string'],
            'password' => 'required',
            'device_name' => 'required',
        ];
    }

    public function toDto(): LoginData
    {
        return new LoginData(
            username: $this->username,
            password: $this->password,
            deviceName: $this->device_name,
        );
    }
}
