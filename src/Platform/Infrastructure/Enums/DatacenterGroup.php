<?php

namespace GooberBlox\Platform\Infrastructure\Enums;

enum DatacenterGroup: int
{
    case BleedOffNoNewGames = 1;
    case BleedOffNoMatchMaking = 2;
}
