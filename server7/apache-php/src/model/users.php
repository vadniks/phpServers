<?php
    require_once '../_helper.php';
    require_once 'AbsPersistentRequestHandler.php';
    require_once 'User.php';
    require_once 'UserRepo.php';

    class Users extends AbsPersistentRequestHandler {

        //curl 'http://localhost:8082/api/users' -d 'id=1' -X GET
        //curl 'http://localhost:8082/api/users' -d 'name=a&password=b' -X POST
        //curl 'http://localhost:8082/api/users' -d 'id=2&name=aa&password=bb' -X PUT
        //curl 'http://localhost:8082/api/users' -d 'id=2' -X DELETE
        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments, new UserRepo());
            switch ($requestMethod) {
                case methods[0]: $this->read(); break;
                case methods[1]: $this->create(); break;
                case methods[2]: $this->update(); break;
                case methods[3]: $this->delete(); break;
                default: error(); break;
            }
        }

        private function create()
        { $this->repo->create($this->arguments[1], $this->arguments[2]) ? success() : error(); }

        private function read() {
            $result = $this->repo->read($this->arguments[0], $this->arguments[1], $this->arguments[2]);
            if ($result == null) { error(); return; }

            header('Content-Type: application/json; charset=utf-8');
            echo sprintf('{"%s": %d, "%s": "%s", "%s": "%s"}',
                UserRepo::columns[0], $result->id,
                UserRepo::columns[1], $result->name,
                UserRepo::columns[2], $result->password);
        }

        private function update() { $this->repo->update(new User(
            intval($this->arguments[0]),
            $this->arguments[1],
            $this->arguments[2]
        )) ? success() : error(); }

        private function delete()
        { $this->repo->delete(intval($this->arguments[0])) ? success() : error(); }
    }
?>
