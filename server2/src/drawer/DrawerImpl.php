<?php

class DrawerImpl {
    const PARAMETER_NAME = 'encoded';
    const SHAPE_MASK = [0b11000000, 6];
    const COLOR_MASK = [0b00110000, 4];
    const WIDTH_MASK = [0b00001100, 2];
    const HEIGHT_MASK = [0b00000011, 0];
    const CIRCLE = 0b00;
    const SQUARE = 0b01;
    const TRIANGLE = 0b10;
    const COLORS = [
        0b00 => 'red',
        0b01 => 'green',
        0b10 => 'blue'
    ];
    private int $shape;
    private string $color;
    private int $width;
    private int $height;

    public function __construct(int $encoded) {
        $this->shape = ($encoded & self::SHAPE_MASK[0]) >> self::SHAPE_MASK[1];
        $color = ($encoded & self::COLOR_MASK[0]) >> self::COLOR_MASK[1];
        $this->width = (($encoded & self::WIDTH_MASK[0]) >> self::WIDTH_MASK[1]) * 20;
        $this->height = (($encoded & self::HEIGHT_MASK[0]) >> self::HEIGHT_MASK[1]) * 20;

        if ($this->shape > 0b10 || $color > 0b10)
            echo 'Wrong encoding';
        else {
            $this->color = self::COLORS[$color];
            $this->paint();
        }
    }

    private function paint() {
        $halfWidth = $this->width / 2;
        $figure = match ($this->shape) {
            self::CIRCLE => <<<A
                <circle 
                    cx="$halfWidth" 
                    cy="$halfWidth" 
                    r="$halfWidth" 
                    fill="$this->color"/>
            A,
            self::SQUARE => <<<B
                <rect 
                    width="$this->width" 
                    height="$this->height" 
                    fill="$this->color"/>
            B,
            self::TRIANGLE => <<<C
                <polygon 
                    points="$this->width,$this->height 0,0 0,$this->height" 
                    fill="$this->color"/>
            C,
            default => 'Not found',
        };
        echo <<<D
        <svg 
            width="$this->width"
            height="$this->height">
            $figure
        </svg>                
        D;
    }
}

?>
