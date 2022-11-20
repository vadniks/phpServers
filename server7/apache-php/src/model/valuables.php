<?php
    require_once '../_helper.php';
    require_once 'AbsPersistentRequestHandler.php';
    require_once 'ValuableRepo.php';
    require_once 'Valuable.php';

    class Valuables extends AbsPersistentRequestHandler {

        //curl 'http://localhost:8082/api/valuables' -X GET
        //curl 'http://localhost:8082/api/valuables' -d 'multiplier=2&mode=1' -X POST
        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments, new ValuableRepo());
            switch ($requestMethod) {
                case methods[0]: $this->sum(); break;
                case methods[1]: $this->sale(); break;
                default: error(); break;
            }
        }

        private function sum() { echo $this->repo->sum(); }

        private function sale() {
            $multiplier = $this->arguments[0];
            $mode = $this->arguments[1];

            if (!isset($multiplier) || !is_numeric($multiplier)
                || !isset($mode) || !is_numeric($mode))
            { error(); return; }

            $this->repo->sale($multiplier, intval($mode) == 0) ? success() : error();
        }
    }
?>
