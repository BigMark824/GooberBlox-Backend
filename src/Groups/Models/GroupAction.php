<?php

namespace GooberBlox\Groups\Models;

use Illuminate\Database\Eloquent\Model;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class GroupAction extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'group_id',
        'action_type_id',
        'description'
    ];

    public static function createNew(int $userId, int $groupId, int $actionTypeId, string $description)
    {
        $group = self::create([
            'user_id' => $userId,
            'group_id'=> $groupId,
            'action_type_id' => $actionTypeId,
            'description'=> $description,
        ]);
    }
}
