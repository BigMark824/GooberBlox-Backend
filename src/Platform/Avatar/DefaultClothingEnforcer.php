<?php
namespace GooberBlox\Platform\Avatar;

use GooberBlox\Platform\Assets\Models\Asset;
use InvalidArgumentException;

class DefaultClothingEnforcer
{
    /**
     * @var array<int, Asset>
     */
    protected array $defaultShirtAssets = [];

    /**
     * @var array<int, Asset>
     */
    protected array $defaultPantsAssets = [];

    public function handleDefaultClothingSetting(string $csv, DefaultClothingType $type): void
    {
        $assetIds = $this->convertCsvToFloats($csv);

        $target = match ($type) {
            DefaultClothingType::Shirt => $this->defaultShirtAssets,
            DefaultClothingType::Pants => $this->defaultPantsAssets,
            default => throw new InvalidArgumentException('Invalid DefaultClothingType'),
        };

        $this->{$target} = [];

        foreach ($assetIds as $index => $assetId) {
            $asset = Asset::findOrFail($assetId);
            $this->{$target}[$index] = $asset;
        }
    }

}
