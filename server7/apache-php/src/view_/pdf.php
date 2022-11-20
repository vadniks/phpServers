<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Files</title>
        <script src="http://localhost:8082/_helper"></script>
        <?php require_once '../_helper.php'; defineDarkTheme(); ?>
    </head>
    <body>
        <form action="/files" method="post" enctype="multipart/form-data">
            Select PDF File to Upload:
            <input type="file" name="file">
            <input type="submit" name="submit" value="Upload">
        </form>
        <button onclick="redir('/files')">Download file</button>
    </body>
</html>
