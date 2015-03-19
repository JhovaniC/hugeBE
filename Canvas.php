<?php

namespace Huge;

/**
 * Canvas Class for HUGE BE Test
 * @author Jhovani Cuadros <angelus985@gmail.com>
 * @version 0.1
 */

class Canvas {

    /**
     * Canvas dimensions
     * @var array
     */
    private $canvasSize;

    /**
     * Canvas grid with characters to be rendered
     * @var array
     */
    private $canvas;

    /**
     * Character to be used for drawing lines
     * @var string
     */
    private $lineChar;

    /**
     * Canvas constructor
     * @param int $x dimension in X
     * @param int $y dimension in Y
     * @param string $lineChar character for drawing lines
     */
    public function __construct($x, $y, $lineChar = "x")
    {
        $this->canvasSize = array($x, $y);
        $this->canvas = array();
        $this->lineChar = $lineChar;
    }

    /**
     * Draws a single line (horizontally or vertically) on the canvas
     * @param $args [x1, y1, x2, y2]
     * @return bool true if the line can be drawn
     */
    public function drawSingleLine($args)
    {
        $args = array_map("intval", $args);

        if ($this->isOutOfCanvas($args[0], $args[1]) || $this->isOutOfCanvas($args[2], $args[3])) {
            return false;
        }

        if ($args[1] == $args[3]) { /* Make sure the line is horizontal*/
            $singleLine = range($args[0], $args[2]);
            foreach ($singleLine as $posX) {
                $this->canvas[$posX][$args[1]] = $this->lineChar;
            }
        } elseif ($args[0] == $args[2]) { /* Make sure the line is vertical */
            $singleLine = range($args[1], $args[3]);
            foreach ($singleLine as $posY) {
                $this->canvas[$args[0]][$posY] = $this->lineChar;
            }
        } else { /* We don't support diagonal lines */
            return false;
        }

        return true;
    }


    /**
     * Draws a non-filled rectangle on the canvas
     * @param $args [x1, y1, x2, y2]
     * @return bool true if the rectangle was drawn
     */
    public function drawRectangle($args)
    {
        $args = array_map("intval", $args);

        if ($args[1] == $args[3] || $args[0] == $args[2] || $this->isOutOfCanvas($args[0], $args[1])
            || $this->isOutOfCanvas($args[2], $args[3])) {
            return false;
        }

        $this->drawSingleLine(array($args[0], $args[1], $args[0], $args[3])); /* Left */
        $this->drawSingleLine(array($args[0], $args[1], $args[2], $args[1])); /* Top */
        $this->drawSingleLine(array($args[2], $args[1], $args[2], $args[3])); /* Right */
        $this->drawSingleLine(array($args[0], $args[3], $args[2], $args[3])); /* Bottom */
        return true;
    }

    /**
     * Bucket fill an area on the canvas connected to a position
     * Source from: http://inventwithpython.com/blog/2011/08/11/recursion-explained-with-the-flood-fill-algorithm-and-zombies-and-cats/
     * @param int $x
     * @param int $y
     * @param string $fill letter to use for filling the area
     * @return bool true when finish
     */
    public function bucketFill($x, $y, $fill)
    {
        if ($this->isOutOfCanvas($x, $y) || $this->isPositionDrawn($x, $y)) {
            return false;
        }

        $this->canvas[$x][$y] = $fill;
        /* Recursive calls */
        $this->bucketFill($x+1, $y, $fill);
        $this->bucketFill($x-1, $y, $fill);
        $this->bucketFill($x, $y+1, $fill);
        $this->bucketFill($x, $y-1, $fill);
        return true;
    }

    /**
     * Determines if a given position is already drawn on the canvas
     * @param $x
     * @param $y
     * @return bool true if the position is drawn on the canvas
     */
    public function isPositionDrawn($x, $y)
    {
        return isset($this->canvas[$x][$y]);
    }

    /**
     * Returns the size of the canvas in X
     * @return mixed
     */
    public function getSizeX()
    {
        return $this->canvasSize[0];
    }

    /**
     * Returns the size of the canvas in Y
     * @return mixed
     */
    public function getSizeY()
    {
        return $this->canvasSize[1];
    }

    /**
     * Gets the line char used to draw lines
     * @return string
     */
    public function getLineChar()
    {
        return $this->lineChar;
    }

    /**
     * Generate a string representing the canvas drawing
     * @return string
     */
    public function printCanvas() {
        $print = "";
        for ($y = 0; $y <= $this->getSizeY()+1; $y++) {
            for ($x = 0; $x <= $this->getSizeX()+1; $x++) {
                if ($y == 0 || $y == $this->getSizeY()+1) {
                    $print .= "-";
                } elseif ($x == 0 || $x == $this->getSizeX()+1) {
                    $print .= "|";
                } elseif ($this->isPositionDrawn($x, $y)) {
                    $print .= $this->canvas[$x][$y];
                } else {
                    $print .= " ";
                }
            }
            $print .= "\n";
        }
        return $print;
    }

    /**
     * Determines if a given position is out of the canvas
     * @param $x
     * @param $y
     * @return bool true if the position is out of the canvas
     */
    private function isOutOfCanvas($x, $y)
    {
        if ($x < 1 || $x > $this->canvasSize[0] || $y < 1 || $y > $this->canvasSize[1]) {
            return true;
        }

        return false;
    }

}