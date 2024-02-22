<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Station;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Domain\Partner\DataTransferObjects\Station\NewStationData;
use Domain\Partner\Enums\StationStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class CreateStationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'required_without_all:latitude,longitude'],
            'longitude' => ['numeric', 'min:-180', 'max:180', 'required_without:address', 'required_with:latitude'],
            'latitude' => ['numeric', 'min:-90', 'max:90', 'required_without:address', 'required_with:longitude'],
            'city_code' => ['required', 'integer', 'min:0', 'max:99'],
            
            'district_code' => ['required', 'integer'],
            'ward_code' => ['integer']
        ];
    }

    public function toDto(): NewStationData
    {
        // dd($this->image);
        return new NewStationData(
            partnerId: Auth::id(),
            name: $this->name,
            address: $this->address ?? null,
            latitude: (float) $this->latitude,
            longitude: (float) $this->longitude,
            cityCode: (int)$this->city_code,
            districtCode: (int) $this->district_code,
            wardCode: $this->ward_code ?? null,
            
            status: StationStatus::Pending,
        );
    }
}
