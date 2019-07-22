<?php

use Illuminate\Database\Seeder;
use App\Favorite;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Favorite::class, 20)->create();
    }
}
