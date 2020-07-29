<?php
function sendingmail($subject,$address,$body,$replyto = "it@corphr.com|IndoHR System",$attachments = "",$ccs = "") {
	global $db,$__username,$_SERVER;
	$db->addtable("mail_queue");
	$db->addfield("subject");$db->addvalue(str_replace("'","''",$subject));
	$db->addfield("address");$db->addvalue($address);
	$db->addfield("body");$db->addvalue(base64_encode($body));
	$db->addfield("replyto");$db->addvalue($replyto);
	$db->addfield("ccs");$db->addvalue($ccs);
	$db->addfield("attachments");$db->addvalue($attachments);
	$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("created_by");$db->addvalue($__username);
	$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$arr = $db->insert();
}

function sendingmail_za($subject,$address,$body,$replyto = "it@corphr.com|ZA System",$attachments = "",$ccs = "") {
	global $db,$__username,$_SERVER;
	$db->addtable("mail_queue_za");
	$db->addfield("subject");$db->addvalue(str_replace("'","''",$subject));
	$db->addfield("address");$db->addvalue($address);
	$db->addfield("body");$db->addvalue(base64_encode($body));
	$db->addfield("replyto");$db->addvalue($replyto);
	$db->addfield("ccs");$db->addvalue($ccs);
	$db->addfield("attachments");$db->addvalue($attachments);
	$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("created_by");$db->addvalue($__username);
	$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$arr = $db->insert();
}

function sendingmail_jk($subject,$address,$body,$replyto = "cs@jalurkerja.com|CS Jalur Kerja",$attachments = "",$ccs = "") {
	global $db,$__username,$_SERVER;
	$db->addtable("mail_queue_jk");
	$db->addfield("subject");$db->addvalue(str_replace("'","''",$subject));
	$db->addfield("address");$db->addvalue($address);
	$db->addfield("body");$db->addvalue(base64_encode($body));
	$db->addfield("replyto");$db->addvalue($replyto);
	$db->addfield("ccs");$db->addvalue($ccs);
	$db->addfield("attachments");$db->addvalue($attachments);
	$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:s"));
	$db->addfield("created_by");$db->addvalue($__username);
	$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
	$arr = $db->insert();
}

?>