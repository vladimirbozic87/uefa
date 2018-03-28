<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['position_name' => 'goalie'],
            ['position_name' => 'defender'],
            ['position_name' => 'midfielder'],
            ['position_name' => 'striker']
        ];

        DB::table('positions')->insert($data);
    }
}
