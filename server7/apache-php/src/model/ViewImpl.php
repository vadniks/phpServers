<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php';

    class ViewImpl extends AbsViewImpl {
        public function draw() {
            $id = $_GET[strtolower(id)];
            if (!isset($id) || !is_numeric($id)) throw new Exception();

            $mysqli = openMysqli();
            $statement = $mysqli->prepare(sprintf(
                'select * from %s where %s = ?',
                valuables, id
            ));
            $_id = intval($id);
            $statement->bind_param('i', $_id);
            $statement->execute();
            $valuable = $statement->get_result()->fetch_assoc();
            echo <<<whatever
                <h1>$valuable[title]</h1><br>
                <span>$valuable[description]</span><br>
                <span>Cost: </span><span>$valuable[cost]</span>
            whatever;
            $mysqli->close();
        }
    }
    new ViewImpl();
?>
