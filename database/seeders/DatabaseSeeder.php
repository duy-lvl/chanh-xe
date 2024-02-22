<?php

declare(strict_types=1);

namespace Database\Seeders;

use Domain\Internal\Enums\StaffRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $manager = \App\Models\Staff::factory()->create([
            'username' => 'admin1',
            'hub_id' => null,
            'email' => null,
        ]);

        $role = Role::create([
            'guard_name' => 'api_internal',
            'name' => StaffRole::Manager,
        ]);

        $createBoxSizePermission = Permission::create([
            'guard_name' => 'api_internal',
            'name' => 'create boxSize',
        ]);

        $editBoxSizePermission = Permission::create([
            'guard_name' => 'api_internal',
            'name' => 'edit boxSize',
        ]);

        $createStaffAccountPermission = Permission::create([
            'guard_name' => 'api_internal',
            'name' => 'create staff',
        ]);

        $createPartnerAccountPermission = Permission::create([
            'guard_name' => 'api_internal',
            'name' => 'create partner',
        ]);

        $role->syncPermissions([$createBoxSizePermission, $editBoxSizePermission, $createStaffAccountPermission, $createPartnerAccountPermission]);

        $manager->assignRole($role);

        \App\Models\Hub::factory()
            ->has(
                factory: \App\Models\Staff::factory()->count(2),
                relationship: 'staffs'
            )
            ->create([
                'name' => 'hub Mỹ Tho',
                'address' => 'QL1, Phường 10, Thành phố Mỹ Tho, Tiền Giang',
                'latitude' => 10.385349380619838,
                'longitude' => 106.3397899723,
            ]);

        \App\Models\Hub::factory()
            ->has(
                factory: \App\Models\Staff::factory()->count(2),
                relationship: 'staffs'
            )
            ->create([
                'name' => 'hub Cần Thơ',
                'address' => 'QL1A, Hưng Phú, Cái Răng, Cần Thơ',
                'latitude' => 10.021925386645547,
                'longitude' => 105.79659107112074,
            ]);

        \App\Models\Staff::factory()->create([
            'username' => 'staff1',
            'hub_id' => 1,
            'email' => 'staff1@example.com',
        ]);

        \App\Models\Staff::factory()->create([
            'username' => 'staff2',
            'hub_id' => 2,
            'email' => 'staff2@example.com',
        ]);

        // \App\Models\Partner::factory(10)->has(\App\Models\PartnerPhone::factory()->count(3), 'phones')->create();
        $this->call([
            PartnerSeeder::class,
            PriceTableSeeder::class,
            //OrderSeeder::class,
            // TransactionRequestSeeder::class
        ]);

        // \App\Models\Customer::factory(10)->create();

        // \App\Models\BoxSize::factory()->create(
        //     [
        //         'max_length' => 50,
        //         'max_height' => 50,
        //         'max_width' => 50,
        //         'max_weight' => 20000,
        //     ]
        // );

        // \App\Models\BoxSize::factory()->create(
        //     [
        //         'max_length' => 100,
        //         'max_height' => 100,
        //         'max_width' => 100,
        //         'max_weight' => 50000,
        //     ]
        // );

        // \App\Models\BoxSizePrice::factory()->create(
        //     [
        //         'box_size_id' => 1,
        //         'apply_from' => '2023-10-01',
        //         'apply_to' => '2023-12-01',
        //         'name' => 'abc',
        //         'priority' => 1,
        //         'status' => 1,
        //     ]
        // );

        // \App\Models\BoxSizePrice::factory()->create(
        //     [
        //         'box_size_id' => 2,
        //         'apply_from' => '2023-10-01',
        //         'apply_to' => '2023-12-01',
        //         'name' => 'abc',
        //         'priority' => 1,
        //         'status' => 1,
        //     ]
        // );
        // \App\Models\BoxSizePrice::factory()->create(
        //     [
        //         'box_size_id' => 1,
        //         'apply_from' => '2023-10-31',
        //         'apply_to' => '2023-11-11',
        //         'name' => 'abc priority',
        //         'priority' => 2,
        //         'status' => 1,
        //     ]
        // );
        // \App\Models\PriceItem::factory()->create(
        //     [
        //         'price_id' => 1,
        //         'from_kilometer' => 0,
        //         'to_kilometer' => 50,
        //         'price_per_kilometer' => 500,
        //         'min_amount' => 20000,
        //         'max_amount' => 60000,
        //     ]
        // );

        // \App\Models\PriceItem::factory()->create(
        //     [
        //         'price_id' => 3,
        //         'from_kilometer' => 0,
        //         'to_kilometer' => 50,
        //         'price_per_kilometer' => 700,
        //         'min_amount' => 20000,
        //         'max_amount' => 80000,
        //     ]
        // );

        // \App\Models\PriceItem::factory()->create(
        //     [
        //         'price_id' => 3,
        //         'from_kilometer' => 50,
        //         'to_kilometer' => 100,
        //         'price_per_kilometer' => 500,
        //         'min_amount' => 20000,
        //         'max_amount' => 100000,
        //     ]
        // );
        // \App\Models\PriceItem::factory()->create(
        //     [
        //         'price_id' => 2,
        //         'from_kilometer' => 0,
        //         'to_kilometer' => 50,
        //         'price_per_kilometer' => 500,
        //         'min_amount' => 20000,
        //         'max_amount' => 60000,
        //     ]
        // );

        // \App\Models\Station::factory(10)->create();

        // \App\Models\OrderRoute::factory()
        //     ->create(
        //         [
        //             'start_station_id' => 1,
        //             'end_station_id' => 3,
        //             'is_selected' => false,
        //             'total_distance' => 33250,
        //         ]
        //     );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 1,
        //     'hub_id' => 1,
        //     'distance' => 20250,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRoute::factory()->create(
        //     [
        //         'start_station_id' => 2,
        //         'end_station_id' => 3,
        //         'is_selected' => false,
        //         'total_distance' => 35000,
        //     ]
        // );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 2,
        //     'hub_id' => 1,
        //     'distance' => 20000,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRoute::factory()->create(
        //     [
        //         'start_station_id' => 1,
        //         'end_station_id' => 3,
        //         'is_selected' => false,
        //         'total_distance' => 33000,
        //     ]
        // );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 3,
        //     'hub_id' => 1,
        //     'distance' => 22000,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRoute::factory()->create(
        //     [
        //         'start_station_id' => 2,
        //         'end_station_id' => 3,
        //         'is_selected' => false,
        //         'total_distance' => 37000,
        //     ]
        // );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 4,
        //     'hub_id' => 1,
        //     'distance' => 17000,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRoute::factory()->create(
        //     [
        //         'start_station_id' => 1,
        //         'end_station_id' => 3,
        //         'is_selected' => false,
        //         'total_distance' => 43000,
        //     ]
        // );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 5,
        //     'hub_id' => 1,
        //     'distance' => 20000,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRoute::factory()->create(
        //     [
        //         'start_station_id' => 2,
        //         'end_station_id' => 3,
        //         'is_selected' => false,
        //         'total_distance' => 45000,
        //     ]
        // );

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 6,
        //     'hub_id' => 1,
        //     'distance' => 15000,
        //     'sequence_number' => 1,
        // ]);

        // \App\Models\OrderRouteSegment::factory()->create([
        //     'order_route_id' => 6,
        //     'hub_id' => 2,
        //     'distance' => 20000,
        //     'sequence_number' => 2,
        // ]);
    }
}
