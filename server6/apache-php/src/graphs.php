<?php /** @noinspection PhpUnhandledExceptionInspection @noinspection PhpComposerExtensionStubsInspection @noinspection SpellCheckingInspection */
    require_once '../jpgraph/jpgraph.php';
    require_once '../jpgraph/jpgraph_line.php';
    require_once '../jpgraph/jpgraph_bar.php';
    require_once '../jpgraph/jpgraph_stock.php';
    require_once '_helper.php';
    const type = 'type', data = 'data', width = 640, height = 360, numder = 'number';

    if (array_key_exists(numder, $_GET)) $number = $_GET[numder];
    if (!isset($number) || !is_numeric($number)) { error(); exit(1); }
    watermark(graph(), stamp($number));

    function split(string $arr): array { return explode(',', substr($arr, 1, strlen($arr) - 2)); }

    function plot(int $type, $data): BoxPlot | LinePlot | BarPlot { return match ($type) {
        0 => new LinePlot($data),
        1 => new BoxPlot($data),
        2 => new BarPlot($data),
        default => throw new Exception()
    }; }

    function graph(): GdImage | bool | null {
        if (array_key_exists(type, $_GET)) $type = $_GET[type];
        if (array_key_exists(data, $_GET)) $data = $_GET[data];

        // http://localhost:8082/graphs.php?type=0&data=[5,11,16,23,36,58,29,20,10,8]&number=0
        if (!isset($type) || !is_numeric($type)
            || !isset($data) || !is_string($data)) {
            error();
            exit(1);
        }

        $type = intval($type);
        $data = split($data);

        $graph = new Graph(width, height);
        $graph->SetScale('intint');
        $graph->title->Set('Graph type ' . $type);
        $graph->xaxis->title->Set('(Powered by jpGraph)');
        $graph->yaxis->title->Set('(Data)');

        $graph->Add(plot($type, $data));
        $graph->img->SetImgFormat('png');
        return $graph->Stroke(_IMG_HANDLER);
    }

    function stamp(int $number): GdImage | bool {
        $image = imagecreate(100, 30);
        imagecolorallocatealpha($image, 255, 255, 255, 127);
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 100);
        imagestring($image, 5, 20, 5, 'Shape #' . $number, $textColor);
        return $image;
    }

    function watermark(GdImage $image, GdImage $stamp) {
        $stampWidth = imagesx($stamp);
        $stampHeight = imagesy($stamp);
        imagecopy(
            $image, $stamp,
            imagesx($image) - $stampWidth - 250,
            imagesy($image) - $stampHeight - 200,
            0, 0,
            $stampWidth, $stampHeight
        );
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
?>
