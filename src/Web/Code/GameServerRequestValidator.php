<?php

namespace GooberBlox\Web\Code;

use App\Http\Requests\InsensitiveRequest as Request;
use GooberBlox\Platform\Infrastructure\Enums\ServerGroup;
use GooberBlox\Platform\Infrastructure\Enums\ServerType;
use Illuminate\Support\Facades\Log;

use GooberBlox\Platform\Infrastructure\Models\Server;
class GameServerRequestValidator
{
    public Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function isPotentialGameServer() : bool
    {
        return !empty($this->request->header('accessKey'));
    }

    public function isValidGameServerRequest() : bool
    {
        if ($this->request->attributes->has('ValidatedGameServerRequest')) {
            return $this->request->attributes->get('ValidatedGameServerRequest');
        }

       $ipAddress = $this->request->ip();

       $isValid = 
            $this->IsGamesRelayIpAddress($ipAddress) &&
            $this->verifyAccessKey($ipAddress);

        $this->request->attributes->set('ValidatedGameServerRequest', $isValid);

        return $isValid;
    }

    private function verifyAccessKey(string $ipAddress): bool
    {
        $accessKey = $this->request->header('accessKey');
        if(empty($accessKey))
        {
            Log::warning('no access key', [$this->request->headers, $ipAddress]);
            return false;
        }

        $isPrimaryAccessKey = $accessKey === config('gooberblox.common.Default.AccessKey');
        $isAlternateAccessKey = $accessKey === config('gooberblox.common.Default.AlternateAccessKey');

        if(!$isPrimaryAccessKey && !$isAlternateAccessKey)
        {
            Log::warning("invalid access key\n Access Key: {$accessKey}", [$this->request->headers, $ipAddress]);
            return false;
        }

        if($isAlternateAccessKey && !$isPrimaryAccessKey)
        {
            Log::warning("alternate access key in use", [$this->request->headers, $ipAddress]);
            return true;
        }  

        return true;
    }
    
    private function IsGamesRelayIpAddress(string $ipAddress) : bool
    {
        return Server::where('primary_ip_address', $ipAddress)
            ->inGroup(ServerGroup::GamesRelay)
            ->exists();
    }
 }