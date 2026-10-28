<?php

namespace App\Providers;

use App\Support\Flasher;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Automatically load custom helpers
        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }

        // Bind Flasher singleton
        $this->app->singleton(Flasher::class, function () {
            return new Flasher();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Blade directives for PHPFlasher compatibility
        Blade::directive('flasher_render', function () {
            return "<?php echo view('admin.partials.flasher-material')->render(); ?>";
        });

        Blade::directive('flasher_assets', function () {
            return "<!-- Flasher Material Assets -->";
        });
    }
}

