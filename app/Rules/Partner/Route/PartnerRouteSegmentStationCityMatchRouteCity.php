<?php

declare(strict_types=1);

namespace App\Rules\Partner\Route;

use App\Models\Station;
use Closure;
use Domain\Partner\Enums\StationStatus;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;

final class PartnerRouteSegmentStationCityMatchRouteCity implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // $stations = Station::whereIn('id', [$this->data['milestones'][0]['station_id'], end($this->data['milestones'])['station_id']])->get();
        // $this->validateStationMatchCityCode($stations->first(), $stations->last(), $fail);

        $stations = Station::whereIn('id', collect($this->data['milestones'])->pluck('station_id'))->get();
        $this->validateStation($stations, $fail);
    }


    private function validateStationMatchCityCode(?Station $first, ?Station $last, Closure $fail): void
    {
        if (null === $first || $this->data['start_city_code'] !== $first->city_code
        || $this->data['start_district_code'] !== $first->district_code) {
            $fail('First milestone city not match route start city.');
        }
        if (null === $last || $this->data['end_city_code'] !== $last->city_code
        || $this->data['end_district_code'] !== $last->district_code) {
            $fail('Last milestone city not match route end city.');
        }
    }

    private function validateStation(SupportCollection $stations, Closure $fail): void
    {
        foreach($stations as $station) {
            if ($station->status !== StationStatus::Active) {
                $fail(__('validation.station_not_active', ['value' => $station->name]));
            }
        }

    }
}
