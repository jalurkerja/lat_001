<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$acceptance_certificate = $db->fetch_all_data("indottech_acceptance_certificate",[],"atd_id='".$atd_id."'")[0];
	$site_id = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
	$indottech_sites = $db->fetch_all_data("indottech_sites",[],"id='".$site_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_acceptance_certificate");
		if($acceptance_certificate["id"] > 0) 	$db->where("id",$acceptance_certificate["id"]);
		$db->addfield("atd_id");							$db->addvalue($atd_id);
		$db->addfield("entry_at");							$db->addvalue($__now);
		$db->addfield("po_number");							$db->addvalue($_POST["po_number"]);
		$db->addfield("site_id");							$db->addvalue($_POST["site_id"]);
		$db->addfield("site_code");							$db->addvalue($indottech_sites["site_code"]);
		$db->addfield("site_name");							$db->addvalue($indottech_sites["name"]);
		$db->addfield("site_address");						$db->addvalue($_POST["site_address"]);
		$db->addfield("site_longitude");					$db->addvalue($_POST["site_longitude"]);
		$db->addfield("site_latitude");						$db->addvalue($_POST["site_latitude"]);
		$db->addfield("worktype_ids");						$db->addvalue(sel_to_pipe($_POST["worktype_id"]));
		$db->addfield("sitetype_ids");						$db->addvalue(sel_to_pipe($_POST["sitetype_id"]));
		$db->addfield("system_module_ids");					$db->addvalue(sel_to_pipe($_POST["sys_mod_type_id"]));
		$db->addfield("rf_module_ids");						$db->addvalue(sel_to_pipe($_POST["rf_mod_id"]));
		$db->addfield("configuration_ids");					$db->addvalue(sel_to_pipe($_POST["bts_config_id"]));
		$db->addfield("number_of_system_modul");			$db->addvalue($_POST["number_of_system_modul"]);
		$db->addfield("number_of_rf");						$db->addvalue($_POST["number_of_rf"]);
		$db->addfield("number_of_antenna");					$db->addvalue($_POST["number_of_antenna"]);
		$db->addfield("installation_at");					$db->addvalue($_POST["installation_at"]);
		$db->addfield("self_assessment_at");				$db->addvalue($_POST["self_assessment_at"]);
		$db->addfield("onair_at");							$db->addvalue($_POST["onair_at"]);
		if($acceptance_certificate["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
		
	if($atr["site_id"] == "") $atr["site_id"] = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
	if($atr["site_address"] == "") $atr["site_address"] = $db->fetch_single_data("indottech_sites","address",["id" => $atr["site_id"]]);
	$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => "13"],["name"],"",true);
	foreach(pipetoarray($acceptance_certificate["worktype_ids"]) as $val_1){
		$worktype_checked[$val_1] = "checked";
	}
	foreach(pipetoarray($acceptance_certificate["sitetype_ids"]) as $val_2){
		$sitetype_checked[$val_2] = "checked";
	}
	foreach(pipetoarray($acceptance_certificate["system_module_ids"]) as $val_3){
		$sys_mod_type_checked[$val_3] = "checked";
	}
	foreach(pipetoarray($acceptance_certificate["rf_module_ids"]) as $val_4){
		$rf_mod_checked[$val_4] = "checked";
	}
	foreach(pipetoarray($acceptance_certificate["configuration_ids"]) as $val_5){
		$bts_config_checked[$val_5] = "checked";
	}
	
?>

<center><h4><b>SITE ACCEPTANCE CERTIFICATE</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="0">
				<tr>
					<td>PO Number :</td>
					<td><?=$f->input("po_number",$acceptance_certificate["po_number"],"placeholder='PO Number' Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Site :</td>
					<td><?=$f->select("site_id",$sites,$atr["site_id"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Site Address :</td>
					<td><?=$f->textarea("site_address",$atr["site_address"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Longitude :</td>
					<td><?=$f->input("site_longitude",$indottech_sites["longitude"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Latitude :</td>
					<td><?=$f->input("site_latitude",$indottech_sites["latitude"],"Xrequired","classinput");?></td>
				</tr>
			</table>
			<br>
			<table border="1" align="center">
				<tr>
					<td>Work Type :</td>
					<td>
						<?=$f->input("worktype_id[0]","1","style='height:13px;' type='checkbox' ".$worktype_checked[1]);?> New Site<br>
						<?=$f->input("worktype_id[1]","2","style='height:13px;' type='checkbox' ".$worktype_checked[2]);?> Swap BTS, Swap antenna<br>
						<?=$f->input("worktype_id[2]","3","style='height:13px;' type='checkbox' ".$worktype_checked[3]);?> Swap BTS, use antenna Existing<br>
						<?=$f->input("worktype_id[3]","4","style='height:13px;' type='checkbox' ".$worktype_checked[4]);?> Outorization
					</td>
					</td>
				</tr>
				<tr>
					<td>Site Type :</td>
					<td>
						<?=$f->input("sitetype_id[0]","1","style='height:13px;' type='checkbox'".$sitetype_checked[1]);?> Green Field Indoor<br>
						<?=$f->input("sitetype_id[1]","2","style='height:13px;' type='checkbox'".$sitetype_checked[2]);?> Green Field Outdoor<br>
						<?=$f->input("sitetype_id[2]","3","style='height:13px;' type='checkbox'".$sitetype_checked[3]);?> Inbuilding Coverage<br>
						<?=$f->input("sitetype_id[3]","4","style='height:13px;' type='checkbox'".$sitetype_checked[4]);?> Rooftop<br>
						<?=$f->input("sitetype_id[4]","5","style='height:13px;' type='checkbox'".$sitetype_checked[5]);?> 3rd Party Building Tower
					</td>
					</td>
				</tr>
				<tr>
					<td>BTS <b>System Module</b><br>Installation Type :</td>
					<td>
						<?=$f->input("sys_mod_type_id[0]","1","style='height:13px;' type='checkbox'".$sys_mod_type_checked[1]);?> Stack type in shelter<br>
						<?=$f->input("sys_mod_type_id[1]","2","style='height:13px;' type='checkbox'".$sys_mod_type_checked[2]);?> Stack type shelter less<br>
						<?=$f->input("sys_mod_type_id[2]","3","style='height:13px;' type='checkbox'".$sys_mod_type_checked[3]);?> Wall Mounted<br>
						<?=$f->input("sys_mod_type_id[3]","4","style='height:13px;' type='checkbox'".$sys_mod_type_checked[4]);?> Pole Mounted<br>
						<?=$f->input("sys_mod_type_id[4]","5","style='height:13px;' type='checkbox'".$sys_mod_type_checked[5]);?> Leg Tower Mounted
					</td>
					</td>
				</tr>
				<tr>
					<td>BTS <b>RF Module</b> :</td>
					<td>
						<?=$f->input("rf_mod_id[0]","1","style='height:13px;' type='checkbox'".$rf_mod_checked[1]);?> Stack type<br>
						<?=$f->input("rf_mod_id[1]","2","style='height:13px;' type='checkbox'".$rf_mod_checked[2]);?> Rack<br>
						<?=$f->input("rf_mod_id[2]","3","style='height:13px;' type='checkbox'".$rf_mod_checked[3]);?> Wall Mounted<br>
						<?=$f->input("rf_mod_id[3]","4","style='height:13px;' type='checkbox'".$rf_mod_checked[4]);?> Pole Mounted<br>
						<?=$f->input("rf_mod_id[4]","5","style='height:13px;' type='checkbox'".$rf_mod_checked[5]);?> Leg Tower Mounted
					</td>
					</td>
				</tr>
				<tr>
					<td>BTS Configuration :</td>
					<td>
						<?=$f->input("bts_config_id[0]","1","style='height:13px;' type='checkbox'".$bts_config_checked[1]);?> G900<br>
						<?=$f->input("bts_config_id[1]","2","style='height:13px;' type='checkbox'".$bts_config_checked[2]);?> G1800<br>
						<?=$f->input("bts_config_id[2]","3","style='height:13px;' type='checkbox'".$bts_config_checked[3]);?> U900<br>
						<?=$f->input("bts_config_id[3]","4","style='height:13px;' type='checkbox'".$bts_config_checked[4]);?> U2100<br>
						<?=$f->input("bts_config_id[4]","5","style='height:13px;' type='checkbox'".$bts_config_checked[5]);?> LTE1800
					</td>
					</td>
				</tr>
				<tr>
					<td>Number of <b>System <br>Module</b> [Units]</td><td><?=$f->input("number_of_system_modul",$acceptance_certificate["number_of_system_modul"],"placeholder='System Module' Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Number of RF [Units]</td><td><?=$f->input("number_of_rf",$acceptance_certificate["number_of_rf"],"placeholder='Number RF' Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Number of <b>Antenna</b> [Units]</td><td><?=$f->input("number_of_antenna",$acceptance_certificate["number_of_antenna"],"placeholder='Number Antenna' Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>Installation Date : </td>
					<td><?=$f->input("installation_at",$acceptance_certificate["installation_at"], "type='date'");?></td>
				</tr>
				<tr>
					<td>Self-Assessment Date : </td>
					<td><?=$f->input("self_assessment_at",$acceptance_certificate["self_assessment_at"], "type='date'");?></td>
				</tr>
				<tr>
					<td>On Air Date : </td>
					<td><?=$f->input("onair_at",$acceptance_certificate["onair_at"], "type='date'");?></td>
				</tr>
			</table>
			<br>
			<table width="100%">
				<tr>
					<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
					<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>