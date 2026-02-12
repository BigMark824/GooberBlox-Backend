<?php

namespace GooberBlox\Platform\Infrastructure\Enums;

enum ServerType: int
{
    case LoadBalancer = 2;
    case WebServer = 4;
    case AppServer = 5;
    case DatabaseServer = 7;
    case VirtualHost = 9;
    case GameServer = 11;
    case LinuxWebServer = 13;
    case LinuxAppServer = 14;
    case LinuxDatabaseServer = 16;
    case LinuxGameServer = 27;
}
