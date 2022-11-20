<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Catalogue</title>
        <script src="http://localhost:8082/_helper"></script>

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
        <?php require_once '../_helper.php'; defineDarkTheme(); ?>

        <script>
            function params(param) { return {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                body: param
            } }
            function ftch(param) { fetch('/session', params(param)).then(reload) }

            function reload() { redir('/view/catalogue') }
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
        <div id="placeholder" class="list"></div>
        <script>impl('/impl/catalogue')</script>
    </body>
</html>
