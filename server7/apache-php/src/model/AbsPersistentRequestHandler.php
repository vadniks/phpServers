<?php require_once '../_helper.php'; require_once 'AbsRequestHandler.php';

    abstract class AbsPersistentRequestHandler extends AbsRequestHandler {
        protected mysqli $mysqli;

        public function __construct(array $arguments) {
            parent::__construct($arguments);
            $this->mysqli = openMysqli();
        }

        public function __destruct() { $this->mysqli->close(); }
    }
?>
