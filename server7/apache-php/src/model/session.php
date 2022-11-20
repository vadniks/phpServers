<?php require_once '../_helper.php'; require_once 'AbsRequestHandler.php';

    class Session extends AbsRequestHandler {

        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments);
            session_start();
            switch ($requestMethod) {
                case methods[0]: $this->isDark(); break;
                case methods[1]: $this->post(); break;
                default: error(); break;
            }
        }

        function isDark() { echo (isset($_SESSION[theme]) && $_SESSION[theme]) ? 'true' : 'false'; }

        function post() {
            switch ($this->arguments[0]) {
                case test: $this->enableTest(); break;
                case theme: $this->setTheme(); break;
                case login: $this->setLogin(); break;
                default: error(); break;
            }
        }

        function enableTest() {
            $enable = $this->arguments[1];
            if ($enable !== 'true' && $enable !== 'false') { error(); return; }
            $_SESSION[test] = $enable === 'true';
        }

        function setTheme() { $_SESSION[theme] = !($_SESSION[theme] ?? false); }
        function setLogin() { $_SESSION[login] = $this->arguments[2]; }
    }
?>
