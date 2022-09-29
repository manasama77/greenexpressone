<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Charter;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('admins')->insert([
            'name'       => 'Admin',
            'username'   => 'admin',
            'password'   => Hash::make('admin'),
            'photo'      => null,
            'email'      => Str::random(10) . '@gmail.com',
            'role'       => 'super admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);

        DB::table('banners')->insert([
            [
                'picture'    => env('APP_URL') . '1.png',
                'url'        => '#',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'picture'    => env('APP_URL') . '2.png',
                'url'        => '#',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'picture'    => env('APP_URL') . '3.png',
                'url'        => '#',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]
        ]);

        DB::table('master_areas')->insert([
            [
                'name'       => 'Jakarta - Bandara Internasional Soekarno-Hatta',
                'area_type'  => 'departure',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'name'       => 'Jakarta Utara',
                'area_type'  => 'arrival',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'name'       => 'Jakarta Timur',
                'area_type'  => 'arrival',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'name'       => 'Jakarta Selatan',
                'area_type'  => 'arrival',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'name'       => 'Jakarta Barat',
                'area_type'  => 'arrival',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'name'       => 'Jakarta Pusat',
                'area_type'  => 'arrival',
                'is_active'  => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
        ]);

        DB::table('master_sub_areas')->insert([
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 1A',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 1B',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 2D',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 2E',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 2F',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 1,
                'name'           => 'Terminal 3',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Cilincing',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Kelapa Gading',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Koja',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Pademangan',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Penjaringan',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 2,
                'name'           => 'Tanjung Priok',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Cakung',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Cipayung',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Ciracas',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Duren Sawit',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Jatinegara',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Kramat Jati',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Makasar',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Pasar Rebo',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 3,
                'name'           => 'Pulo Gadung',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Cilandak',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Jagakarsa',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Kebayoran baru',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Kebayoran Lama',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Mampang Prapatan',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Pancoran',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Pasar Minggu',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Pesanggrahan',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Setiabudi',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 4,
                'name'           => 'Tebet',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Cengkareng',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Grogol Petamburan',
                'is_active'      => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Taman Sari',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Tambora',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Kebon Jeruk',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Kalideres',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Palmerah',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 5,
                'name'           => 'Kembangan',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Cempaka Putih',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Gambir',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Johar Baru',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Kemayoran',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Menteng',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Sawah Besar',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Senen',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'master_area_id' => 6,
                'name'           => 'Tanah Abang',
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
        ]);

        for ($i = 7; $i <= 47; $i++) {
            DB::table('master_special_areas')->insert([
                [
                    'master_sub_area_id' => $i,
                    'first_person_price' => 10,
                    'extra_person_price' => 5,
                    'is_active'          => true,
                    'notes'              => null,
                    'created_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'         => Carbon::now()->format('Y-m-d H:i:s'),
                    'deleted_at'         => null,
                ],
            ]);
        }

        DB::table('pages')->insert([
            [
                'page_title'   => 'Privacy',
                'page_content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, provident.'
            ],
            [
                'page_title'   => 'Term and Condition',
                'page_content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores recusandae exercitationem ipsa ab amet! Sed tempore maxime officiis possimus molestiae!'
            ]
        ]);


        for ($i = 1; $i <= 23; $i += 3) {
            $dt = Carbon::createFromFormat('H:i:s', '00:00:00')->addHours($i);
            $data = [
                'from_type'      => 'airport',
                'from_id'        => 1,
                'to_id'          => 7,
                'vehicle_name'   => 'Avanza 1',
                'vehicle_number' => 'B 1234 CCD',
                'time_departure' => $dt->format("H:00:00"),
                'is_active'      => true,
                'photo'          => null,
                'price'          => 25,
                'driver_contact' => '+62123456789',
                'notes'          => 'Lorem ipsum dolor sit amet.',
                'total_seat'     => 20,
                'luggage_price'  => 5,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ];
            DB::table('schedule_shuttles')->insert($data);
        }

        for ($i = 1; $i <= 23; $i += 3) {
            $dt = Carbon::createFromFormat('H:i:s', '00:00:00')->addHours($i);
            $data = [
                'from_type'      => 'district',
                'from_id'        => 7,
                'to_id'          => 1,
                'vehicle_name'   => 'Avanza 2',
                'vehicle_number' => 'B 9876 CCD',
                'time_departure' => $dt->format("H:00:00"),
                'is_active'      => true,
                'photo'          => null,
                'price'          => 25,
                'driver_contact' => '+62123456789',
                'notes'          => 'Lorem ipsum dolor sit amet.',
                'total_seat'     => 20,
                'luggage_price'  => 5,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ];
            DB::table('schedule_shuttles')->insert($data);
        }

        DB::table('vouchers')->insert([
            [
                'name'           => 'Discount 10%',
                'code'           => 'promo10%',
                'date_start'     => '2022-09-01',
                'date_expired'   => '2022-10-31',
                'discount_type'  => 'percentage',
                'discount_value' => 10,
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
            [
                'name'           => 'Media Social Promo',
                'code'           => 'medsos',
                'date_start'     => '2022-09-01',
                'date_expired'   => '2022-10-31',
                'discount_type'  => 'value',
                'discount_value' => 5,
                'is_active'      => true,
                'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at'     => null,
            ],
        ]);

        $charter                 = new Charter();
        $charter->from_type      = 'airport';
        $charter->from_id        = 1;
        $charter->to_id          = 7;
        $charter->vehicle_name   = 'Avanza 1';
        $charter->vehicle_number = 'B 1234 CCD';
        $charter->photo          = null;
        $charter->price          = 100;
        $charter->is_available   = true;
        $charter->driver_contact = '+62123456789';
        $charter->notes          = 'Lorem ipsum dolor sit amet.';
        $charter->save();

        $charter                 = new Charter();
        $charter->from_type      = 'airport';
        $charter->from_id        = 1;
        $charter->to_id          = 8;
        $charter->vehicle_name   = 'Avanza 2';
        $charter->vehicle_number = 'B 5678 CCD';
        $charter->photo          = null;
        $charter->price          = 100;
        $charter->is_available   = true;
        $charter->driver_contact = '+62123456789';
        $charter->notes          = 'Lorem ipsum dolor sit amet.';
        $charter->save();

        $charter                 = new Charter();
        $charter->from_type      = 'district';
        $charter->from_id        = 7;
        $charter->to_id          = 1;
        $charter->vehicle_name   = 'Avanza 1';
        $charter->vehicle_number = 'B 1234 CCD';
        $charter->photo          = null;
        $charter->price          = 100;
        $charter->is_available   = true;
        $charter->driver_contact = '+62123456789';
        $charter->notes          = 'Lorem ipsum dolor sit amet.';
        $charter->save();

        $charter                 = new Charter();
        $charter->from_type      = 'district';
        $charter->from_id        = 8;
        $charter->to_id          = 1;
        $charter->vehicle_name   = 'Avanza 1';
        $charter->vehicle_number = 'B 5678 CCD';
        $charter->photo          = null;
        $charter->price          = 100;
        $charter->is_available   = true;
        $charter->driver_contact = '+62123456789';
        $charter->notes          = 'Lorem ipsum dolor sit amet.';
        $charter->save();
    }
}
