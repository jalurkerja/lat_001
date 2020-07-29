<?php
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	var_dump(file_get_contents('php://input'));
	$data = file_get_contents('php://input');
	$filename = "../geophoto/".date("YmsHis").rand(0,9).rand(0,9).rand(0,9).".jpg";
	$photo_is_saved = move_uploaded_file($_FILES["photofile"]["tmp_name"], $filename);
	if(!$photo_is_saved) $photo_is_saved = file_put_contents($filename,$data);

	if (!($photo_is_saved === FALSE)){
		echo "oke";
	} else {
		echo "File Failed Transfered||"; 
	}
?>
