<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$atr = $db->fetch_all_data("indottech_acceptance_test_rectifier",[],"atd_id='".$atd_id."'")[0];
	$battery_discharge = $db->fetch_all_data("indottech_battery_discharge",[],"atd_id='".$atd_id."'");
	
	if(isset($_POST["save"])){
		// $db->addtable("indottech_battery_discharge"); $db->where("atd_id",$atd_id); $db->delete_();
		$is_any_failed = 0;
		foreach($_POST["val"] as $bank_no => $batteries){
			foreach($batteries as $batt_no => $vals){
				foreach($vals as $minute_at => $val){
					$battery_discharge_id = $db->fetch_single_data("indottech_battery_discharge","id",["atd_id"=>$atd_id, "bank_no" => $bank_no,"batt_no" => $batt_no,"minute_at" => $minute_at]);
					$db->addtable("indottech_battery_discharge");
					if($battery_discharge_id > 0) $db->where("id",$battery_discharge_id);
					$db->addfield("atd_id");		$db->addvalue($atd_id);
					$db->addfield("load_current");	$db->addvalue($_POST["load_current"][$bank_no]);
					$db->addfield("bank_no");		$db->addvalue($bank_no);
					$db->addfield("batt_no");		$db->addvalue($batt_no);
					$db->addfield("minute_at");		$db->addvalue($minute_at);
					$db->addfield("val");			$db->addvalue($val);
					if($battery_discharge_id > 0) $inserting = $db->update(); else $inserting = $db->insert();
					if($inserting["affected_rows"] <= 0) $is_any_failed++;
				}
			}
		}
		if($is_any_failed == 0){
			javascript("window.location=\"atp_installation_battery_photo.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	$no_of_bank = $atr["battery_no_of_bank"];
?>
<center><h4><b>BATTERY DISCHARGE TEST TABLE</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<?php 
		for($yy = 0;$yy < $no_of_bank; $yy++){ 
			$load_current = $db->fetch_single_data("indottech_battery_discharge","load_current",["atd_id"=>$atd_id, "bank_no" => $yy]);
	?>
		<table width="100%">
			<tr><td>Load Current</td><td><?=$f->input("load_current[".$yy."]",$load_current,"","classinput60");?>A</td></tr>
			<tr><td>Battery Bank</td><td><?=($yy+1);?></td></tr>
		</table>
		<table id="data_content">
			<tr> <th>Batt No</th> <th>0</th> <th>30</th> <th>60</th> <th>90</th> <th>120</th> <th>150</th> <th>180</th> </tr>
			<?php 
				for($xx = 0;$xx < 4;$xx++){ 
					$val[$yy][$xx]["0"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "0"]);
					$val[$yy][$xx]["30"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "30"]);
					$val[$yy][$xx]["60"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "60"]);
					$val[$yy][$xx]["90"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "90"]);
					$val[$yy][$xx]["120"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "120"]);
					$val[$yy][$xx]["150"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "150"]);
					$val[$yy][$xx]["180"] = $db->fetch_single_data("indottech_battery_discharge","val",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "180"]);
			?>
				<tr>
					<td align="right"><?=($xx+1);?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][0]",$val[$yy][$xx]["0"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][30]",$val[$yy][$xx]["30"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][60]",$val[$yy][$xx]["60"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][90]",$val[$yy][$xx]["90"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][120]",$val[$yy][$xx]["120"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][150]",$val[$yy][$xx]["150"],"type='number' step='any'","classinput");?></td>
					<td><?=$f->input("val[".$yy."][".$xx."][180]",$val[$yy][$xx]["180"],"type='number' step='any'","classinput");?></td>
				</tr>
			<?php } ?>
		<table>
		<hr>
	<?php } ?>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
		<td align="right"><?=$f->input("save","Next To Voltage Photo","type='submit'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>