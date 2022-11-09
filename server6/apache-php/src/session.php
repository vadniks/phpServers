<?php require_once '_helper.php';
    define('requestMethod', $_SERVER[method]);
    const action = 'action';
    session_start();

    switch (requestMethod) {
        case methods[0]: isDark(); break;
        case methods[1]: post(); break;
        default: error(); break;
    }

    function isDark() { echo (isset($_SESSION[theme]) && $_SESSION[theme]) ? 'true' : 'false'; }

    function post() {
        if (!array_key_exists(action, $_POST)) { error(); return; }
        switch ($_POST[action]) {
            case test: enableTest(); break;
            case theme: setTheme(); break;
            case login: setLogin(); break;
            default: error(); break;
        }
    }

    function enableTest() {
        if (array_key_exists(test, $_POST)) $enable = $_POST[test]; else { error(); return; }
        if ($enable !== 'true' && $enable !== 'false') { error(); return; }
        $_SESSION[test] = $enable === 'true';
        echo 'changed to ' . ($_SESSION[test] ? 'true' : 'false');
    }

    function setTheme() {
        $theme = $_SESSION[theme] ?? false;
        $_SESSION[theme] = !$theme;
    }

    function setLogin() {
        $login = $_POST[login] ?? null;
        if (!$login) { error(); return; }
        $_SESSION[login] = $login;
    }
?>
