<?php use MongoDB\BSON\Binary;
    require '../vendor/autoload.php'; require_once '_helper.php';
    const dir = '/var/www/files/';
    define('requestMethod', $_SERVER[method]);
    const file = 'file',
        name = 'name',
        tmpName = 'tmp_name',
        url = 'mongodb://mongo:27017',
        files = 'files',
        id = 'id';

    if (requestMethod === methods[1]) upload();
    else if (requestMethod === methods[0]) download();

    function upload() {
        $tempFile = $_FILES[file][tmpName];
        $fileName = $_FILES[file][name];

        if (!isset($_POST['submit']) || empty($fileName)) { error(); return; }
        if (pathinfo(basename($_FILES[file][name]), PATHINFO_EXTENSION) !== 'pdf') { error(); return; }

        $handle = fopen($tempFile, 'rb');
        $content = fread($handle, filesize($tempFile));
        fclose($handle);

        $client = new MongoDB\Client(url);
        $db = $client->selectDatabase(files);
        $collection = $db->selectCollection(files);
        if (!$collection) $db->createCollection(files);

        session_start();
        $sid = session_id();
        $collection->deleteMany([id => $sid]);

        if ($collection->insertOne([
            id => $sid,
            name => $fileName,
            file => new Binary($content, Binary::TYPE_GENERIC)
        ])->getInsertedCount() !== 1)
        { error(); return; }

        $result = $collection->findOne([id => $sid]);
        echo 'File ' . $result[name] . ' uploaded by ' . $result[id] . ' Content: ' . $result[file];
    }

    function download() {
        session_start();

        $client = new MongoDB\Client(url);
        $db = $client->selectDatabase(files);
        $collection = $db->selectCollection(files);
        if (!$collection) { error(); return; }

        $result = $collection->findOne([id => session_id()]);
        $fileName = $result[name];
        $content = $result[file]->getData();
        error_log(print_r('File ' . $fileName . ' uploaded by ' . $result[id] . ' Content: ' . $content, TRUE));

        $filePath = dir . $fileName;
        $handle = fopen($filePath, 'wb+');
        if (!$handle) { error(); return; }
        if (!fwrite($handle, $content)) { error(); return; }
        fclose($handle);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Pragma: public');
        flush();
        readfile($filePath);
        unlink($filePath);
        exit();
    }
?>
