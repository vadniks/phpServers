<?php require_once '../_helper.php'; new RestrictedController(uri());

    class RestrictedController {
        public function __construct(string $route) { switch ($route) {
            case uriAdmin: $which = '../view_/admin.php'; break;
            case uriImplAdmin: $which = '../model/AdminImpl.php'; break;
            default: error(); break;
        } if (isset($which)) echoEvaluated($which); else error(); }
    }
?>
