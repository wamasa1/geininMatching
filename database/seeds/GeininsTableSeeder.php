<?php

use Illuminate\Database\Seeder;
use App\Geinin;

class GeininsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Geinin::class, 30)->create();
    }
}
