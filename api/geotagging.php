<?php
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	include_once "func.sendingmail_v2.php";
	$lat = $_GET["lat"];
	$long = $_GET["long"];
	$site_id = $_GET["site_id"];
	$sitename = $_GET["sitename"];
	$tagging_at = $_GET["tagging_at"];
	$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
	$siteIdSelected = $_GET["siteIdSelected"];
	$name = $db->fetch_single_data("users","name",["token" => $token]);
	if($_GET["retakeMode"] && $_GET["wait_approving"] == ""){
		$datediff = $db->fetch_single_data("indottech_geotagging_req","concat(HOUR(TIMEDIFF(NOW(), approved_at)))",["id" => $indottech_geotagging_req_id]);
		$db->addtable("indottech_geotagging_req");
		$db->where("id",$indottech_geotagging_req_id);
		$db->where("status",2);
		$db->addfield("latitude");	$db->addvalue($lat);
		$db->addfield("longitude");	$db->addvalue($long);
		if($datediff >= 2){
			$db->addfield("status");	$db->addvalue(0);
		} else {
			$db->addfield("status");	$db->addvalue(1);
			$db->addfield("approved_at");$db->addvalue(date("Y-m-d H:i:s"));
		}
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");$db->addvalue($username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->update();
		$teamleaders = $db->fetch_all_data("users",[],"group_id = '11' AND forbidden_chr_dashboards='6'");
		foreach($teamleaders as $teamleader){	
			$address = $teamleader["email"];
			$replyto = $db->fetch_single_data("users","email",["id" => $user_id]);
			$body = "<b>GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename."</b><br>";
			$body .= "<a href='http://103.253.113.201/indottech/indottech_geotagging_req_list.php' target='_BLANK'>";
			$body .= "Please visit Indottech - Dasboards or Indottech Apps for Approving this request!";
			$body .= "</a>";
			//sendingmail("GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename,$address,$body,$replyto);
			//sendingmail($teamleader["email"]." GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename,$address,$body,$replyto);
		}
		echo "1";
	}
	if($_GET["requesting"] == "1"){
		//if($db->fetch_single_data("indottech_geotagging_req","id",["user_id" => $user_id,"site_id" => $site_id,"created_at" => date("Y-m-d")."%:LIKE","status" => "-1:>"]) <= 0){
		$db->addtable("indottech_geotagging_req"); $db->addfield("id");
		$db->awhere("user_id = '".$user_id."' AND site_id = '".$site_id."' AND status > '-1' AND DATEDIFF(NOW(), created_at) <= '7'");
		$db->order("id DESC"); $db->limit(1);
		$indottech_geotagging_req_id = $db->fetch_data()[0];
		if($indottech_geotagging_req_id <= 0){
			
			$db->addtable("indottech_geotagging_req");
			$db->addfield("user_id");	$db->addvalue($user_id);
			$db->addfield("site_id");	$db->addvalue($site_id);
			$db->addfield("sitename");	$db->addvalue($sitename);
			$db->addfield("latitude");	$db->addvalue($lat);
			$db->addfield("longitude");	$db->addvalue($long);
			$db->addfield("status");	$db->addvalue(0);
			if($siteIdSelected > 0){
				$db->addfield("fsfl_mode");$db->addvalue(1);
				$db->addfield("siteIdSelected");$db->addvalue($siteIdSelected);
			}
			$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("created_by");$db->addvalue($username);
			$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");$db->addvalue($username);
			$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert();
			
			$teamleaders = $db->fetch_all_data("users",[],"group_id = '11' AND forbidden_chr_dashboards='6'");
			foreach($teamleaders as $teamleader){	
				$address = $teamleader["email"];
				$replyto = $db->fetch_single_data("users","email",["id" => $user_id]);
				$body = "<b>GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename."</b><br>";
				$body .= "<a href='http://103.253.113.201/indottech/indottech_geotagging_req_list.php' target='_BLANK'>";
				$body .= "Please visit Indottech - Dasboards or Indottech Apps for Approving this request!";
				$body .= "</a>";
				//sendingmail("GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename,$address,$body,$replyto);
				//sendingmail($teamleader["email"]." GeoTagging Request From ".$name." Sitename: [".$site_id."] ".$sitename,$address,$body,$replyto);
			}
		}
		echo "1";
	}
	if($_GET["wait_approving"] == "1"){
		$updateStatus = false;
		if($_GET["retakeMode"] == ""){
			$db->addtable("indottech_geotagging_req"); $db->addfield("id");
			$db->awhere("user_id = '".$user_id."' AND site_id = '".$site_id."' AND status > '0' AND DATEDIFF(NOW(), created_at) <= '7'");
			$db->order("id DESC"); $db->limit(1);
			$indottech_geotagging_req_id = $db->fetch_data()[0];
			if($indottech_geotagging_req_id > 0){
				$updateStatus = true;
			} else {
				$indottech_geotagging_req_id = $db->fetch_single_data("indottech_geotagging_req","id",["user_id" => $user_id,"site_id" => $site_id,"created_at" => date("Y-m-d")."%:LIKE","status" => "-1"]);
				if($indottech_geotagging_req_id > 0){
					$db->addtable("indottech_geotagging_req"); 
					$db->where("id",$indottech_geotagging_req_id);
					$db->addfield("status");	$db->addvalue("-2");
					$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
					$db->addfield("updated_by");$db->addvalue($username);
					$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
					$db->update();
					echo "geotagging_rejected||";exit();
				}
			}
		} else {
			$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
			if($db->fetch_single_data("indottech_geotagging_req","status",["id" => $indottech_geotagging_req_id]) == "1"){
				$updateStatus = true;
			}
		}
		if($updateStatus){
			$db->addtable("indottech_geotagging_req"); 
			$db->where("id",$indottech_geotagging_req_id);
			$db->addfield("status");	$db->addvalue("2");
			$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");$db->addvalue($username);
			$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->update();
			
			$photo_item_ids = pipetoarray($db->fetch_single_data("indottech_geotagging_req","photo_item_ids",["id" => $indottech_geotagging_req_id]));
			echo "geotagging_approved||".next_photo_item($photo_item_ids)."||".get_complete_name(next_photo_item($photo_item_ids))."||".$indottech_geotagging_req_id;
		}
	}
?>