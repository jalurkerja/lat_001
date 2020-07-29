<?php //include_once "head.php";?>
<?php 
	include_once "func.sendingmail_v2.php";
?>
<?php
	$_pesan		= "Test from cs lukman";
	$_target	= "warih@jalurkerja.com";
	$subject	= "ini local";
	// sendingmail($subject,$_target,$_pesan);
	sendingmail_jk($subject,$_target,$_pesan);
	
	echo $_target." => ".$_pesan." => ".$subject;
?>
<?php //include_once "footer.php";?>
