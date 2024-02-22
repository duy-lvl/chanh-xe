<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Station;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Domain\Partner\DataTransferObjects\Station\UpdatableStationData;
use Domain\Partner\Enums\StationStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class UpdateStationRequest extends FormRequest
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
            'station_id' => ['required', 'numeric', Rule::exists(table: 'partner_stations', column: 'id')],
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function getUpdatableStationData(): UpdatableStationData
    {
        return new UpdatableStationData(
            id: (int) $this->station_id,
            name: $this->name,
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'station_id' => $this->id,
        ]);
    }
}
