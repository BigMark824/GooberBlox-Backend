<?php

namespace GooberBlox\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/*
    Laravel implementation of Roblox.Common.JSON
*/
class PropertyResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(public string $propertyName, public string $propertyValue)
    {
        //
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->propertyName => $this->propertyValue,
        ];
    }
}
