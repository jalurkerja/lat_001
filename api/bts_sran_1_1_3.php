<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_1_1_3 = $db->fetch_all_data("indottech_bts_sran_1_1_3",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_1_1_3");
		if($bts_sran_1_1_3["id"] > 0) 				$db->where("id",$bts_sran_1_1_3["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("fxdb1_1");					$db->addvalue($_POST["fxdb1_1"]);
		$db->addfield("fxdb1_2");					$db->addvalue($_POST["fxdb1_2"]);
		$db->addfield("fxdb1_3");					$db->addvalue($_POST["fxdb1_3"]);
		$db->addfield("fxdb1_4");					$db->addvalue($_POST["fxdb1_4"]);
		$db->addfield("fxdb1_5");					$db->addvalue($_POST["fxdb1_5"]);
		$db->addfield("fxdb1_6");					$db->addvalue($_POST["fxdb1_6"]);
		$db->addfield("fxdb2_1");					$db->addvalue($_POST["fxdb2_1"]);
		$db->addfield("fxdb2_2");					$db->addvalue($_POST["fxdb2_2"]);
		$db->addfield("fxdb2_3");					$db->addvalue($_POST["fxdb2_3"]);
		$db->addfield("fxdb2_4");					$db->addvalue($_POST["fxdb2_4"]);
		$db->addfield("fxdb2_5");					$db->addvalue($_POST["fxdb2_5"]);
		$db->addfield("fxdb2_6");					$db->addvalue($_POST["fxdb2_6"]);
		$db->addfield("fxed1_1");					$db->addvalue($_POST["fxed1_1"]);
		$db->addfield("fxed1_2");					$db->addvalue($_POST["fxed1_2"]);
		$db->addfield("fxed1_3");					$db->addvalue($_POST["fxed1_3"]);
		$db->addfield("fxed1_4");					$db->addvalue($_POST["fxed1_4"]);
		$db->addfield("fxed1_5");					$db->addvalue($_POST["fxed1_5"]);
		$db->addfield("fxed1_6");					$db->addvalue($_POST["fxed1_6"]);
		$db->addfield("fxed2_1");					$db->addvalue($_POST["fxed2_1"]);
		$db->addfield("fxed2_2");					$db->addvalue($_POST["fxed2_2"]);
		$db->addfield("fxed2_3");					$db->addvalue($_POST["fxed2_3"]);
		$db->addfield("fxed2_4");					$db->addvalue($_POST["fxed2_4"]);
		$db->addfield("fxed2_5");					$db->addvalue($_POST["fxed2_5"]);
		$db->addfield("fxed2_6");					$db->addvalue($_POST["fxed2_6"]);
		$db->addfield("frgu1_1");					$db->addvalue($_POST["frgu1_1"]);
		$db->addfield("frgu1_2");					$db->addvalue($_POST["frgu1_2"]);
		$db->addfield("frgu1_3");					$db->addvalue($_POST["frgu1_3"]);
		$db->addfield("frgu1_4");					$db->addvalue($_POST["frgu1_4"]);
		$db->addfield("frgu1_5");					$db->addvalue($_POST["frgu1_5"]);
		$db->addfield("frgu1_6");					$db->addvalue($_POST["frgu1_6"]);
		$db->addfield("frgu2_1");					$db->addvalue($_POST["frgu2_1"]);
		$db->addfield("frgu2_2");					$db->addvalue($_POST["frgu2_2"]);
		$db->addfield("frgu2_3");					$db->addvalue($_POST["frgu2_3"]);
		$db->addfield("frgu2_4");					$db->addvalue($_POST["frgu2_4"]);
		$db->addfield("frgu2_5");					$db->addvalue($_POST["frgu2_5"]);
		$db->addfield("frgu2_6");					$db->addvalue($_POST["frgu2_6"]);
		if($bts_sran_1_1_3["id"] > 0) $inserting = $db->update();
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
<center>1.1.3 Antenna lines VSWR value (BTS measurement)</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td>RF MODULE</td>
					<td>Port Ke-</td>
				</tr>
				<tr align="center">
					<td>FXDB#1</td>
					<td>
						<?=$f->input("fxdb1_1",$bts_sran_1_1_3["fxdb1_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("fxdb1_2",$bts_sran_1_1_3["fxdb1_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("fxdb1_3",$bts_sran_1_1_3["fxdb1_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("fxdb1_4",$bts_sran_1_1_3["fxdb1_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("fxdb1_5",$bts_sran_1_1_3["fxdb1_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("fxdb1_6",$bts_sran_1_1_3["fxdb1_6"],"placeholder='Port 6' Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="center">
					<td>FXDB#2</td>
					<td>
						<?=$f->input("fxdb2_1",$bts_sran_1_1_3["fxdb2_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("fxdb2_2",$bts_sran_1_1_3["fxdb2_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("fxdb2_3",$bts_sran_1_1_3["fxdb2_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("fxdb2_4",$bts_sran_1_1_3["fxdb2_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("fxdb2_5",$bts_sran_1_1_3["fxdb2_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("fxdb2_6",$bts_sran_1_1_3["fxdb2_6"],"placeholder='Port 6' Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="center">
					<td>FXED#1</td>
					<td>
						<?=$f->input("fxed1_1",$bts_sran_1_1_3["fxed1_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("fxed1_2",$bts_sran_1_1_3["fxed1_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("fxed1_3",$bts_sran_1_1_3["fxed1_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("fxed1_4",$bts_sran_1_1_3["fxed1_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("fxed1_5",$bts_sran_1_1_3["fxed1_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("fxed1_6",$bts_sran_1_1_3["fxed1_6"],"placeholder='Port 6' Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="center">
					<td>FXED#2</td>
					<td>
						<?=$f->input("fxed2_1",$bts_sran_1_1_3["fxed2_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("fxed2_2",$bts_sran_1_1_3["fxed2_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("fxed2_3",$bts_sran_1_1_3["fxed2_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("fxed2_4",$bts_sran_1_1_3["fxed2_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("fxed2_5",$bts_sran_1_1_3["fxed2_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("fxed2_6",$bts_sran_1_1_3["fxed2_6"],"placeholder='Port 6' Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="center">
					<td>FRGU#1</td>
					<td>
						<?=$f->input("frgu1_1",$bts_sran_1_1_3["frgu1_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("frgu1_2",$bts_sran_1_1_3["frgu1_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("frgu1_3",$bts_sran_1_1_3["frgu1_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("frgu1_4",$bts_sran_1_1_3["frgu1_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("frgu1_5",$bts_sran_1_1_3["frgu1_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("frgu1_6",$bts_sran_1_1_3["frgu1_6"],"placeholder='Port 6' Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="center">
					<td>FRGU#2</td>
					<td>
						<?=$f->input("frgu2_1",$bts_sran_1_1_3["frgu2_1"],"placeholder='Port 1' Xrequired","classinput");?><br>
						<?=$f->input("frgu2_2",$bts_sran_1_1_3["frgu2_2"],"placeholder='Port 2' Xrequired","classinput");?><br>
						<?=$f->input("frgu2_3",$bts_sran_1_1_3["frgu2_3"],"placeholder='Port 3' Xrequired","classinput");?><br>
						<?=$f->input("frgu2_4",$bts_sran_1_1_3["frgu2_4"],"placeholder='Port 4' Xrequired","classinput");?><br>
						<?=$f->input("frgu2_5",$bts_sran_1_1_3["frgu2_5"],"placeholder='Port 5' Xrequired","classinput");?><br>
						<?=$f->input("frgu2_6",$bts_sran_1_1_3["frgu2_6"],"placeholder='Port 6' Xrequired","classinput");?>
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