<?php
	include_once "../common.php";
	include_once "user_info.php";
	$db->addtable("attendance");
	$db->addfield("project_id");	$db->addvalue($project_id);
	$db->addfield("user_id");		$db->addvalue($user_id);
	$db->addfield("in_out");		$db->addvalue($_GET["in_out"]);
	$db->addfield("tap_time");		$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("latitude");		$db->addvalue($_GET["latitude"]);
	$db->addfield("longitude");		$db->addvalue($_GET["longitude"]);
	$inserting = $db->insert();
	echo $inserting["affected_rows"];
?>
