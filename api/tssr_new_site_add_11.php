<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_11_existing_rec_batt",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_11_existing_rec_batt");
		if($tssr["id"] > 0) 					$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");				$db->addvalue($tssr_id);
		$db->addfield("rect_brand");			$db->addvalue($_POST["rect_brand"]);
		$db->addfield("rect_current");			$db->addvalue($_POST["rect_current"]);
		$db->addfield("rect_qty");				$db->addvalue($_POST["rect_qty"]);
		$db->addfield("rect_type");				$db->addvalue($_POST["rect_type"]);
		$db->addfield("rect_space");			$db->addvalue($_POST["rect_space"]);
		$db->addfield("rect_remark");			$db->addvalue($_POST["rect_remark"]);
		$db->addfield("batt_brand");			$db->addvalue($_POST["batt_brand"]);
		$db->addfield("batt_number");			$db->addvalue($_POST["batt_number"]);
		$db->addfield("batt_qty");				$db->addvalue($_POST["batt_qty"]);
		$db->addfield("batt_capacity");			$db->addvalue($_POST["batt_capacity"]);
		$db->addfield("batt_space");			$db->addvalue($_POST["batt_space"]);
		$db->addfield("batt_remark");			$db->addvalue($_POST["batt_remark"]);
		$db->addfield("batt_rectifier");		$db->addvalue($_POST["batt_rectifier"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_11.php?token=".$token."&tssr_id=".$tssr_id."\";");
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
			<center><h5><u>Existing Rectifier (for redeploy/swap)</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Near End Site</td>
					<td><?=$f->input("near_end_site",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Brand</td>
					<td><?=$f->input("rect_brand",$tssr["rect_brand"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Current Capacity Module (A)</td>
					<td><?=$f->input("rect_current",$tssr["rect_current"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Quantity of Module (pcs)</td>
					<td><?=$f->input("rect_qty",$tssr["rect_qty"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Type of Module</td>
					<td><?=$f->input("rect_type",$tssr["rect_type"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Space for new Module</td>
					<td><?=$f->input("rect_space",$tssr["rect_space"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Remark (recti cover of equipment)</td>
					<td><?=$f->input("rect_remark",$tssr["rect_remark"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<center><h5><u>Existing Battery (for redeploy/swap)</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Near End Site</td>
					<td><?=$f->input("near_end_site",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Brand</td>
					<td><?=$f->input("batt_brand",$tssr["batt_brand"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Number of bank Battery(Pcs)</td>
					<td><?=$f->input("batt_number",$tssr["batt_number"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Quantity of Battery (pcs)</td>
					<td><?=$f->input("batt_qty",$tssr["batt_qty"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Capacity of Battery (AH)</td>
					<td><?=$f->input("batt_capacity",$tssr["batt_capacity"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Space for new Battery</td>
					<td><?=$f->input("batt_space",$tssr["batt_space"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Remark</td>
					<td><?=$f->input("batt_remark",$tssr["batt_remark"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Rectifier</td>
					<td><?=$f->input("batt_rectifier",$tssr["batt_rectifier"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_10.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=11\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_12.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#rect_brand").focus(); </script>
<?php include_once "footer.php";?>