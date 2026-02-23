<?php

namespace GooberBlox\Web\Code\CookieConstraint;

use Illuminate\Http\Request;
use GooberBlox\Web\GameServerRequestValidator;

class CookieConstraintVerifier {
    private const GAME_SERVER_BYPASS_HEADER_NAME = "X-EnforceGameServerBypass";
    private const FORCE_CONSTRAINT_HEADER_NAME = "X-ForceMaintenanceMode";

    private readonly GameServerRequestValidator $gameServerRequestValidator;

    public function __construct(GameServerRequestValidator $gameServerRequestValidator)
    {
        $this->gameServerRequestValidator = $gameServerRequestValidator;
    }

    public function isVerified(Request $request) : bool
    {
        if(!config('gooberblox.web-code.Default.IsCookieConstraintEnabled'))
        {
            return true; 
        }

       if (!$request || $this->isConstraintForced($request->headers)) 
        {
            return false;
        }

        if ((!in_array($request->ip(), ['127.0.0.1', '::1'])) && (!$this->hasCookie($request)) && (!$this->isOptionsRequest($request)) && (!$this->verifyIpBypass($request))) 
        {
            if(config('gooberblox.web-code.Default.IsGameServerCookieConstraintBypassEnabled'))
            {
                return $this->isRequestFromGameServer($request);
            }
            return false;
        }

        return true;
    }

    protected function isRequestFromGameServer(Request $request) : bool
    {
        if(!$this->gameServerRequestValidator)
        {
            return false;
        }
        $gameServerBypassValues = $request->headers->get('X-EnforceGameServerBypass');

        if ($gameServerBypassValues !== null && str_contains($gameServerBypassValues, config('gooberblox.web-code.Default.GameServerHeaderBypassValue'))) {
            return true;
        }

        return $this->gameServerRequestValidator->isGamesRelayIpAddress($request->ip());
    }


    protected function hasCookie(Request $request): bool
    {
        return $request->cookies->has(config('gooberblox.web-code.Default.CookieConstraintCookieName'));
    }

    // todo more accurate
    protected function verifyIpbypass(Request $request): bool
    {
        $ipBypassList = explode(',', config('gooberblox.web-code.Default.CookieConstraintIpBypassRangeCsv')); 

        $requestIp = $request->ip();

        if (in_array($requestIp, array_map('trim', $ipBypassList))) {
            return true;
        }
        return false;
    }

    protected function isOptionsRequest(Request $request): bool
    {
        return $request->isMethod('OPTIONS');
    }

    protected function isConstraintForced($headers): bool
    {
        return $headers->has('X-ForceMaintenanceMode');
    }
}