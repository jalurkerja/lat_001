<?php 
	include_once "header.php";
	$dwdm_id = $_GET["dwdm_id"];
	$indottech_dwdm = $db->fetch_all_data("indottech_dwdm",[],"id = '".$dwdm_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_dwdm");
		$db->addfield("project");						$db->addvalue($_POST["project"]);
		$db->addfield("doc_date");						$db->addvalue($_POST["doc_date"]);
		$db->addfield("site_name");						$db->addvalue($_POST["site_name"]);
		$db->addfield("equipment");						$db->addvalue($_POST["equipment"]);
		$db->addfield("ref_po");						$db->addvalue($_POST["ref_po"]);
		$db->addfield("user_id");						$db->addvalue($__user_id);
		$db->addfield("etsi_rack");						$db->addvalue($_POST["check_01"]);
		$db->addfield("subrack");						$db->addvalue($_POST["check_02"]);
		$db->addfield("tray");							$db->addvalue($_POST["check_03"]);
		$db->addfield("rack_subrack");					$db->addvalue($_POST["check_04"]);
		$db->addfield("dc_power");						$db->addvalue($_POST["check_05"]);
		$db->addfield("verify_battery");				$db->addvalue($_POST["check_06"]);
		$db->addfield("all_module");					$db->addvalue($_POST["check_07"]);
		$db->addfield("otb_sfd_dcm");					$db->addvalue($_POST["check_08"]);
		$db->addfield("patch_cord");					$db->addvalue($_POST["check_09"]);
		$db->addfield("label_equipment");				$db->addvalue($_POST["check_10"]);
		$db->addfield("label_tru_pdu");					$db->addvalue($_POST["check_11"]);
		$db->addfield("label_rectifier");				$db->addvalue($_POST["check_12"]);
		$db->addfield("label_power_cable");				$db->addvalue($_POST["check_13"]);
		$db->addfield("label_grounding");				$db->addvalue($_POST["check_14"]);
		$db->addfield("label_optical_cabel");			$db->addvalue($_POST["check_15"]);
		$db->addfield("photo_documentation");			$db->addvalue($_POST["check_16"]);
		$db->addfield("factory_test");					$db->addvalue($_POST["check_17"]);
		$db->addfield("as_plan_drawing");				$db->addvalue($_POST["check_18"]);
		
		if($_GET["dwdm_id"]){
			$db->where("id",$dwdm_id);
			$updating = $db->update();
			javascript("window.location=\"indosat_dwdm_add.php?token=".$token."&dwdm_id=".$dwdm_id."\";");
		} else {
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$dwdm_id = $inserting["insert_id"];
				javascript("window.location=\"indosat_dwdm_photo.php?token=".$token."&dwdm_id=".$dwdm_id."\";");
				exit();
			} else {
				$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
			}
		}
		
	}
?>
	<center><h4><b>INSTALLATION CHECK LIST</b></h4></center>
	<center><?=$_errormessage;?></center>
	<?php
		if($indottech_dwdm["doc_date"] == "") $indottech_dwdm["doc_date"] = date("Y-m-d");
		if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-success");
		
		if($indottech_dwdm["etsi_rack"] == 0){$checked["ny_01"] = " checked";} else {$checked["ok_01"] = " checked";}
		if($indottech_dwdm["subrack"] == 0){$checked["ny_02"] = " checked";} else {$checked["ok_02"] = " checked";}
		if($indottech_dwdm["tray"] == 0){$checked["ny_03"] = " checked";} else {$checked["ok_03"] = " checked";}
		if($indottech_dwdm["rack_subrack"] == 0){$checked["ny_04"] = " checked";} else {$checked["ok_04"] = " checked";}
		if($indottech_dwdm["dc_power"] == 0){$checked["ny_05"] = " checked";} else {$checked["ok_05"] = " checked";}
		if($indottech_dwdm["verify_battery"] == 0){$checked["ny_06"] = " checked";} else {$checked["ok_06"] = " checked";}
		if($indottech_dwdm["all_module"] == 0){$checked["ny_07"] = " checked";} else {$checked["ok_07"] = " checked";}
		if($indottech_dwdm["otb_sfd_dcm"] == 0){$checked["ny_08"] = " checked";} else {$checked["ok_08"] = " checked";}
		if($indottech_dwdm["patch_cord"] == 0){$checked["ny_09"] = " checked";} else {$checked["ok_09"] = " checked";}
		if($indottech_dwdm["label_equipment"] == 0){$checked["ny_10"] = " checked";} else {$checked["ok_10"] = " checked";}
		if($indottech_dwdm["label_tru_pdu"] == 0){$checked["ny_11"] = " checked";} else {$checked["ok_11"] = " checked";}
		if($indottech_dwdm["label_rectifier"] == 0){$checked["ny_12"] = " checked";} else {$checked["ok_12"] = " checked";}
		if($indottech_dwdm["label_power_cable"] == 0){$checked["ny_13"] = " checked";} else {$checked["ok_13"] = " checked";}
		if($indottech_dwdm["label_grounding"] == 0){$checked["ny_14"] = " checked";} else {$checked["ok_14"] = " checked";}
		if($indottech_dwdm["label_optical_cabel"] == 0){$checked["ny_15"] = " checked";} else {$checked["ok_15"] = " checked";}
		if($indottech_dwdm["photo_documentation"] == 0){$checked["ny_16"] = " checked";} else {$checked["ok_16"] = " checked";}
		if($indottech_dwdm["factory_test"] == 0){$checked["ny_17"] = " checked";} else {$checked["ok_17"] = " checked";}
		if($indottech_dwdm["as_plan_drawing"] == 0){$checked["ny_18"] = " checked";} else {$checked["ok_18"] = " checked";}
	?>
	<form method="POST" action="?token=<?=$token;?>&dwdm_id=<?=$dwdm_id;?>">
		<table width="100%" border = "0">
			<tr> <td>Project</td>	<td>:</td>	<td><?=$f->input("project",$indottech_dwdm["project"],"required style='width:100%'");?></td> </tr>
			<tr> <td>Date</td>		<td>:</td>	<td><?=$f->input("doc_date",$indottech_dwdm["doc_date"],"type='date' style='width:100%'");?></td> </tr>
			<tr> <td>Site Name</td>	<td>:</td>	<td><?=$f->input("site_name",$indottech_dwdm["site_name"],"required style='width:100%'");?></td> </tr>
			<tr> <td>Equipment</td>	<td>:</td>	<td><?=$f->input("equipment",$indottech_dwdm["equipment"],"required style='width:100%'");?></td> </tr>
			<tr> <td>Ref. PO</td>	<td>:</td>	<td><?=$f->input("ref_po",$indottech_dwdm["ref_po"]," style='width:100%'");?></td> </tr>
		</table>
		<br>
		<table width="100%" border = "1" rules="all">
			<tr>
				<td align="center" style="font-weight:bold">NO</td>
				<td align="center" style="font-weight:bold">INSTALLATION DESCRIPTION</td>
				<td align="center" style="font-weight:bold">CHECK LIST RESULT</td>
			</tr>
			<tr>
				<td align = "center">1</td>
				<td>ETSI Rack Equipment Installation</td>
				<td valign="top"><?=$f->input("check_01","0","style='height:13px;' type='radio' required".$checked["ny_01"]);?> - NY &emsp;/&emsp; <?=$f->input("check_01","1","style='height:13px;' type='radio' required".$checked["ok_01"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">2</td>
				<td>Subrack and equipment installation</td>
				<td valign="top"><?=$f->input("check_02","0","style='height:13px;' type='radio' required".$checked["ny_02"]);?> - NY &emsp;/&emsp; <?=$f->input("check_02","1","style='height:13px;' type='radio' required".$checked["ok_02"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">3</td>
				<td>Tray (Vertical/ horizontal) Installation</td>
				<td valign="top"><?=$f->input("check_03","0","style='height:13px;' type='radio' required".$checked["ny_03"]);?> - NY &emsp;/&emsp; <?=$f->input("check_03","1","style='height:13px;' type='radio' required".$checked["ok_03"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">4</td>
				<td>Rack &amp; Subrack grounding installation</td>
				<td valign="top"><?=$f->input("check_04","0","style='height:13px;' type='radio' required".$checked["ny_04"]);?> - NY &emsp;/&emsp; <?=$f->input("check_04","1","style='height:13px;' type='radio' required".$checked["ok_04"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">5</td>
				<td>DC Power Cable Installation</td>
				<td valign="top"><?=$f->input("check_05","0","style='height:13px;' type='radio' required".$checked["ny_05"]);?> - NY &emsp;/&emsp; <?=$f->input("check_05","1","style='height:13px;' type='radio' required".$checked["ok_05"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">6</td>
				<td>Verify Barrtery A/B power assignment</td>
				<td valign="top"><?=$f->input("check_06","0","style='height:13px;' type='radio' required".$checked["ny_06"]);?> - NY &emsp;/&emsp; <?=$f->input("check_06","1","style='height:13px;' type='radio' required".$checked["ok_06"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">7</td>
				<td>All Module insertion ( refer to BoQ)</td>
				<td valign="top"><?=$f->input("check_07","0","style='height:13px;' type='radio' required".$checked["ny_07"]);?> - NY &emsp;/&emsp; <?=$f->input("check_07","1","style='height:13px;' type='radio' required".$checked["ok_07"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">8</td>
				<td>OTB/SFD/DCM installation ( if any)</td>
				<td valign="top"><?=$f->input("check_08","0","style='height:13px;' type='radio' required".$checked["ny_08"]);?> - NY &emsp;/&emsp; <?=$f->input("check_08","1","style='height:13px;' type='radio' required".$checked["ok_08"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">9</td>
				<td>Patch cord Installation</td>
				<td valign="top"><?=$f->input("check_09","0","style='height:13px;' type='radio' required".$checked["ny_09"]);?> - NY &emsp;/&emsp; <?=$f->input("check_09","1","style='height:13px;' type='radio' required".$checked["ok_09"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">10</td>
				<td>Labeling on Equipment/Rack/Subrack</td>
				<td valign="top"><?=$f->input("check_10","0","style='height:13px;' type='radio' required".$checked["ny_10"]);?> - NY &emsp;/&emsp; <?=$f->input("check_10","1","style='height:13px;' type='radio' required".$checked["ok_10"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">11</td>
				<td>Labeling on TRU/PDU breakers</td>
				<td valign="top"><?=$f->input("check_11","0","style='height:13px;' type='radio' required".$checked["ny_11"]);?> - NY &emsp;/&emsp; <?=$f->input("check_11","1","style='height:13px;' type='radio' required".$checked["ok_11"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">12</td>
				<td>Labeling on Rectifier MCB's</td>
				<td valign="top"><?=$f->input("check_12","0","style='height:13px;' type='radio' required".$checked["ny_12"]);?> - NY &emsp;/&emsp; <?=$f->input("check_12","1","style='height:13px;' type='radio' required".$checked["ok_12"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">13</td>
				<td>Labeling Power Cable <br>( near PDU/TRU and  near Rectifier/DCPDB)</td>
				<td valign="top"><?=$f->input("check_13","0","style='height:13px;' type='radio' required".$checked["ny_13"]);?> - NY &emsp;/&emsp; <?=$f->input("check_13","1","style='height:13px;' type='radio' required".$checked["ok_13"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">14</td>
				<td>Labeling Grounding <br>( Near Equipment &amp; Main Grounding Bar)</td>
				<td valign="top"><?=$f->input("check_14","0","style='height:13px;' type='radio' required".$checked["ny_14"]);?> - NY &emsp;/&emsp; <?=$f->input("check_14","1","style='height:13px;' type='radio' required".$checked["ok_14"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">15</td>
				<td>Labelin Optical Cabel / Patch Cord <br>( on Equipment &amp; OTB)</td>
				<td valign="top"><?=$f->input("check_15","0","style='height:13px;' type='radio' required".$checked["ny_15"]);?> - NY &emsp;/&emsp; <?=$f->input("check_15","1","style='height:13px;' type='radio' required".$checked["ok_15"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">16</td>
				<td>Photo documentation</td>
				<td valign="top"><?=$f->input("check_16","0","style='height:13px;' type='radio' required".$checked["ny_16"]);?> - NY &emsp;/&emsp; <?=$f->input("check_16","1","style='height:13px;' type='radio' required".$checked["ok_16"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">17</td>
				<td>Factory test sheet collection</td>
				<td valign="top"><?=$f->input("check_17","0","style='height:13px;' type='radio' required".$checked["ny_17"]);?> - NY &emsp;/&emsp; <?=$f->input("check_17","1","style='height:13px;' type='radio' required".$checked["ok_17"]);?> - OK </td>
			</tr>
			<tr>
				<td align = "center">18</td>
				<td>As Plan Drawing collection</td>
				<td valign="top"><?=$f->input("check_18","0","style='height:13px;' type='radio' required".$checked["ny_18"]);?> - NY &emsp;/&emsp; <?=$f->input("check_18","1","style='height:13px;' type='radio' required".$checked["ok_18"]);?> - OK </td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"indosat_dwdm.php?token=".$token."\";'","btn btn-warning");?></td>
			<?php if(!$dwdm_id) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td width="33.33%" align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td width="33.33%" align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"indosat_dwdm_photo.php?token=".$token."&dwdm_id=".$dwdm_id."\";'","btn btn-info");?></td>
			<?php } ?>
		</tr></table>
	</form>
	<script> $("#project").focus(); </script>
<?php include_once "footer.php";?>