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
    </head>
    <body>
        <h1>Catalogue</h1>
        <?php
            require_once '_helper.php';
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
