<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_2_3 = $db->fetch_all_data("indottech_bts_sran_2_2_3",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_2_3");
		if($bts_sran_2_2_3["id"] > 0) 					$db->where("id",$bts_sran_2_2_3["id"]);
		$db->addfield("atd_id");						$db->addvalue($atd_id);
		$db->addfield("bts_restart");					$db->addvalue($_POST["bts_restart"]);
		$db->addfield("launch");						$db->addvalue($_POST["launch"]);
		if($bts_sran_2_2_3["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
?>
<center>2.2.3 Remote Access Test</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>TEST</b></td>
					<td><b>OK/NOK</b></td>
				</tr>
					<td>BTS Restart</td>
					<td><?=$f->select("bts_restart",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_2_3["bts_restart"], "Xrequired");?></td>
				<tr>
					<td>Launch & connection<br>BTS from WEB browser</td>
					<td><?=$f->select("launch",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_2_3["launch"], "Xrequired");?></td>
				</tr>
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