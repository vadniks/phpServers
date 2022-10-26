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
        methods = ['GET', 'POST', 'PUT', 'DELETE'],
        login = 'login',
        theme = 'theme',
        test = 'test';

    function openMysqli(): mysqli
    { return new mysqli(host, dbUser, password, db); }

    function success() { echo 'Success'; }
    function error() { echo 'Error'; http_response_code(400); }
    function defineArgs(&$result) { parse_str(file_get_contents(phpInput),$result); }

    function defineDarkTheme() { session_start(); if (isset($_SESSION[theme]) && $_SESSION[theme]) echo <<<A
        <style>
            body { background-color: black; }
            span { color: white; }
            h1 { color: white; }
            button { background-color: black; color: white; }
            input { background-color: black; color: white; }
            form { color: white; }
        </style>
    A; }
?>
