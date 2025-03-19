<?php

declare(strict_types=1);

namespace JustCoded\PhpCsFixer\Utils;

use Composer\Autoload\ClassLoader;

class Utils
{
    public static function getAppBasePath(): string
    {
        return match (true) {
            function_exists('base_path') => base_path(),
            isset($_ENV['APP_BASE_PATH']) => $_ENV['APP_BASE_PATH'],
            default => dirname(array_values(array_filter(
                array_keys(ClassLoader::getRegisteredLoaders()),
                fn($path) => !str_starts_with($path, 'phar://'),
            ))[0]),
        };
    }
}
