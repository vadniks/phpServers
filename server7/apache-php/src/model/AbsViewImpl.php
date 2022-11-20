<?php require_once '../_helper.php'; require_once 'AbsPersistentRequestHandler.php';

    abstract class AbsViewImpl extends AbsPersistentRequestHandler {

        public function __construct() {
            parent::__construct([]);
            $this->draw();
        }

        public abstract function draw();
    }
?>
