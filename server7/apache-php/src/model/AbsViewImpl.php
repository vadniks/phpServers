<?php require_once '../_helper.php'; require_once 'AbsPersistentRequestHandler.php'; require_once 'AbsRepo.php';

    abstract class AbsViewImpl extends AbsPersistentRequestHandler {

        public function __construct(AbsRepo $repo) {
            parent::__construct([], $repo);
            $this->draw();
        }

        public abstract function draw();
    }
?>
