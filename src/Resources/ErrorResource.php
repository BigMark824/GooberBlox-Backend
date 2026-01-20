<?php

namespace GooberBlox\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/*
    Laravel implementation of Roblox.Common.JSON
*/
class ErrorResource extends JsonResource
{
    public static $wrap = null;

    public function __construct(public string $message)
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
            'Error' => $this->message
        ];
    }
}
