<?php

namespace GooberBlox\Platform\Games\Implementation;

use Illuminate\Support\Facades\Log;
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
            Log::error($e->getMessage());
            $this->betaFeaturePlaceIds = [];
        }
    }
    public function isRobloxPlace(int $placeId): bool
    {
        return isset($this->betaFeaturePlaceIds[$placeId]);
    }
}