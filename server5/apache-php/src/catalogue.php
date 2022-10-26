<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Catalogue</title>
        <script src="http://localhost:8082/_helper.js"></script>

        <style>
            span { margin: 10px; }
            .list {
                display: flex;
                flex-direction: column;
            }
            .item {
                display: flex;
                flex-direction: row;
                cursor: pointer;
            }
            .item:hover { background-color: cadetblue; }
        </style>
        <?php require_once '_helper.php'; defineDarkTheme(); ?>

        <script>
            function params(param) { return {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                body: param
            } }
            function ftch(param) { fetch('/session.php', params(param)).then(reload) }

            function reload() { redir('/catalogue.php') }
            function enableTest(enable) { ftch('action=test&test=' + enable) }
            function changeTheme() { ftch('action=theme') }
            function setLogin() { ftch('action=login&login=' + document.querySelector('input').value) }
        </script>

    </head>
    <body>
        <?php if (isset($_SESSION[login])) echo '<h1>Welcome ' . $_SESSION[login] . '</h1><br/>'; ?>
        <input placeholder="login"><button onclick="setLogin()">Set login</button><br>
        <button onclick="changeTheme()">Change theme</button>
        <?php
            if (isset($_SESSION[test]) && $_SESSION[test])
                echo '<button onclick="enableTest(false)">Disable test</button>';
            else echo '<button onclick="enableTest(true)">Enable test</button>';
        ?>
        <br/>

        <h1>Catalogue</h1>
        <?php
            $mysqli = openMysqli();
            $result = $mysqli->query("select * from " . valuables);
        ?>
        <div class="list"><?php if ($result->num_rows > 0) foreach ($result as $valuable) echo <<<A
            <div
                onclick="redir('view.php?id={$valuable[id]}')" 
                class="item">
                <span>{$valuable[title]}</span>
                <span>{$valuable[description]}</span>
                <span>{$valuable[cost]}</span>
            </div>
        A; else echo 'Empty'; ?></div>
    </body>
</html>
