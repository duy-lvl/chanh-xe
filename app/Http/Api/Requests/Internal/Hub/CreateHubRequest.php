<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Hub;

use Domain\Internal\DataTransferObjects\Hub\NewHubData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CreateHubRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'required_without_all:latitude,longitude'],
            'longitude' => ['numeric', 'min:-180', 'max:180', 'required_without:address', 'required_with:latitude'],
            'latitude' => ['numeric', 'min:-90', 'max:90', 'required_without:address', 'required_with:longitude'],
        ];
    }

    public function toDto(): NewHubData
    {
        return new NewHubData(
            name: $this->name,
            address: $this->address ?? null,
            latitude: $this->latitude ?? null,
            longitude: $this->longitude ?? null,
        );
    }
}
