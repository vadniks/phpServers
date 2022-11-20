<?php require_once 'AbsRepo.php'; require_once '../_helper.php'; require_once 'Valuable.php';

    class ValuableRepo extends AbsRepo {

        public function getAll(): array {
            $array = [];
            foreach ($this->mysqli->query("select * from " . valuables) as $valuable)
                array_push($array, new Valuable(
                    $valuable[id],
                    $valuable[title],
                    $valuable[description],
                    $valuable[cost]
                ));
            return $array;
        }

        public function getById(int $id): Valuable {
            $statement = $this->mysqli->prepare(sprintf(
                'select * from %s where %s = ?',
                valuables, id
            ));
            $statement->bind_param('i', $id);
            $statement->execute();
            $result = $statement->get_result()->fetch_assoc();

            return new Valuable(
                $result[id],
                $result[title],
                $result[description],
                $result[cost]
            );
        }

        public function sum(): int {
            $result = $this->mysqli->query(sprintf(
                'select sum(%s) from %s',
                cost, valuables
            ));
            if ($result->num_rows !== 1) { error(); return -1; }
            return array_values($result->fetch_assoc())[0];
        }

        public function sale(int $multiplier, bool $mode): bool {
            $statement = $this->mysqli->prepare(sprintf('update %s set %s = %s %s ?',
                valuables, cost, cost, $mode ? '*' : '/'));
            $statement->bind_param('i', $multiplier);
            return $statement->execute() == true;
        }
    }
?>
