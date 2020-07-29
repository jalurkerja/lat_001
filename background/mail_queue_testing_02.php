<?php
	set_time_limit(0);
	include_once "document_root_path.php";
	include_once "../func.sendingmail.php";
	include_once "common.php";
	
	$subject = "SMTP Email";
	$body 	 = "SMTP Ready To Use!";
	
	$address = "it@corphr.com";
	sendingmail_za($subject,$address,$body);

	// $address = "warih@jalurkerja.com";
	// sendingmail_jk($subject,$address,$body);
?>