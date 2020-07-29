<?php
	error_reporting(0);
	$_SERVER["DOCUMENT_ROOT"] = "../";
	include_once "common.php";
	$storages = $db->fetch_all_data("storage",[],"expired_at < NOW()");
	foreach($storages as $storage){
		$physicalname = $db->fetch_single_data("storage","physicalname",["id" => $storage["id"]]);
		unlink("storage_share/".$physicalname);
		$db->addtable("storage"); $db->where("id",$storage["id"]); $db->delete_();
	}
?>
