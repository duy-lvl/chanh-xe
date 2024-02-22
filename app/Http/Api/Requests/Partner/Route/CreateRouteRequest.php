<?php

declare(strict_types=1);

namespace App\Http\Api\Requests\Partner\Route;

use App\Rules\Partner\Route\PartnerRouteSegmentStationCityMatchRouteCity;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\Partner\DataTransferObjects\Route\NewRouteData;
use Domain\Partner\DataTransferObjects\RouteSegment\NewRouteMilestoneData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class CreateRouteRequest extends FormRequest
{
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
            'start_city_code' => ['required', 'integer', 'max:99', 'min:1', 'different:end_city_code'],
            'start_district_code' => ['required', 'integer', 'max:999', 'min:100', 'different:end_district_code'],
            'end_city_code' => ['required', 'integer', 'max:99', 'min:1', 'different:start_city_code'],
            'end_district_code' => ['required', 'integer', 'max:999', 'min:100', 'different:start_district_code'],
            'name' => ['required', 'string'],
            'package_types' => ['required', 'array'],
            'package_types.*' => ['required', 'integer', new Enum(PackageType::class)],
            'milestones' => ['required', 'array',  new PartnerRouteSegmentStationCityMatchRouteCity()],

            'milestones.*.station_id' => ['required', 'integer', Rule::exists(table: 'partner_stations', column: 'id')->where('partner_id', Auth::id())],
            'milestones.*.distance_from_previous' => ['required', 'numeric', 'min:0'],
            'milestones.*.hubs' => ['array'],
            'milestones.*.hubs.*.id' => ['required', 'integer', Rule::exists(table: 'hubs', column: 'id')],
            'milestones.*.hubs.*.distance_from_milestone' => ['required', 'integer', 'min:0', ],
        ];
    }

    public function toDto(): NewRouteData
    {
        $packageTypes = collect($this->package_types)->map(fn (int $value) => PackageType::from($value));
        $milestones = collect();

        $i = 1;
        foreach ($this->milestones as $milestone) {

            $hubs = collect();

            if (isset($milestone['hubs'])){
                foreach ($milestone['hubs'] as $hub) {
                    $hubs->put(
                        $hub['id'],
                        ['distance_from_milestone'=>$hub['distance_from_milestone']]
                    );
                }
            }

            $milestones->push(new NewRouteMilestoneData(
                stationId: $milestone['station_id'],
                milestoneNumber: $i++,
                distanceFromPrevious: $milestone['distance_from_previous'],
                hubs: $hubs,
            ));
        }

        return new NewRouteData(
            partnerId: Auth::id(),
            startCityCode: $this->start_city_code,
            startDistrictCode: $this->start_district_code,
            endCityCode: $this->end_city_code,
            endDistrictCode: $this->end_district_code,
            name: $this->name,
            packageTypes: $packageTypes,
            milestones: $milestones,
        );
    }
}
