<?php

namespace Database\Seeders;

use GooberBlox\Library\Models\FeedType;
use Illuminate\Database\Seeder;

class FeedTypeSeeder extends Seeder
{
    public function run(): void
    {
        $feedTypes = [
            ['type' => 'status', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'group', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'newplace', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'boughtitem', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'place', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'character', 'lifetime' => 0, 'enabled' => true],
            ['type' => 'playgame', 'lifetime' => 0, 'enabled' => true],
        ];

        foreach ($feedTypes as $feedType) {
            FeedType::updateOrCreate(
                ['type' => $feedType['type']],
                [
                    'lifetime' => $feedType['lifetime'],
                    'enabled' => $feedType['enabled'],
                ]
            );
        }
    }
}
