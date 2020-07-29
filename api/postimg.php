<?php
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	$data = file_get_contents('php://input');
	$site_id = $_GET["site_id"];
	$sitename = $_GET["sitename"];
	$photo_item_id = $_GET["photo_item_id"];
	$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
	$sitename = $db->fetch_single_data("indottech_geotagging_req","sitename",["id" => $indottech_geotagging_req_id]);
	$photo_item_name = get_complete_name($photo_item_id);
	
	if($indottech_geotagging_req_id > 0){
		$tagging_at = $_GET["tagging_at"];
		$basefilename = "tag_".$user_id."_".$site_id."_".$tagging_at."_".$photo_item_name.".jpg";
		$basezipfile = "geotag_".$user_id."_".$site_id."_".$tagging_at.".zip";
		$filename = "../geophoto/".$basefilename;
		$zipfile = "../geophoto/".$basezipfile;
	}
	if($_GET["photoMode"] == "atp_installation_battery_photo"){
		$params = explode("|",$_GET["param"]);
		$fieldname = $params[0];
		$atd_id = $params[1];
		$battery_discharge_id = $params[2];
		$tagging_at = date("YmdHis");
		$basefilename = "tag_".$__user_id."_".$fieldname."_".$atd_id."_".$battery_discharge_id."_".$tagging_at.".jpg";
		$filename = "../geophoto/".$basefilename;
		$coordinates = explode("|",$_GET["coordinate"]);
		$latitude = $coordinates[0];
		$longitude = $coordinates[1];
		$site_id = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
		$site_name = $db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);
		$battery_discharge_photos_id = $db->fetch_single_data("indottech_battery_discharge_photos","id",["battery_discharge_id" => $battery_discharge_id,"atd_id" => $atd_id,"minute_at" => "30"]);
		$oldfile = $db->fetch_single_data("indottech_battery_discharge_photos",$fieldname,["id" => $battery_discharge_photos_id]);
		unlink("../geophoto/".$oldfile);
	}
	if($_GET["photoMode"] == "atp_installation_photos_detail"){
		$params = explode("|",$_GET["param"]);
		$atd_id = $params[0];
		$photo_items_id = $params[1];
		$tagging_at = date("YmdHis");
		$basefilename = "tag_atp_installation_".$__user_id."_".$atd_id."_".$photo_items_id."_".$tagging_at.".jpg";
		$filename = "../geophoto/".$basefilename;
		$site_id = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $site_id]);
			$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $site_id]);
		}
		$site_name = $db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["atd_id" => $atd_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
	}
	if($_GET["photoMode"] == "tag_photo_project_detail"){
		$params = explode("|",$_GET["param"]);
		$atd_id = $params[0];
		$photo_items_id = $params[1];
		$_site_id = $db->fetch_single_data("indottech_tag_photo_projects","site_id",["id" => $atd_id]);
		$site_id = $db->fetch_single_data("indottech_tag_photo_projects","site_code",["id" => $atd_id]);
		$doctype = $db->fetch_single_data("indottech_photo_items","doctype",["id" => $photo_items_id]);
		$com = $db->fetch_single_data("indottech_photo_items","com",["id" => $photo_items_id]);
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["atd_id" => $atd_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
		$basefilename = $site_id."_".$com."_".$doctype.numberpad($seqno,2).".jpg";
		$filename = "../geophoto/".$basefilename;
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $_site_id]);
			$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $_site_id]);
		}
		$site_name = $db->fetch_single_data("indottech_tag_photo_projects","site_name",["id" => $atd_id]);
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
	}
	if($_GET["photoMode"] == "indosat_dwdm_photo_detail"){
		$params = explode("|",$_GET["param"]);
		$dwdm_id = $params[0];
		$photo_items_id = $params[1];
		$site_name = $db->fetch_single_data("indottech_dwdm","site_name",["id" => $dwdm_id]);
		
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["dwdm_id" => $dwdm_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
		$basefilename = date("y")."_dwdm_".$dwdm_id."_".$photo_items_id.numberpad($seqno,2).".jpg";
		$filename = "../geophoto/".$basefilename;
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
		
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = "0";
			$longitude = "0";
		}
	}
	if($_GET["photoMode"] == "tssr_new_site_add_photo_detail"){
		$params = explode("|",$_GET["param"]);
		$tssr_id = $params[0];
		$photo_items_id = $params[1];
		$site_name 	= $db->fetch_single_data("indottech_tssr_01","site_name",["id" => $tssr_id]);
		$site_code 	= $db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]);
		$com 		= $db->fetch_single_data("indottech_photo_items","com",["id" => $photo_items_id]);
		$doctype 	= $db->fetch_single_data("indottech_photo_items","doctype",["id" => $photo_items_id]);
		
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["tssr_id" => $tssr_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
		
		$basefilename 	= strtoupper($site_code)."_".$com."_".$doctype.numberpad($seqno,2).".jpg";
		$filename = "../geophoto/".$basefilename;
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = "0";
			$longitude = "0";
		}
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
	}
	if($_GET["photoMode"] == "pms_nokia_photo_detail"){
		$params = explode("|",$_GET["param"]);
		$pms_id = $params[0];
		$photo_items_id = $params[1];
		$photo_name = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
		$site_id = $db->fetch_single_data("pms_nokia","site_id",["id" => $pms_id]);
		$site_name = $db->fetch_single_data("pms_nokia","site_name",["id" => $pms_id]);
		
		$seqno = $db->fetch_single_data("indottech_photos","seqno",["filename" => "%PmsId_".$pms_id."%:LIKE","photo_items_id" => $photo_items_id],["seqno DESC"]);
		$seqno++;
		$basefilename = "PmsId_".$pms_id."_".$photo_name.numberpad($seqno,2).".jpg";
		$filename = "../geophoto/".$basefilename;
		$photo_title = $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
	}
	if($_GET["photoMode"] == "new_activities" || $_GET["photoMode"] == "attach_activities" || $_GET["photoMode"] == "sick_activities" || $_GET["photoMode"] == "sick_activities_edit"){
		// $plan_id = $params[0];
		// $plan_site_id = $params[1];
		$basefilename = "activityphoto_".$_GET["param"].".jpg";
		$filename = "../geophoto/".$basefilename;
		if($_GET["photoMode"] == "attach_activities"){
			$params = explode("|",$_GET["param"]);
			$basefilename = "activity_".$params[0].".jpg";
			$filename = "../activity_attachments/".$basefilename;
		}
		if($_GET["photoMode"] == "sick_activities" || $_GET["photoMode"] == "sick_activities_edit"){
			$params = explode("|",$_GET["param"]);
			$basefilename = "sick_".$params[0].".jpg";
			$filename = "../geophoto/".$basefilename;
		}
		if($_GET["coordinate"] != ""){
			$coordinates = explode("|",$_GET["coordinate"]);
			$latitude = $coordinates[0];
			$longitude = $coordinates[1];			
		} else {
			$latitude = "0";
			$longitude = "0";
		}
	}
	// if($_GET["photoMode"] == "view_activities" || $_GET["photoMode"] == "attendance_sick" || $_GET["photoMode"] == "activity_wo_plan_edit"){
		// $params = explode("|",$_GET["param"]);
		// $plan_id = $params[0];
		// $plan_site_id = $params[1];
		// $basefilename = "activityphoto_".$__user_id."_".$plan_id."_".$plan_site_id.".jpg";
		// $filename = "../geophoto/".$basefilename;
		// if($_GET["coordinate"] != ""){
			// $coordinates = explode("|",$_GET["coordinate"]);
			// $latitude = $coordinates[0];
			// $longitude = $coordinates[1];			
		// } else {
			// $latitude = "0";
			// $longitude = "0";
		// }
	// }

	$photo_is_saved = move_uploaded_file($_FILES["photofile"]["tmp_name"], $filename);
	if(!$photo_is_saved) $photo_is_saved = file_put_contents($filename,$data);
	if (!($photo_is_saved === FALSE)){
		resizeImage($filename);
		if($indottech_geotagging_req_id > 0){
			$latitude = $db->fetch_single_data("indottech_geotagging_req","latitude",["id" => $indottech_geotagging_req_id]);
			$longitude = $db->fetch_single_data("indottech_geotagging_req","longitude",["id" => $indottech_geotagging_req_id]);
			if($_GET["watermark"] == "true"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
			
			$db->addtable("indottech_geotagging"); 
			$db->where("indottech_geotagging_req_id",$indottech_geotagging_req_id);
			$db->where("photo_item_id",$photo_item_id);
			$db->delete_();
			
			$db->addtable("indottech_geotagging");
			$db->addfield("indottech_geotagging_req_id");	$db->addvalue($indottech_geotagging_req_id);
			$db->addfield("user_id");						$db->addvalue($user_id);
			$db->addfield("site_id");						$db->addvalue($site_id);
			$db->addfield("sitename");						$db->addvalue($sitename);
			$db->addfield("tagging_at");					$db->addvalue($tagging_at);
			$db->addfield("photo_item_id");					$db->addvalue($photo_item_id);
			$db->addfield("filename");						$db->addvalue($basefilename);
			$db->addfield("created_at");					$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("created_by");					$db->addvalue($username);
			$db->addfield("created_ip");					$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$db->insert();
			$zip = new ZipArchive;
			if(true === ($zip->open($zipfile, ZipArchive::CREATE))){
				$zip->addFile($filename, $basefilename);
				$zip->close();
			}
			
			$photo_item_ids = pipetoarray($db->fetch_single_data("indottech_geotagging_req","photo_item_ids",["id" => $indottech_geotagging_req_id]));
			echo "File Transfered||".next_photo_item($photo_item_ids,$photo_item_id)."||".get_complete_name(next_photo_item($photo_item_ids,$photo_item_id));
		}
		if($_GET["photoMode"] == "atp_installation_battery_photo"){
			if($_GET["watermark"] == "yes"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
			
			$db->addtable("indottech_battery_discharge_photos");
			if($battery_discharge_photos_id > 0)	$db->where("id",$battery_discharge_photos_id);
			$db->addfield("battery_discharge_id");	$db->addvalue($battery_discharge_id);
			$db->addfield("atd_id");				$db->addvalue($atd_id);
			$db->addfield("minute_at");				$db->addvalue("30");
			$db->addfield($fieldname);				$db->addvalue($basefilename);
			if($battery_discharge_photos_id > 0) $db->update();
			else $db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "atp_installation_photos_detail" || $_GET["photoMode"] == "tag_photo_project_detail"){
			if($_GET["watermark"] == "yes"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
			
			$db->addtable("indottech_photos");
			$db->addfield("atd_id");			$db->addvalue($atd_id);
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "indosat_dwdm_photo_detail"){
			if($_GET["watermark"] == "yes"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
			
			$db->addtable("indottech_photos");
			$db->addfield("dwdm_id");			$db->addvalue($dwdm_id);
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "tssr_new_site_add_photo_detail"){
			if($_GET["watermark"] == "yes"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
			
			$db->addtable("indottech_photos");
			$db->addfield("tssr_id");			$db->addvalue($tssr_id);
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->insert();
			echo "OK";
		}
		if($_GET["photoMode"] == "pms_nokia_photo_detail"){
			if($_GET["watermark"] == "yes"){
				$imgtext = $site_id." - ".$site_name;
				$imgtext .= "<br>".$latitude.";".$longitude;
				$imgtext .= "<br>".date("d/m/Y H:i:s");
				insertTextImg($filename,$filename,$imgtext);
			} else {}
				
			$date_1 = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-30,date("Y")));
			$date_2 = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")+2,date("Y")));
			$tag_id = $db->fetch_all_data("indottech_tag_photo_projects",[],"project_id = '3' AND user_id = '".$__user_id."' AND site_code LIKE '".$site_id."' AND site_name LIKE '".$site_name."' AND created_at BETWEEN '".$date_1."' AND '".$date_2."'","created_at DESC")[0];
			$tag_id = $tag_id["id"];
			if(!$tag_id){
				$db->addtable("indottech_tag_photo_projects");
				$db->addfield("project_id");		$db->addvalue("3");
				$db->addfield("user_id");			$db->addvalue($__user_id);
				$db->addfield("site_code");			$db->addvalue($site_id);
				$db->addfield("site_name");			$db->addvalue($site_name);
				$inserting = $db->insert();
				$tag_id =  $inserting["insert_id"];
				
				$db->addtable("pms_nokia");			$db->where("id",$pms_id);
				$db->addfield("tag_photo_id");		$db->addvalue($tag_id);
				$db->update();
			}
			
			$db->addtable("indottech_photos");
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->addfield("atd_id");			$db->addvalue($tag_id);
			$db->insert();
			echo "OK";
		}
		// if($_GET["photoMode"] == "view_activities" || $_GET["photoMode"] == "attendance_sick" || $_GET["photoMode"] == "activity_wo_plan_edit"){
			// $imgtext = "<br>".$latitude.";".$longitude;
			// $imgtext .= "<br>".date("d/m/Y H:i:s");
			// if($_GET["coordinate"] != "" && $latitude != 0 && $longitude != 0) {
				// insertTextImg($filename,$filename,$imgtext);
				// $db->addtable("attendance_activity");
				// $db->addfield("longitude");			$db->addvalue($longitude);
				// $db->addfield("latitude");			$db->addvalue($latitude);
				// $db->where("id",$params[0]);
				// $db->update();
			// }
			// echo "OK";
		// }
		if($_GET["photoMode"] == "new_activities" || $_GET["photoMode"] == "attach_activities" || $_GET["photoMode"] == "sick_activities" || $_GET["photoMode"] == "sick_activities_edit"){
			$imgtext = "<br>".$latitude.";".$longitude;
			if($_GET["photoMode"] == "attach_activities"){
				$imgtext = "";
				$db->addtable("attendance_activity");
				$db->addfield("attachment");		$db->addvalue($basefilename);
				$db->where("id",$params[1]);
				$db->update();
			}
			$imgtext .= "<br>".date("d/m/Y H:i:s");
			if($_GET["coordinate"] != "" && $latitude != 0 && $longitude != 0) {
				insertTextImg($filename,$filename,$imgtext);
				$db->addtable("attendance_photos");
				$db->addfield("user_id");			$db->addvalue($__user_id);
				$db->addfield("filename");			$db->addvalue($basefilename);
				$db->addfield("longitude");			$db->addvalue($longitude);
				$db->addfield("latitude");			$db->addvalue($latitude);
				$db->insert();
			}
			echo "OK";
		}
	} else {
		echo "File Failed Transfered||"; 
	}
?>
