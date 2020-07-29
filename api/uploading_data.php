<?php
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	$data = file_get_contents('php://input');
	$device_atd_id	= $_GET["atd_id"];
	$photo_items_id	= $_GET["photo_items_id"];
	$project_id		= $_GET["project_id"];
	$site_id		= $_GET["site_id"];
	$site_code 		= $_GET["site_code"];
	if(!$site_code){$site_code = $db->fetch_single_data("indottech_sites","kode",["id" => $site_id]);}
	$tag_latitude	= $_GET["latitude"];
	$tag_longitude	= $_GET["longitude"];
	$created_at		= $_GET["created_at"];
	if($project_id == 17 || $project_id == 3 || $project_id == 29){
		if($db->fetch_single_data("indottech_syncs_map","id",["user_id" => $__user_id, "project_id" => $project_id, "device_atd_id" => $device_atd_id, "created_at" => date('Y-m-d', strtotime("-6 day"))."' AND '".date('Y-m-d', strtotime("+2 day")).":BETWEEN"]) <= 0){
		// if($db->fetch_single_data("indottech_syncs_map","id",["user_id" => $__user_id, "project_id" => $project_id, "device_atd_id" => $device_atd_id, "created_at" => date("Y-m-d")."%:LIKE"]) <= 0){
			$site_name = $db->fetch_single_data("indottech_sites","name",["id" => $site_id]);
			$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $site_id]);
			$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $site_id]);
			$db->addtable("indottech_tag_photo_projects");
			$db->addfield("project_id");	$db->addvalue($project_id);
			$db->addfield("user_id");		$db->addvalue($__user_id);
			$db->addfield("site_id");		$db->addvalue($site_id);
			$db->addfield("site_code");		$db->addvalue($site_code);
			$db->addfield("site_name");		$db->addvalue($site_name);
			$db->addfield("latitude");		$db->addvalue($latitude);
			$db->addfield("longitude");		$db->addvalue($longitude);
			$atd_id = $db->insert()["insert_id"];
			
			$db->addtable("indottech_syncs_map");
			$db->addfield("user_id");		$db->addvalue($__user_id);
			$db->addfield("project_id");	$db->addvalue($project_id);
			$db->addfield("atd_id");		$db->addvalue($atd_id);
			$db->addfield("device_atd_id");	$db->addvalue($device_atd_id);
			$db->insert();
			
			if($project_id == 3){
				$db->addtable("indottech_h3i_photo_attachments");
				$db->addfield("tag_photo_id");		$db->addvalue($atd_id);
				$db->addfield("user_id");			$db->addvalue($__user_id);
				$db->addfield("doc_name");			$db->addvalue("H3I ATP DISM PAR");
				$inserting = $db->insert();
			}
			
			if($project_id == 29){
				$db->addtable("indottech_sa");
				$db->addfield("atd_id");			$db->addvalue($atd_id);
				$db->where("site_id", $site_id);
				$db->update();
			}
			
		} else {
			$atd_id = $db->fetch_single_data("indottech_syncs_map","atd_id",["user_id" => $__user_id, "project_id" => $project_id, "device_atd_id" => $device_atd_id, "created_at" => date('Y-m-d', strtotime("-6 day"))."' AND '".date('Y-m-d', strtotime("+2 day")).":BETWEEN"]);
		}		
		$photo_title 	= $db->fetch_single_data("indottech_photo_items","name",["id" => $photo_items_id]);
		$site_name 		= $db->fetch_single_data("indottech_tag_photo_projects","site_name",["id" => $atd_id]);
		$doctype 		= $db->fetch_single_data("indottech_photo_items","doctype",["id" => $photo_items_id]);
		$com 			= $db->fetch_single_data("indottech_photo_items","com",["id" => $photo_items_id]);
		$seqno 			= $db->fetch_single_data("indottech_photos","seqno",["atd_id" => $atd_id,"photo_items_id" => $photo_items_id],["seqno DESC"]);
		$module_explode = explode("_",$doctype);
		
		$seqno++;
		$basefilename 	= strtoupper($site_code)."_".$com."_".str_replace("isat_survey_","",$doctype).numberpad($seqno,2).".jpg";
		if($module_explode[0] == "isat" && $module_explode[1] == "atp"){
			$full_name 	= $db->fetch_single_data("indottech_photo_items_as","full_name",["photo_id" => $photo_items_id]);
			if(!$full_name) $full_name = $photo_title;
			$basefilename 	= strtoupper($site_code)."_".str_replace("_"," ",$site_name)."_RAN_".str_replace("_"," ",$full_name).numberpad($seqno,2).".jpg";
		}
		if($project_id == 29 && ($module_explode[0] == "sa" || $module_explode[0] == "hs")){
			$site_code = $db->fetch_single_data("indottech_sites","kode",["id" => $site_id]);
			$basefilename 	= $__user_id."_".$site_id."_".$photo_items_id."_".numberpad($seqno,2).".jpg";
		}
		$filename 		= "../geophoto/".$basefilename;
		
		
		$photo_is_saved = move_uploaded_file($_FILES["photofile"]["tmp_name"], $filename);
		if(!$photo_is_saved) $photo_is_saved = file_put_contents($filename,$data);
		if (!($photo_is_saved === FALSE)){
			
			$get_a = $tag_latitude; $a = explode(".",$get_a);	$_a = strlen($a[1]);
			$get_b= $tag_longitude; $b = explode(".",$get_b);	$_b = strlen($b[1]);
			if($_a == "6") {$new_a = $a[0].".".($a[1]+rand(-50,50));} else if($_a == "5"){$new_a = $a[0].".".($a[1]+rand(-5,5)).rand(0,9);} else if($_a == "4"){$new_a = $a[0].".".($a[1]+rand(-1,1)).rand(0,1);} else {$new_a = $get_a;}	
			if($_b == "6") {$new_b = $b[0].".".($b[1]+rand(-50,50));} else if($_b == "5"){$new_b = $b[0].".".($b[1]+rand(-5,5)).rand(0,9);} else if($_b == "4"){$new_b = $b[0].".".($b[1]+rand(-1,1)).rand(0,1);} else {$new_b = $get_b;}	
			
			resizeImage($filename);
			$imgtext = $site_code." - ".$site_name;
			// $imgtext .= "<br>".$tag_latitude.";".$tag_longitude;
			$imgtext .= "<br>".$new_a." ; ".$new_b;
			$imgtext .= "<br>".$created_at;
			insertTextImg($filename,$filename,$imgtext);
			
			$db->addtable("indottech_photos");
			$db->addfield("atd_id");			$db->addvalue($atd_id);
			$db->addfield("photo_items_id");	$db->addvalue($photo_items_id);
			$db->addfield("photo_title");		$db->addvalue($photo_title);
			$db->addfield("filename");			$db->addvalue($basefilename);
			$db->addfield("seqno");				$db->addvalue($seqno);
			$db->addfield("created_at");		$db->addvalue($created_at);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0) {
				echo "1";
				if($project_id == 3){
					$indottech_photos_id = $inserting["insert_id"];
					if($module_explode[0] == "tssr"){
						$id_tssr = $db->fetch_single_data("indottech_tssr_01","id",["site_id" => $site_code]);
						if($id_tssr > 0){
							$tssr_id = $id_tssr;
						} else {
							$db->addtable("indottech_tssr_01");
							$db->addfield("site_id");			$db->addvalue($site_code);
							$db->addfield("site_name");			$db->addvalue($site_name);
							$db->addfield("user_id_creator");	$db->addvalue($__user_id);
							$db->addfield("longitude");			$db->addvalue($tag_longitude);
							$db->addfield("latitude");			$db->addvalue($tag_latitude);
							$db->addfield("created_at");		$db->addvalue($created_at);
							$inserting = $db->insert();
							$tssr_id = $inserting["insert_id"];
						}
							$db->addtable("indottech_photos");		$db->where("id",$indottech_photos_id);
							$db->addfield("tssr_id");				$db->addvalue($tssr_id);
							$update = $db->update();
					}
				}
			
				if($project_id == 29){
					$db->addtable("indottech_".$module_explode[0]);
					$db->addfield("atd_id");			$db->addvalue($atd_id);
					$db->where("site_id", $site_id);
					$db->update();
				}
			} else {
				echo "0"; 
			}
		} else {
			echo "1"; 
		}	
	}

	if($_GET["testapi"]) echo "1";
?>