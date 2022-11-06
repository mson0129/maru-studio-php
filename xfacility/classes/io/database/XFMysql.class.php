<?php
// xFacility2015
/**
 * # class XFMySQL
 * - Ported from PyMySQL module of Python3.
 * - This class is for managing MySQL database.
 * - This is not compatible with previous XFMySQL class.
 * 
 * ## Contributors
 * - Studio2b
 * - Michael Son(mson0129@gmail.com)
 * 
 * ## History
 * - 26NOV2022(1.0.0.) - This file is newly added.
 */
class XFMySQL extends XFObject {
    private $__connection;
    private $__stmt;

    public function __construct($host, $user, $password, $database, $port=3306, $charset="utf8") {
        $this->connect($host, $user, $password, $database, $port, $charset);
    }

    public function connect($host, $user, $password, $database, $port=3306, $charset="utf8") {
        $this->__connection = new mysqli($host, $user, $password, $database, $port);
        if($this->__connection->connect_error)
        if ($this->__connection->connect_errno) {
            die("Could not connect: " . $this->__connection->connect_error);
        } else {
            $this->__connection->set_charset($charset);
            return $this->__connection;
        }
    }

    public function cursor() {
        $this->__stmt = $this->__connection->stmt_init();
    }

    public function execute(string $query, array $params=NULL) {
        $query = str_replace("?", "%s", $query);
        $query = vsprintf($query, $params);

        $this->__stmt->prepare("SELECT id, email, pw, `name`, auth FROM dnyc_users WHERE email = ?");
        $this->__stmt->bind_param("s", $_POST["email"]);
        $this->__stmt->execute();
        $this->__stmt->affected_rows;
    }
}
?>