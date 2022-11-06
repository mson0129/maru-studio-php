<?php
// xFacility2015
/**
 * # class XFDatetime
 * - Porting Datetime Objects of Python3.
 * - https://docs.python.org/3/library/datetime.html#datetime-objects
 * - https://www.php.net/manual/en/class.datetime.php
 * - https://www.php.net/manual/en/datetime.format.php
 * 
 * ## Contributors
 * - Studio2b  
 * - Michael Son(mson0129@gmail.com)
 * 
 * ## History
 * - 05NOV2022 - This file is newly created.
 */
class XFDatetime extends XFObject {
    private $datetime;

    public function __construct($year, $month, $day, $hour = 0, $minute = 0, $second = 0, $microsecond = 0, $tzinfo = null) {
        $this->datetime = new DateTime();
        $this->datetime->setDate($year, $month, $day);
        $this->datetime->setTime($hour, $minute, $second, $microsecond);
        $this->datetime->setTimezone($tzinfo);
    }

    public function __get($name) {
        // Not implemented yet.
        /*
        if ($name === "min") {
        } else if ($name === "max") {
        } else if ($name === "resolution") {
        } else 
        */
        
        if ($name === "year") {
            $output = $this->datetime->format("Y");
        } else if ($name === "month") {
            $output = $this->datetime->format("m");
        } else if ($name === "day") {
            $output = $this->datetime->format("d");
        } else if ($name === "hour") {
            $output = $this->datetime->format("H");
        } else if ($name === "minute") {
            $output = $this->datetime->format("i");
        } else if ($name === "second") {
            $output = $this->datetime->format("s");
        } else if ($name === "microsecond") {
            $output = $this->datetime->format("u");
        } else if ($name === "tzinfo") {
            $output = $this->datetime->getTimezone();
        } else if ($name === "fold") {
            $output = $this->datetime->format("I");
        } else {
            trigger_error("Undefined property: " . __CLASS__ . "::" . $name, E_USER_NOTICE);
        }
        return $output;
    }

    public function __set($name, $value) {
        if ($name === "readonly") {
            trigger_error("Can't set property: " . __CLASS__ . "::" . $name, E_USER_NOTICE);
        } else {
            $this->$name = $value;
        }
    }

    public function __toString(): string {
        return $this->datetime->format("Y-m-d H:i:s.u");
    }

    public function today() {
        $this->datetime = new DateTime();
    }

    public function now($tzinfo = null) {
        $this->datetime = new DateTime();
        $this->datetime->setTimezone($tzinfo);
    }

    public function utcnow() {
        $this->datetime = new DateTime();
        $this->datetime->setTimezone(new DateTimeZone("UTC"));
    }

    public function fromtimestamp($timestamp, $tzinfo = null) {
        $this->datetime = new DateTime();
        $this->datetime->setTimestamp($timestamp);
        $this->datetime->setTimezone($tzinfo);
    }

    public function utcfromtimestamp($timestamp) {
        $this->datetime = new DateTime();
        $this->datetime->setTimestamp($timestamp);
        $this->datetime->setTimezone(new DateTimeZone("UTC"));
    }

    public function fromordinal($ordinal) {
        $this->datetime = new DateTime();
        $this->datetime->setDate(1, 1, 1);
        $this->datetime->add(new DateInterval("P".($ordinal - 1)."D"));
    }

    public function combine($date, $time, $tzinfo = null) {
        $this->datetime = new DateTime();
        $this->datetime->setDate($date->year(), $date->month(), $date->day());
        $this->datetime->setTime($time->hour(), $time->minute(), $time->second(), $time->microsecond());
        $this->datetime->setTimezone($tzinfo);
    }

    public function fromisoformat($date_string) {
        $this->datetime = new DateTime($date_string);
    }

    public function fromisocalendar($year, $week, $day, $tzinfo = null) {
        $this->datetime = new DateTime();
        $this->datetime->setISODate($year, $week, $day);
        $this->datetime->setTimezone($tzinfo);
    }

    public function strptime($string, $format) {
        $this->datetime = DateTime::createFromFormat($format, $string);
    }

    public function date() {
        return $this->datetime->format("Y-m-d");
    }

    public function time() {
        return $this->datetime->format("H:i:s.u");
    }

    public function timetz() {
        return $this->datetime->format("H:i:s.uP");
    }

    public function replace($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $microsecond = null, $tzinfo = null) {
        if ($year == null) {
            $year = $this->datetime->format("Y");
        }
        if ($month == null) {
            $month = $this->datetime->format("m");
        }
        if ($day == null) {
            $day = $this->datetime->format("d");
        }
        if ($hour == null) {
            $hour = $this->datetime->format("H");
        }
        if ($minute == null) {
            $minute = $this->datetime->format("i");
        }
        if ($second == null) {
            $second = $this->datetime->format("s");
        }
        if ($microsecond == null) {
            $microsecond = $this->datetime->format("u");
        }
        if ($tzinfo == null) {
            $tzinfo = $this->datetime->getTimezone();
        }

        $this->datetime->setDate($year, $month, $day);
        $this->datetime->setTime($hour, $minute, $second, $microsecond);
        $this->datetime->setTimezone($tzinfo);
    }

    public function astimezone($tzinfo = null) {
        $this->datetime->setTimezone($tzinfo);
    }

    public function utcoffset() {
        return $this->datetime->getOffset();
    }

    public function dst() {
        return $this->datetime->format("I");
    }

    public function tzname() {
        return $this->datetime->format("T");
    }

    // Can't implement this method because PHP doesn't support it.
    /*
    public function timetuple() {
    }
    */

    public function utctimetuple() {
        $this->datetime->setTimezone(new DateTimeZone("UTC"));
    }

    public function toordinal() {
        $this->datetime->setDate(1, 1, 1);
        return $this->datetime->format("z") + 1;
    }

    public function timestamp() {
        return $this->datetime->getTimestamp();
    }

    public function weekday() {
        return $this->datetime->format("w");
    }

    public function isoweekday() {
        return $this->datetime->format("N");
    }

    public function isocalendar() {
        return array($this->datetime->format("o"), $this->datetime->format("W"), $this->datetime->format("N"));
    }

    public function isoformat($sep = "T") {
        return $this->datetime->format("Y-m-d").$sep.$this->datetime->format("H:i:s.u");
    }

    public function ctime() {
        return $this->datetime->format("D M j H:i:s Y");
    }

    public function strftime($format): string {
        return $this->datetime->format($format);
    }    
}
?>