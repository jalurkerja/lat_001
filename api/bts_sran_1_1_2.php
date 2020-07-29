<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_1_1_2 = $db->fetch_all_data("indottech_bts_sran_1_1_2",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

		$db->addtable("indottech_bts_sran_1_1_2");
		if($bts_sran_1_1_2["id"] > 0) 				$db->where("id",$bts_sran_1_1_2["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("jumper_length_1");			$db->addvalue($_POST["jumper_length_1"]);
		$db->addfield("jumper_length_2");			$db->addvalue($_POST["jumper_length_2"]);
		$db->addfield("jumper_length_3");			$db->addvalue($_POST["jumper_length_3"]);
		$db->addfield("optical_length_1");			$db->addvalue($_POST["optical_length_1"]);
		$db->addfield("optical_length_2");			$db->addvalue($_POST["optical_length_2"]);
		$db->addfield("optical_length_3");			$db->addvalue($_POST["optical_length_3"]);
		$db->addfield("powercable_length_1");		$db->addvalue($_POST["powercable_length_1"]);
		$db->addfield("powercable_length_2");		$db->addvalue($_POST["powercable_length_2"]);
		$db->addfield("powercable_length_3");		$db->addvalue($_POST["powercable_length_3"]);
		if($bts_sran_1_1_2["id"] > 0) $inserting = $db->update();
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
<center>1.1.2 Antenna Line Configuration</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
			<tr align="center">
				<td>Jumper Length (Meter)</td>
				<td>
					<?=$f->input("jumper_length_1",$bts_sran_1_1_2["jumper_length_1"],"placeholder='Sektor 1' Xrequired","classinput");?><br>
					<?=$f->input("jumper_length_2",$bts_sran_1_1_2["jumper_length_2"],"placeholder='Sektor 2' Xrequired","classinput");?><br>
					<?=$f->input("jumper_length_3",$bts_sran_1_1_2["jumper_length_3"],"placeholder='Sektor 3' Xrequired","classinput");?>
				</td>
			</tr>
			<tr align="center">
				<td>Optical Length (Meter)</td>
				<td>
					<?=$f->input("optical_length_1",$bts_sran_1_1_2["optical_length_1"],"placeholder='Sektor 1' Xrequired","classinput");?><br>
					<?=$f->input("optical_length_2",$bts_sran_1_1_2["optical_length_2"],"placeholder='Sektor 2' Xrequired","classinput");?><br>
					<?=$f->input("optical_length_3",$bts_sran_1_1_2["optical_length_3"],"placeholder='Sektor 3' Xrequired","classinput");?>
				</td>
			</tr>
			<tr align="center">
				<td>Power cable Length SM - RF (Meter)</td>
				<td>
					<?=$f->input("powercable_length_1",$bts_sran_1_1_2["powercable_length_1"],"placeholder='Sektor 1' Xrequired","classinput");?><br>
					<?=$f->input("powercable_length_2",$bts_sran_1_1_2["powercable_length_2"],"placeholder='Sektor 2' Xrequired","classinput");?><br>
					<?=$f->input("powercable_length_3",$bts_sran_1_1_2["powercable_length_3"],"placeholder='Sektor 3' Xrequired","classinput");?>
				</td>
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
	<br>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>