<?php

namespace GooberBlox\Platform\GameInstances\Data;

class PlaceSummary
{
    public function __construct(
        public int $id,
        public int $gameCount,
        public int $playerCount,
        public int $under13PlayerCount = 0,
        public array $playerCountByPlatformId = [],
        public array $under13PlayerCountByPlatformId = [],
        public array $vrPlayerCountByPlatformId = [],
        public int $vrPlayerCount = 0,
        public array $playerCountByBotCheckStatus = [],
    ) {}
}