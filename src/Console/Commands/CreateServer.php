<?php

namespace GooberBlox\Console\Commands;

use Illuminate\Console\Command;
use GooberBlox\Infrastructure\Models\Server;
use GooberBlox\Infrastructure\Enums\{ServerStatus, ServerType};
class CreateServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:server {name} {--ip_address=127.0.0.1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a server entry in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $server = Server::create([
            'name' => $this->argument('name'),
            'ip_address' => $this->option('ip_address') ?? "127.0.0.1",
            'server_type' => ServerType::MixServer, 
            'server_status' => ServerStatus::Live, 
            'is_alive' => true,
        ]);

        $this->info("Created a new Production Server, ID: {$server->id}, Name: {$server->name}, IP: {$server->ip_address}");

        return Command::SUCCESS;
    }
}
