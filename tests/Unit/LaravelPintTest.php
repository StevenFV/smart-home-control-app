<?php

use Symfony\Component\Process\Process;

it('runs laravel pint', function () {
    $command = './vendor/bin/pint --test';

    $process = Process::fromShellCommandline($command);
    $process->run();

    expect($process->getExitCode())->toBe(0, 'Laravel pint error(s):' . $process->getOutput());
});
