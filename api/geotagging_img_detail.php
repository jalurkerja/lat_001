<?php 
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	$user_id = $_GET["user_id"];
	$sitename = $_GET["sitename"];
	$site_id = $_GET["site_id"];
	$current = $_GET["current"];
	$fromlist = $_GET["fromlist"];
	$photo_item_id = $_GET["photo_item_id"];
	$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
	
	if($_GET["save_sn"]){
		$db->addtable("indottech_geotagging"); $db->where("id",$_GET["id"]);
		$db->addfield("serial_number"); $db->addvalue($_GET["sn"]);
		$db->update();
		$message = "<font color='blue'>Serial Number Saved!</font>";
	}
	
	$fsfl_mode = $db->fetch_single_data("indottech_geotagging_req","fsfl_mode",["id" => $indottech_geotagging_req_id]);
	if($fsfl_mode != 1){
		if($db->fetch_single_data("indottech_geotagging_req","id",["id" => $indottech_geotagging_req_id, "photo_item_ids" => "%|615|%:LIKE"])) $fsfl_mode = 1;
	}
	$dl_url = $_GET["dl_url"];
	$tagging_at = $db->fetch_single_data("indottech_geotagging","tagging_at",["id" => $_GET["id"]]);
	$serial_number = $db->fetch_single_data("indottech_geotagging","serial_number",["id" => $_GET["id"]]);
	echo "<input type='button' value='Back' style='width:100%;height:50px;font-size:20px;font-weight:bolder;' onclick=\"window.location='geotagging_mine.php?fromlist=".$fromlist."&current=".$current."&user_id=".$user_id."&token=".$token."&site_id=".$site_id."&sitename=".$sitename."&tagging_at=".$tagging_at."&indottech_geotagging_req_id=".$indottech_geotagging_req_id."&dl_url=".$dl_url."';\">";
	echo "<input type='button' value='Retake Photo' style='width:100%;height:50px;font-size:20px;font-weight:bolder;' onclick=\"window.location='geotagging_mine.php?fromlist=".$fromlist."&current=".$current."&user_id=".$user_id."&token=".$token."&site_id=".$site_id."&sitename=".$sitename."&tagging_at=".$tagging_at."&indottech_geotagging_req_id=".$indottech_geotagging_req_id."&dl_url=".$dl_url."&skipItem=".$photo_item_id."||".get_complete_name($photo_item_id)."';\">";
	if($message!="") echo $message;
	if($fsfl_mode>0){
		echo "<br>";
		echo "<form method='GET'>";
		echo "<input type='hidden' name='id' value='".$_GET["id"]."'>";
		echo "<input type='hidden' name='user_id' value='".$_GET["user_id"]."'>";
		echo "<input type='hidden' name='sitename' value='".$_GET["sitename"]."'>";
		echo "<input type='hidden' name='site_id' value='".$_GET["site_id"]."'>";
		echo "<input type='hidden' name='current' value='".$_GET["current"]."'>";
		echo "<input type='hidden' name='fromlist' value='".$_GET["fromlist"]."'>";
		echo "<input type='hidden' name='photo_item_id' value='".$_GET["photo_item_id"]."'>";
		echo "<input type='hidden' name='indottech_geotagging_req_id' value='".$_GET["indottech_geotagging_req_id"]."'>";
		echo "S/N: <input name='sn' value='".$serial_number."'><input type='submit' name='save_sn' value='Save'>";
		echo "</form>";
	}
	echo "<img src='../geophoto/".$db->fetch_single_data("indottech_geotagging","filename",["id" => $_GET["id"]])."'' style='width:100%;'><br>";
?>