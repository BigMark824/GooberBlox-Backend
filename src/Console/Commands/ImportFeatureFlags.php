<?php

namespace GooberBlox\Console\Commands;

use Illuminate\Console\Command;

use GooberBlox\ClientSettings\Models\FeatureFlags;
class ImportFeatureFlags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:fflags {file} {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Feature Flags.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');
        $group = $this->argument('group');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $json = file_get_contents($file);
        $flags = json_decode($json, true);

        if (!$flags || !is_array($flags)) {
            $this->error("Invalid JSON in file: {$file}");
            return 1;
        }

        $now = now();

        foreach ($flags as $name => $value) {
            FeatureFlags::create([
                'group' => $group,
                'name' => $name,
                'value' => (string)$value,
                'created_at' => $now,
            ]);
        }

        $this->info(count($flags) . " flags imported for group '{$group}'");
        return 0;
    }
}
