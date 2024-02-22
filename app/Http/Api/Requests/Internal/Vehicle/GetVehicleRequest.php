<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Internal\Vehicle;

use App\Http\Api\Requests\HasPagingData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GetVehicleRequest extends FormRequest
{
    use HasPagingData;

    /**
     * Determine if the Internal is authorized to make this request.
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
            'id' => ['integer', 'required', Rule::exists('partners', 'id')]
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
