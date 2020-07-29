<?php
	include_once "../common.php";
	include_once "user_info.php";
	$indottech_notification_id = $db->fetch_single_data("indottech_notifications","id",["user_id" => $user_id,"status"=>"0"]);
	if($indottech_notification_id > 0){
		$message = $db->fetch_single_data("indottech_notifications","message",["id" => $indottech_notification_id]);
		$db->addtable("indottech_notifications"); 
		$db->where("id",$indottech_notification_id);
		$db->addfield("status");	$db->addvalue("1");
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->update();
		echo $message;
	}else{
		echo "0";
	}
?>