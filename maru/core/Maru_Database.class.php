<?php
class Maru_Database {
    private $tables = array(
        "authentication" => array(
            "accounts" => "maru1_authentication1_accounts1",
            "users" => "maru1_authentication1_users1",
            "usersperonae" => "maru1_authentication1_userpersonae1",
            "personae" => "maru1_authentication1_personae1",
            "groups" => "maru1_authentication1_groups1",
            "acls" => "maru1_authentication1_acls1"
        )
    );

    public function __construct() {
    }
}
?>