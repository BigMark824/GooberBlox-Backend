<?php

namespace Database\Seeders;

use GooberBlox\Platform\Infrastructure\Enums\ServerGroup as ServerGroupEnum;
use GooberBlox\Platform\Infrastructure\Models\ServerGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServerGroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('server_groups')->truncate();

        foreach (ServerGroupEnum::cases() as $group) {
            ServerGroup::create([
                'group_type_id' => $group->value,
                'name' => $group->name,
                'description' => null,
            ]);
        }
    }
}
