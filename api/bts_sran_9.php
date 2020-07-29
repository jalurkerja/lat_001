<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_9 = $db->fetch_all_data("indottech_bts_sran_9",[],"atd_id='".$atd_id."' ORDER BY seqno");
	
	if(isset($_POST["save"])){
		foreach($_POST["description"] as $seqno => $description){			
			$db->addtable("indottech_bts_sran_9");
			if($bts_sran_9[$seqno]["id"] > 0) 			$db->where("id",$bts_sran_9[$seqno]["id"]);
			$db->addfield("atd_id");					$db->addvalue($atd_id);
			$db->addfield("seqno");						$db->addvalue($seqno);
			$db->addfield("description");				$db->addvalue($description);
			$db->addfield("history_at");				$db->addvalue($_POST["history_at"][$seqno]);
			if($bts_sran_9[$seqno]["id"] > 0) $inserting = $db->update();
			else $inserting = $db->insert();
		}
		javascript("alert('Data berhasil disimpan');");
		javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
		exit();
	}
	
	$descriptions = [
		"Remove old version<br>hardware from option list",
		"Insert list of technology<br>SRAN table",
		"Remove old installation<br>check list (BTS cabinet)",
		"Update check list from<br>feeder to optic cable (feeder less solution",
		"Update template of <br>equipment SRAN BoQ",
		"Remove E1 transmission information",
		"Additional summary number<br>of SM module, RF module and antenna"
	];
	
?>
<center><b>9. DOCUMENT HISTORY</b></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<table width="320"align="center">
		<tr>
			<td>
				<table border="1">
					<?=$t->row(["No","Description","Date"]);?>
					<?php
						foreach($descriptions as $no => $description){
							echo $f->input("description[".$no."]",str_replace("<br>","",$description),"type='hidden'");
							echo $t->row([
										($no+1),
										$description,
										$f->input("history_at[".$no."]",$bts_sran_9[$no]["history_at"],"type='date'")
									]);
						}
					?>
				</table>
				<table width="100%">
					<tr>
						<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
						<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>