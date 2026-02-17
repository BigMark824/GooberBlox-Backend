<?php

namespace GooberBlox\Platform\Membership\Models;

use GooberBlox\Platform\AssetPermissions\AssetPermissionsVerifier;
use GooberBlox\Platform\Assets\Place;
use GooberBlox\Platform\Games\UserExtension;
use GooberBlox\Platform\Games\UserExtensions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use GooberBlox\Account\Models\Account;
use GooberBlox\Agent\Models\Agent;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class User extends Model
{
    use Cachable;
    protected $fillable = [
        'account_id',
        'age_bracket',
        'account_status',
        'age_bracket_is_locked',
        'birth_date',
        'use_super_safe_conversation_mode',
        'use_super_privacy_mode',
        'conversation_safety_mode_is_locked',
        'privacy_safety_mode_is_locked'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function agent(): MorphOne
    {
        return $this->morphOne(
            Agent::class,
            'target',
            'agent_type',
            'agent_target_id'
        );
    }

    public function hasRole(string $roleName): bool
    {
        return $this->account && $this->account->roleSets->contains('name', $roleName);
    }

    public function isMember(): bool { return $this->hasRole('Member'); }
    public function isTrustedContributor(): bool { return $this->hasRole('TrustedContributor'); }
    public function isSoothsayer(): bool { return $this->hasRole('Soothsayer'); }
    public function isContentCreator(): bool { return $this->hasRole('ContentCreator'); }
    public function isModerator(): bool { return $this->hasRole('Moderator'); }
    public function isSuperModerator(): bool { return $this->hasRole('SuperModerator'); }
    public function isCustomerService(): bool { return $this->hasRole('CustomerService'); }
    public function isSuperAdministrator(): bool { return $this->hasRole('SuperAdministrator'); }
    public function isDeveloper(): bool { return $this->hasRole('Developer'); }
    public function isEconomyManager(): bool { return $this->hasRole('EconomyManager'); }
    public function isMarketing(): bool { return $this->hasRole('Marketing'); }
    public function isMarketingManager(): bool { return $this->hasRole('MarketingManager'); }
    public function isAdOps(): bool { return $this->hasRole('AdOps'); }
    public function isAdOpsManager(): bool { return $this->hasRole('AdOpsManager'); }
    public function isCommunityManager(): bool { return $this->hasRole('CommunityManager'); }
    public function isModeratorManager(): bool { return $this->hasRole('ModeratorManager'); }
    public function isCommunityRepresentative(): bool { return $this->hasRole('CommunityRepresentative'); }
    public function isBursar(): bool { return $this->hasRole('Bursar'); }
    public function isFinance(): bool { return $this->hasRole('Finance'); }
    public function isBetaTester(): bool { return $this->hasRole('BetaTester'); }
    public function isProtectedUser(): bool { return $this->hasRole('ProtectedUser'); }
    public function isReleaseEngineer(): bool { return $this->hasRole('ReleaseEngineer'); }
    public function isViewer(): bool { return $this->hasRole('Viewer'); }
    public function isCommunityChampion(): bool { return $this->hasRole('CommunityChampion'); }
    public function isDeveloperRelations(): bool { return $this->hasRole('DeveloperRelations'); }
    public function isDevRelManager(): bool { return $this->hasRole('DevRelManager'); }
    public function isDataAdministrator(): bool { return $this->hasRole('DataAdministrator'); }
    public function isEventStreamCreator(): bool { return $this->hasRole('EventStreamCreator'); }
    public function isTranslationManager(): bool { return $this->hasRole('TranslationManager'); }
    public function isTranslationContributor(): bool { return $this->hasRole('TranslationContributor'); }
    public function isPIIManager(): bool { return $this->hasRole('PIIManager'); }
    public function isIT(): bool { return $this->hasRole('IT'); }
    public function isCSAgentAdmin(): bool { return $this->hasRole('CSAgentAdmin'); }
    public function isFastTrackMember(): bool { return $this->hasRole('FastTrackMember'); }
    public function isFastTrackModerator(): bool { return $this->hasRole('FastTrackModerator'); }
    public function isFastTrackAdmin(): bool { return $this->hasRole('FastTrackAdmin'); }
    public function isThumbnailAdmin(): bool { return $this->hasRole('ThumbnailAdmin'); }
    public function isMatchmakingAdmin(): bool { return $this->hasRole('MatchmakingAdmin'); }
    public function isRccReleaseTester(): bool { return $this->hasRole('RccReleaseTester'); }
    public function isRccReleaseTesterManager(): bool { return $this->hasRole('RccReleaseTesterManager'); }
    public function isChinaLicenseUser(): bool { return $this->hasRole('ChinaLicenseUser'); }
    public function isChinaBetaUser(): bool { return $this->hasRole('ChinaBetaUser'); }
    public function isInfluencer(): bool { return $this->hasRole('Influencer'); }
    public function isItemManager(): bool { return $this->hasRole('ItemManager'); }
    public function isCatalogItemCreator(): bool { return $this->hasRole('CatalogItemCreator'); }
    public function isCLBGameDeveloper(): bool { return $this->hasRole('CLBGameDeveloper'); }
    public function isModerationImpersonator(): bool { return $this->hasRole('ModerationImpersonator'); }

    public function canShutdownGameInstance(Place $place, AssetPermissionsVerifier $assetPermissionsVerifier) {
        return UserExtensions::canShutdownGameInstances($this, $place, $assetPermissionsVerifier);
    }
}
