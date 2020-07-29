<?php
	function get_complete_name($id = 0){
		global $db;
		$return = $db->fetch_single_data("indottech_photo_items","name",["id" => $id]);
		$parent_id = $db->fetch_single_data("indottech_photo_items","parent_id",["id" => $id]);
		if($parent_id > 0) $return = $db->fetch_single_data("indottech_photo_items","name",["id" => $parent_id])."--".$return;
		$parent_id = $db->fetch_single_data("indottech_photo_items","parent_id",["id" => $parent_id]);
		if($parent_id > 0) $return = $db->fetch_single_data("indottech_photo_items","name",["id" => $parent_id])."--".$return;
		return str_replace([" ","(",")","/"],["","_","","_"],$return);
	}
	
	function photo_items_list($ids){
		global $db;
		$i=-1;
		$return = array();
		foreach($ids as $id){
			$indottech_photo_items = $db->fetch_all_data("indottech_photo_items",[],"parent_id = '".$id."'");
			foreach($indottech_photo_items as $photo_items_list){
				if($photo_items_list["is_childest"] == 1){
					$i++;
					$return[$i]["id"] = $photo_items_list["id"];
					$return[$i]["name"] = get_complete_name($photo_items_list["id"]);
				} else {
					$indottech_photo_items2 = $db->fetch_all_data("indottech_photo_items",[],"parent_id = '".$photo_items_list["id"]."'");
					foreach($indottech_photo_items2 as $photo_items_list2){
						if($photo_items_list2["is_childest"] == 1){
							$i++;
							$return[$i]["id"] = $photo_items_list2["id"];
							$return[$i]["name"] = get_complete_name($photo_items_list2["id"]);
						}
					}
				}
			}
		}
		return $return;
	}
	
	function next_photo_item($group_ids,$current_id = 0){
		$arr = photo_items_list($group_ids);
		if($current_id > 0){
			foreach($arr as $key => $data){
				if($data["id"] == $current_id){
					return $arr[$key+1]["id"];
					break;
				}
			}
		} else {
			return $arr[0]["id"];
		}
		return $arr[0]["id"];
	}

	function prev_photo_item($group_ids,$current_id = 0){
		$arr = photo_items_list($group_ids);
		foreach($arr as $key => $data){
			if($data["id"] == $current_id){
				return $arr[$key-1]["id"];
				break;
			}
		}
		return $arr[count($arr)-1]["id"];
	}
	
	function resizeImage($filename){
		list($width, $height) = getimagesize($filename);
		$percent = 1024/$width;
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
		
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($filename);
		
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg($thumb, $filename,100);
		return 1;
	}
	
	function insertTextImg($source,$dest,$text){
		ob_start();
		header('Content-type: image/jpeg');
		$image = imagecreatefromjpeg($source);
		$color = imagecolorallocate($image, 255, 255, 255);
		$color2 = imagecolorallocate($image, 0, 0, 0);
		//$font = imageloadfont("font.gdf");
		// $font = "/var/www/html/indottech/api/arial.ttf";
		$font = "/var/www/html/indottech/api/TruenoLt.otf";
		list($width, $height, $image_type) = getimagesize($source);
		$x = $width - 370;
		$x = 10;
		$y = $height - ($height * 0.95);
		// $text = $height." xxxxx ".$y;
		$arrtext = explode("<br>",$text);
		foreach($arrtext as $text){
			// imagestring($image, $font, $x+2, $y+2, $text, $color2);
			// imagestring($image, $font, $x, $y, $text, $color);
			imagettftext($image, 25, 0, $x+1, $y+2, $color2, $font, $text );
			imagettftext($image, 25, 0, $x, $y, $color, $font, $text );
			$y+=34;
		}
		imagejpeg($image);
		$return = ob_get_contents();
		ob_clean();
		$fp = fopen($dest, "w");
		fwrite($fp, $return);
		fclose($fp);
	}
?>