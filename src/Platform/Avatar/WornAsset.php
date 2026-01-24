<?php
namespace GooberBlox\Platform\Avatar;

class WornAsset
{
    public int $assetTypeId;
    public int $assetId;
    public bool $isEquippedGear;
    public bool $isGear;
    public bool $isAnimation;

    public function __construct(int $assetTypeId, int $assetId, bool $isEquippedGear, bool $isGear, bool $isAnimation)
    {
        $this->assetTypeId = $assetTypeId;
        $this->assetId = $assetId;
        $this->isEquippedGear = $isEquippedGear;
        $this->isGear = $isGear;
        $this->isAnimation = $isAnimation;
    }
}
