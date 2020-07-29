<?php
	$token = $_GET["token"];
	if($token != ""){		
		$job_title = $db->fetch_single_data("users","job_title",["token" => $token]);
		$nama_user = $db->fetch_single_data("users","name",["token" => $token]);
		$username = $db->fetch_single_data("users","email",["token" => $token]);
		$user_id = $db->fetch_single_data("users","id",["token" => $token]);
		$group_id = $db->fetch_single_data("users","group_id",["token" => $token]);
		$__username = $username;
		$_SESSION["username"] = $username;
		$__user_id = $user_id;
		$__group_id = $group_id;
	}
?>