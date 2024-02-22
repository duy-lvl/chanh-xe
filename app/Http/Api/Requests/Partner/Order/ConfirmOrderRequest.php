<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Order;

use App\Models\Order;
use Domain\Partner\DataTransferObjects\Order\OrderConfirmationData;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class ConfirmOrderRequest extends FormRequest
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
            // 'order_code' => ['required', 'string', Rule::exists(table: Order::class, column: 'code')],
            'weight' => ['required', 'integer', 'min:0'],
            'height' => ['required', 'integer', 'min:0'],
            'length' => ['required', 'integer', 'min:0'],
            'width' => ['required', 'integer', 'min:0'],
            'package_value' => ['required', 'integer', 'min:0'],
        ];
    }

    public function getConfirmationData(): OrderConfirmationData
    {
        return new OrderConfirmationData(
            code: Str::lower($this->order_code),
            packageWeight: new Weight((int) $this->weight),
            packageDimensions: new Dimensions(
                height: (int) $this->height,
                length: (int) $this->length,
                width: (int) $this->width,
                unit: LengthUnit::Milimeter
            ),
            packageValue: $this->package_value
        );
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'order_code' => Str::lower($this->code),
        ]);
    }
}
