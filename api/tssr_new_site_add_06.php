<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_06_radio_trans",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_06_radio_trans");
		if($tssr["id"] > 0) 					$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");				$db->addvalue($tssr_id);
		$db->addfield("near_end_site");			$db->addvalue($_POST["near_end_site"]);
		$db->addfield("ne_dia");				$db->addvalue($_POST["ne_dia"]);
		$db->addfield("ne_height");				$db->addvalue($_POST["ne_height"]);
		$db->addfield("azimuth_to_fe");			$db->addvalue($_POST["azimuth_to_fe"]);
		$db->addfield("far_end_site");			$db->addvalue($_POST["far_end_site"]);
		$db->addfield("fe_dia");				$db->addvalue($_POST["fe_dia"]);
		$db->addfield("fe_height");				$db->addvalue($_POST["fe_height"]);
		$db->addfield("azimuth_to_ne");			$db->addvalue($_POST["azimuth_to_ne"]);
		$db->addfield("exist_operator");		$db->addvalue($_POST["exist_operator"]);
		$db->addfield("exist_dia");				$db->addvalue($_POST["exist_dia"]);
		$db->addfield("exist_azimuth");			$db->addvalue($_POST["exist_azimuth"]);
		$db->addfield("exist_height");			$db->addvalue($_POST["exist_height"]);
		$db->addfield("exist_leg");			$db->addvalue($_POST["exist_leg"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_06.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>Radio Transmission</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td>Near End Site</td>
					<td><?=$f->input("near_end_site",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Dia (m)</td>
					<td><?=$f->input("ne_dia",$tssr["ne_dia"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Height (agl)</td>
					<td><?=$f->input("ne_height",$tssr["ne_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth to F.E.<br>(Deg)</td>
					<td><?=$f->input("azimuth_to_fe",$tssr["azimuth_to_fe"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Far End Site</td>
					<td><?=$f->input("far_end_site",$tssr["far_end_site"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Dia (m)</td>
					<td><?=$f->input("fe_dia",$tssr["fe_dia"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Height (agl)</td>
					<td><?=$f->input("fe_height",$tssr["fe_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth to N.E. (Deg)</td>
					<td><?=$f->input("azimuth_to_ne",$tssr["azimuth_to_ne"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<center><h5><u>Existing Transmission</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Operator</td>
					<td><?=$f->input("exist_operator",$tssr["exist_operator"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Diameter (m)</td>
					<td><?=$f->input("exist_dia",$tssr["exist_dia"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth (deg)</td>
					<td><?=$f->input("exist_azimuth",$tssr["exist_azimuth"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Height (m)</td>
					<td><?=$f->input("exist_height",$tssr["exist_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Leg</td>
					<td><?=$f->input("exist_leg",$tssr["exist_leg"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_05.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=06\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_07.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#near_end_site").focus(); </script>
<?php include_once "footer.php";?>