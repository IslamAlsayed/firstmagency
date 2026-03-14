<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Article;
use App\Models\Service;
use App\Models\Project;
use App\Models\Client;
use App\Models\Partner;
use App\Models\PestDomain;
use App\Models\OfficialDomain;
use App\Models\WhyUs;
use App\Models\PlatformManagement;
use App\Models\LineWork;
use App\Models\WorkUsStep;
use App\Models\MarketingPackage;
use App\Models\Review;
use App\Models\Ticket;
use App\Models\Programming;
use App\Models\OurProgramming;
use App\Models\ProjectStep;
use App\Models\HostingFeature;
use App\Models\DashboardsAndSystem;
use App\Models\HostingPackage;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ArticlePolicy;
use App\Policies\ServicePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\ClientPolicy;
use App\Policies\PartnerPolicy;
use App\Policies\PestDomainPolicy;
use App\Policies\OfficialDomainPolicy;
use App\Policies\WhyUsPolicy;
use App\Policies\PlatformManagementPolicy;
use App\Policies\LineWorkPolicy;
use App\Policies\WorkUsStepPolicy;
use App\Policies\MarketingPackagePolicy;
use App\Policies\ReviewPolicy;
use App\Policies\TicketPolicy;
use App\Policies\ProgrammingPolicy;
use App\Policies\OurProgrammingPolicy;
use App\Policies\ProjectStepPolicy;
use App\Policies\HostingFeaturePolicy;
use App\Policies\DashboardsAndSystemPolicy;
use App\Policies\HostingPackagePolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Article::class => ArticlePolicy::class,
        Service::class => ServicePolicy::class,
        Project::class => ProjectPolicy::class,
        Client::class => ClientPolicy::class,
        Partner::class => PartnerPolicy::class,
        PestDomain::class => PestDomainPolicy::class,
        OfficialDomain::class => OfficialDomainPolicy::class,
        WhyUs::class => WhyUsPolicy::class,
        MarketingPackage::class => MarketingPackagePolicy::class,
        WorkUsStep::class => WorkUsStepPolicy::class,
        LineWork::class => LineWorkPolicy::class,
        PlatformManagement::class => PlatformManagementPolicy::class,
        Review::class => ReviewPolicy::class,
        Ticket::class => TicketPolicy::class,
        Programming::class => ProgrammingPolicy::class,
        OurProgramming::class => OurProgrammingPolicy::class,
        ProjectStep::class => ProjectStepPolicy::class,
        HostingFeature::class => HostingFeaturePolicy::class,
        DashboardsAndSystem::class => DashboardsAndSystemPolicy::class,
        HostingPackage::class => HostingPackagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
