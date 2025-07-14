<?php

namespace Database\Seeders;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@kelurahan.test'],
            [
                'name' => 'Admin Kelurahan',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('super_admin');

        $rw3 = Rw::firstOrCreate(['nomor' => '3']);

        $ketua_rw_3 = User::firstOrCreate(
            ['email' => 'rw3@kelurahan.test'],
            [
                'name' => 'Ketua RW 3',
                'password' => Hash::make('password'),
                'rw_id' => $rw3->id,
            ]
        );
        $ketua_rw_3->assignRole('ketua_rw');

        foreach (range(1, 9) as $i) {
            $rt = Rt::firstOrCreate([
                'nomor' => $i,
                'rw_id' => $rw3->id,
            ]);

            $email = "rt{$i}rw{$rw3->nomor}@kelurahan.test";

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "Ketua RT {$i} RW {$rw3->nomor}",
                    'password' => Hash::make('password'),
                    'rt_id' => $rt->id,
                ]
            );

            $user->assignRole('ketua_rt');
        }
    }
}
