<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php';

    class CatalogueImpl extends AbsViewImpl {
        public function draw() {
            $mysqli = openMysqli();
            $result = $mysqli->query("select * from " . valuables);

            $html = '';
            if ($result->num_rows > 0) foreach ($result as $valuable) $html .= <<<sheeeaaat
                <div
                    onclick="redir('view?id={$valuable[id]}')" 
                    class="item">
                    <span>{$valuable[title]}</span>
                    <span>{$valuable[description]}</span>
                    <span>{$valuable[cost]}</span>
                </div>
            sheeeaaat; else $html = 'Empty';

            $mysqli->close();
            echo "<div class=\"list\">{$html}</div>";
        }
    }
    new CatalogueImpl();
?>
