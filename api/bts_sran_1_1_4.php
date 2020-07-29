<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_1_1_4 = $db->fetch_all_data("indottech_bts_sran_1_1_4",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_1_1_4");
		if($bts_sran_1_1_4["id"] > 0) 				$db->where("id",$bts_sran_1_1_4["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("rectifier");					$db->addvalue($_POST["rectifier"]);
		$db->addfield("pln");						$db->addvalue($_POST["pln"]);
		if($bts_sran_1_1_4["id"] > 0) $inserting = $db->update();
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
<center>1.1.4 Supply Voltages Information</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
			<tr align="center">
				<td>Measurement</td>
				<td>Expected (V)</td>
				<td>Actual (V)</td>
			</tr>
			<tr align="center">
				<td>DC Measured Voltage (Rectifier Output)</td>
				<td>48</td>
				<td><?=$f->input("rectifier",$bts_sran_1_1_4["rectifier"],"placeholder='Rectifier Output' Xrequired","classinput");?></td>
			</tr>
			<tr align="center">
				<td>AC Measured Voltage (PLN Output)</td>
				<td>220</td>
				<td><?=$f->input("pln",$bts_sran_1_1_4["pln"],"placeholder='PLN Output' Xrequired","classinput");?></td>
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