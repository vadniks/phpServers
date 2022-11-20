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
        idParam = 'id',
        title = 'title',
        description = 'description',
        cost = 'cost',
        phpInput = 'php://input',
        method = 'REQUEST_METHOD',
        uri = 'REQUEST_URI',
        uriView = '/view',
        uriApiUsers = '/api/users',
        uriApiValuables = '/api/valuables',
        uriSession = '/session',
        uriFiles = '/files',
        uriGraphs = '/graphs',
        uriCatalogue = uriView . '/catalogue',
        uriView_ = uriView . '/view',
        uriAdmin = uriView . '/admin',
        uriTest = uriView . '/test',
        uriPdf = uriView . '/pdf',
        uriStatistics = uriView . '/statistics',
        uriImplCatalogue = '/impl/catalogue',
        uriImplView = '/impl/view',
        uriImplAdmin = '/impl/admin',
        methods = ['GET', 'POST', 'PUT', 'DELETE'],
        login = 'login',
        theme = 'theme',
        test = 'test',
        action = 'action';

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

    function method(): ?string { return $_SERVER[method]; }
    function uri(): ?string { return $_SERVER[uri]; }

    function withoutParamsIfPresent(string $route): string { return
        str_contains($route, '?') ? explode('?', $route)[0] : $route; }

    /** @noinspection PhpIncludeInspection */
    function echoEvaluated(string $which) {
        $evaluated = require_once $which;
        echo substr($evaluated, 0, strlen($evaluated) - 1);
    }
?>
