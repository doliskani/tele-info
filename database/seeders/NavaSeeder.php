<?php

namespace Database\Seeders;

use App\Models\Nava;
use Illuminate\Database\Seeder;

class NavaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nava::factory()->create();

        Nava::factory()
            ->state([
                'file_urls' => ['https://d38nvwmjovqyq6.cloudfront.net/va90web25003/companions/ws_smith/20%20Crescendo%20And%20Decrescendo.mp3']
            ])->create();
    }
}
