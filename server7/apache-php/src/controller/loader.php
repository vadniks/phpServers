<?php require_once '../_helper.php'; require_once 'PageController.php'; require_once 'RestController.php';
    define('route', uri());

    if (method() == methods[0] && str_starts_with(route, uriView))
        PageController::getInstance()->route(route);
    else if (!str_starts_with(uri(), uriView))
        RestController::getInstance()->route(route);
    else
        error();
?>
