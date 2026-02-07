<?php

namespace GooberBlox\PersonalServers\Enums;

enum PersonalServerRoles : int
{
    case OWNER = 255;
    case ADMIN = 240;
    case MEMBER = 128;
    case VISITOR = 10;
    case BANNED = 0;
}
