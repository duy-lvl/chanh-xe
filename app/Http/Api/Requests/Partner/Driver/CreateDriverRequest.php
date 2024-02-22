<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Driver;

use App\Http\Api\Requests\HasFromBase64;
use Arr;
use Domain\Partner\DataTransferObjects\Driver\NewDriverData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File as RulesFile;

final class CreateDriverRequest extends FormRequest
{
    use HasFromBase64;
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
            'avatar' => ['required', RulesFile::image()
                                        ->max(1024*15)
                                        ->dimensions(
                                            Rule::dimensions()
                                                ->maxWidth(2000)
                                                ->maxHeight(2000)
                                                ->minWidth(1)
                                                ->minHeight(1)
                                        )
                        ],
            'name' => ['required', 'string'],
            'phone' => ['string', 'min:10', 'max:11', Rule::unique(table: 'partner_drivers', column: 'phone')->where('partner_id', Auth::id())->whereNull('deleted_at')],
        ];
    }

    public function getDriverData(): NewDriverData
    {
        return new NewDriverData(
            name: $this->name,
            phone: $this->phone,
            avatar: $this->avatar,
            partnerId: Auth::id()
        );
    }

    protected function prepareForValidation(): void {

        $this->merge(['id' => $this->id]);
        if ($this->avatar !== null) {
            $avatar = $this->fromBase64($this->avatar);
            $this->merge(['avatar' => $avatar]);
        }

    }

}
