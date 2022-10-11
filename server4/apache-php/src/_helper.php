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
        cost = 'cost';

    function openMysqli(): mysqli { return new mysqli(
        host, dbUser, password, db
    ); }

    function success() { echo 'Success'; }
    function error() { echo 'Error'; }
?>
