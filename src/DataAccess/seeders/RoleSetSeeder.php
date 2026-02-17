<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GooberBlox\Platform\Membership\Models\RoleSet;

class RoleSetSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Member', 'rank' => 0],
            ['name' => 'TrustedContributor', 'rank' => 10],
            ['name' => 'Soothsayer', 'rank' => 20],
            ['name' => 'ContentCreator', 'rank' => 30],
            ['name' => 'Moderator', 'rank' => 40],
            ['name' => 'SuperModerator', 'rank' => 50],
            ['name' => 'CustomerService', 'rank' => 60],
            ['name' => 'SuperAdministrator', 'rank' => 100],
            ['name' => 'Developer', 'rank' => 70],
            ['name' => 'EconomyManager', 'rank' => 45],
            ['name' => 'Marketing', 'rank' => 35],
            ['name' => 'MarketingManager', 'rank' => 55],
            ['name' => 'AdOps', 'rank' => 25],
            ['name' => 'AdOpsManager', 'rank' => 50],
            ['name' => 'CommunityManager', 'rank' => 45],
            ['name' => 'ModeratorManager', 'rank' => 60],
            ['name' => 'CommunityRepresentative', 'rank' => 40],
            ['name' => 'Bursar', 'rank' => 20],
            ['name' => 'Finance', 'rank' => 30],
            ['name' => 'BetaTester', 'rank' => 5],
            ['name' => 'ProtectedUser', 'rank' => 15],
            ['name' => 'ReleaseEngineer', 'rank' => 50],
            ['name' => 'Viewer', 'rank' => 0],
            ['name' => 'CommunityChampion', 'rank' => 35],
            ['name' => 'DeveloperRelations', 'rank' => 50],
            ['name' => 'DevRelManager', 'rank' => 60],
            ['name' => 'DataAdministrator', 'rank' => 70],
            ['name' => 'EventStreamCreator', 'rank' => 25],
            ['name' => 'TranslationManager', 'rank' => 30],
            ['name' => 'TranslationContributor', 'rank' => 20],
            ['name' => 'PIIManager', 'rank' => 50],
            ['name' => 'IT', 'rank' => 55],
            ['name' => 'CSAgentAdmin', 'rank' => 60],
            ['name' => 'FastTrackMember', 'rank' => 10],
            ['name' => 'FastTrackModerator', 'rank' => 45],
            ['name' => 'FastTrackAdmin', 'rank' => 70],
            ['name' => 'ChinaLicenseUser', 'rank' => 5],
            ['name' => 'ItemManager', 'rank' => 40],
            ['name' => 'CatalogItemCreator', 'rank' => 35],
            ['name' => 'RccReleaseTesterManager', 'rank' => 50],
        ];

        foreach ($roles as $role) {
            RoleSet::updateOrCreate(
                ['name' => $role['name']],
                ['rank' => $role['rank']]
            );
        }
    }
}
