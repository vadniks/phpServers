<?php

class SortImpl {
    const PARAMETER_NAME = 'array';
    private const DELIMITER = ',';
    private array $array = [];
    private int $length = 0;

    public function __construct(string $arrayStr, callable $onDone) {
        if (!$this->checkForBadSymbols($arrayStr)) {
            echo 'Url parameter must be a string containing nothing but numbers' .
                'and each of them must be divided by the comma symbol i.e. 1,2,3,...';
            return;
        }

        $token = strtok($arrayStr, self::DELIMITER);

        while ($token !== false) {
            array_push($this->array, $token);
            $this->length++;
            $token = strtok(self::DELIMITER);
        }
        $this->shellSort();
        $onDone($this->array);
    }

    /** @noinspection PhpStatementHasEmptyBodyInspection */
    private function checkForBadSymbols(string $arrayStr): bool {
        $alphabet = ',';
        for ($i = 0; $i <= 9; $alphabet .= $i++);
        for ($i = 0; $i < strlen($arrayStr); $i++) {
            $isGood = false;
            for ($j = 0; $j < strlen($alphabet); $isGood |= $arrayStr[$i] === $alphabet[$j], $j++);
            if (!$isGood) return false;
        }
        return true;
    }

    private function shellSort() { for ($interval = $this->length; $interval > 0; $interval /= 2) {
        for ($i = $interval; $i < $this->length; $i++) {
            $temp = $this->array[$i];
            $j = $i;
            for (; $j >= $interval && $this->array[$j - $interval] > $temp; $j -= $interval)
              $this->array[$j] = $this->array[$j - $interval];
            $this->array[$j] = $temp;
        }
    } }
}

?>
