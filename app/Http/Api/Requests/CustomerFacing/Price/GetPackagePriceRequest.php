<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Price;

use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Distance;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Foundation\Http\FormRequest;

final class GetPackagePriceRequest extends FormRequest
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
            'weight' => ['required', 'integer', 'min:0'], //gram
            'height' => ['required', 'integer', 'min:0'], //mm
            'length' => ['required', 'integer', 'min:0'], //mm
            'width' => ['required', 'integer', 'min:0'], //mm
            'distance' => ['required', 'integer', 'min:0'], //meter
        ];
    }

    public function getPackageDimension(): Dimensions
    {
        return new Dimensions(
            width: (int) $this->width,
            height: (int) $this->height,
            length: (int) $this->length,
            unit: LengthUnit::Milimeter,
        );
    }

    public function getPackageWeight(): Weight
    {
        return new Weight(
            value: (int) $this->weight,
            unit: MassUnit::Gram,
        );
    }

    public function getDistance(): Distance
    {
        return new Distance(
            value: (int) $this->distance,
            unit: LengthUnit::Meter,
        );
    }
}
