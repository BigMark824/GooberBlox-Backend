<?php

namespace GooberBlox\Platform\Groups\Enums;

enum GroupRoleSetPermissionType: int
{
    case CanDeletePosts = 0;
    case CanPostToWall = 1;
    case CanInviteMembers = 2;
    case CanPostToStatus = 3;
    case CanRemoveMembers = 4;
    case CanViewStatus = 5;
    case CanViewWall = 6;
    case CanChangeRank = 7;
    case CanAdvertise = 8;
    case CanManageRelationships = 9;
    case CanAddGroupPlaces = 10;
    case CanViewAuditLog = 11;
    case CanCreateItems = 12;
    case CanManageItems = 13;
    case CanSpendGroupFunds = 14;
    case CanManageClan = 15;
    case CanManageGroupGames = 16;
}
