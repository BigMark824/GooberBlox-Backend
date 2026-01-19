<?php

namespace GooberBlox\Platform\Outfits;

class KeyGeneratorInput
{
    public string $avatarHash;
    public ?int $bodyColorSetId;
    public array $assetIds; 
    public ?int $equippedGearId;
}