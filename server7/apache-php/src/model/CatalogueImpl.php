<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php'; require_once 'ValuableRepo.php';

    class CatalogueImpl extends AbsViewImpl {
        public function draw() {
            $html = '';
            $result = (new ValuableRepo())->getAll();
            foreach ($result as $valuable) $html .= <<<dontCare
                <div
                    onclick="redir('view?id={$valuable->id}')" 
                    class="item"
                >
                    <span>{$valuable->title}</span>
                    <span>{$valuable->description}</span>
                    <span>{$valuable->cost}</span>
                </div>
            dontCare;
            echo "<div class=\"list\">{$html}</div>";
        }
    }
    new CatalogueImpl(new ValuableRepo());
?>
