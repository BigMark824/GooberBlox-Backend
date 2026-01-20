<?php

namespace GooberBlox\Platform\Groups;

use GooberBlox\Groups\Models\GroupAction;
final class InitiatorUserJson
{
    public int $initiatorId;

    public function __construct(int $initiatorId = 0)
    {
        $this->initiatorId = $initiatorId;
    }
}
class GroupManagement
{
    public static function logGroupAction(int $userId, int $groupId, int $actionTypeId, object $json): void
    {
        GroupAction::createNew($userId, $groupId, $actionTypeId, json_encode($json));
    }
}
