
<?php require_once '../_helper.php';
    const actions = ['create', 'read', 'update', 'delete'];
    const param = 'action';
    const columns = ['ID', 'name', 'password'];
    define("_id", strtolower(columns[0]));

    if (array_key_exists(param, $_GET) && $_GET[param] === actions[1]) read();
    else if (array_key_exists(param, $_POST)) switch ($_POST[param]) {
        case actions[0]: create(); break;
        case actions[2]: update(); break;
        case actions[3]: delete(); break;
        default: error(); break;
    } else error();

    function create() {
        if (array_key_exists(_id, $_POST)) $id = $_POST[_id];
        if (array_key_exists(columns[1], $_POST)) $name = $_POST[columns[1]];
        if (array_key_exists(columns[2], $_POST)) $password = $_POST[columns[2]];

        if (!isset($name) || !isset($password)) { error(); return; }
        $isIdPresent = isset($id) && is_numeric($id); if ($isIdPresent) $id = intval($id);

        $mysqli = openMysqli();
        $statement = $mysqli->prepare(sprintf('insert into %s(%s%s, %s) values(%s?, ?)',
            users, $isIdPresent ? columns[0] . ', ' : '',
            columns[1], columns[2], $isIdPresent ? '?, ' : ''));
        $isIdPresent
            ? $statement->bind_param('iss', $id, $name, $password)
            : $statement->bind_param('ss', $name, $password);
        $statement->execute() ? success() : error();
        $mysqli->close();
    }

    function read() {
        if (array_key_exists(_id, $_GET)) $id = $_GET[_id];
        if (array_key_exists(columns[1], $_GET)) $name = $_GET[columns[1]];
        if (array_key_exists(columns[2], $_GET)) $password = $_GET[columns[2]];

        if (isset($id) && is_numeric($id)) {
            $select = columns[0];
            $param = intval($id);
            $type = 'i';
        } elseif (isset($name)) {
            $select = columns[1];
            $param = $name;
            $type = 's';
        } elseif (isset($password)) {
            $select = columns[2];
            $param = $password;
            $type = 's';
        } else {
            error();
            return;
        }

        $mysqli = openMysqli();
        $statement = $mysqli->prepare(sprintf('select * from %s where %s = ?', users, $select));
        $statement->bind_param($type, $param);

        if (!$statement->execute()) { error(); return; }
        $result = $statement->get_result()->fetch_assoc();

        echo sprintf('{"%s": %d, "%s": "%s", "%s": "%s"}',
            columns[0], $result[columns[0]],
            columns[1], $result[columns[1]],
            columns[2], $result[columns[2]]);

        $mysqli->close();
    }

    function update() {
        if (array_key_exists(_id, $_POST)) $id = $_POST[_id];
        if (!isset($id)) { error(); return; }

        if (array_key_exists(columns[1], $_POST)) $name = $_POST[columns[1]];
        if (array_key_exists(columns[2], $_POST)) $password = $_POST[columns[2]];

        if (isset($name)) {
            $which = columns[1];
            $param = $name;
        } elseif (isset($password)) {
            $which = columns[2];
            $param = $password;
        } else {
            error();
            return;
        }

        $mysqli = openMysqli();
        $statement = $mysqli->prepare(sprintf('update %s set %s = ? where %s = ?',
            users, $which, columns[0]));
        $statement->bind_param('si', $param, $id);
        $statement->execute() ? success() : error();
        $mysqli->close();
    }

    function delete() {
        if (array_key_exists(_id, $_POST)) $id = $_POST[_id];
        if (!isset($id)) { error(); return; }

        $mysqli = openMysqli();
        $statement = $mysqli->prepare(sprintf('delete from %s where %s = ?', users, columns[0]));
        $statement->bind_param('i', $id);
        $statement->execute() ? success() : error();
        $mysqli->close();
    }
?>
