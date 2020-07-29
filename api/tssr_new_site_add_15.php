<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_15_far_pln",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_15_far_pln");
		if($tssr["id"] > 0) 					$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");				$db->addvalue($tssr_id);
		$db->addfield("pln");					$db->addvalue($_POST["pln"]);
		$db->addfield("kwh_phase_r");			$db->addvalue($_POST["kwh_phase_r"]);
		$db->addfield("kwh_phase_s");			$db->addvalue($_POST["kwh_phase_s"]);
		$db->addfield("kwh_phase_t");			$db->addvalue($_POST["kwh_phase_t"]);
		$db->addfield("acpdb_phase_r");			$db->addvalue($_POST["acpdb_phase_r"]);
		$db->addfield("acpdb_phase_s");			$db->addvalue($_POST["acpdb_phase_s"]);
		$db->addfield("acpdb_phase_t");			$db->addvalue($_POST["acpdb_phase_t"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_15.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><b><u>FAR END SITES</u></b></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<center><h5><u>Existing Power (FarEnd)</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Near End Site</td>
					<td><?=$f->input("near_end_site",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>PLN Capacity</td>
					<td><?=$f->input("pln",$tssr["pln"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>KWH Phase-R A (AC)</td>
					<td><?=$f->input("kwh_phase_r",$tssr["kwh_phase_r"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>KWH Phase-S A (AC)</td>
					<td><?=$f->input("kwh_phase_s",$tssr["kwh_phase_s"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>KWH Phase-T A (AC)</td>
					<td><?=$f->input("kwh_phase_t",$tssr["kwh_phase_t"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>ACPDB Phase-R A (AC)</td>
					<td><?=$f->input("acpdb_phase_r",$tssr["acpdb_phase_r"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>ACPDB Phase-S A (AC)</td>
					<td><?=$f->input("acpdb_phase_s",$tssr["acpdb_phase_s"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>ACPDB Phase-T A (AC)</td>
					<td><?=$f->input("acpdb_phase_t",$tssr["acpdb_phase_t"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_14.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=15\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","All Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=16\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#pln").focus(); </script>
<?php include_once "footer.php";?>