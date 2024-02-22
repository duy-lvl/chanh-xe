<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Account;

use Domain\Internal\DataTransferObjects\Account\NewStaffAccountData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class CreateStaffAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->can('create staff') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique(table: 'staffs', column: 'email'),
            ],
            'username' => [
                'required',
                'string',
                Rule::unique(table: 'staffs', column: 'username'),
            ],
            'hub_id' => [
                'integer',
                Rule::exists(table: 'hubs', column: 'id'),
            ],
        ];
    }

    public function getNewStaffAccountData(): NewStaffAccountData
    {
        return new NewStaffAccountData(
            email: $this->email,
            username: $this->username,
            hubId: (int) $this->hub_id,
        );
    }
}
