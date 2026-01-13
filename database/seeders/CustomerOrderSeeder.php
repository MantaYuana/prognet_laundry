<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Outlet;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CustomerOrderSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void {
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        $outlet = Outlet::first() ?? Outlet::create([
            'name' => 'Demo Outlet',
            'address' => 'Jl. Sudirman No. 1',
            'phone_number' => '0800000000',
            'owner_id' => null,
        ]);

        $services = LaundryService::where('outlet_id', $outlet->id)->get();
        if ($services->isEmpty()) {
            $seedServices = [
                ['name' => 'Wash & Fold', 'service_type' => 'per_kg', 'price' => 5000],
                ['name' => 'Dry Clean', 'service_type' => 'per_item', 'price' => 12000],
                ['name' => 'Ironing', 'service_type' => 'per_item', 'price' => 7000],
            ];

            foreach ($seedServices as $seedService) {
                $serviceModel = LaundryService::where('name', $seedService['name'])
                    ->where('outlet_id', $outlet->id)
                    ->first();

                if (!$serviceModel) {
                    $serviceModel = new LaundryService([
                        'name' => $seedService['name'],
                        'service_type' => $seedService['service_type'],
                        'price' => (string) $seedService['price'],
                    ]);
                    $serviceModel->outlet_id = $outlet->id;
                    $serviceModel->save();
                }
            }

            $services = LaundryService::where('outlet_id', $outlet->id)->get();
        }

        $staffUser = User::firstOrCreate(
            ['email' => 'staff001@prognetlaravel.com'],
            [
                'name' => 'Staff Demo',
                'password' => Hash::make('Staff123'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
        );
        $staffUser->assignRole($staffRole);

        $staff = Staff::firstOrCreate(
            ['user_id' => $staffUser->id],
            [
                'title' => 'Operator',
                'address' => 'Staff Street',
                'phone_number' => '0811111111',
                'outlet_id' => $outlet->id,
            ],
        );

        $statuses = Order::STATUSES;
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "customer{$i}@prognetlaravel.com"],
                [
                    'name' => "Customer {$i}",
                    'password' => Hash::make('Customer123'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ],
            );
            $user->assignRole($customerRole);

            $customer = Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => "Customer {$i} Address",
                    'phone_number' => '082200000' . $i,
                ],
            );

            for ($j = 1; $j <= 2; $j++) {
                $status = $statuses[array_rand($statuses)];

                $order = Order::create([
                    'code' => 'ORD-' . Str::upper(Str::random(8)),
                    'status' => $status,
                    'payment_confirm' => $status === 'done',
                    'address' => "Order {$j} for Customer {$i}",
                    'customer_id' => $customer->id,
                    'outlet_id' => $outlet->id,
                    'staff_id' => $staff->id,
                    'subtotal' => 0,
                    'discount_amount' => 0,
                    'total' => 0,
                ]);

                $itemsToCreate = $services->shuffle()->take(random_int(1, min(3, $services->count())));
                $total = 0;

                foreach ($itemsToCreate as $service) {
                    $qty = random_int(1, 3);
                    $unit = (int) $service->price;
                    $subtotal = $unit * $qty;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'laundry_service_id' => $service->id,
                        'quantity' => $qty,
                        'item_price' => $unit,
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                $order->update(['subtotal' => $total, 'total' => $total]);
            }
        }
    }
}
