<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Transaction;

use App\Http\Api\Requests\HasFromBase64;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

final class TopupRequest extends FormRequest
{
    use HasFromBase64;
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
            'amount' => ['integer', 'min:10000', 'required'],
            'image' =>  ['required', File::image()
                            ->max(1024*15)
                            ->dimensions(
                                Rule::dimensions()
                                    ->maxWidth(2000)
                                    ->maxHeight(2000)
                                    ->minWidth(1)
                                    ->minHeight(1)
                            )
                        ],
        ];
    }

    public function getAmount() {
        return $this->amount;
    }
    public function getImage(): UploadedFile
    {
        return $this->image;
    }
    protected function prepareForValidation(): void {
        if ($this->image !== null) {
            $image = $this->fromBase64($this->image);
            $this->merge(['image' => $image]);
        }
    }
}
