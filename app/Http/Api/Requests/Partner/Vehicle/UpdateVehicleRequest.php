<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Vehicle;

use Auth;
use Domain\Partner\DataTransferObjects\Vehicle\UpdateVehicleData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateVehicleRequest extends FormRequest
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
            'id' => ['required','integer', Rule::exists(table: 'partner_vehicles', column: 'id')],
            'type' => ['required', 'string'],
            'plate_number' => ['string', 'min:8', 'max:15', Rule::unique(table: 'partner_vehicles', column: 'plate_number')->ignore($this->id, 'id')->where('partner_id', Auth::id())],
        ];
    }

    public function getVehicleData(): UpdateVehicleData
    {
        return new UpdateVehicleData(
            type: $this->type,
            plateNumber: $this->plate_number,
            id: (int) $this->id,
        );
    }

    protected function prepareForValidation(): void {
        $this->merge(['id' => $this->id]);
    }
}
