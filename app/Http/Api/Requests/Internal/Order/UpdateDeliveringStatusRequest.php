<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateDeliveringStatusRequest extends FormRequest
{
    /**
     * Determine if the Internal is authorized to make this request.
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
            'driver_id' => ['required', 'integer', Rule::exists(table: 'partner_drivers', column: 'id')],
            'vehicle_id' => ['required', 'integer', Rule::exists(table: 'partner_vehicles', column: 'id')],
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
}
