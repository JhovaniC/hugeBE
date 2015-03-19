<?php

namespace Huge;

include "./Canvas.php";

/**
 * Paint app file for HUGE BE Test
 * @author Jhovani Cuadros <angelus985@gmail.com>
 * @version 0.1
 */

use Huge\Canvas;

$GLOBALS["canvas"] = null;

/**
 * @param $input
 * @return string
 */
function processCommand($input) {
    /**
     * Available commands for user input
     * @var array
     */
    $availableCommands = array("C", "L", "R", "B", "Q");
    $args = explode(" ", trim($input));
    $output = "";
    $canvas = $GLOBALS["canvas"];

    if (in_array($args[0], $availableCommands)) {
        if ($args[0] == "Q") {
            $output .= "Bye!";
        } elseif ($args[0] == "C") {
            $canvas = new Canvas($args[1], $args[2]);
            $GLOBALS["canvas"] = $canvas;
            $output .= $canvas->printCanvas();
        } elseif ($canvas instanceof Canvas) {
            if ($args[0] == "L") {
                $canvas->drawSingleLine(array($args[1], $args[2], $args[3], $args[4]));
            } elseif ($args[0] == "R") {
                $canvas->drawRectangle(array($args[1], $args[2], $args[3], $args[4]));
            } elseif ($args[0] == "B") {
                $canvas->bucketFill($args[1], $args[2], $args[3]);
            }
            $output .= $canvas->printCanvas();
        } else {
            $output = "Create a canvas first ( C X Y )";
        }
    } else {
        $output = "Command \"$args[0]\" is not available";
    }
    $output .= "\n";
    return $output;
}

function initApp() {
    $input = "";
    while ($input != "Q") {
        print_r("Enter command: ");
        $input = stream_get_line(STDIN, 1024, PHP_EOL);
        print_r(processCommand($input));
    }
}

initApp();