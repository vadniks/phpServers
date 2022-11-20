<?php

    abstract class AbsRepo {
        protected mysqli $mysqli;

        public function __construct() { $this->mysqli = openMysqli(); }
        public function __destruct() { $this->mysqli->close(); }
    }
?>
