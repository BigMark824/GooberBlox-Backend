<?php

namespace GooberBlox\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class GroupActionType extends Model
{
    use Cachable;

    protected $table = 'GroupActionTypes';

    protected $fillable = [
        'permission_type_id',
        'name',
    ];

    protected static ?array $actionTypes = null;

    public static GroupActionType $DeletePost;
    public static GroupActionType $RemoveMember;
    public static GroupActionType $AcceptJoinRequest;
    public static GroupActionType $DeclineJoinRequest;
    public static GroupActionType $PostStatus;
    public static GroupActionType $ChangeRank;
    public static GroupActionType $BuyAd;
    public static GroupActionType $SendAllyRequest;
    public static GroupActionType $CreateEnemy;
    public static GroupActionType $AcceptAllyRequest;
    public static GroupActionType $DeclineAllyRequest;
    public static GroupActionType $DeleteAlly;
    public static GroupActionType $DeleteEnemy;
    public static GroupActionType $AddGroupPlace;
    public static GroupActionType $DeleteGroupPlace;
    public static GroupActionType $CreateItems;
    public static GroupActionType $ConfigureItems;
    public static GroupActionType $SpendGroupFunds;
    public static GroupActionType $ChangeOwner;
    public static GroupActionType $Delete;
    public static GroupActionType $Rename;
    public static GroupActionType $AdjustCurrencyAmounts;
    public static GroupActionType $Abandon;
    public static GroupActionType $Claim;
    public static GroupActionType $ChangeDescription;
    public static GroupActionType $InviteToClan;
    public static GroupActionType $KickFromClan;
    public static GroupActionType $CancelClanInvite;
    public static GroupActionType $BuyClan;
    public static GroupActionType $CreateAsset;
    public static GroupActionType $UpdateAsset;
    public static GroupActionType $ConfigureAsset;
    public static GroupActionType $RevertAsset;
    public static GroupActionType $CreateDeveloperProduct;
    public static GroupActionType $ConfigureGame;
    public static GroupActionType $Lock;
    public static GroupActionType $Unlock;
    public static GroupActionType $CreateGamePass;
    public static GroupActionType $CreateBadge;
    public static GroupActionType $ConfigureBadge;
    public static GroupActionType $SavePlace;
    public static GroupActionType $PublishPlace;

    public static function booted()
    {
        static::$actionTypes = static::all()->keyBy('name')->toArray();

        static::$DeletePost = static::getByName('Delete Post');
        static::$RemoveMember = static::getByName('Remove Member');
        static::$AcceptJoinRequest = static::getByName('Accept Join Request');
        static::$DeclineJoinRequest = static::getByName('Decline Join Request');
        static::$PostStatus = static::getByName('Post Status');
        static::$ChangeRank = static::getByName('Change Rank');
        static::$BuyAd = static::getByName('Buy Ad');
        static::$SendAllyRequest = static::getByName('Send Ally Request');
        static::$CreateEnemy = static::getByName('Create Enemy');
        static::$AcceptAllyRequest = static::getByName('Accept Ally Request');
        static::$DeclineAllyRequest = static::getByName('Decline Ally Request');
        static::$DeleteAlly = static::getByName('Delete Ally');
        static::$DeleteEnemy = static::getByName('Delete Enemy');
        static::$AddGroupPlace = static::getByName('Add Group Place');
        static::$DeleteGroupPlace = static::getByName('Remove Group Place');
        static::$CreateItems = static::getByName('Create Items');
        static::$ConfigureItems = static::getByName('Configure Items');
        static::$SpendGroupFunds = static::getByName('Spend Group Funds');
        static::$ChangeOwner = static::getByName('Change Owner');
        static::$Delete = static::getByName('Delete');
        static::$Rename = static::getByName('Rename');
        static::$AdjustCurrencyAmounts = static::getByName('Adjust Currency Amounts');
        static::$Abandon = static::getByName('Abandon');
        static::$Claim = static::getByName('Claim');
        static::$ChangeDescription = static::getByName('Change Description');
        static::$InviteToClan = static::getByName('Invite to Clan');
        static::$KickFromClan = static::getByName('Kick from Clan');
        static::$CancelClanInvite = static::getByName('Cancel Clan Invite');
        static::$BuyClan = static::getByName('Buy Clan');
        static::$CreateAsset = static::getByName('Create Group Asset');
        static::$UpdateAsset = static::getByName('Update Group Asset');
        static::$ConfigureAsset = static::getByName('Configure Group Asset');
        static::$RevertAsset = static::getByName('Revert Group Asset');
        static::$CreateDeveloperProduct = static::getByName('Create Group Developer Product');
        static::$ConfigureGame = static::getByName('Configure Group Game');
        static::$Lock = static::getByName('Lock');
        static::$Unlock = static::getByName('Unlock');
        static::$CreateGamePass = static::getByName('Create Game Pass');
        static::$CreateBadge = static::getByName('Create Badge');
        static::$ConfigureBadge = static::getByName('Configure Badge');
        static::$SavePlace = static::getByName('Save Place');
        static::$PublishPlace = static::getByName('Publish Place');
    }

    public static function getByName(string $name): ?self
    {
        if (!isset(static::$actionTypes[$name])) {
            return null;
        }

        $data = static::$actionTypes[$name];
        return new self($data);
    }

    public static function get(int $id): ?self
    {
        if ($id === 0) return null;

        return static::find($id);
    }

    public static function createNew(int $permissionTypeId, string $name): self
    {
        $actionType = new self([
            'permission_type_id' => $permissionTypeId,
            'name' => $name,
        ]);

        $actionType->insert();

        return $actionType;
    }

    public static function getGroupActionTypes(): array
    {
        return array_values(static::$actionTypes);
    }
}
