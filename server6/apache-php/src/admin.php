<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administrate</title>
        <style>span { margin: 10px; }</style>
        <?php require_once '_helper.php'; defineDarkTheme(); ?>
    </head>
    <body>
        <h1>List of users</h1>
        <?php
            $mysqli = openMysqli();
            $users = $mysqli->query('select * from ' . users);
        ?>
        <div style="
            display: flex;
            flex-direction: column;
        "><?php foreach ($users as $user) { echo <<<A
            <div style="
                display: flex;
                flex-direction: row;
            ">
                <span>{$user[id]}</span><span>{$user[name]}</span><span>{$user[password]}</span>
            </div>
        A; } ?></div>
        <?php $mysqli->close(); ?>
    </body>
</html>
