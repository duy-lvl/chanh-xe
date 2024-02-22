<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DeleteVehicleRequest extends FormRequest
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
            'id' => ['integer', Rule::exists(table: 'partner_vehicles', column: 'id'), 'required'],
        ];
    }

    protected function prepareForValidation(): void {
        $this->merge(['id' => $this->id]);
    }

    public function getId(): int
    {
        return (int) $this->id;
    }
}
