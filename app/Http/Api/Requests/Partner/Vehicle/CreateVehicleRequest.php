<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Vehicle;

use App\Http\Api\Requests\HasFromBase64;
use Domain\Partner\DataTransferObjects\Vehicle\NewVehicleData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File as RulesFile;

final class CreateVehicleRequest extends FormRequest
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
            'image' => ['required', RulesFile::image()
                                        ->max(1024*15)
                                        ->dimensions(
                                            Rule::dimensions()
                                                ->maxWidth(2000)
                                                ->maxHeight(2000)
                                                ->minWidth(1)
                                                ->minHeight(1)
                                        )
                        ],
            'type' => ['required', 'string'],
            'plate_number' => ['string', 'min:8', 'max:15', Rule::unique(table: 'partner_vehicles', column: 'plate_number')->where('partner_id', Auth::id())->whereNull('deleted_at')],
        ];
    }

    public function getVehicleData(): NewVehicleData
    {
        return new NewVehicleData(
            type: $this->type,
            plateNumber: $this->plate_number,
            image: $this->image,
            partnerId: Auth::id()
        );
    }

    protected function prepareForValidation(): void {

        $this->merge(['id' => $this->id]);
        if ($this->image !== null) {
            $image = $this->fromBase64($this->image);
            $this->merge(['image' => $image]);
        }
    }

}
