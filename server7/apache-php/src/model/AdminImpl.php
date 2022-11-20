<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php';

    class AdminImpl extends AbsViewImpl {
        public function draw() {
            $mysqli = openMysqli();
            $users = $mysqli->query('select * from ' . users);

            $html = '';
            foreach ($users as $user) $html .= <<<thisSyntaxIsReallyWeird
                <div style="
                    display: flex;
                    flex-direction: row;
                ">
                    <span>{$user[id]}</span><span>{$user[name]}</span><span>{$user[password]}</span>
                </div>
            thisSyntaxIsReallyWeird;
            echo $html;

            $mysqli->close();
        }
    }
    new AdminImpl();
?>
