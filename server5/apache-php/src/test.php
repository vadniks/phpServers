<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>test</title>
        <?php require_once '_helper.php'; defineDarkTheme(); ?>
    </head>
    <body>
        <?php
            session_start();

            if (!$_SESSION[test] ?? false) {
                header('Location: /catalogue.php');
                exit();
            }

            const count = 'count';
            $count = $_SESSION[count] ?? 1;
            echo '<span>Sessions count: ' . $count . '</span>';
            $_SESSION[count] = ++$count;
        ?>
    </body>
</html>
