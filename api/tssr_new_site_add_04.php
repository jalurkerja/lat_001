<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_04_existing",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_04_existing");
		if($tssr["id"] > 0) 			$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");		$db->addvalue($tssr_id);
		$db->addfield("operator");		$db->addvalue($_POST["operator"]);
		$db->addfield("ant_type");		$db->addvalue($_POST["ant_type"]);
		$db->addfield("azimuth");		$db->addvalue($_POST["azimuth"]);
		$db->addfield("height");		$db->addvalue($_POST["height"]);
		$db->addfield("leg");			$db->addvalue($_POST["leg"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_04.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>Existing Antenna (if available)</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Operator</td>
					<td><?=$f->input("operator",$tssr["operator"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Ant Type</td>
					<td><?=$f->input("ant_type",$tssr["ant_type"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth (deg)</td>
					<td><?=$f->input("azimuth",$tssr["azimuth"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Height (m)</td>
					<td><?=$f->input("height",$tssr["height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Leg</td>
					<td><?=$f->input("leg",$tssr["leg"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_03.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=04\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_05.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#operator").focus(); </script>
<?php include_once "footer.php";?>