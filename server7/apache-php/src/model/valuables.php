<?php require_once '../_helper.php'; require_once 'AbsPersistentRequestHandler.php';

    class Valuables extends AbsPersistentRequestHandler {

        // curl 'http://localhost:8082/api/valuables' -X GET
        // curl 'http://localhost:8082/api/valuables' -d 'multiplier=2&mode=1' -X POST
        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments);
            switch ($requestMethod) {
                case methods[0]: $this->sum(); break;
                case methods[1]: $this->sale(); break;
                default: error(); break;
            }
        }

        private function sum() {
            $result = $this->mysqli->query(sprintf(
                'select sum(%s) from %s',
                cost, valuables
            ));
            if ($result->num_rows !== 1) { error(); return; }
            echo array_values($result->fetch_assoc())[0];
        }

        private function sale() {
            $multiplier = $this->arguments[0];
            $mode = $this->arguments[1];

            if (!isset($multiplier) || !is_numeric($multiplier)
                || !isset($mode) || !is_numeric($mode))
            { error(); return; }

            $mysqli = openMysqli();
            $statement = $mysqli->prepare(sprintf('update %s set %s = %s %s ?',
                valuables, cost, cost, intval($mode) == 0 ? '*' : '/'));
            $statement->bind_param('i', $multiplier);
            $statement->execute() ? success() : error();
            $mysqli->close();
        }
    }
?>
