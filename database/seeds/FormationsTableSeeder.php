<?php

use Illuminate\Database\Seeder;

class FormationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['type' => '5-4-1'],
            ['type' => '4-4-2'],
            ['type' => '3-4-3']
        ];

        DB::table('formations')->insert($data);
    }
}
