<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php'; require_once 'ValuableRepo.php';

    class ViewImpl extends AbsViewImpl {
        public function draw() {
            $id = $_GET[strtolower(id)];
            if (!isset($id) || !is_numeric($id)) throw new Exception();

            $valuable = (new ValuableRepo())->getById(intval($id));
            echo <<<weirdSyntaxIsntIt
                <h1>{$valuable->title}</h1><br>
                <span>{$valuable->description}</span><br>
                <span>Cost: </span><span>{$valuable->cost}</span>
            weirdSyntaxIsntIt;
        }
    }
    new ViewImpl(new ValuableRepo());
?>
