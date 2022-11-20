<?php require_once '../_helper.php'; require_once 'AbsViewImpl.php'; require_once 'UserRepo.php';

    class AdminImpl extends AbsViewImpl {
        public function draw() {
            $html = '';
            foreach ((new UserRepo())->getAll() as $user) $html .= <<<whatever
                <div style="
                    display: flex;
                    flex-direction: row;
                ">
                    <span>{$user->id}</span><span>{$user->name}</span><span>{$user->password}</span>
                </div>
            whatever;
            echo $html;
        }
    }
    new AdminImpl(new UserRepo());
?>
