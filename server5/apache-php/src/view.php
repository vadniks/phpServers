<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Valuable details</title>
        <?php require_once '_helper.php'; defineDarkTheme(); ?>
    </head>
    <body>
        <?php $id = $_GET[strtolower(id)];
            if (!isset($id) || !is_numeric($id)) throw new Exception();

            $mysqli = openMysqli();
            $statement = $mysqli->prepare(sprintf('select * from %s where %s = ?', valuables, id));
            $_id = intval($id);
            $statement->bind_param('i', $_id);
            $statement->execute();
            $valuable = $statement->get_result()->fetch_assoc();
            echo <<<A
                <h1>$valuable[title]</h1><br>
                <span>$valuable[description]</span><br>
                <span>Cost: </span><span>$valuable[cost]</span>
            A;
            $mysqli->close();
        ?>
    </body>
</html>
