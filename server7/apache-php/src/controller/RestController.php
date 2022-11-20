<?php require_once '../_helper.php'; require_once '../model/users.php';
      require_once '../model/valuables.php'; require_once '../model/session.php';
      require_once '../model/files.php'; require_once '../model/graphs.php';

    class RestController {
        private static ?RestController $instance = null;

        public static function getInstance(): ?RestController { return
            self::$instance == null
                ? (self::$instance = new RestController())
                : self::$instance; }

        private function getArgumentOrNull(string $which, array &$arguments): ?string { return
            (array_key_exists($which, $arguments) ? $arguments[$which] : null)
            ?? (array_key_exists($which, $_GET) ? $_GET[$which] : null)
            ?? (array_key_exists($which, $_POST) ? $_POST[$which] : null); }

        public function route(string $route) {
            $requestMethod = $_SERVER[method];
            defineArgs($arguments);

            switch (withoutParamsIfPresent($route)) {
                case uriApiUsers: new Users($requestMethod, [
                    $this->getArgumentOrNull(idParam, $arguments),
                    $this->getArgumentOrNull(name, $arguments),
                    $this->getArgumentOrNull(password, $arguments)
                ]); break;
                case uriApiValuables: new Valuables($requestMethod, [
                    $this->getArgumentOrNull('multiplier', $arguments),
                    $this->getArgumentOrNull('mode', $arguments)
                ]); break;
                case uriSession: new Session($requestMethod, [
                    $this->getArgumentOrNull(action, $arguments),
                    $this->getArgumentOrNull(test, $arguments),
                    $this->getArgumentOrNull(login, $arguments)
                ]); break;
                case uriFiles: new Files($requestMethod); break;
                case uriGraphs: new Graphs($requestMethod, [
                    $this->getArgumentOrNull('number', $arguments),
                    $this->getArgumentOrNull('type', $arguments),
                    $this->getArgumentOrNull('data', $arguments),
                ]); break;
                case uriImplCatalogue: echoEvaluated('../model/CatalogueImpl.php'); break;
                case uriImplView: echoEvaluated('../model/ViewImpl.php'); break;
                default: error(); break;
            }
        }
    }
?>
