<?php

namespace GooberBlox\Platform\Universes;

use GooberBlox\Platform\Universes\Models\Universe as UniverseModel;
use InvalidArgumentException;


/*
*   TODO
*
*   1. Add updateNameDescriptionTrusted (bypasses textResult)
*
*
*/
class Universe {
    protected UniverseModel $universe;
    public function __construct(UniverseModel $universe) 
    {
        $this->universe = $universe;
    }

    // TODO: work on filter
    public function updateNameDescription(string $newName, string $newDescription, bool $allowPartiallyModerated = true): void
    {
        if( empty($newName) || $newName > config('gooberblox.universes.UniverseNameMaxLength'))
        {
            throw new InvalidArgumentException("newName");
        }

        // TODO: implement textfilterresult

        $universeModel = $this->universe;

        $universeModel->name = $newName;
        $universeModel->description = $newDescription;
        $universeModel->save();
    }
    
    public function updateNameDescriptionTrusted(string $trustedName, string $trustedDescription): void
    {
        //
    }

    public function updateBasicSettings(?bool $newStudioAccessToApisAllowed)
    {
        $universeModel = $this->universe;
        if( $newStudioAccessToApisAllowed )
        {
            $universeModel->api_services = $newStudioAccessToApisAllowed;
        }
    }
}

