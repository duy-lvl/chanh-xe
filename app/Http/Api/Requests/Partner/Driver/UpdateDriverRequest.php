<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Driver;

use Auth;
use Domain\Partner\DataTransferObjects\Driver\UpdateDriverData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateDriverRequest extends FormRequest
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
            'id' => ['required','integer', Rule::exists(table: 'partner_drivers', column: 'id')],
            'name' => ['required', 'string'],
            'phone' => ['string', 'min:10', 'max:11', Rule::unique(table: 'partner_drivers', column: 'phone')->ignore($this->id, 'id')->where('partner_id', Auth::id())],
        ];
    }

    public function getDriverData(): UpdateDriverData
    {
        return new UpdateDriverData(
            name: $this->name,
            phone: $this->phone,
            id: (int)$this->id,
        );
    }

    protected function prepareForValidation(): void {
        $this->merge(['id' => $this->id]);
    }
}
