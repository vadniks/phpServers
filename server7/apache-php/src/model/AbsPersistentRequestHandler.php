<?php use JetBrains\PhpStorm\Pure; require_once 'AbsRequestHandler.php'; require_once '../_helper.php';

    abstract class AbsPersistentRequestHandler extends AbsRequestHandler {
        protected AbsRepo $repo;

        #[Pure] public function __construct(array $arguments, AbsRepo $repo) {
            parent::__construct($arguments);
            $this->repo = $repo;
        }
    }
?>
