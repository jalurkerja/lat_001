<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$atr = $db->fetch_all_data("indottech_acceptance_test_rectifier",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		$sitename = $db->fetch_single_data("indottech_sites","name",["id" => $_POST["site_id"]]);
		$db->addtable("indottech_acceptance_test_rectifier");
		if($atr["id"] > 0) 							$db->where("id",$atr["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("test_at");					$db->addvalue($_POST["test_at"]);
		$db->addfield("customer");					$db->addvalue($_POST["customer"]);
		$db->addfield("site_id");					$db->addvalue($_POST["site_id"]);
		$db->addfield("site_name");					$db->addvalue($sitename);
		$db->addfield("site_address");				$db->addvalue($_POST["site_address"]);
		$db->addfield("power_system_sn");			$db->addvalue($_POST["power_system_sn"]);
		$db->addfield("sub_rack_sn");				$db->addvalue($_POST["sub_rack_sn"]);
		$db->addfield("supervisory_modul_sn");		$db->addvalue($_POST["supervisory_modul_sn"]);
		$db->addfield("rectifier_module_type");		$db->addvalue($_POST["rectifier_module_type"]);
		$db->addfield("rectifier1_sn");				$db->addvalue($_POST["rectifier1_sn"]);
		$db->addfield("rectifier2_sn");				$db->addvalue($_POST["rectifier2_sn"]);
		$db->addfield("rectifier3_sn");				$db->addvalue($_POST["rectifier3_sn"]);
		$db->addfield("rectifier4_sn");				$db->addvalue($_POST["rectifier4_sn"]);
		$db->addfield("rectifier5_sn");				$db->addvalue($_POST["rectifier5_sn"]);
		$db->addfield("rectifier6_sn");				$db->addvalue($_POST["rectifier6_sn"]);
		$db->addfield("rectifier7_sn");				$db->addvalue($_POST["rectifier7_sn"]);
		$db->addfield("ac_input_vac");				$db->addvalue($_POST["ac_input_vac"]);
		$db->addfield("ac_input_phase");			$db->addvalue($_POST["ac_input_phase"]);
		$db->addfield("output_vdc1");				$db->addvalue($_POST["output_vdc1"]);
		$db->addfield("output_vdc2");				$db->addvalue($_POST["output_vdc2"]);
		$db->addfield("float_vdc");					$db->addvalue($_POST["float_vdc"]);
		$db->addfield("equalize_vdc");				$db->addvalue($_POST["equalize_vdc"]);
		$db->addfield("polarity");					$db->addvalue($_POST["polarity"]);
		$db->addfield("load_current");				$db->addvalue($_POST["load_current"]);
		$db->addfield("load_output_vdc");			$db->addvalue($_POST["load_output_vdc"]);
		$db->addfield("alarm_low_float");			$db->addvalue($_POST["alarm_low_float"]);
		$db->addfield("alarm_low_load");			$db->addvalue($_POST["alarm_low_load"]);
		$db->addfield("alarm_high_float");			$db->addvalue($_POST["alarm_high_float"]);
		$db->addfield("alarm_high_load");			$db->addvalue($_POST["alarm_high_load"]);
		$db->addfield("alarm_load_fuse_fail");		$db->addvalue($_POST["alarm_load_fuse_fail"]);
		$db->addfield("alarm_battery_fuse_fail")	;$db->addvalue($_POST["alarm_battery_fuse_fail"]);
		$db->addfield("rectifier_system_vdc");		$db->addvalue($_POST["rectifier_system_vdc"]);
		$db->addfield("rectifier_ipaddr");			$db->addvalue($_POST["rectifier_ipaddr"]);
		$db->addfield("rectifier_subnet");			$db->addvalue($_POST["rectifier_subnet"]);
		$db->addfield("rectifier_gateway");			$db->addvalue($_POST["rectifier_gateway"]);
		$db->addfield("connected_ip");				$db->addvalue($_POST["connected_ip"]);
		$db->addfield("connected_port");			$db->addvalue($_POST["connected_port"]);
		if($atr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if($atr["test_at"] == "") $atr["test_at"] = substr($__now,0,10);
	if($atr["customer"] == "") $atr["customer"] = $db->fetch_single_data("indottech_atd_cover","customer",["id" => $atd_id]);
	if($atr["site_id"] == "") $atr["site_id"] = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
	if($atr["site_address"] == "") $atr["site_address"] = $db->fetch_single_data("indottech_sites","address",["id" => $atr["site_id"]]);
	$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => "13"],["name"],"",true);
?>
<center><h4><b>ACCEPTANCE TEST RECTIFIER</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<table>
		<tr><td>Date</td><td>:</td><td><?=$f->input("test_at",$atr["test_at"],"type='date'");?></td></tr>
		<tr><td>Customer</td><td>:</td><td><?=$f->input("customer",$atr["customer"],"required","classinput");?></td></tr>
		<tr><td>Site</td><td>:</td><td><?=$f->select("site_id",$sites,$atr["site_id"],"required","classinput");?></td></tr>
		<tr><td valign="top">Site Address</td><td valign="top">:</td><td valign="top"><?=$f->textarea("site_address",$atr["site_address"],"required","classinput");?></td></tr>
	</table>
	<br>
	<b style="font-size:11px;">A. RECTIFIER POWER SYSTEM</b>
	<table>
		<tr><td align="right">1.</td><td>Power System</td><td>S/N: <?=$f->input("power_system_sn",$atr["power_system_sn"],"","classinput80");?></td></tr>
		<tr><td align="right">2.</td><td>Sub Rack</td><td>S/N: <?=$f->input("sub_rack_sn",$atr["sub_rack_sn"],"","classinput80");?></td></tr>
		<tr><td align="right">3.</td><td>Supervisory Module<br>(eNatel SM36-00)</td><td>S/N: <?=$f->input("supervisory_modul_sn",$atr["supervisory_modul_sn"],"","classinput80");?></td></tr>
		<tr><td align="right">4.</td><td>Rectifier Module Type :</td><td><?=$f->input("rectifier_module_type",$atr["rectifier_module_type"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>a. Rectifier 1</td><td>S/N: <?=$f->input("rectifier1_sn",$atr["rectifier1_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>b. Rectifier 2</td><td>S/N: <?=$f->input("rectifier2_sn",$atr["rectifier2_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>c. Rectifier 3</td><td>S/N: <?=$f->input("rectifier3_sn",$atr["rectifier3_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>d. Rectifier 4</td><td>S/N: <?=$f->input("rectifier4_sn",$atr["rectifier4_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>e. Rectifier 5</td><td>S/N: <?=$f->input("rectifier5_sn",$atr["rectifier5_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>f. Rectifier 6</td><td>S/N: <?=$f->input("rectifier6_sn",$atr["rectifier6_sn"],"","classinput80");?></td></tr>
		<tr><td>&nbsp;</td><td>g. Rectifier 7</td><td>S/N: <?=$f->input("rectifier7_sn",$atr["rectifier7_sn"],"","classinput80");?></td></tr>
		<tr><td align="right">5.</td><td>AC Input</td><td><?=$f->input("ac_input_vac",$atr["ac_input_vac"],"type='number' step='any'","classinput30");?>VAC<?=$f->input("ac_input_phase",$atr["ac_input_phase"],"","classinput30");?>Phase</td></tr>
		<tr><td align="right">6.</td><td>Output Voltage</td><td><?=$f->input("output_vdc1",$atr["output_vdc1"],"type='number' step='any'","classinput30");?>VDC to <?=$f->input("output_vdc2",$atr["output_vdc2"],"","classinput30");?>VDC</td></tr>
		<tr><td align="right">7.</td><td>Float Voltage</td><td><?=$f->input("float_vdc",$atr["float_vdc"],"type='number' step='any'","classinput30");?>VDC</td></tr>
		<tr><td align="right">8.</td><td>Equalize Voltage</td><td><?=$f->input("equalize_vdc",$atr["equalize_vdc"],"type='number' step='any'","classinput30");?>VDC</td></tr>
		<tr><td align="right">9.</td><td>Polarity</td><td><?=$f->select("polarity",[""=>"","1" => "Positif","2" => "Negatif"],$atr["polarity"]);?></td></tr>
		<tr><td align="right">10.</td><td>Load Test</td><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td>- Load Current</td><td><?=$f->input("load_current",$atr["load_current"],"type='number' step='any'","classinput80");?>A</td></tr>
		<tr><td>&nbsp;</td><td>- Output Voltage</td><td><?=$f->input("load_output_vdc",$atr["load_output_vdc"],"type='number' step='any'","classinput80");?>VDC</td></tr>
		<tr><td align="right">11.</td><td>Alarm Test</td><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td>- Low Float</td><td><?=$f->select("alarm_low_float",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_low_float"]);?></td></tr>
		<tr><td>&nbsp;</td><td>- Low Load</td><td><?=$f->select("alarm_low_load",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_low_load"]);?></td></tr>
		<tr><td>&nbsp;</td><td>- High Float</td><td><?=$f->select("alarm_high_float",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_high_float"]);?></td></tr>
		<tr><td>&nbsp;</td><td>- High Load</td><td><?=$f->select("alarm_high_load",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_high_load"]);?></td></tr>
		<tr><td>&nbsp;</td><td>- Load Fuse Fail</td><td><?=$f->select("alarm_load_fuse_fail",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_load_fuse_fail"]);?></td></tr>
		<tr><td>&nbsp;</td><td>- Battery Fuse Fail</td><td><?=$f->select("alarm_battery_fuse_fail",[""=>"","1" => "Pass","2" => "Fail"],$atr["alarm_battery_fuse_fail"]);?></td></tr>
		<tr><td align="right">12.</td><td>Rectifier System Voltage</td><td><?=$f->input("rectifier_system_vdc",$atr["rectifier_system_vdc"],"type='number' step='any'","classinput80");?>VDC</td></tr>
		<tr><td align="right">13.</td><td>Rectifier NMS</td><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td>IP Address</td><td><?=$f->input("rectifier_ipaddr",$atr["rectifier_ipaddr"],"","classinput60");?></td></tr>
		<tr><td>&nbsp;</td><td>Subnet</td><td><?=$f->input("rectifier_subnet",$atr["rectifier_subnet"],"","classinput60");?></td></tr>
		<tr><td>&nbsp;</td><td>Gateway</td><td><?=$f->input("rectifier_gateway",$atr["rectifier_gateway"],"","classinput60");?></td></tr>
		<tr><td>&nbsp;</td><td>Physical port<br>connected to</td><td><?=$f->input("connected_ip",$atr["connected_ip"],"","classinput60");?> Port: <?=$f->input("connected_port",$atr["connected_port"],"type='number' step='any'","classinput20");?></td></tr>
	</table>
	<br>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
		<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>