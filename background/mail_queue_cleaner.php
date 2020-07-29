<?php
	set_time_limit(0);
	include_once "document_root_path.php";
	include_once "common.php";
	
	$lastday = date("Y-m-d",mktime(0,0,0,date("m"),date("d") - 3));
	
	$db->addtable("mail_queue");
	$db->where("status",1);
	$db->where("created_at",$lastday,"s","<");
	$db->delete_();
	
	$db->addtable("mail_queue_za");
	$db->where("status",1);
	$db->where("created_at",$lastday,"s","<");
	$db->delete_();
	
	$db->addtable("mail_queue_jk");
	$db->where("status",1);
	$db->where("created_at",$lastday,"s","<");
	$db->delete_();

?>