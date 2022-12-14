<?php
// xFacility2015
/**
 * # class XFFile
 * - This class is a wrapper of PHP's File class.
 * 
 * ## Contributors
 * - Studio2b
 * - Michael Son(mson0129@gmail.com)
 * 
 * ## History
 * - 23JUN2014(1.0.0.) - This file is newly added.
 * - 26JUN2014(1.1.0.) - Non-Standard xFacility functions are added.
 * - 29JAN2015(1.2.0.) - Importing path including a path of DOCUMENT_ROOT is available without an error.
 */
class XFFile extends XFObject {
	var $path, $fullPath;
	var $directory, $basename, $extension;
	var $size, $exif, $hash, $mime;
	
    /**
     * # function Constructor
     * - This function is a constructor of XFFile class.
     * 
     * ## Contributors
     * - Michael Son(mson0129@gmail.com)
     * 
     * ## History
     * - 23JUN2014
     */
	function __construct($path) {
		if(substr($path, 0, strlen($_SERVER['DOCUMENT_ROOT']))==$_SERVER['DOCUMENT_ROOT'])
			$path = substr($path, strlen($_SERVER['DOCUMENT_ROOT']));
		$this->path = $path;
		$this->fullPath = $_SERVER['DOCUMENT_ROOT']."/".$path;
		if(file_exists($this->fullPath)) {
			$pathinfo = pathinfo($this->fullPath);
			$this->directory = $pathinfo['dirname'];
			$this->basename = $pathinfo['basename'];
			$this->extension = strtolower($pathinfo['extension']);
			$this->size = filesize($this->fullPath);
			$this->exif = exif_read_data($this->fullPath);
			$this->hash = md5($this->peruse());
			list($this->mime, $temp) = explode(";", exec("file -bi '$this->fullPath'"), 2);
			unset($temp);
		}
	}
	
	//xFacility Standard IO
	function create($data) {
		$fileHandle = fopen($this->path, "wb+");
		if(flock($fileHandle, LOCK_EX)) {
			fwrite($fileHandle, $data) or die("fwrite failed");
			flock($fileHandle, LOCK_UN);
		}
		fclose($fileHandle) or die("fclose failed");
			
		return $this->path;
	}
	
	function modify($newPath) {
		if(!is_null($newPath) && !file_exists($_SERVER['DOCUMENT_ROOT']."/".$newPath)) {
			rename($this->fullPath, $_SERVER['DOCUMENT_ROOT']."/".$newPath);
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}
	
	function delete() {
		if(file_exists($this->fullPath)) {
			unlink($this->fullPath);
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}
	
	function browse() {
		//Get Info
		if(file_exists($this->fullPath)) {
			$return = pathinfo($this->fullPath);
		} else {
			$return = false;
		}
		return $return;
	}
	
	function peruse($base64=false) {
		//Contents
		if(file_exists($this->fullPath)) {
			$return = implode("", file($this->fullPath));
			if($base64==true)
				$return = base64_encode($return);
		} else {
			$return = false;
		}
		return $return;
	}
	
	//Non-Standard IO
	function read($base64=false) {
		return $this->peruse($base64);
	}
	
	function copy($newPath, $overwrite = false) {
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$newPath) && $overwrite!=true) {
			$return = false;
		} else {
			copy($this->fullPath, $_SERVER['DOCUMENT_ROOT']."/".$newPath);
			$return = true;
		}
		return $return;
	}
	
	function move($newPath) {
		return $this->modify($newPath);
	}
	
	function info() {
		return $this->browse();
	}
}
?>