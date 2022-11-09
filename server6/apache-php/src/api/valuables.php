<?php require_once '../_helper.php';
    const multiplier = 'multiplier';
    const mode = 'mode';
    define('requestMethod', $_SERVER[method]);

    if (requestMethod === methods[0]) sum();
    else if (requestMethod === methods[1]) sale();
    else error();

    function sum() {
        $mysqli = openMysqli();
        $result = $mysqli->query(sprintf('select sum(%s) from %s', cost, valuables));

        if ($result->num_rows !== 1) { error(); return; }
        echo array_values($result->fetch_assoc())[0];

        $mysqli->close();
    }

    function sale() {
        if (array_key_exists(multiplier, $_POST)) $multiplier = $_POST[multiplier];
        if (array_key_exists(mode, $_POST)) $mode = $_POST[mode];

        if (!isset($multiplier) || !is_numeric($multiplier)
            || !isset($mode) || !is_numeric($mode))
        { error(); return; }

        $mysqli = openMysqli();
        $statement = $mysqli->prepare(sprintf('update %s set %s = %s %s ?',
            valuables, cost, cost, intval($mode) == 0 ? '*' : '/'));
        $statement->bind_param('i', $multiplier);
        $statement->execute() ? success() : error();
        $mysqli->close();
    }
?>