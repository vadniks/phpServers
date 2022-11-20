<?php require_once 'AbsRepo.php'; require_once '../_helper.php'; require_once 'User.php';

    class UserRepo extends AbsRepo {
        public const columns = ['ID', 'name', 'password'];

        public function getAll(): array {
            $array = [];
            foreach ($this->mysqli->query('select * from ' . users) as $user)
                array_push($array, new User(
                    $user[id],
                    $user[name],
                    $user[password]
                ));
            return $array;
        }

        public function create(string $name, string $password): bool {
            $statement = $this->mysqli->prepare(sprintf(
                'insert into %s (%s, %s) values(?, ?)',
                users, self::columns[1], self::columns[2]
            ));
            $statement->bind_param('ss', $name, $password);
            return $statement->execute() == true;
        }

        public function read(?int $id, ?string $name, ?string $password): ?User {
            if ($id != null) {
                $select = self::columns[0];
                $param = $id;
                $type = 'i';
            } elseif ($name != null) {
                $select = self::columns[1];
                $param = $name;
                $type = 's';
            } elseif ($password != null) {
                $select = self::columns[2];
                $param = $password;
                $type = 's';
            } else
                return null;

            $statement = $this->mysqli->prepare(sprintf(
                'select * from %s where %s = ?',
                users, $select
            ));
            $statement->bind_param($type, $param);

            if (!$statement->execute()) return null;
            $result = $statement->get_result()->fetch_assoc();
            if ($result == null) return null;

            return new User(
                $result[self::columns[0]],
                $result[self::columns[1]],
                $result[self::columns[2]]
            );
        }

        public function update(User $user): bool {
            $statement = $this->mysqli->prepare(sprintf(
                'update %s set %s = ?, %s = ? where %s = ?',
                users, self::columns[1], self::columns[2], self::columns[0]
            ));
            $statement->bind_param('ssi', $user->name, $user->password, $user->id);
            return $statement->execute() == true;
        }

        public function delete(int $id): bool {
            $statement = $this->mysqli->prepare(sprintf(
                'delete from %s where %s = ?',
                users, self::columns[0]
            ));
            $statement->bind_param('i', $id);
            return $statement->execute() == true;
        }
    }
?>
