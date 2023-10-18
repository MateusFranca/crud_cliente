<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\ClienteFactory;
use App\Models\Cliente;


class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::factory()->count(50)->create();
    }
}
