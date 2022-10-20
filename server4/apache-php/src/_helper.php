<?php
    const
        host = 'mysql',
        users = 'users',
        name = 'name',
        dbUser = 'user',
        password = 'password',
        db = 'appDB',
        valuables = 'valuables',
        id = 'ID',
        title = 'title',
        description = 'description',
        cost = 'cost',
        phpInput = 'php://input',
        method = 'REQUEST_METHOD',
        methods = ['GET', 'POST', 'PUT', 'DELETE'];

    function openMysqli(): mysqli
    { return new mysqli(host, dbUser, password, db); }

    function success() { echo 'Success'; }
    function error() { echo 'Error'; }
    function defineArgs(&$result) { parse_str(file_get_contents(phpInput),$result); }
?>
