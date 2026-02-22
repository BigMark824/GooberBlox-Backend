<?php

namespace Database\Seeders;

use GooberBlox\Library\PremiumFeatures\DurationType;
use Illuminate\Database\Seeder;
use GooberBlox\Platform\Membership\Models\RoleSet;

class DurationTypeSeeder extends Seeder
{
    public function run(): void
    {
        DurationType::insert([
            [
                'id' => 1,
                'value' => 'None',
                'amount' => 0,
            ],
            [
                'id' => 2,
                'value' => '1 Month',
                'amount' => 30 * 86400 * 10_000_000,
            ],
            [
                'id' => 3,
                'value' => '45 Days',
                'amount' => 45 * 86400 * 10_000_000,
            ],
            [
                'id' => 4,
                'value' => '6 Months',
                'amount' => 180 * 86400 * 10_000_000,
            ],
            [
                'id' => 5,
                'value' => '12 Months',
                'amount' => 365 * 86400 * 10_000_000,
            ],
            [
                'id' => 6,
                'value' => 'Lifetime',
                'amount' => 0,
            ],
        ]);

    }
}
