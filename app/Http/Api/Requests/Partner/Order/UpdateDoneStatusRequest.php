<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Order;

use App\Http\Api\Requests\HasFromBase64;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Str;

final class UpdateDoneStatusRequest extends FormRequest
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
            'code' => ['required', 'string', Rule::exists(table: 'orders', column: 'code')],
            'receive_token' => ['required', 'string'],
            'image' =>  [
                'required',
                File::image()
                    ->max(1024*15)
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(2000)
                            ->maxHeight(2000)
                            ->minWidth(1)
                            ->minHeight(1)
                    ),
            ],
        ];
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    public function getReceiveToken(): string
    {
        return $this->receive_token;
    }

    public function prepareForValidation()
    {
        $this->merge(['code' => Str::lower($this->code)]);

        if ($this->image !== null){
            $image = $this->fromBase64($this->image);
            $this->merge(['image' => $image]);
        }
    }
}
