	<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$atr = $db->fetch_all_data("indottech_acceptance_test_rectifier",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_acceptance_test_rectifier");
		if($atr["id"] > 0) 							$db->where("id",$atr["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("battery_type");				$db->addvalue($_POST["battery_type"]);
		$db->addfield("battery_capacity");			$db->addvalue($_POST["battery_capacity"]);
		$db->addfield("battery_voltage_per_block");	$db->addvalue($_POST["battery_voltage_per_block"]);
		$db->addfield("battery_no_of_bank");		$db->addvalue($_POST["battery_no_of_bank"]);
		$db->addfield("battery_charging_rate");		$db->addvalue($_POST["battery_charging_rate"]);
		
		if($atr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("window.location=\"atp_installation_battery_table.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
?>
<center><h4><b>BATTERY</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<table width="100%">
		<tr><td align="right">1.</td><td>Battery Type</td><td><?=$f->input("battery_type",$atr["battery_type"],"","classinput");?></td></tr>
		<tr><td align="right">2.</td><td>Capacity</td><td><?=$f->input("battery_capacity",$atr["battery_capacity"],"","classinput");?></td></tr>
		<tr><td align="right">3.</td><td>Voltage per Block</td><td><?=$f->input("battery_voltage_per_block",$atr["battery_voltage_per_block"],"","classinput");?></td></tr>
		<tr><td align="right">4.</td><td>No of Bank</td><td><?=$f->input("battery_no_of_bank",$atr["battery_no_of_bank"],"type='number'","classinput");?></td></tr>
		<tr><td align="right">5.</td><td>Charging rate</td><td><?=$f->input("battery_charging_rate",$atr["battery_charging_rate"],"","classinput");?></td></tr>
	</table>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
		<td align="right"><?=$f->input("save","Next To Discharge Test Table","type='submit'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>