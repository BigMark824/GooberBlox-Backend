<?php

namespace GooberBlox\Grid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Cache};
use GooberBlox\GameInstances\Models\Server;
class Grid {
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function getServer()
    {
        $ipAddress = $this->request->ip();
 
        return Cache::remember("server:{$ipAddress}", now()->addDays(2), function () use ($ipAddress) {
            $server = Server::where('ip_address', $ipAddress)->first();

            return $server ? $server->toArray() : null;
        });
    }

    public function validateRCC(): bool
    {
        $accessKey = $this->request->header("AccessKey");
        $expectedKey = env('GRID_ACCESS_KEY') ?? 0;
        
        if( env('APP_DEBUG') == true ) return true;

        if($accessKey !== $expectedKey) return false;

        $server = $this->getServer();

        if(!$server)
            return false;

        return true;
    }
}