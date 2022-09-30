<?php

namespace App\Providers;

use App\Modules\Admin\LeadComment\Model\LeadComment;
use App\Modules\Admin\Sources\Model\Source;
use App\Modules\Admin\User\Models\User;
use App\Modules\Admin\Role\Model\Role;
use App\Modules\Admin\Role\Policies\RolePolicy;
use App\Modules\Admin\Sources\Policies\SourcePolicy;
use App\Modules\Admin\LeadComment\Policies\LeadCommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Source::class => SourcePolicy::class,
        LeadComment::class => LeadCommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
