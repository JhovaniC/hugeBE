<?php

namespace Huge;

/**
 * PHPUnit Test for HUGE BE Test
 *
 */
include "./Canvas.php";

use Huge\Canvas;

class CanvasTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Canvas
     */
    private $canvas;

    public function setUp() {
        $this->canvas = new Canvas(20, 20);
    }

    /**
     * Test drawSingleLine method
     */
    public function testDrawSingleLine() {
        $this->assertTrue($this->canvas->drawSingleLine(array(1,1,20,1)));
        $this->assertNotTrue($this->canvas->drawSingleLine(array(1,1,31,1)));
        $this->assertNotTrue($this->canvas->drawSingleLine(array(1,2,31,1)));
        print_r("\n");
        print_r($this->canvas->printCanvas());
    }

    /**
     * Test drawRectangle method
     * @return Canvas
     */
    public function testDrawRectangle() {
        $this->assertTrue($this->canvas->drawRectangle(array(1,1,20,5)));
        $this->assertNotTrue($this->canvas->drawRectangle(array(1,1,11,1)));
        $this->assertNotTrue($this->canvas->drawRectangle(array(1,2,31,1)));
        $this->assertNotTrue($this->canvas->drawRectangle(array(1,2,1,10)));
        print_r("\n");
        print_r($this->canvas->printCanvas());
        return $this->canvas;
    }

    /**
     * Test bucketFill method
     * @param Canvas $canvas
     * @depends testDrawRectangle
     * @return Canvas
     */
    public function testBucketFill($canvas) {
        $this->assertNotTrue($canvas->bucketFill(1, 1, "o"));
        $this->assertNotTrue($canvas->bucketFill(0, 0, "o"));
        $this->assertTrue($canvas->bucketFill(3, 4, "o"));
        $this->assertTrue($canvas->bucketFill(2, 7, "3"));
        print_r("\n");
        print_r($canvas->printCanvas());
    }

    /**
     * Test isPositionDrawn method
     */
    public function testIsPositionDrawn() {
        $this->canvas->drawRectangle(array(1,1,20,5));
        $this->assertTrue($this->canvas->isPositionDrawn(1, 1));
        $this->assertNotTrue($this->canvas->isPositionDrawn(3, 4));
        print_r("\n");
        print_r($this->canvas->printCanvas());
    }

    /**
     * Test printCanvas method
     */
    public function testPrintCanvas() {
        $this->assertNotEmpty($this->canvas->printCanvas());
        $this->assertInternalType("string", $this->canvas->printCanvas());
    }

    public function tearDown() {
        $this->canvas = null;
        unset($this->canvas);
    }

}
