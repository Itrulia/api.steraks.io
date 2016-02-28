<?php namespace App\Providers;

use App\Jobs\CalculateRanking;
use App\Map;
use App\Match;
use App\Services\Avatar\Contract\Avatar;
use App\Services\Avatar\Gravatar;
use App\Validators\Maps;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;
use Queue;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            Avatar::class
        ];
    }
}
