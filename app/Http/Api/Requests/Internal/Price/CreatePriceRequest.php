<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Price;

use App\Rules\Internal\Price\PriceCreation;
use Carbon\CarbonImmutable;
use Domain\Internal\DataTransferObjects\Price\NewPriceData;
use Domain\Internal\DataTransferObjects\Price\PriceItemData;
use Domain\Internal\Enums\PriceTableStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class CreatePriceRequest extends FormRequest
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
            'apply_from' => ['required', 'date'],
            'apply_to' => ['required', 'date', 'after:apply_from'],
            'name' => ['string', 'required'],
            'priority' => ['required', 'integer'],
            'note' => ['string'],
            'items' => ['required', 'array', new PriceCreation()],
            'items.*.from_kilometer' => ['required', 'integer', 'min:0'],
            'items.*.to_kilometer' => ['required', 'integer', 'gt:items.*.from_kilometer'],
            'items.*.price_per_kilometer' => ['required', 'integer', 'min:1'],
            'items.*.min_amount' => ['required', 'integer', 'min:0', 'lte:items.*.max_amount'],
            'items.*.max_amount' => ['required', 'integer', 'min:0'],
        ];
    }

    public function getNewPriceData(): NewPriceData
    {
        $items = collect();
        foreach ($this->items as $item) {
            $items->push(new PriceItemData(
                fromKilometer:  (int) $item['from_kilometer'],
                toKilometer: (int) $item['to_kilometer'],
                pricePerKilometer: (int) $item['price_per_kilometer'],
                minAmount: (int) $item['min_amount'],
                maxAmount: (int) $item['max_amount']
            ));
        }

        return new NewPriceData(
            // applyFrom: CarbonImmutable::createFromFormat('Y-m-d', $this->apply_from),
            // applyTo: CarbonImmutable::createFromFormat('Y-m-d', $this->apply_to),
            applyFrom: new CarbonImmutable($this->apply_from),
            applyTo: new CarbonImmutable($this->apply_to),
            name: $this->name,
            priority: (int) $this->priority,
            status: PriceTableStatus::Available,
            items: $items,
            note: $this->note ?? null,
        );
    }
}
