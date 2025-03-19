<?php

declare(strict_types=1);

namespace JustCoded\PhpCsFixer\Providers;

use Illuminate\Support\ServiceProvider;
use JustCoded\PhpCsFixer\Services\CodeFixer;

class PhpCsFixerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(CodeFixer::class, function () {
            return new CodeFixer(config('php-cs-fixer', []));
        });
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/php-cs-fixer.php', 'php-cs-fixer');

        $this->publishes([
            __DIR__.'/../../config/php-cs-fixer.php' => config_path('php-cs-fixer.php'),
        ], 'php-cs-fixer-config');

        $this->publishes([
            __DIR__.'/../../config/ecs.php' => base_path('ecs.php'),
        ], 'php-cs-fixer-ecs-config');
    }
}
