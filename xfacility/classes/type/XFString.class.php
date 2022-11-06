<?php
// xFacility2015
/**
 * # class XFString
 * - Porting String class in Python3.
 * - https://docs.python.org/3/library/string.html
 * 
 * ## Contributors
 * - Studio2b  
 * - Michael Son(mson0129@gmail.com)
 * 
 * ## History
 * - 05NOV2022 - This file is newly created.
 */
class XFString extends XFObject {
    private $string;

    public function __construct($string = "") {
        $this->string = $string;
    }

    public function __toString(): string {
        return $this->string;
    }

    /**
     * # Method: len
     * Get length of the string.  
     * It's equivalent to Python3's len(string).
     * 
     * ## Parameters
     * - $start: int
     * - $end: int
     * - $step: int = 1
     * 
     * ## Return
     * - $output: string
     */
    public function len(): int {
        return strlen($this->string);
    }

    /**
     * # Method: length
     * It's equivalent to XFString::len().
     */
    public function length(): int {
        return $this->len();
    }

    /**
     * # Method: slice
     * Slice the string.  
     * It's equivalent to Python3's string[start:end:step].
     * 
     * ## Parameters
     * - $start: int
     * - $end: int
     * - $step: int = 1
     * 
     * ## Return
     * - $output: string
     */
    public function slice(int $start, int $end, int $step = 1): string {
        $string = substr($this->string, $start, $end - $start);
        $output = "";
        if ($step == 0) {
            $step = 1;
        }

        if ($step > 0) {
            // Forward
            for ($i = 0; $i < strlen($string); $i += $step) {
                $output .= substr($string, $i, 1);
            }
        } else {
            // Backward
            for ($i = strlen($string) - 1; $i >= 0; $i += $step) {
                $output .= substr($string, $i, 1);
            }
        }
        return $output;
    }

    /**
     * # Method: substr
     * It's equivalent to XFString::slice().
     */
    public function substr($start, $end, $step = 1): string {
        return $this->slice($start, $end, $step);
    }
}
?>