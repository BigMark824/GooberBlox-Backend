<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GooberBlox\Platform\Games\Models\MatchmakingContext;

class MatchmakingContextSeeder extends Seeder
{
    public function run(): void
    {
        $contexts = ['Default', 'XBoxLive', 'CloudEdit', 'CloudEditPlayTest'];

        foreach ($contexts as $value) {
            MatchmakingContext::firstOrCreate(['value' => $value]);
        }
    }
}
