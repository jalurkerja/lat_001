<?php
	set_time_limit(0);
	include_once "document_root_path.php";
	include_once "../func.sendingmail_v2.php";
	include_once "common.php";
	
	$db->addtable("mail_queue");
	$db->where("status",0);
	$db->order("id");
	$db->limit(25);

	foreach($db->fetch_data(true) as $mail_queue){
		$subject = $mail_queue["subject"];
		$body = base64_decode($mail_queue["body"]);
		$address = $mail_queue["address"];
		$replyto = $mail_queue["replyto"];
		$ccs = "";
		foreach (pipetoarray($mail_queue["ccs"]) as $cc){
		$ccs .= "|".$cc."|";
		}
		$attachments = $mail_queue["attachments"];
		
		sendingmail($subject,$address,$body,$replyto,"/var/www/html/indottech/".$attachments, $ccs);
		$db->addtable("mail_queue");
		$db->where("id",$mail_queue["id"]);
		$db->addfield("status");$db->addvalue(1);
		$db->update();
	}
	
	// /////////////////////////
	// $db->addtable("mail_queue_jk");
	// $db->where("status",0);
	// $db->order("id");
	// $db->limit(25);
	// foreach($db->fetch_data(true) as $mail_queue_jk){
		// $subject = $mail_queue_jk["subject"];
		// $body = base64_decode($mail_queue_jk["body"]);
		// $address = $mail_queue_jk["address"];
		// $replyto = $mail_queue_jk["replyto"];
		// $ccs = "";
		// foreach (pipetoarray($mail_queue_jk["ccs"]) as $cc){
		// $ccs .= "|".$cc."|";
		// }
		// $attachments = $mail_queue_jk["attachments"];
		
		// sendingmail_jk($subject,$address,$body,$replyto,"/var/www/html/indottech/".$attachments, $ccs);
		// $db->addtable("mail_queue_jk");
		// $db->where("id",$mail_queue_jk["id"]);
		// $db->addfield("status");$db->addvalue(1);
		// $db->update();
	// }
	
	///////////////////////////
	$db->addtable("mail_queue_za");
	$db->where("status",0);
	$db->order("id");
	$db->limit(25);
	foreach($db->fetch_data(true) as $mail_queue_za){
		$subject = $mail_queue_za["subject"];
		$body = base64_decode($mail_queue_za["body"]);
		$address = $mail_queue_za["address"];
		$replyto = $mail_queue_za["replyto"];
		$ccs = "";
		foreach (pipetoarray($mail_queue_za["ccs"]) as $cc){
		$ccs .= "|".$cc."|";
		}
		$attachments = $mail_queue_za["attachments"];
		
		sendingmail_za($subject,$address,$body,$replyto,"/var/www/html/indottech/".$attachments, $ccs);
		$db->addtable("mail_queue_za");
		$db->where("id",$mail_queue_za["id"]);
		$db->addfield("status");$db->addvalue(1);
		$db->update();
	}

?>
