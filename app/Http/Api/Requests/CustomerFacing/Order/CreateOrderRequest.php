<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\CustomerFacing\Order;

use Domain\CustomerFacing\DataTransferObjects\Order\NewOrderData;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class CreateOrderRequest extends FormRequest
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
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_phone' => ['required', 'string', 'max:11', 'min:10'],
            'sender_email' => ['email', 'max:255'],

            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_phone' => ['required', 'string', 'max:11', 'min:10'],
            'receiver_email' => ['email', 'max:255'],

            'note' => ['string'],

            'package_value' => ['integer', 'min:0', 'max:5000000'], // VND

            'weight' => ['required', 'integer', 'min:1', 'max:50000'], //gram
            'height' => ['integer', 'min:10', 'max:1000'], //mm
            'length' => ['integer', 'min:10', 'max:1000'], //mm
            'width' => ['integer', 'min:10', 'max:1000'], //mm

            'package_types' => ['required', 'array'],
            'package_types.*' => ['required', 'integer', new Enum(PackageType::class)],

            'payment_method' => ['required', 'integer', new Enum(PaymentMethod::class)],

            'order_route_id' => ['required', 'integer', Rule::exists(table: 'temporary_order_routes', column: 'id')],

            'collect_on_delivery' => ['required', 'boolean'],
        ];
    }

    public function getNewOrderData(): NewOrderData
    {
        $packageTypes = collect($this->package_types)->map(fn (int $value) => PackageType::from($value));

        return new NewOrderData(
            customerId: Auth::guard('api_customer')->id() ?? null,
            senderName: $this->sender_name,
            senderPhone: $this->sender_phone,
            senderEmail: $this->sender_email ?? null,
            receiverName: $this->receiver_name,
            receiverPhone: $this->receiver_phone,
            receiverEmail: $this->receiver_email ?? null,
            note: $this->note ?? null,
            packageValue: null === $this->package_value ? null : (int) $this->package_value,
            weight: new Weight($this->weight, MassUnit::Gram),
            dimensions: new Dimensions(
                width: null === $this->height ? 0 : (int) $this->height,
                height: null === $this->length ? 0 : (int) $this->length,
                length: null === $this->width ? 0 : (int) $this->width,
                unit: LengthUnit::Milimeter,
            ),
            packageTypes: $packageTypes,
            paymentMethod: PaymentMethod::from((int) $this->payment_method),
            orderRouteId: (int) $this->order_route_id,
            collectOnDelivery: (bool) $this->collect_on_delivery,
        );
    }
}
