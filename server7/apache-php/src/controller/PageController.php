<?php require_once '../_helper.php';

    class PageController {
        private static ?PageController $instance = null;

        public static function getInstance(): ?PageController { return
            self::$instance == null
                ? (self::$instance = new PageController())
                : self::$instance; }

        public function route(string $route) { switch (withoutParamsIfPresent($route)) {
            case uriCatalogue: $which = '../view_/catalogue.php'; break;
            case uriView_: $which = '../view_/view.php'; break;
            case uriTest: $which = '../view_/test.php'; break;
            case uriPdf: $which = '../view_/pdf.php'; break;
            case uriStatistics: $which = '../view_/statistics.php'; break;
            default: error(); break;
        } if (isset($which)) echoEvaluated($which); else error(); }
    }
?>
