<?php
	include_once "../common.php";
	include_once "user_info.php";
	if($token != ""){
		$user_id = $db->fetch_single_data("users","id",["token" => $token]);
		if($user_id > 0){
			$username = $db->fetch_single_data("users","email",["token" => $token]);
			if($group_id == 12) echo $username."||1";
			else echo $username."||2";
		} else {
			echo "0";
		}
	} else {
		echo "0";
	}
?>