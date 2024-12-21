<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Watchers\RequestWatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * 应用服务提供者
 *
 * @author KanekiYuto
 */
class AppServiceProvider extends ServiceProvider
{

	/**
	 * 引导任何应用程序服务
	 *
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function boot(): void
	{
		$watcher = $this->app->make(RequestWatcher::class);
		$watcher->register($this->app);

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
	}

	/**
	 * 注册任何应用服务
	 *
	 * @return void
	 */
	public function register(): void
	{
        Passport::ignoreRoutes();
	}

}
