<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Statistics</title>
        <style>span { margin: 10px; }</style>
        <?php require_once '../_helper.php'; defineDarkTheme(); ?>
    </head>
    <body>
        <h1>Graphs:</h1>
        <?php require '../../vendor/autoload.php';

            class Shape_ {
                var int $r, $g, $b, $width, $height;
                public function __toString(): string { return sprintf(
                    '[%d,%d,%d,%d,%d]',
                    $this->r, $this->g, $this->b, $this->width, $this->height
                ); }
            }

            $loader = new Nelmio\Alice\Loader\NativeLoader();
            /** @noinspection PhpUnhandledExceptionInspection */
            $objectSet = $loader->loadData([
                Shape_::class => [
                    'shape{1..50}' => [
                        'r' => '<numberBetween(0, 255)>',
                        'g' => '<numberBetween(0, 255)>',
                        'b' => '<numberBetween(0, 255)>',
                        'width' => '<numberBetween(600, 1000)>',
                        'height' => '<numberBetween(300, 700)>'
                    ],
                ]
            ]);
            $array = $objectSet->getObjects();
        ?>
        <div style="
            display: flex;
            flex-direction: column;
        "><?php $i = 0; $j = 0; foreach ($array as &$shape) { if ($i === 3) $i = 0; echo <<<whatever
            <!--suppress HtmlRequiredAltAttribute --><style="
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            ">
                <img src="/graphs?type=$i&data=$shape&number=$j"><span></span>
            </div>
        whatever; $i++; $j++; } ?></div>
    </body>
</html>
