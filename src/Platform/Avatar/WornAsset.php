<?php
namespace GooberBlox\Platform\Avatar;

class WornAsset
{
    public int $assetId;
    public bool $isEquippedGear;
    public bool $isGear;
    public bool $isWearable; 
    public bool $isAnimation;
    public int $assetTypeId;

    public function __construct(int $assetId, bool $isEquippedGear, bool $isGear, bool $isWearable, bool $isAnimation, int $assetTypeId)
    {
        $this->assetId = $assetId;
        $this->isEquippedGear = $isEquippedGear;
        $this->isGear = $isGear;
        $this->isWearable = $isWearable;
        $this->isAnimation = $isAnimation;
        $this->assetTypeId = $assetTypeId;
    }
}
