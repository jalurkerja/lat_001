<?php
include_once "header.php";
include_once "user_info.php";

$user_details = $db->fetch_all_data("users",[],"id = '".$__user_id."'")[0];
if($user_details["on_board"] != "0000-00-00"){
	$txt_tap_time1 = $user_details["on_board"];
	$txt_tap_time2 = date("Y-m-d");
	$datetime1 = new DateTime($txt_tap_time1);
	$datetime2 = new DateTime($txt_tap_time2);
	$difference = $datetime1->diff($datetime2);
	$diff_d	= $difference->days+1;
	$diff_y	= $difference->y;
	$diff_m	= $difference->m;
	
	if($user_details["leave_num"] < 12 && $user_details["leave_num"] != $diff_m){
		$db->addtable("users");					$db->where("id",$__user_id);
		if($diff_y == 0){
			$db->addfield("leave_num"); 		$db->addvalue($diff_m);
		}
		if($diff_y == 1 && $diff_m == 0 && $user_details["leave_num"] < 12){
			$db->addfield("leave_num"); 		$db->addvalue("12");
		}
		$inserting = $db->update();
	}
}
?>
