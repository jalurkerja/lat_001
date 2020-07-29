<?php
	include_once "../common.php";
	echo $db->fetch_single_data("users","token",["token" => $_GET["token"]]);
?>