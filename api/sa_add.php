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
	
	$val_m	= 0;
	$val_v	= 0;
	$val_w	= 0;
	$base_transceiver	= 0;
	$material			= 0;
	$services			= 0;
	$defects_open		= 0;
	$last_seqno 		= $db->fetch_single_data("indottech_sa_01","seqno",["sa_id"=>$id],["seqno DESC"]);
	$indottech_sa_01	= $db->fetch_all_data("indottech_sa_01",[],"sa_id = '".$id."' AND seqno = '".$last_seqno."'");
	
	foreach($indottech_sa_01 as $key => $sa_01){
		if($sa_01["insp_result"] == 2){
			$val_m += $db->fetch_single_data("indottech_checklist","nilai_inspection",["id" => $sa_01["checklist_id"]]);
			$val_w ++;
			if($sa_01["responsible"] == "Subkon"){
				$val_v += $db->fetch_single_data("indottech_checklist","nilai_inspection",["id" => $sa_01["checklist_id"]]);
			}
		}
	}
	$base_transceiver 	= $val_m;
	$services 			= $val_v;
	$material 			= $base_transceiver - $services;
	$defects_open 		= $val_w;
	
	$indottech_sa_05	= $db->fetch_all_data("indottech_sa_05",[],"sa_id = '".$id."'")[0];
	if(isset($_POST["save"])){
		if(!$id) {
			$db->addtable("indottech_sa");
			$db->addfield("site_id");				$db->addvalue($site_id);
			$inserting = $db->insert();
			$id = $inserting["insert_id"];
		}
		$db->addtable("indottech_sa_05");
		$db->addfield("sa_id");					$db->addvalue($id);
		$db->addfield("project_name");			$db->addvalue($_POST["project_name"]);
		$db->addfield("wp_id");					$db->addvalue($_POST["wp_id"]);
		$db->addfield("site_type");				$db->addvalue($_POST["site_type"]);
		$db->addfield("partner_bts");			$db->addvalue($_POST["partner_bts"]);
		$db->addfield("team_leader");			$db->addvalue($_POST["team_leader"]);
		$db->addfield("assessment_date");		$db->addvalue($_POST["assessment_date"]);
		$db->addfield("swap_date");				$db->addvalue($_POST["swap_date"]);
		$db->addfield("assessment_type");		$db->addvalue($_POST["assessment_type"]);
		$db->addfield("equip_type");			$db->addvalue($_POST["equip_type"]);
		$db->addfield("antenna_type");			$db->addvalue($_POST["antenna_type"]);
		$db->addfield("antenna_direction");		$db->addvalue($_POST["antenna_direction"]);
		$db->addfield("antenna_tilt");			$db->addvalue($_POST["antenna_tilt"]);
		$db->addfield("antenna_height");		$db->addvalue($_POST["antenna_height"]);
		$db->addfield("current_config");		$db->addvalue($_POST["current_config"]);
		$db->addfield("cme_supplier");			$db->addvalue($_POST["cme_supplier"]);
		$db->addfield("ti_supplier");			$db->addvalue($_POST["ti_supplier"]);
		$db->addfield("remarks");				$db->addvalue($_POST["remarks"]);
		$db->addfield("assessor");				$db->addvalue($_POST["assessor"]);
		$db->addfield("project_engineer");		$db->addvalue($_POST["project_engineer"]);
		$db->addfield("subcontractor");			$db->addvalue($_POST["subcontractor"]);
		$db->addfield("regional_pm");			$db->addvalue($_POST["regional_pm"]);
		if(!$indottech_sa_05){
			$inserting = $db->insert();
		} else {
			$db->where("id",$indottech_sa_05["id"]);
			$inserting = $db->update();
		}
		if($inserting["affected_rows"] >= 0){
			javascript("window.location=\"".str_replace("_add","_add_01",$_SERVER["PHP_SELF"])."?token=".$token."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";");
		} else {
			echo "<center><font style='color:red;'>Saving Failed!</font></center>";
		}
	}
	if($indottech_sa_05){
		$_POST["project_name"] 		= $indottech_sa_05["project_name"];
		$_POST["wp_id"] 			= $indottech_sa_05["wp_id"];
		$_POST["site_type"] 		= $indottech_sa_05["site_type"];
		$_POST["partner_bts"] 		= $indottech_sa_05["partner_bts"];
		$_POST["team_leader"] 		= $indottech_sa_05["team_leader"];
		$_POST["assessment_date"] 	= $indottech_sa_05["assessment_date"];
		$_POST["swap_date"] 		= $indottech_sa_05["swap_date"];
		$_POST["assessment_type"] 	= $indottech_sa_05["assessment_type"];
		$_POST["equip_type"] 		= $indottech_sa_05["equip_type"];
		$_POST["antenna_type"] 		= $indottech_sa_05["antenna_type"];
		$_POST["antenna_direction"]	= $indottech_sa_05["antenna_direction"];
		$_POST["antenna_tilt"] 		= $indottech_sa_05["antenna_tilt"];
		$_POST["antenna_height"] 	= $indottech_sa_05["antenna_height"];
		$_POST["current_config"] 	= $indottech_sa_05["current_config"];
		$_POST["cme_supplier"] 		= $indottech_sa_05["cme_supplier"];
		$_POST["ti_supplier"] 		= $indottech_sa_05["ti_supplier"];
		$_POST["remarks"] 			= $indottech_sa_05["remarks"];
		$_POST["assessor"] 			= $indottech_sa_05["assessor"];
		$_POST["project_engineer"]	= $indottech_sa_05["project_engineer"];
		$_POST["subcontractor"] 	= $indottech_sa_05["subcontractor"];
		$_POST["regional_pm"]		= $indottech_sa_05["regional_pm"];
	}
?>
	<style>
		#biru_1{
			background-color:#1a75ff;
			color:white;
			font-weight:bolder;
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
			<td colspan="5" align="right" style="font-family:NokiaNokkok; color:#1a75ff;">NOKIA</td>
		</tr>
		<tr>
			<td colspan="5" align="center" style="font-size:8px;">Telecom Works Checklist (V1.5.1)</td>
		</tr>
		<tr>
			<td colspan="5" id="biru_1" align="center">Site Assessment Report</td>
		</tr>
	</table>
	<table width="100%" style="font-family:Arial; color:solid black;">
		<tr>
			<td colspan="3" id="biru_2" align="center">Site Assessment Information</td>
			<td colspan="2" id="biru_2" align="center">Site Assessment Score</td>
		</tr>
		<tr>
			<td>Project Name</td>
			<td colspan="2"><?=$f->input("project_name",$_POST["project_name"],"style='width:100%;'");?></td>
			<td colspan="2" id="biru_3" align="center">Base Transceiver</td>
		</tr>
		<tr>
			<td>Site ID - Name</td>
			<td colspan="2"><?=str_replace(" ","_",($site_details["kode"]."_".$site_details["name"]));?></td>
			<td colspan="2" rowspan="6" id="biru_3" align="center" valign="middle" style="font-size:48px; padding-top:1%;"><?=$base_transceiver;?></td>
		</tr>
		<tr>
			<td>Region / Zone</td>
			<td colspan="2"><?=$db->fetch_single_data("indottech_regions","name",["id" => $site_details["region_id"]])." / ".($site_details["area"] != ""? $site_details["area"]:"");?></td>
		</tr>
		<tr>
			<td>Work Package ID</td>
			<td colspan="2"><?=$f->input("wp_id",$_POST["wp_id"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td>Site Type</td>
			<td colspan="2"><?=$f->input("site_type",$_POST["site_type"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td>Partner - BTS</td>
			<td colspan="2"><?=$f->input("partner_bts",$_POST["partner_bts"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td>Team Leader - PITD</td>
			<td colspan="2"><?=$f->input("team_leader",$_POST["team_leader"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td>Assessment Date</td>
			<td colspan="2"><?=$f->input("assessment_date",$_POST["assessment_date"],"type='date' style='width:100%;'");?></td>
			<td id="biru_3" align="center">Material</td>
			<td id="biru_3" align="center">Services</td>
		</tr>
		<tr>
			<td>Integration / Swap Date</td>
			<td colspan="2"><?=$f->input("swap_date",$_POST["swap_date"],"type='date' style='width:100%;'");?></td>
			<td rowspan="6" id="biru_3" align="center" valign="middle" style="font-size:36px; padding-top:3%;"><?=$material;?></td>
			<td rowspan="6" id="biru_3" align="center" valign="middle" style="font-size:36px; padding-top:3%;"><?=$services;?></td>
		</tr>
		<tr>
			<td>Assessment Type</td>
			<td colspan="2"><?=$f->input("assessment_type",$_POST["assessment_type"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td id="biru_2" align="center">Equipment Type</td>
			<td id="biru_2" align="center">Antenna Type</td>
			<td id="biru_2" align="center">Antenna Direction</td>
		</tr>
		<tr>
			<td align="center"><?=$f->input("equip_type",$_POST["equip_type"],"style='width:100%;'");?></td>
			<td align="center"><?=$f->input("antenna_type",$_POST["antenna_type"],"style='width:100%;'");?></td>
			<td align="center"><?=$f->input("antenna_direction",$_POST["antenna_direction"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td id="biru_2" align="center">Current Config</td>
			<td id="biru_2" align="center">Antenna Tilt</td>
			<td id="biru_2" align="center">Antenna Height</td>
		</tr>
		<tr>
			<td align="center"><?= $f->input("current_config",$_POST["current_config"],"style='width:100%;'");?></td>
			<td align="center"><?= $f->input("antenna_tilt",$_POST["antenna_tilt"],"style='width:100%;'");?></td>
			<td align="center"><?= $f->input("antenna_height",$_POST["antenna_height"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td id="biru_2" align="center">CME Supplier</td>
			<td id="biru_2" align="center">TI Supplier</td>
			<td id="biru_2" align="center"># Defects still Open</td>
			<td id="biru_2" align="center" colspan="2">Remarks</td>
		</tr>
		<tr>
			<td align="center"><?= $f->input("cme_supplier",$_POST["cme_supplier"],"style='width:100%;'");?></td>
			<td align="center"><?= $f->input("ti_supplier",$_POST["ti_supplier"],"style='width:100%;'");?></td>
			<td align="center" style="font-size:36px; padding-top:0.5%;"><?=$defects_open;?></td>
			<td align="center" colspan="2"><?= $f->input("remarks",$_POST["remarks"],"style='width:100%;'") ;?></td>
		</tr>
	</table>
	<table width="100%" style="font-family:Arial; color:solid black;">
		<tr>
			<td id="biru_2" align="center" width="25%">Assessor</td>
			<td id="biru_2" align="center" width="25%">Project Engineer</td>
			<td id="biru_2" align="center" width="25%">Subcontractor Representative</td>
			<td id="biru_2" align="center" width="25%">Regional Project Manager</td>
		</tr>
		<tr>
			<td align="center"><?=$f->input("assessor",$_POST["assessor"],"style='width:100%;'");?></td>
			<td align="center"><?=$f->input("project_engineer",$_POST["project_engineer"],"style='width:100%;'");?></td>
			<td align="center"><?=$f->input("subcontractor",$_POST["subcontractor"],"style='width:100%;'");?></td>
			<td align="center"><?=$f->input("regional_pm",$_POST["regional_pm"],"style='width:100%;'");?></td>
		</tr>
		<tr>
			<td align="center">Signature</td>
			<td align="center">Signature</td>
			<td align="center">Signature</td>
			<td align="center">Signature</td>
		</tr>
	</table>
	<br>
	<?=$f->input("","Back","type='button' onclick='window.location=\"hs_sa_menu.php?token=".$_GET["token"]."&site_id=".$site_id."\";'","btn btn-warning");?>&ensp;
	<?=$f->input("save","Next","type='submit'","btn btn-primary");?>&ensp;
	<!--
	<?=$f->input("","Next","type='button' onclick='window.location=\"".str_replace("_add","_add_01",$_SERVER["PHP_SELF"])."?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-primary");?>&ensp;
	-->
</form>	
<?php include_once "footer.php";?>
