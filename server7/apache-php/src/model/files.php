<?php require '../../vendor/autoload.php'; require_once '../_helper.php';
      use MongoDB\BSON\Binary; require_once 'AbsRequestHandler.php';

    class Files {
        private const dir = '/var/www/files/',
            file = 'file',
            tmpName = 'tmp_name',
            url = 'mongodb://mongo:27017',
            files = 'files',
            pdfFormatLeadingBytes = '%PDF';

        public function __construct(string $requestMethod) {
            if ($requestMethod === methods[1]) $this->upload();
            else if ($requestMethod === methods[0]) $this->download();
        }

        function upload() {
            $tempFile = $_FILES[self::file][self::tmpName];
            $fileName = $_FILES[self::file][name];

            if (!isset($_POST['submit']) || empty($fileName)) { error(); return; }

            if (pathinfo(
                basename($_FILES[self::file][name]),
                PATHINFO_EXTENSION
            ) !== 'pdf') { error(); return; }

            $handle = fopen($tempFile, 'rb');
            $content = fread($handle, filesize($tempFile));
            if (!str_contains($content, self::pdfFormatLeadingBytes)) { error(); return; }
            fclose($handle);

            $client = new MongoDB\Client(self::url);
            $db = $client->selectDatabase(self::files);
            $collection = $db->selectCollection(self::files);
            if (!$collection) $db->createCollection(self::files);

            session_start();
            $sid = session_id();
            $collection->deleteMany([idParam => $sid]);

            if ($collection->insertOne([
                idParam => $sid,
                name => $fileName,
                self::file => new Binary($content, Binary::TYPE_GENERIC)
            ])->getInsertedCount() !== 1)
            { error(); return; }

            if (!$collection->findOne([idParam => $sid])) error();
        }

        function download() {
            session_start();

            $client = new MongoDB\Client(self::url);
            $db = $client->selectDatabase(self::files);
            $collection = $db->selectCollection(self::files);
            if (!$collection) { error(); return; }

            $result = $collection->findOne([idParam => session_id()]);
            $fileName = $result[name];
            $content = $result[self::file]->getData();

            $filePath = self::dir . $fileName;
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
    }
?>
