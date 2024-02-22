<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Profile;

use Auth;
use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;
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
            'phones' => ['array'],
            'phones.*' => ['string', 'min:8', 'max:11', 'distinct', Rule::unique(table: 'partner_phones', column: 'phone')->ignore(Auth::id(), 'partner_id')],
            'description' => ['string'],
        ];
    }

    public function getProfileData(): UpdateProfileData
    {
        return new UpdateProfileData(
            name: $this->name,
            phones: collect($this->phones),
            description: $this->description,
        );
    }
}
