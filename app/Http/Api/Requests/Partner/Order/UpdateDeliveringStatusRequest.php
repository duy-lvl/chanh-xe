<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Str;

final class UpdateDeliveringStatusRequest extends FormRequest
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
            'driver_id' => ['required', 'integer', Rule::exists(table: 'partner_drivers', column: 'id')->where('partner_id', Auth::id())],
            'vehicle_id' => ['required', 'integer', Rule::exists(table: 'partner_vehicles', column: 'id')->where('partner_id', Auth::id())],
            'code' => ['required', 'string', Rule::exists(table: 'orders', column: 'code')]
        ];
    }

    public function getDriverId(): int
    {
        return (int) $this->driver_id;
    }
    public function getVehicleId(): int
    {
        return (int) $this->vehicle_id;
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function prepareForValidation()
    {
        $this->merge(['code' => Str::lower($this->code)]);
    }
}
