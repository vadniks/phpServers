<?php require_once '../_helper.php'; require_once 'AbsPersistentRequestHandler.php';

    class Users extends AbsPersistentRequestHandler {
        private const columns = ['ID', 'name', 'password'];

        //curl 'http://localhost:8082/api/users' -d 'id=1' -X GET
        //curl 'http://localhost:8082/api/users' -d 'name=a&password=b' -X POST
        //curl 'http://localhost:8082/api/users' -d 'id=2&name=aa&password=bb' -X PUT
        //curl 'http://localhost:8082/api/users' -d 'id=2' -X DELETE
        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments);
            switch ($requestMethod) {
                case methods[0]: $this->read(); break;
                case methods[1]: $this->create(); break;
                case methods[2]: $this->update(); break;
                case methods[3]: $this->delete(); break;
                default: error(); break;
            }
        }

        private function create() {
            $statement = $this->mysqli->prepare(sprintf(
                'insert into %s (%s, %s) values(?, ?)',
                users, self::columns[1], self::columns[2]
            ));
            $statement->bind_param('ss', $this->arguments[1], $this->arguments[2]);
            $statement->execute() ? success() : error();
        }

        private function read() {
            $id = $this->arguments[0];
            $name = $this->arguments[1];
            $password = $this->arguments[2];

            if ($id != null) {
                $select = self::columns[0];
                $param = intval($id);
                $type = 'i';
            } elseif ($name != null) {
                $select = self::columns[1];
                $param = $name;
                $type = 's';
            } elseif ($password != null) {
                $select = self::columns[2];
                $param = $password;
                $type = 's';
            } else {
                error();
                return;
            }

            $statement = $this->mysqli->prepare(sprintf(
                'select * from %s where %s = ?',
                users, $select
            ));
            $statement->bind_param($type, $param);

            if (!$statement->execute()) { error(); return; }
            $result = $statement->get_result()->fetch_assoc();
            if ($result == null) { error(); return; }

            header('Content-Type: application/json; charset=utf-8');
            echo sprintf('{"%s": %d, "%s": "%s", "%s": "%s"}',
                self::columns[0], $result[self::columns[0]],
                self::columns[1], $result[self::columns[1]],
                self::columns[2], $result[self::columns[2]]);
        }

        private function update() {
            $statement = $this->mysqli->prepare(sprintf(
                'update %s set %s = ?, %s = ? where %s = ?',
                users, self::columns[1], self::columns[2], self::columns[0]
            ));
            $id = intval($this->arguments[0]); // sql injections in cursov
            $statement->bind_param('ssi', $this->arguments[1], $this->arguments[2], $id);
            $statement->execute() ? success() : error();
        }

        private function delete() {
            $statement = $this->mysqli->prepare(sprintf(
                'delete from %s where %s = ?',
                users, self::columns[0]
            ));
            $statement->bind_param('i', $this->arguments[0]);
            $statement->execute() ? success() : error();
        }
    }
?>
