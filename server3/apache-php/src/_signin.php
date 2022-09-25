<?php require_once '_helper.php';
    const cookie = 'auth';

    header('Access-Control-Allow-Origin: *');

    $name = $_GET[name]; $password = $_GET[password];
    if (!isset($name) || !isset($password)) { echo 'false'; exit(0); }

    $mysqli = openMysqli();
    $statement = $mysqli->prepare(sprintf(
        'select %s from %s where name = ? and password = ?',
        id, users
    ));
    $statement->bind_param('ss', $name, $password);
    $statement->execute();
    $result = $statement->get_result()->num_rows === 1;
    $mysqli->close();

    if ($result) {
        setcookie(cookie, strval(rand(0, 9)));
        header('Location: ' . '/admin.php');
        exit(0);
    } else {
        setcookie(cookie, null);
        echo 'Wrong credentials';
    }
?>
