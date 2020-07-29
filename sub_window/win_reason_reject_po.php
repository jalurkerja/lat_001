<?php
	include_once "win_head.php";
	if($_POST["reason"]){
		$errormessage="";
		if($_POST["reason_reject"] =="") $errormessage = "Please fill the reason!";
		if($errormessage == ""){
			$db->addtable("indottech_po_vendor");	$db->where("id",$_GET["reject"]);
			$db->addfield("reason_reject");			$db->addvalue($_POST["reason_reject"]);
			$db->addfield("checked_at");			$db->addvalue("");
			$db->addfield("checked_by");			$db->addvalue("");
			$db->addfield("checked_ip");			$db->addvalue("");
			$db->addfield("po_status");				$db->addvalue("2");
			$db->addfield("reject_at");				$db->addvalue($__now);
			$db->addfield("reject_by");				$db->addvalue($__username);
			$db->addfield("reject_ip");				$db->addvalue($__remoteaddr);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
			?>
				<body onload="setTimeout ('parent.location.reload(true)', 500,); "> 
				<center><b>PO Has Rejected</b></center>
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
	<?=$t->row(["PO Reject Reason", $reason, $action]);?> 
	<?=$t->end();?>
<?=$f->end();?>
