<?php

namespace GooberBlox\Platform\Games\Implementation;
class RobloxBetaPlaceAuthority
{    
    private array $betaFeaturePlaceIds = [];

    public function __construct()
    {
        try {
            $value = config('gooberblox.common.Default.BetaFeaturePlaceIds');

            if ($value !== '') {
                $ids = array_map(
                    fn($v) => (int) trim($v),
                    explode(',', $value)
                );

                $this->betaFeaturePlaceIds = array_fill_keys($ids, true);
            }
        } catch (\Throwable $e) {
            error_log($e);
            $this->betaFeaturePlaceIds = [];
        }
    }
    public function isRobloxPlace(int $placeId): bool
    {
        return isset($this->betaFeaturePlaceIds[$placeId]);
    }
}