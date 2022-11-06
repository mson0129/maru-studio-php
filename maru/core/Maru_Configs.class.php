<?php
/**
 * # Class Maru_Configs
 */
class Maru_Configs {
    private $debug = false;
    private $path;
    private $key;
    private $configs = array();

    public function get_configs() {
        return $this->configs;
    }

    public function set_configs($input) {
        $this->configs = $input;
    }

    public function __construct($configs_path = "configs.ini") {
        $this->path = $_SERVER["DOCUMENT_ROOT"]."/".$configs_path;
        $this->open_file($configs_path);
    }

    public function open_file($configs_path = "configs.ini", $key_path = "configs.key"): bool {
        // Set Path
        if (is_null($configs_path) || !(file_exists($_SERVER["DOCUMENT_ROOT"]."/".$configs_path) && is_file($_SERVER["DOCUMENT_ROOT"]."/".$configs_path))) {
            $configs_path = $this->path;
        } else {
            $this->path = $_SERVER["DOCUMENT_ROOT"]."/".$configs_path;
        }

        // Set Key
        if (is_null($key_path) || !(file_exists($_SERVER["DOCUMENT_ROOT"]."/".$key_path) && is_file($_SERVER["DOCUMENT_ROOT"]."/".$key_path))) {
            $key = $this->key;
        } else {
            $key = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/".$key_path);
            // https://stackoverflow.com/questions/2236668/file-get-contents-breaks-up-utf-8-characters
            $key = mb_convert_encoding($key, "UTF-8", mb_detect_encoding($key, "UTF-8, ISO-8859-1", true));
        }

        // Read File
        // To Do: Check if file is encrypted
        if (file_exists($this->path) && is_file($this->path)) {
            $configs = parse_ini_file($this->path, true);
            $this->configs = $configs;
            $output = true;
        } else {
            $output = false;
        }
        return $output;
    }
}
?>