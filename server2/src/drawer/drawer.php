<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Drawer</title>
    </head>
    <body>
        <?php
            include_once 'DrawerImpl.php';
            $parameter = $_GET[DrawerImpl::PARAMETER_NAME];

            if (!is_numeric($parameter) || $parameter > 0b11111111 || $parameter < 0)
                echo 'Url parameter must be a string containing a 8 bit unsigned integer';
            else new DrawerImpl($parameter);
        ?>
    </body>
</html>
