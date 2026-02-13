<?php

namespace GooberBlox\Platform\Infrastructure;

use Illuminate\Support\Facades\{Log, Cache};

use GooberBlox\Platform\Infrastructure\Models\Server;

class ServerIpValidator {
    public int $serverTypeId;
    public int $serverGroupId;
    protected string $cacheKey;
    protected int $cacheSeconds;
    protected bool $loggingEnabled;

    public function __construct(int $serverTypeId, int $serverGroupId, bool $loggingEnabled = false, int $cacheSeconds = 60)
    {
        $this->serverTypeId = $serverTypeId;
        $this->serverGroupId = $serverGroupId;
        $this->cacheSeconds = $cacheSeconds;
        $this->loggingEnabled = $loggingEnabled;

        $this->cacheKey = "server_ip_validator:group:{$this->serverGroupId}:type:{$this->serverTypeId}";
    }

    public function verifyServerAccess(string $ipAddress) : bool
    {
        $ips = $this->getServerIps();

        $isValid = in_array($ipAddress, $ips);

        if ($this->loggingEnabled) {
            Log::info("ServerIpValidator check: IP={$ipAddress}, valid=" . ($isValid ? 'true' : 'false'));
        }

        return $isValid;
    }

    protected function getServerIps() : array
    {
        return Cache::remember($this->cacheKey, $this->cacheSeconds, function()
        {
            $servers = Server::where('server_type_id', $this->serverTypeId)
                ->whereHas('groups', function ($q) {
                    $q->where('server_group', $this->serverGroupId);
                })
                ->get(['primary_ip_address']);

                $ips = $servers->pluck('primary_ip_address')->toArray();

            if ($this->loggingEnabled) {
                Log::info("ServerIpValidator fetched IPs for group {$this->serverGroupId} type {$this->serverTypeId}: " . implode(',', $ips));
            }

            return $ips;
        });
    }
}