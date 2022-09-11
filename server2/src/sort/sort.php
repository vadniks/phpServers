<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Shell sort</title>
    </head>
    <body>
        <?php
            include_once 'SortImpl.php';
            $a = new SortImpl($_GET[SortImpl::PARAMETER_NAME], function($array) {
                foreach ($array as &$item) echo $item, ',';
            });
        ?>
    </body>
</html>
