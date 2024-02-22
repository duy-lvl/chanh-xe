<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Statistics;

use App\Http\Api\Requests\HasPagingData;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

final class DateRequest extends FormRequest
{
    use HasPagingData;


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
            'year' => ['required', 'integer', 'min:2020', 'max:2100'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
        ];
    }

    public function getYear(): int {
        return (int)$this->year;
    }
    public function getMonth(): int {
        return (int)$this->month;
    }
}

