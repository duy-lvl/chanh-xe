<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Profile;

use Auth;
use Domain\CustomerFacing\DataTransferObjects\Profile\UpdateProfileData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string', 'min:8', 'max:11'],
        ];
    }

    public function toProfileData(): UpdateProfileData
    {
        return new UpdateProfileData(
            id: Auth::id(),
            name: $this->name,
            phone: $this->phone,
            email: $this->email
        );
    }
}
