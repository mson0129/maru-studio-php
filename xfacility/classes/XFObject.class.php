<?php
// xFacility2015
/**
 * # class XFObject
 * - The basic class of xFacility for all classes
 * 
 * # Contributors
 * - Studio2b
 * - Michael Son(mson0129@gmail.com)
 * 
 * ## History
 * - 16MAR2015 - This file is newly created.
 */
class XFObject {
	function path() {
		return substr(__FILE__, 0, strlen(__FILE__)-strlen("/classes/XFObject.class.php"));
	}
}
?>