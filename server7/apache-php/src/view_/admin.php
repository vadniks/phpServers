<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Administrate</title>
        <style>span { margin: 10px; }</style>
        <?php require_once '../_helper.php'; defineDarkTheme(); ?>
        <script src="http://localhost:8082/_helper"></script>
    </head>
    <body>
        <h1>List of users</h1>
        <div id="placeholder" style="
            display: flex;
            flex-direction: column;
        "></div>
        <script>impl('/impl/admin')</script>
    </body>
</html>
