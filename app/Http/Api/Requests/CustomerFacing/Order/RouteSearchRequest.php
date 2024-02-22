<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Order;

use Domain\CustomerFacing\Enums\PackageType;
use Domain\Shared\DataTransferObjects\PositionCodeData;
use Domain\Shared\DataTransferObjects\PositionData;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class RouteSearchRequest extends FormRequest
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
            'start_latitude' => ['required_with:start_longitude', 'required_without_all:start_city_code,start_district_code', 'numeric'],
            'start_longitude' => ['required_with:start_latitude', 'required_without_all:start_city_code,start_district_code', 'numeric'],
            'start_city_code' => ['required_with:start_district_code', 'required_without_all:start_latitude,start_longitude', 'numeric'],
            'start_district_code' => ['required_with:start_city_code', 'required_without_all:start_latitude,start_longitude', 'numeric'],
            'maximum_distance_to_start' => ['integer', 'min:2000', 'max:30000'],
            'end_latitude' => ['required_with:end_longitude', 'required_without_all:end_city_code,end_district_code', 'numeric'],
            'end_longitude' => ['required_with:end_latitude', 'required_without_all:end_city_code,end_district_code', 'numeric'],
            'end_city_code' => ['required_with:end_district_code', 'required_without_all:end_latitude,end_longitude', 'numeric'],
            'end_district_code' => ['required_with:end_city_code', 'required_without_all:end_latitude,end_longitude', 'numeric'],
            'number_of_results' => ['integer', 'min:1', 'max:20'],
            'maximum_distance_to_end' => ['integer', 'min:2000', 'max:30000'],
            'package_types' => ['required', 'array'],
            'package_types.*' => ['required', 'integer', Rule::enum(PackageType::class)],
        ];
    }

    public function getStartPosition(): ?PositionData
    {
        if (null === $this->start_latitude) {
            return null;
        }

        return new PositionData(
            latitude: (float) $this->start_latitude,
            longitude: (float) $this->start_longitude,
        );
    }

    public function getStartPositionCodeData(): ?PositionCodeData
    {
        if (null === $this->start_city_code) {
            return null;
        }

        return new PositionCodeData(
            cityCode: $this->start_city_code,
            districtCode: $this->start_district_code,
        );
    }

    public function getStartMaxDistance(): Distance
    {
        return new Distance(
            value: null === $this->maximum_distance_to_start ? 10000 : (int) $this->maximum_distance_to_start,
            unit: LengthUnit::Meter,
        );
    }

    public function getEndPosition(): ?PositionData
    {
        if (null === $this->end_latitude) {
            return null;
        }

        return new PositionData(
            latitude: (float) $this->end_latitude,
            longitude: (float) $this->end_longitude,
        );
    }

    public function getEndPositionCodeData(): ?PositionCodeData
    {
        if (null === $this->end_city_code) {
            return null;
        }

        return new PositionCodeData(
            cityCode: $this->end_city_code,
            districtCode: $this->end_district_code,
        );
    }

    public function getEndMaxDistance(): Distance
    {
        return new Distance(
            value: null === $this->maximum_distance_to_end ? 10000 : (int) $this->maximum_distance_to_end,
            unit: LengthUnit::Meter,
        );
    }

    public function getNumberOfResults(): int
    {
        return null === $this->number_of_results ? 10 : (int) $this->number_of_results;
    }

    /**
     * @return Collection<PackageType>
     */
    public function getPackageTypes(): Collection
    {
        return collect($this->package_types)->map(fn ($type) => PackageType::from((int) $type));
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if( !isset($this->package_types)){
            return;
        }
        // dd($this->package_types);
        $collection = match (true) {
            is_array($this->package_types) => collect($this->package_types),
            Str::startsWith($this->package_types, '[') && Str::endsWith($this->package_types, ']') => collect(json_decode($this->package_types)),
            default => collect(explode(',', $this->package_types)),
        };

        $this->merge([
            'package_types' => $collection->toArray(),
        ]);
    }
}
