<?php

use Symfony\Component\Process\Process;

it('runs laravel pint', function () {
    $command = './vendor/bin/pint';

    $process = Process::fromShellCommandline($command);
    $process->run();

    $output = $process->getOutput();

    expect($output)->toBe('', 'laravel pint errors and/or warnings:');
});
