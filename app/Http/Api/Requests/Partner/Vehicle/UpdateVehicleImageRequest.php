<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Vehicle;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class UpdateVehicleImageRequest extends FormRequest
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
            'image' =>  ['required', File::image()
                            ->max(1024*15)
                            ->dimensions(
                                Rule::dimensions()
                                    ->maxWidth(2000)
                                    ->maxHeight(2000)
                                    ->minWidth(1)
                                    ->minHeight(1)
                            )
                            // ->extensions()
                        ],
            'id' => ['required', 'integer', Rule::exists(table: 'partner_vehicles', column: 'id')],
        ];
    }

    public function getVehicleImage(): UploadedFile
    {
        return $this->image;
    }

    public function getVehicleId(): int
    {
        return (int) $this->id;
    }
    protected function prepareForValidation(): void {
        $this->merge(['id' => $this->id]);
        if ($this->avatar !== null) {
            $image = $this->fromBase64($this->image);
            $this->merge(['image' => $image]);
        }
    }
}
