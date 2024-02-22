<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Profile\Write\Implementations;

use App\Exceptions\ProfileException;
use App\Models\Customer;
use Domain\CustomerFacing\Actions\Profile\Write\UpdateProfileContract;
use Domain\CustomerFacing\DataTransferObjects\Profile\UpdateProfileData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class UpdateProfile implements UpdateProfileContract
{

    public function handle(UpdateProfileData $data): void
    {   
        $query = Customer::query()->where('id', '<>' ,$data->id)
            ->where('phone', $data->phone);
        if ($query->count() > 0) {
            throw ProfileException::PhoneNumberExistedException();
        }

        $query = Customer::query()->where('id', '<>' ,$data->id)
            ->where('email', 'ILIKE' ,$data->email);
        if ($query->count() > 0) {
            throw ProfileException::EmailExistedException();
        }

        $customer = Customer::findOrFail($data->id);
        
        DB::transaction(
            callback: function () use ($data, $customer): void {
                
                $customer->name = $data->name;

                if ($customer->email !== $data->email) {
                    $customer->email = $data->email;
                    $customer->email_verified_at = null;
                }
                
                if ($customer->phone !== $data->phone) {
                    $customer->phone = $data->phone;
                    $customer->phone_verified_at = null;
                }
                
                $updateResult = $customer->save();
                if (!$updateResult) {
                    throw ProfileException::UpdateFailException();
                }

            },
            attempts: 3
        );
    }
}
