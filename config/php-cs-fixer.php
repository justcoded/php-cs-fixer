<?php

declare(strict_types=1);

return [
    /*
    | If null Symfony\Component\Process\Process::isTtySupported() is used.
    | You probably want it to be false to be able to capture the output.
    */
    'tty' => env('PHP_CS_FIXER_TTY', false),

    /*
    | Path to ecs.php config file. Could be used to override default/root config.
    | Could be either absolute or relative to a project root.
    */
    'ecs_path' => env('PHP_CS_FIXER_ECS_PATH', null),
];
