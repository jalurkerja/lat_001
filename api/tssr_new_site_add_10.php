<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_10_existing_equip",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_10_existing_equip");
		if($tssr["id"] > 0) 					$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");				$db->addvalue($tssr_id);
		$db->addfield("type_bts");				$db->addvalue($_POST["type_bts"]);
		$db->addfield("type_note");				$db->addvalue($_POST["type_note"]);
		$db->addfield("type_ip");				$db->addvalue($_POST["type_ip"]);
		$db->addfield("type_bsc");				$db->addvalue($_POST["type_bsc"]);
		$db->addfield("type_rnc");				$db->addvalue($_POST["type_rnc"]);
		$db->addfield("type_metro");			$db->addvalue($_POST["type_metro"]);
		$db->addfield("type_sdh");				$db->addvalue($_POST["type_sdh"]);
		$db->addfield("type_other");			$db->addvalue($_POST["type_other"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_10.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<center><h5><u>Existing Equipment (for redeploy/swap)</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Near End Site</td>
					<td><?=$f->input("near_end_site",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Type BTS</td>
					<td><?=$f->input("type_bts",$tssr["type_bts"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>TYPE Note B</td>
					<td><?=$f->input("type_note",$tssr["type_note"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Type IP MW</td>
					<td><?=$f->input("type_ip",$tssr["type_ip"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>BSC</td>
					<td><?=$f->input("type_bsc",$tssr["type_bsc"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>RNC</td>
					<td><?=$f->input("type_rnc",$tssr["type_rnc"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>METRO E</td>
					<td><?=$f->input("type_metro",$tssr["type_metro"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>SDH Backbone</td>
					<td><?=$f->input("type_sdh",$tssr["type_sdh"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Other</td>
					<td><?=$f->input("type_other",$tssr["type_other"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_09.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=10\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_11.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#near_end_site").focus(); </script>
<?php include_once "footer.php";?>