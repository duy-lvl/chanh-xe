<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Balance;

use Domain\Internal\Enums\StaffRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class GetCustomerDirectPaymentStatisticsRequest extends FormRequest
{
    /**
     * Determine if the internal is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->hasRole(StaffRole::Manager, 'api_internal') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'year' => ['required', 'integer', 'min:2020', 'max:2100'],
        ];
    }

    public function getYear(): int
    {
        return (int) $this->year;
    }
}
