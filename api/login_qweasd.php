<?php
	include_once "../common.php";
	if(login_action($_GET["username"],$_GET["password"]) == "1"){
		$user_id = $db->fetch_single_data("users","id",["email" => $_GET["username"]]);
		$token = session_id().$user_id;
		$db->addtable("users");	$db->where("id",$user_id);
		$db->addfield("token");	$db->addvalue($token);
		$db->update();
		echo $token;
	} else {
		echo "0";
	}
?>
