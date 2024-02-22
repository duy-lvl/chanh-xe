<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Account;

use App\Http\Api\Requests\HasPagingData;
use Illuminate\Foundation\Http\FormRequest;

final class GetPartnerAccountRequest extends FormRequest
{
    use HasPagingData;

    /**
     * Determine if the admin is authorized to make this request.
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
        ];
    }
}
