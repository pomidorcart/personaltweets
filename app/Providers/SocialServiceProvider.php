<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entities\Repositories\SocialRepositoryInterface;
use App\Entities\Repositories\TwitterMessageRepository;
use App\Entities\Social;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\SocialServiceInterface',
        'App\Services\TwitterService');

        $this->app->bind(SocialRepositoryInterface::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new TwitterMessageRepository(
                $app['em'],
                $app['em']->getClassMetaData(Social::class)
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
