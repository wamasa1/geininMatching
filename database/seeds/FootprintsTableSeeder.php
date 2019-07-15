<?php

use Illuminate\Database\Seeder;
use App\Footprint;

class FootprintsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Footprint::class, 15)->create();
    }
}
