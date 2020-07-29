<?php
function gethttp_value($url){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
function sendingmail_jk($subject,$address,$body,$replyto = "cs@jalurkerja.com|CS JalurKerja.com", $attachments = "", $ccs = "") {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$arr_replyto = explode("|",$replyto);
	$arr_replyto_mail = $arr_replyto[0];
	$domain = explode("@",$address);
	$_server = 2;
	$namasender = "Broadcast IndoHR";

	if($domain[1] == "corphr-nokia.com"){
		$_server = 1;
	}
	if($domain[1] == "corphr.com" || $domain[1] == "indottech.corphr.com"){
		$_server = 3;
	}
	if(preg_match("/jalurkerja/", strtolower($subject)) || preg_match("/jk/", strtolower($subject))){
		$_server = 2;
		$namasender = "CS JalurKerja.com";
	}

	$config[1]["secure"] = "ssl";
	$config[1]["host"] = "email.corphr-nokia.com";
	$config[1]["port"] = 465;
	$config[1]["username"] = "mailer@corphr-nokia.com";
	$config[1]["password"] = "pg=CA)6a?hVA]L9J_+dKINDOHR9999xzxz!@#";
	
	$config[2]["secure"] = "ssl";
	$config[2]["host"] = "mail.jalurkerja.com";
	$config[2]["port"] = 465;
	$config[2]["username"] = "cs@jalurkerja.com";
	$config[2]["password"] = "Rahasia2020!";
	
	$config[3]["secure"] = "ssl";
	$config[3]["host"] = "webmail.corphr.com";
	$config[3]["port"] = 465;
	$config[3]["username"] = "mailer@corphr.com";
	$config[3]["password"] = "pg=CA)6a?hVA]L9J_+dKINDOHR9999xzxz!@#";
	
	$config[4]["secure"] = "ssl";
	$config[4]["host"] = "mail.jalurkerja.com";
	$config[4]["port"] = 465;
	$config[4]["username"] = "info@jalurkerja.com";
	$config[4]["password"] = "infoJK!@#45";

	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = $config[$_server]["secure"];
	$mail->Host       = $config[$_server]["host"];
	$mail->Port       = $config[$_server]["port"];
	$mail->Username   = $config[$_server]["username"];
	$mail->Password   = $config[$_server]["password"];

	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  
	$mail->SetFrom($config[$_server]["username"],$namasender);
	$mail->AddReplyTo($arr_replyto_mail,$namasender);
	$mail->Subject    = $subject;
	
	if($ccs != ""){
		$_ccs = pipetoarray($ccs);
		$mail->AddCC($_ccs[0]);
		$mail->AddCC($_ccs[1]);
	}
	
	
	if($attachments != ""){
		$mail->addAttachment($attachments);
	}

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { return "1"; }
	
	$_server = "";
}

function sendingmail($subject,$address,$body,$replyto = "it@corphr.com|IT CorpHR", $attachments = "", $ccs = "") {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$arr_replyto = explode("|",$replyto);
	$arr_replyto_mail = $arr_replyto[0];
	$domain = explode("@",$address);
	$_server = 4;
	$namasender = "Broadcast IndoHR";

	if($domain[1] == "corphr-nokia.com"){
		$_server = 1;
	}
	if($domain[1] == "corphr.com" || $domain[1] == "indottech.corphr.com"){
		$_server = 3;
	}
	if(preg_match("/jalurkerja/", strtolower($subject)) || preg_match("/jk/", strtolower($subject))){
		$_server = 4;
		$namasender = "CS JalurKerja.com";
	}

	$config[1]["secure"] = "ssl";
	$config[1]["host"] = "email.corphr-nokia.com";
	$config[1]["port"] = 465;
	$config[1]["username"] = "mailer@corphr-nokia.com";
	$config[1]["password"] = "pg=CA)6a?hVA]L9J_+dKINDOHR9999xzxz!@#";
	
	$config[2]["secure"] = "ssl";
	$config[2]["host"] = "mail.jalurkerja.com";
	$config[2]["port"] = 465;
	$config[2]["username"] = "cs@jalurkerja.com";
	$config[2]["password"] = "Rahasia2020!";
	
	$config[3]["secure"] = "ssl";
	$config[3]["host"] = "webmail.corphr.com";
	$config[3]["port"] = 465;
	$config[3]["username"] = "mailer@corphr.com";
	$config[3]["password"] = "pg=CA)6a?hVA]L9J_+dKINDOHR9999xzxz!@#";
	
	$config[4]["secure"] = "ssl";
	$config[4]["host"] = "mail.jalurkerja.com";
	$config[4]["port"] = 465;
	$config[4]["username"] = "info@jalurkerja.com";
	$config[4]["password"] = "infoJK!@#45";

	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = $config[$_server]["secure"];
	$mail->Host       = $config[$_server]["host"];
	$mail->Port       = $config[$_server]["port"];
	$mail->Username   = $config[$_server]["username"];
	$mail->Password   = $config[$_server]["password"];

	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  
	$mail->SetFrom($config[$_server]["username"],$namasender);
	$mail->AddReplyTo($arr_replyto_mail,$namasender);
	$mail->Subject    = $subject;
	
	if($ccs != ""){
		$_ccs = pipetoarray($ccs);
		$mail->AddCC($_ccs[0]);
		$mail->AddCC($_ccs[1]);
	}
	
	
	if($attachments != ""){
		$mail->addAttachment($attachments);
	}

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { return "1"; }
	
	$_server = "";
}

function sendingmail_za($subject,$address,$body,$replyto = "it@corphr.com|Info ZA", $attachments = "", $ccs = "") {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$domain = explode("@",$address);
	$_server = 5;
	
	$config[5]["secure"] = "ssl";
	$config[5]["host"] = "webmail.corphr.com";
	$config[5]["port"] = 465;
	$config[5]["username"] = "mailer@zenarmada.id";
	$config[5]["password"] = "pg=CA)6a?hVA]L9J_+dKINDOHR9999xzxz!@#";

	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = $config[$_server]["secure"];
	$mail->Host       = $config[$_server]["host"];
	$mail->Port       = $config[$_server]["port"];
	$mail->Username   = $config[$_server]["username"];
	$mail->Password   = $config[$_server]["password"];

	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  
	$arr_replyto = explode("|",$replyto);
	$mail->SetFrom($config[$_server]["username"],"Info ZA");
	$mail->AddReplyTo("it@corphr.com","Info ZA");
	$mail->Subject    = $subject;
	
	if($ccs != ""){
		$_ccs = pipetoarray($ccs);
		$mail->AddCC($_ccs[0]);
		$mail->AddCC($_ccs[1]);
	}
	
	
	if($attachments != ""){
		$mail->addAttachment($attachments);
	}

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { return "1"; }
	
	$_server = "";
}


?>
