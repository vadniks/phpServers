<?php /** @noinspection PhpUnhandledExceptionInspection
       * @noinspection PhpComposerExtensionStubsInspection
       * @noinspection SpellCheckingInspection */ require_once '../_helper.php';
    require_once '../../jpgraph/jpgraph.php'; require_once '../../jpgraph/jpgraph_line.php';
    require_once '../../jpgraph/jpgraph_bar.php'; require_once '../../jpgraph/jpgraph_stock.php';

    class Graphs extends AbsRequestHandler {
        const type = 'type',
            data = 'data',
            width = 640,
            height = 360,
            numder = 'number';

        public function __construct(string $requestMethod, array $arguments) {
            parent::__construct($arguments);
//            if (array_key_exists(numder, $_GET)) $number = $_GET[numder];
            $number = $arguments[0];
            if (!is_numeric($number) || $requestMethod !== methods[0]) { error(); exit(1); }
            $this->watermark($this->graph(), $this->stamp($number));
        }

        function split(string $arr): array { return
            explode(',', substr($arr, 1, strlen($arr) - 2)); }

        function plot(int $type, $data): BoxPlot|LinePlot|BarPlot { return match ($type) {
            0 => new LinePlot($data),
            1 => new BoxPlot($data),
            2 => new BarPlot($data),
            default => throw new Exception()
        }; }

        function graph(): GdImage | bool | null {
            $type = $this->arguments[1];
            $data = $this->arguments[2];

            // http://localhost:8082/graphs?type=0&data=[124,193,26,654,415]&number=49
            if (!is_numeric($type) || !is_string($data)) { error(); exit(1); }

            $type = intval($type);
            $data = $this->split($data);

            $graph = new Graph(self::width, self::height);
            $graph->SetScale('intint');
            $graph->title->Set('Graph type ' . $type);
            $graph->xaxis->title->Set('(Powered by jpGraph)');
            $graph->yaxis->title->Set('(Data)');

            $graph->Add($this->plot($type, $data));
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
    }
?>
