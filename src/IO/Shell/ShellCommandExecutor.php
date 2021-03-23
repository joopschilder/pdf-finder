<?php

namespace IO\Shell;

trait ShellCommandExecutor
{
    protected function shellExec(string $command, string ...$args): array
    {
        $args = array_map('escapeshellarg', $args);

        $output = shell_exec(sprintf(
            '%s %s 2>/dev/null',
            escapeshellcmd($command),
            implode(' ', $args)
        ));

        return explode(PHP_EOL, $output);
    }
}
