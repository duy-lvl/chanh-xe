<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Driver;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class UpdateDriverAvatarRequest extends FormRequest
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
            'avatar' =>  ['required', File::image()
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
            'id' => ['required', 'integer', Rule::exists(table: 'partner_drivers', column: 'id')],
        ];
    }

    public function getDriverImage(): UploadedFile
    {
        return $this->avatar;
    }
    public function getDriverId(): int
    {
        return (int) $this->id;
    }
    protected function prepareForValidation(): void {
        $this->merge(['id' => $this->id]);
        if ($this->avatar !== null) {
            $avatar = $this->fromBase64($this->avatar);
            $this->merge(['avatar' => $avatar]);
        }
    }
}
