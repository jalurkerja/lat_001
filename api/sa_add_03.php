<?php include_once "header.php";?>
<?php 
	if($_GET["id"]){
		$id = $_GET["id"];
		$indottech_sa 	= $db->fetch_all_data("indottech_sa",[],"id='".$id."'")[0];
		$site_id		= $indottech_sa["site_id"];
	} else {
		$site_id	= $_GET["site_id"];
		$id 		= $db->fetch_single_data("indottech_sa","id",["site_id"=>$site_id]);
	}
	$site_details 	= $db->fetch_all_data("indottech_sites",[],"id='".$site_id."'")[0];
	$site_kode_name = str_replace(" ","_",$site_details["kode"]."_".$site_details["name"]);
	$back 			=$f->input("","Back","type='button' onclick='window.location=\"sa_add_02.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-warning");
	$next			= "";
	if(isset($_POST["save"])){
		$sa_02_id = $db->fetch_single_data("indottech_sa_03","id",["sa_id" => $id]);
		
		$db->addtable("indottech_sa_03");
		$db->addfield("sa_id");					$db->addvalue($id);
		$db->addfield("protel_site_id");		$db->addvalue($_POST["protel_site_id"]);
		$db->addfield("survey_date");			$db->addvalue($_POST["survey_date"]);
		$db->addfield("height");				$db->addvalue($_POST["height"]);
		$db->addfield("client_name");			$db->addvalue($_POST["client_name"]);
		$db->addfield("client_id");				$db->addvalue($_POST["client_id"]);
		$db->addfield("actual_vertical");		$db->addvalue($_POST["actual_vertical"]);
		if($sa_02_id){
			$db->where("id",$sa_02_id);
			$inserting = $db->update();
		} else {
			$inserting = $db->insert();
		}
		if($inserting["affected_rows"] >= 0){
			$seqno = $db->fetch_single_data("indottech_sa_04","seqno",["sa_id"=>$id],["seqno desc"]);
			foreach($_POST["ant_type"] as $key => $ant_type){
				$db->addtable("indottech_sa_04");
				$db->addfield("sa_id");				$db->addvalue($id);
				$db->addfield("seqno");				$db->addvalue($seqno+1);
				$db->addfield("item");				$db->addvalue($_POST["item"][$key]);
				$db->addfield("ant_type");			$db->addvalue($_POST["ant_type"][$key]);
				$db->addfield("ant_length");		$db->addvalue($_POST["ant_length"][$key]);
				$db->addfield("ant_qty");			$db->addvalue($_POST["ant_qty"][$key]);
				$db->addfield("ant_elevation");		$db->addvalue($_POST["ant_elevation"][$key]);
				$db->addfield("azimuth");			$db->addvalue($_POST["azimuth"][$key]);
				$db->addfield("cable_qty");			$db->addvalue($_POST["cable_qty"][$key]);
				$db->addfield("cable_diameter");	$db->addvalue($_POST["cable_diameter"][$key]);
				$db->addfield("purposed_req");		$db->addvalue($_POST["purposed_req"][$key]);
				$db->addfield("remarks");			$db->addvalue($_POST["remarks"][$key]);
				$inserting = $db->insert();
			}
		}
		javascript("window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";");
	}
	
	if($id){
		$next			=$f->input("","Finish","type='button' onclick='window.location=\"hs_sa_menu.php?token=".$_GET["token"]."&site_id=".$site_id."&user_id=".$__user_id."\";'","btn btn-success");
		
		$seqno 			= $db->fetch_single_data("indottech_sa_04","seqno",["sa_id"=>$id],["seqno desc"]);
		$master			= $db->fetch_all_data("indottech_sa_04",[],"sa_id = '".$id."' AND seqno = '".$seqno."'");
		foreach($master as $key => $row_data){
			$_data["item"][$key] 			= "";	$_data["item"][$key] 				= $row_data["item"]; 	
			$_data["ant_type"][$key] 		= "";	$_data["ant_type"][$key] 			= $row_data["ant_type"]; 	
			$_data["ant_length"][$key] 		= "";	$_data["ant_length"][$key] 			= $row_data["ant_length"]; 	
			$_data["ant_qty"][$key] 		= "";	$_data["ant_qty"][$key] 			= $row_data["ant_qty"]; 	
			$_data["ant_elevation"][$key] 	= "";	$_data["ant_elevation"][$key] 		= $row_data["ant_elevation"]; 	
			$_data["azimuth"][$key] 		= "";	$_data["azimuth"][$key] 			= $row_data["azimuth"]; 	
			$_data["cable_qty"][$key] 		= "";	$_data["cable_qty"][$key] 			= $row_data["cable_qty"]; 	
			$_data["cable_diameter"][$key] 	= "";	$_data["cable_diameter"][$key] 		= $row_data["cable_diameter"]; 	
			$_data["purposed_req"][$key] 	= "";	$_data["purposed_req"][$key] 		= $row_data["purposed_req"]; 	
			$_data["remarks"][$key] 		= "";	$_data["remarks"][$key] 			= $row_data["remarks"]; 	
		}
		
		$data		= $db->fetch_all_data("indottech_sa_03",[],"sa_id = '".$id."'")[0];
	}
		$save		=$f->input("save","Save","type='submit'","btn btn-success");

?>
<table width="100%">
	<tr>
		<td width="50%" align="left"><?=$back;?></td>
		<td width="50%" align="right"><?=$next;?></td>
	</tr>
	<tr>
		<td colspan="2">Site : <?=$site_kode_name;?></td>
	</tr>
</table>

<style>
	#biru_1{
		background-color:#1a75ff;
		color:white;
		font-weight:bolder;
		white-space: normal; 
	}
	#biru_2{
		background-color:#80b3ff;
		color:black;
		font-weight:bolder;
	}
	#biru_3{
		background-color:#1a75ff;
		color:white;
	}
	
</style>
<form method="POST" action="?token=<?=$token;?>&site_id=<?=$site_id;?>&id=<?=$id;?>&mode=sa&user_id=<?=$__user_id;?>">
	<table width="100%" style="font-family:Arial; color:solid black;">
		<tr>
			<td>&nbsp;</td>
			<td colspan="8" id="biru_1" align="center" style="font-size:14px;">PICTORIAL REPORT</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td id="biru_1">Protelindo SITE ID</td>
			<td ><?=$f->input("protel_site_id",$data["protel_site_id"],"style='width:100%;'");?></td>
			<td >&nbsp;</td>
			<td colspan="3" id="biru_1">CLIENT NAME</td>
			<td colspan="2"><?=$f->input("client_name",$data["client_name"],"style='width:100%;'");?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td id="biru_1">SURVEY DATE</td>
			<td ><?=$f->input("survey_date",$data["survey_date"],"style='width:100%;' type='date'");?></td>
			<td >&nbsp;</td>
			<td colspan="3" id="biru_1">CLIENT ID</td>
			<td colspan="2"><?=$f->input("client_id",$data["client_id"],"style='width:100%;'");?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td id="biru_1">BUILDING + TOWER HEIGHT</td>
			<td ><?=$f->input("height",$data["height"],"style='width:100%;'");?></td>
			<td >&nbsp;</td>
			<td colspan="3" id="biru_1">ACTUAL 3 M VERTICAL</td>
			<td colspan="2"><?=$f->input("actual_vertical",$data["actual_vertical"],"style='width:100%;'");?></td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<br>
	<div style="overflow-x:auto;">
		<table width="100%" cellspacing="0" border="1" rules="all" id="data_content">
			<tr>
				<td id="biru_1" align="center" >Item</td>
				<td id="biru_1" align="center" >Antenna Type</td>
				<td id="biru_1" align="center" >Dimension Lenght</td>
				<td id="biru_1" align="center" >Ant QTY</td>
				<td id="biru_1" align="center" >Antenna Elevation</td>
				<td id="biru_1" align="center" >Azimuth</td>
				<td id="biru_1" align="center" >Cable QTY</td>
				<td id="biru_1" align="center" >Cable Diameter</td>
				<td id="biru_1" align="center" >Request</td>
				<td id="biru_1" align="center" >Remarks</td>
			</tr>
			<?php for($i=0;$i<=17;$i++){ ?>
				<tr>
					<td ><?=$f->input("item[]",$_data["item"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("ant_type[]",$_data["ant_type"][$i],"style='width:100px;'");?></td>
					<td ><?=$f->input("ant_length[]",$_data["ant_length"][$i],"style='width:200px;'");?></td>
					<td ><?=$f->input("ant_qty[]",$_data["ant_qty"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("ant_elevation[]",$_data["ant_elevation"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("azimuth[]",$_data["azimuth"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("cable_qty[]",$_data["cable_qty"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("cable_diameter[]",$_data["cable_diameter"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("purposed_req[]",$_data["purposed_req"][$i],"style='width:100%;'");?></td>
					<td ><?=$f->input("remarks[]",$_data["remarks"][$i],"style='width:100%;'");?></td>
				</tr>
			<?php } ?>
		</table>
		<br>
	</div>
	<table width="100%">
		<tr>
			<td width="33%" align="left"><?=$back;?></td>
			<td align="center"><?=$save;?></td>
			<td width="33%" align="right"><?=$next;?></td>
		</tr>
	</table>
</form>	

<?php
	foreach($_POST["ant_type_before"] as $key => $ant_type_before){
		?><script>
			document.getElementById("ant_type_before[<?=$key;?>]").value = "<?=$ant_type_before;?>";
			document.getElementById("ant_type_after[<?=$key;?>]").value = "<?=$_POST["ant_type_after"][$key];?>";
			document.getElementById("ant_height_before[<?=$key;?>]").value = "<?=$_POST["ant_height_before"][$key];?>";
			document.getElementById("ant_height_after[<?=$key;?>]").value = "<?=$_POST["ant_height_after"][$key];?>";
			document.getElementById("azimuth_before[<?=$key;?>]").value = "<?=$_POST["azimuth_before"][$key];?>";
			document.getElementById("azimuth_after[<?=$key;?>]").value = "<?=$_POST["azimuth_after"][$key];?>";
			document.getElementById("mech_before[<?=$key;?>]").value = "<?=$_POST["mech_before"][$key];?>";
			document.getElementById("mech_after[<?=$key;?>]").value = "<?=$_POST["mech_after"][$key];?>";
			document.getElementById("elect_before[<?=$key;?>]").value = "<?=$_POST["elect_before"][$key];?>";
			document.getElementById("elect_after18[<?=$key;?>]").value = "<?=$_POST["elect_after18"][$key];?>";
			document.getElementById("elect_after21[<?=$key;?>]").value = "<?=$_POST["elect_after21"][$key];?>";
		</script><?php
	}
?>
<?php include_once "footer.php";?>