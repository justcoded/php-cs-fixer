<?php

declare(strict_types=1);

namespace JustCoded\PhpCsFixer\Services;

use Closure;
use Illuminate\Support\Arr;
use JustCoded\PhpCsFixer\DTO\CodeFixerResult;
use JustCoded\PhpCsFixer\Utils\Utils;
use Symfony\Component\Process\Process;

class CodeFixer
{
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->config['tty'] = $this->config['tty'] ?? Process::isTtySupported();
    }

    public function check(
        array|string|null $path = null,
        array $config = [],
        ?Closure $callback = null,
    ): CodeFixerResult {
        return $this->execute($path, config: $config, callback: $callback);
    }

    public function fix(
        array|string|null $path = null,
        array $config = [],
        ?Closure $callback = null,
    ): CodeFixerResult {
        return $this->execute($path, fix: true, config: $config, callback: $callback);
    }

    public function execute(
        array|string|null $path = null,
        bool $fix = false,
        array $config = [],
        ?Closure $callback = null,
    ): CodeFixerResult {
        $tty = $config['tty'] ?? $this->config['tty'];
        $ecsConfigPath = $config['ecs_path'] ?? $this->config['ecs_path'] ?? null;
        $basePath = Utils::getAppBasePath();
        $ecsConfigPath = $this->getEcsConfigPath($basePath, $ecsConfigPath);

        $paths = match (true) {
            is_null($path) => [$basePath],
            is_array($path) => $path,
            default => [$path],
        };

        $cmd = [
            "{$basePath}/vendor/bin/ecs",
            "--config={$ecsConfigPath}",
            "check",
            ...($fix ? ["--fix"] : []),
            ...$paths,
        ];

        $process = new Process($cmd);
        $process->setTty($tty);
        $process->run($callback);

        return CodeFixerResult::make(
            successful: $process->isSuccessful(),
            output: $process->getOutput() . $process->getErrorOutput(),
        );
    }

    protected function getEcsConfigPath(string $basePath, ?string $ecsConfigPath = null): string
    {
        return match (true) {
            isset($ecsConfigPath) && file_exists($ecsConfigPath) => realpath($ecsConfigPath),
            isset($ecsConfigPath) && file_exists("{$basePath}/{$ecsConfigPath}") => realpath("{$basePath}/{$ecsConfigPath}"),
            file_exists("{$basePath}/ecs.php") => realpath("{$basePath}/ecs.php"),
            default => realpath(__DIR__ . "/../../config/ecs.php"),
        };
    }
}
