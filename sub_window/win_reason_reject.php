<?php
	include_once "win_head.php";
	if($_POST["reason"]){
		$errormessage="";
		if($_POST["reason_reject"] =="") $errormessage = "Please fill the reason!";
		if($errormessage == ""){
			$db->addtable("attendance_activity");		$db->where("id",$_GET["reject"]);
			$db->addfield("reason_reject");				$db->addvalue($_POST["reason_reject"]);
			$db->addfield("attendance_status");			$db->addvalue(($_GET["attendance_status"]+3));
			$db->addfield("reject_at");					$db->addvalue($__now);
			$db->addfield("reject_by");					$db->addvalue($__username);
			$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				?>
					<body onload="setTimeout ('parent.location.reload(true)', 500,); "> 
					<center><b>Activity Has Rejected</b></center>
				<?php
				
				} else {
					?>
						<center><b>Reject Failed</b></center>
					<?php
				}
		}
	}
?>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	<?=$t->start("","editor_content");?>
	<center><b><?=$errormessage;?></b></center>
	<?php
		$_POST["reason_reject"] = "";
		$reason= $f->textarea("reason_reject",$_POST["reason_reject"],"size='50'");
		$action= $f->input("reason","Post","type='submit'");
	?>
	<?=$t->row(["Reason Reject", $reason, $action]);?> 
	<?=$t->end();?>
<?=$f->end();?>
