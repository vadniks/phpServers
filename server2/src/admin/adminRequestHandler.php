<?php
    include_once 'AdminImpl.php';
    new AdminImpl(urldecode($_GET[AdminImpl::COMMAND]));
?>
