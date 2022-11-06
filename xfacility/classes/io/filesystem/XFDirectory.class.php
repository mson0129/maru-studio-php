<?php
// xFacility2015
/**
 * # Class XFDirectory
 * - This class is for managing directories.
 * 
 * ## Contributors
 * - Studio2b
 * - Michael Son(mson0129@gmail.com)
 * - Kim, Gyoung Han(https://flystone.tistory.com)
 * 
 * ## History
 * - 23JUN2014(1.0.0.) - This file is newly added.
 * - 01JUL2014(1.1.0.) - list_directory() and list_file() are added.
 * - 06NOV2022(1.1.1.) - Some bugs are fixed.
 */
class XFDirectory extends XFObject {
	public $path, $fullPath;
	
	public function __construct($path = NULL) {
		//Add front slash
		if(substr($path, 0, 1)!="/")
			$path = "/".$path;
		//Remove end slash
		if(substr($path, -1)=="/")
			$path = substr($path, 0, strlen($path)-1);
		//Set a path
		if(!is_null($path)) {
			$this->fullPath = $_SERVER['DOCUMENT_ROOT'].$path;
			$this->path = $path;
		} else {
			$this->fullPath = $_SERVER['DOCUMENT_ROOT'];
		}
	}
	
	//path
	public function go_to_parent() {
        $return = "";
		if(substr($this->path, 0, 1)=="/")
			$tempPath = substr($this->path, 1, strlen($this->path));
		$temp = explode("/", $tempPath);
		for($i=0; $i<count($temp)-1; $i++) {
			$return .= "/".$temp[$i];
		}
		$this->path = $return;
		$this->fullPath = $_SERVER['DOCUMENT_ROOT'].$return;
		return $return;
	}
	
	public function go_to_sub($directory) {
		$this->path .= "/".$directory;
		$this->fullPath .= "/".$directory;
		return $this->path;
	}
	
	//IO
	public function create() {
		$directories = explode("/", $this->fullPath);
        $now = "";
		foreach($directories as $directory) {
			$now .= "/".$directory;
			if(!is_dir($now))
				if(!mkdir($now))
					return false;
		}
		return true;
	}
	
	public function modify($newPath) {
		if(is_dir($_SERVER['DOCUMENT_ROOT']."/".$newPath) && !is_dir($this->fullPath)) {
			$return = false;
		} else {
			rename($this->fullPath, $_SERVER['DOCUMENT_ROOT']."/".$newPath);
			$return = $_SERVER['DOCUMENT_ROOT']."/".$newPath;
		}
		return $return;	
	}
	
    /**
     * # function delete
     * - Original: rmdirAll(http://flystone.tistory.com/54)
     * 
     * ## Contributors
     * - Kim, Gyoung Han(https://flystone.tistory.com)
     * 
     * ## History
     * - 27APR2011(1.0.0.) - Posted by Kim, Gyoung Han
     */
	public function delete() {
		$directories = dir($this->fullPath);
		while(false !== ($entry = $directories->read())) {
			if(($entry != '.') && ($entry != '..')) {
				if(is_dir($this->fullPath.'/'.$entry)) {
					$this->delete($this->fullPath.'/'.$entry);
				} else {
					@unlink($this->fullPath.'/'.$entry);
				}
			}
		}
		$directories->close();
		@rmdir($this->fullPath);
	}
	
	public function browse() {
		//Get Info
		if(is_dir($this->fullPath)) {
			$return = pathinfo($this->fullPath);
		} else {
			$return = false;
		}
		return $return;
	}
	
	public function peruse($includePath = true) {
		//Contents
		if(is_dir($this->fullPath)) {
			$handle = opendir($this->fullPath);
		} else {
			$handle = opendir(dirname($this->fullPath));
		}
		while (false !== ($subPath = readdir($handle))) {
			if ($subPath != "." && $subPath != "..") {
				if($includePath==true) {
					$return[] = $this->path."/".$subPath;
				} else {
					$return[] = $subPath;
				}
			}
		}
		closedir($handle);
		
		return $return;
	}
	
	public function list_directory($includePath = true) {
		if(is_dir($this->fullPath)) {
			$handle = opendir($this->fullPath);
		} else {
			$handle = opendir(dirname($this->fullPath));
		}
		while (false !== ($dir = readdir($handle))) {
			if ($dir != "." && $dir != "..") {
				if(is_dir($this->fullPath."/".$dir)) {
					if($includePath==true) {
						$return[] = $this->path."/".$dir;
					} else {
						$return[] = $dir;
					}
				}
			}
		}
		closedir($handle);
		return $return;
	}
	
	public function list_file($includePath = true) {
		if(is_dir($this->fullPath)) {
			$handle = opendir($this->fullPath);
		} else {
			$handle = opendir(dirname($this->fullPath));
		}
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(file_exists($this->fullPath."/".$file)) {
					if($includePath==true) {
						$return[] = $this->path."/".$file;
					} else {
						$return[] = $file;
					}
				}
			}
		}
		closedir($handle);
		return $return;
	}
}
?>