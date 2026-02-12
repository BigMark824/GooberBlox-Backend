<?php

namespace GooberBlox\Platform\Infrastructure\Enums;

enum ServerStatus
{
    const Prep = 1;
    const Live = 2;
    const Maintenance = 3;
    const Retired = 4;
    const Reserve = 5;
    const Defective = 6;
}
