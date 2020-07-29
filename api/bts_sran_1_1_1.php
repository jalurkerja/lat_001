<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_1_1_1 = $db->fetch_all_data("indottech_bts_sran_1_1_1",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_bts_sran_1_1_1");
		if($bts_sran_1_1_1["id"] > 0) 				$db->where("id",$bts_sran_1_1_1["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("antena_type_1");				$db->addvalue($_POST["antena_type_1"]);
		$db->addfield("antena_type_2");				$db->addvalue($_POST["antena_type_2"]);
		$db->addfield("antena_type_3");				$db->addvalue($_POST["antena_type_3"]);
		$db->addfield("antena_type_1_isok");		$db->addvalue($_POST["antena_type_1_isok"]);
		$db->addfield("antena_type_2_isok");		$db->addvalue($_POST["antena_type_2_isok"]);
		$db->addfield("antena_type_3_isok");		$db->addvalue($_POST["antena_type_3_isok"]);
		$db->addfield("serialno_1");				$db->addvalue($_POST["serialno_1"]);
		$db->addfield("serialno_2");				$db->addvalue($_POST["serialno_2"]);
		$db->addfield("serialno_3");				$db->addvalue($_POST["serialno_3"]);
		$db->addfield("serialno_1_isok");			$db->addvalue($_POST["serialno_1_isok"]);
		$db->addfield("serialno_2_isok");			$db->addvalue($_POST["serialno_2_isok"]);
		$db->addfield("serialno_3_isok");			$db->addvalue($_POST["serialno_3_isok"]);
		$db->addfield("direction_1");				$db->addvalue($_POST["direction_1"]);
		$db->addfield("direction_2");				$db->addvalue($_POST["direction_2"]);
		$db->addfield("direction_3");				$db->addvalue($_POST["direction_3"]);
		$db->addfield("direction_1_isok");			$db->addvalue($_POST["direction_1_isok"]);
		$db->addfield("direction_2_isok");			$db->addvalue($_POST["direction_2_isok"]);
		$db->addfield("direction_3_isok");			$db->addvalue($_POST["direction_3_isok"]);
		$db->addfield("mechanical_tilt_1");			$db->addvalue($_POST["mechanical_tilt_1"]);
		$db->addfield("mechanical_tilt_2");			$db->addvalue($_POST["mechanical_tilt_2"]);
		$db->addfield("mechanical_tilt_3");			$db->addvalue($_POST["mechanical_tilt_3"]);
		$db->addfield("mechanical_tilt_1_isok");	$db->addvalue($_POST["mechanical_tilt_1_isok"]);
		$db->addfield("mechanical_tilt_2_isok");	$db->addvalue($_POST["mechanical_tilt_2_isok"]);
		$db->addfield("mechanical_tilt_3_isok");	$db->addvalue($_POST["mechanical_tilt_3_isok"]);
		$db->addfield("electrical_tilt_1");			$db->addvalue($_POST["electrical_tilt_1"]);
		$db->addfield("electrical_tilt_2");			$db->addvalue($_POST["electrical_tilt_2"]);
		$db->addfield("electrical_tilt_3");			$db->addvalue($_POST["electrical_tilt_3"]);
		$db->addfield("electrical_tilt_1_isok");	$db->addvalue($_POST["electrical_tilt_1_isok"]);
		$db->addfield("electrical_tilt_2_isok");	$db->addvalue($_POST["electrical_tilt_2_isok"]);
		$db->addfield("electrical_tilt_3_isok");	$db->addvalue($_POST["electrical_tilt_3_isok"]);
		$db->addfield("antenna_height_1");			$db->addvalue($_POST["antenna_height_1"]);
		$db->addfield("antenna_height_2");			$db->addvalue($_POST["antenna_height_2"]);
		$db->addfield("antenna_height_3");			$db->addvalue($_POST["antenna_height_3"]);
		$db->addfield("antenna_height_1_isok");		$db->addvalue($_POST["antenna_height_1_isok"]);
		$db->addfield("antenna_height_2_isok");		$db->addvalue($_POST["antenna_height_2_isok"]);
		$db->addfield("antenna_height_3_isok");		$db->addvalue($_POST["antenna_height_3_isok"]);
		if($bts_sran_1_1_1["id"] > 0) $inserting = $db->update();
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
<center><h4><b>SITE SPECIFIC INTSALLATION DATA</b></h4></center>
<center><h5><b>1.1 Antenna and Antenna Line General Information</b></h5></center>
<center>1.1.1 Antenna Configuration</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td></td>
					<td>
						<b>PLAN (DRM) - VALUE</b>
					</td>
					<td>
						<b>[OK / NOK]</b>
					</td>
				</tr>
				<tr align="center">
					<td rowspan="4">Antenna Type</td>
				</tr>
					<tr>
						<td><?=$f->input("antena_type_1",$bts_sran_1_1_1["antena_type_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("antena_type_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antena_type_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("antena_type_2",$bts_sran_1_1_1["antena_type_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("antena_type_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antena_type_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("antena_type_3",$bts_sran_1_1_1["antena_type_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("antena_type_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antena_type_3_isok"], "Xrequired");?></td>
					</tr>
					
				
				<tr align="center">
					<td rowspan="4">Serial No</td>
				</tr>	
					<tr>
						<td><?=$f->input("serialno_1",$bts_sran_1_1_1["serialno_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("serialno_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["serialno_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("serialno_2",$bts_sran_1_1_1["serialno_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("serialno_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["serialno_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("serialno_3",$bts_sran_1_1_1["serialno_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("serialno_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["serialno_3_isok"], "Xrequired");?></td>
					</tr>
				<tr align="center">
					<td rowspan="4">Direction</td>
				</tr>
					<tr>
						<td><?=$f->input("direction_1",$bts_sran_1_1_1["direction_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("direction_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["direction_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("direction_2",$bts_sran_1_1_1["direction_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("direction_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["direction_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("direction_3",$bts_sran_1_1_1["direction_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("direction_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["direction_3_isok"], "Xrequired");?></td>
					</tr>
				<tr align="center">
					<td rowspan="4">Mechanical Tilt</td>
				</tr>
					<tr>
						<td><?=$f->input("mechanical_tilt_1",$bts_sran_1_1_1["mechanical_tilt_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("mechanical_tilt_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["mechanical_tilt_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("mechanical_tilt_2",$bts_sran_1_1_1["mechanical_tilt_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("mechanical_tilt_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["mechanical_tilt_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("mechanical_tilt_3",$bts_sran_1_1_1["mechanical_tilt_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("mechanical_tilt_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["mechanical_tilt_3_isok"], "Xrequired");?></td>
					</tr>
				<tr align="center">
					<td rowspan="4">Electrical Tilt</td>
				</tr>
					<tr>
						<td><?=$f->input("electrical_tilt_1",$bts_sran_1_1_1["electrical_tilt_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("electrical_tilt_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["electrical_tilt_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("electrical_tilt_2",$bts_sran_1_1_1["electrical_tilt_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("electrical_tilt_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["electrical_tilt_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("electrical_tilt_3",$bts_sran_1_1_1["electrical_tilt_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("electrical_tilt_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["electrical_tilt_3_isok"], "Xrequired");?></td>
					</tr>
				<tr align="center">
					<td rowspan="4">Antenna Height</td>
				</tr>
					<tr>
						<td><?=$f->input("antenna_height_1",$bts_sran_1_1_1["antenna_height_1"],"placeholder='Sektor 1' Xrequired","classinput");?></td>
						<td><?=$f->select("antenna_height_1_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antenna_height_1_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("antenna_height_2",$bts_sran_1_1_1["antenna_height_2"],"placeholder='Sektor 2' Xrequired","classinput");?></td>
						<td><?=$f->select("antenna_height_2_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antenna_height_2_isok"], "Xrequired");?></td>
					</tr>
					<tr>
						<td><?=$f->input("antenna_height_3",$bts_sran_1_1_1["antenna_height_3"],"placeholder='Sektor 3' Xrequired","classinput");?></td>
						<td><?=$f->select("antenna_height_3_isok",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_1_1_1["antenna_height_3_isok"], "Xrequired");?></td>
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