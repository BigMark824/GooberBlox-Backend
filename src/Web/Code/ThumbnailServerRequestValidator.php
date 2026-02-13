<?php

namespace GooberBlox\Web\Code;

use GooberBlox\Web\Requests\InsensitiveRequest as Request;
use GooberBlox\Platform\Infrastructure\Enums\ServerGroup;
use GooberBlox\Platform\Infrastructure\Enums\ServerType;
use Illuminate\Support\Facades\Log;

use GooberBlox\Platform\Infrastructure\Models\Server;
use GooberBlox\Platform\Infrastructure\ServerIpValidator;
class ThumbnailServerRequestValidator
{
    public Request $request;
    protected ServerIpValidator $serverIpValidator;
    public function __construct(ServerIpValidator $serverIpValidator)
    {
        if ($serverIpValidator->serverGroupId !== ServerGroup::ThumbnailServiceRCC ||
            $serverIpValidator->serverTypeId !== ServerType::GameServer) {
            throw new \InvalidArgumentException("Not a thumbnail server validator");
        }

        $this->serverIpValidator = $serverIpValidator;
    }
 
    public function isValidThumbnailServerRequest(Request $request): bool
    {
        $accessKey = $request->header('accesskey');

        $validKeys = [
            config('gooberblox.common.Default.AccessKey'),
            config('gooberblox.common.Default.AlternateAccessKey'),
        ];

        if (empty($accessKey) || !in_array($accessKey, $validKeys)) {
            return false;
        }

        $ipAddress = $request->ip();

        return $this->serverIpValidator->verifyServerAccess($ipAddress);
    }
 }