<?php

class AdminImpl {
    const COMMAND = 'command';
    const LS = 'ls';
    const PS = 'ps';
    const WHOAMI = 'whoami';
    const ID = 'id';
    const PWD = 'pwd';
    const UNAME_A = 'uname -a';
    const DELIMITER = ' ';

    public function __construct(string $command) {
        $result = match ($command) {
            self::LS, self::PS, self::WHOAMI, self::ID, self::PWD, self::UNAME_A => $this->exec($command),
            default => throw new Exception('Unsupported operation')
        };
        if ($result == null) throw new Exception();
        echo $result;
    }

    private function exec(string $command): string | null {
        exec($command, $output, $status);
        return implode(self::DELIMITER, $output);
    }
}

?>
