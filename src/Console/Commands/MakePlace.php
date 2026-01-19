<?php

namespace GooberBlox\Console\Commands;

use Illuminate\Console\Command;

use GooberBlox\Assets\Models\Asset;
use GooberBlox\Universes\Models\Universes;
use GooberBlox\Assets\Enums\{AssetType, CreatorType};
class MakePlace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:place {name} {--creatorId=0} {--privacyType=Public}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Place Asset, with Universe.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $creatorId = $this->option('creatorId') ?? 0;
        $privacyType = $this->option('privacyType') ?? 'Public';

        $universe = Universes::create([
            'name' => "{$name}",
            'creator_target_id' => $creatorId,
            'description' => null,
            'creator_type' => CreatorType::User,
            'privacy_type' => $privacyType,
        ]);

        $place = Asset::create([
            'name' => $name,
            'asset_type_id' => AssetType::Place,
            'creator_id' => $creatorId,
            'universe_id' => $universe->id,
        ]);

        $universe->root_place_id = $place->id;
        $universe->save();

        $this->info("Created a new Place, ID: {$place->id}, Name: {$place->name}");

        return Command::SUCCESS;
    }
}
