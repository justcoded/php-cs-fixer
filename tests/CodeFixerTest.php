<?php

declare(strict_types=1);

use JustCoded\PhpCsFixer\DTO\CodeFixerResult;
use JustCoded\PhpCsFixer\Services\CodeFixer;
use Symfony\Component\Process\Process;

beforeEach(function () {
    $codeDir = __DIR__ . '/Code';

    if (!is_dir($codeDir)) {
        mkdir($codeDir, 0777, true);
    }

    foreach (['Valid', 'InValid'] as $stub) {
        file_put_contents(
            "{$codeDir}/{$stub}.php",
            file_get_contents(__DIR__ . "/stubs/{$stub}.php.stub"),
        );
    }
});


afterEach(function () {
    $codeDir = __DIR__ . '/Code';

    foreach (['Valid', 'InValid'] as $stub) {
        $file = "{$codeDir}/{$stub}.php";

        if (file_exists($file)) {
            unlink($file);
        }
    }

    if (file_exists("{$codeDir}/ecs.php")) {
        unlink("{$codeDir}/ecs.php");
    }

    if (is_dir($codeDir)) {
        rmdir($codeDir);
    }
});


it('can instantiate CodeFixer with default config', function () {
    $fixer = new CodeFixer();

    expect($fixer)->toBeInstanceOf(CodeFixer::class)
        ->and((fn() => $this->config['tty'])->call($fixer))->toBe(Process::isTtySupported());
});

it('can instantiate CodeFixer with custom config', function () {
    $fixer = new CodeFixer(['tty' => true]);

    expect($fixer)->toBeInstanceOf(CodeFixer::class)
        ->and((fn() => $this->config['tty'])->call($fixer))->toBeTrue();
});

it('runs check command successfully', function () {
    $fixer = new CodeFixer(['tty' => false]);
    $result = $fixer->check(__DIR__ . '/Code/Valid.php', config: ['tty' => false]);

    expect($result)->toBeInstanceOf(CodeFixerResult::class)
        ->and($result->successful)->toBeTrue()
        ->and($result->output)->toBeString();
});

it('runs fix command successfully', function () {
    $fixer = new CodeFixer(['tty' => false]);
    $result = $fixer->fix(__DIR__ . '/Code', config: ['tty' => false]);

    expect($result)->toBeInstanceOf(CodeFixerResult::class)
        ->and($result->successful)
        ->toBeTrue()
        ->and($result->output)
        ->toBeString()
        ->and(file_get_contents(__DIR__ . '/Code/InValid.php'))
        ->toEqual(str_replace('Valid', 'InValid', file_get_contents(__DIR__ . '/Code/Valid.php')));

});

it('runs execute command with fix flag', function () {
    $fixer = new CodeFixer(['tty' => false]);
    $result = $fixer->execute(__DIR__ . '/Code', fix: true, config: ['tty' => false]);

    expect($result)->toBeInstanceOf(CodeFixerResult::class)
        ->and($result->successful)->toBeTrue()
        ->and($result->output)->toBeString();
});

it('returns custom ecs.php path if file exists', function () {
    $fixer = new CodeFixer(['tty' => false]);
    $ecsPath = __DIR__ . '/Code/ecs.php';
    file_put_contents($ecsPath, file_get_contents(__DIR__ . '/../config/ecs.php'));

    $result = (fn() => $this->getEcsConfigPath(__DIR__ . '/Code'))->call($fixer);

    expect($result)->toBe(realpath($ecsPath));
});

it('returns default ecs.php path if no file exists in base path', function () {
    $fixer = new CodeFixer(['tty' => false]);

    $result = (fn() => $this->getEcsConfigPath(__DIR__ . '/Code'))->call($fixer);

    expect($result)->toBe(realpath(__DIR__ . "/../config/ecs.php"));
});
