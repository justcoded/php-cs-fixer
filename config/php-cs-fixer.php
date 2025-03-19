<?php

declare(strict_types=1);

return [
    /*
    | If null Symfony\Component\Process\Process::isTtySupported() is used.
    | You probably want it to be false to be able to capture the output.
    */
    'tty' => env('PHP_CS_FIXER_TTY', false),
];
