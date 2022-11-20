<?php

    class Valuable { public function __construct(
        public ?int $id,
        public string $title,
        public string $description,
        public int $cost
    ) {} }
?>
