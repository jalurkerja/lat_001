<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$atr = $db->fetch_all_data("indottech_acceptance_test_rectifier",[],"atd_id='".$atd_id."'")[0];
	$no_of_bank = $atr["battery_no_of_bank"];
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
?>
<center><h4><b>BATTERY SERIAL NUMBER AND VOLTAGE AFTER 30 MINUTES ATP</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<?php 
		for($yy = 0;$yy < $no_of_bank; $yy++){
			$load_current = $db->fetch_single_data("indottech_battery_discharge","load_current",["atd_id"=>$atd_id, "bank_no" => $yy]);
	?>
		<b>Battery Bank : <?=($yy+1);?></b>
		<table id="data_content">
			<tr> <th>Batt No</th> <th>Serial Number</th> <th>VOLTAGE AFTER 30 MINUTES</th> </tr>
			<?php 
				for($xx = 0;$xx < 4;$xx++){
					$battery_discharge_id = $db->fetch_single_data("indottech_battery_discharge","id",["atd_id"=>$atd_id, "bank_no" => $yy,"batt_no" => $xx,"minute_at" => "30"]);
					$serialnumber = $db->fetch_single_data("indottech_battery_discharge_photos","serialnumber",["battery_discharge_id" => $battery_discharge_id,"atd_id" => $atd_id]);
					$voltmeter = $db->fetch_single_data("indottech_battery_discharge_photos","voltmeter",["battery_discharge_id" => $battery_discharge_id,"atd_id" => $atd_id]);
					if($serialnumber == "") $serialnumber = "nophoto.png";
					if($voltmeter == "") $voltmeter = "nophoto.png";
			?>
				<tr>
					<td align="right"><?=($xx+1);?></td>
					<td align="center">
						<img onclick="zoomimage('<?=$serialnumber;?>');" src="../geophoto/<?=$serialnumber;?>" width="100">
						<br><input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$token;?>&atd_id=<?=$atd_id;?>&takephoto=serialnumber|<?=$atd_id;?>|<?=$battery_discharge_id;?>';">
					</td>
					<td align="center">
						<img onclick="zoomimage('<?=$voltmeter;?>');" src="../geophoto/<?=$voltmeter;?>" width="100">
						<br><input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$token;?>&atd_id=<?=$atd_id;?>&takephoto=voltmeter|<?=$atd_id;?>|<?=$battery_discharge_id;?>';">
					</td>
					<td></td>
				</tr>
			<?php } ?>
		<table>
		<hr>
	<?php } ?>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>