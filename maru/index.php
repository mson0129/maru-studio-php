<?php
// require_once($_SERVER["DOCUMENT_ROOT"]."/maru/classes/core/maru_configs.class.php");
// $maru_configs = new Maru_Configs();
// print_r($maru_configs->get_configs());


require_once($_SERVER["DOCUMENT_ROOT"]."/xfacility/autoload.php");
$str = new XFString("20221105T232947+0900");

$dt = new DateTime("20221105T232947+0900");
echo $dt->format("Y-m-d H:i:s");
?>