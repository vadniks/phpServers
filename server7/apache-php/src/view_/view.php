<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Valuable details</title>
        <?php require_once '../_helper.php'; defineDarkTheme(); ?>
        <script src="http://localhost:8082/_helper"></script>
    </head>
    <?php
        $id = $_GET[strtolower(id)];
        if (!isset($id) || !is_numeric($id)) throw new Exception();
    ?>
    <?php echo "<body id=\"placeholder\"><script>impl('/impl/view?id={$id}')</script></body>" ?>
</html>
