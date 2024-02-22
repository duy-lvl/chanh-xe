<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Price;

use Domain\Internal\DataTransferObjects\Price\NewBoxData;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class CreateBoxSizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()?->can('create boxSize') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'max_weight' => ['required', 'integer', 'min:1'],
            'max_height' => ['required', 'integer', 'min:1'],
            'max_length' => ['required', 'integer', 'min:1'],
            'max_width' => ['required', 'integer', 'min:1'],
        ];
    }

    public function getNewBoxSizeData(): NewBoxData
    {
        return new NewBoxData(
            dimensions: new Dimensions(
                width: (int) $this->max_height,
                height: (int) $this->max_length,
                length: (int) $this->max_width,
                unit: LengthUnit::Milimeter,
            ),
            weight: new Weight( (int) $this->max_weight, MassUnit::Gram),
        );
    }
}
