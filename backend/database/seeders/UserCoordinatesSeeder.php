<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCoordinatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_coordinates')->insert([
            'user_id' => '1',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_coordinates')->insert([
            'user_id' => '2',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '3',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '4',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '5',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '6',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '7',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '8',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '9',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '10',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '11',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '12',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('user_coordinates')->insert([
            'user_id' => '13',
            'lat' => 51.69971,
            'lon' => 39.13577,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
