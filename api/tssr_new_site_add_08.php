<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_08_ps",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_08_ps");
		if($tssr["id"] > 0) 						$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");					$db->addvalue($tssr_id);
		$db->addfield("installation");				$db->addvalue($_POST["installation"]);
		$db->addfield("additional");				$db->addvalue($_POST["additional"]);
		$db->addfield("power_cable");				$db->addvalue($_POST["power_cable"]);
		$db->addfield("length");					$db->addvalue($_POST["length"]);
		$db->addfield("ground");					$db->addvalue($_POST["ground"]);
		$db->addfield("ground_spec");				$db->addvalue($_POST["ground_spec"]);
		$db->addfield("ground_length");				$db->addvalue($_POST["ground_length"]);
		$db->addfield("distance");					$db->addvalue($_POST["distance"]);
		$db->addfield("capacity");					$db->addvalue($_POST["capacity"]);
		$db->addfield("num_poles");					$db->addvalue($_POST["num_poles"]);
		$db->addfield("any_private");				$db->addvalue($_POST["any_private"]);
		$db->addfield("type_supply");				$db->addvalue($_POST["type_supply"]);
		$db->addfield("spare_breaker");				$db->addvalue($_POST["spare_breaker"]);
		$db->addfield("length_power");				$db->addvalue($_POST["length_power"]);
		$db->addfield("length_cable");				$db->addvalue($_POST["length_cable"]);
		$db->addfield("demolition");				$db->addvalue($_POST["demolition"]);
		$db->addfield("spec_type");					$db->addvalue($_POST["spec_type"]);
		$db->addfield("explain_generator");			$db->addvalue($_POST["explain_generator"]);
		$db->addfield("distance_proposed");			$db->addvalue($_POST["distance_proposed"]);
		$db->addfield("soundproof");				$db->addvalue($_POST["soundproof"]);
		$db->addfield("available");					$db->addvalue($_POST["available"]);
		$db->addfield("available_other");			$db->addvalue($_POST["available_other"]);
		$db->addfield("other_important");			$db->addvalue($_POST["other_important"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_08.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
		echo $inserting[sql];
	}
	$installation[$tssr["installation"]] = "checked";
	$power_cable[$tssr["power_cable"]] = "checked";
	$ground[$tssr["ground"]] = "checked";
	$any_private[$tssr["any_private"]] = "checked";
	$type_supply[$tssr["type_supply"]] = "checked";
	$demolition[$tssr["demolition"]] = "checked";
	$soundproof[$tssr["soundproof"]] = "checked";
	$available[$tssr["available"]] = "checked";
	$background = " style='background:Gainsboro'";
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<center><h5><u>Power Supply</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:5 0 5 0"><b>Connect to PLN:</b></td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Installation of aerial cable allowed:<br>
						<?=$f->input("installation","1","style='height:13px;' type='radio' ".$installation[1]);?> Yes&emsp;
						<?=$f->input("installation","2","style='height:13px;' type='radio' ".$installation[2]);?> No
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Additional poles required to reach the 3 phase supply: <br>Quantity: 
						<?=$f->input("additional",$tssr["additional"],"placeholder='' type='number'  step='any'".$background,"");?> Pcs
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Power cable required to be installed underground:<br>
						<?=$f->input("power_cable","1","style='height:13px;' type='radio' ".$power_cable[1]);?> Yes&emsp;
						<?=$f->input("power_cable","2","style='height:13px;' type='radio' ".$power_cable[2]);?> No
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Length of required underground installation: <br>
						<?=$f->input("length",$tssr["length"],"placeholder='' type='number' step='any'".$background,"");?> m
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Ground condition where cables will pass:<br>
						<?=$f->input("ground_length",$tssr["ground_length"],"placeholder='Length' type='number' step='any'".$background,"");?> m<br>
						<?=$f->input("ground","1","style='height:13px;' type='radio' ".$ground[1]);?> Concrete&emsp;
						<?=$f->input("ground","2","style='height:13px;' type='radio' ".$ground[2]);?> Soil&emsp;
						<?=$f->input("ground","3","style='height:13px;' type='radio' ".$ground[3]);?> Others:
						<?=$f->input("ground_spec",$tssr["ground_spec"],"placeholder='Specify Jika Other' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Distance from the nearest transformer: <br>
						<?=$f->input("distance",$tssr["distance"],"placeholder='' type='number' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Capacity of the PLN Transformer: <br>
						<?=$f->input("capacity",$tssr["capacity"],"placeholder='' type='number' step='any'".$background,"");?> KVA
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Number. of poles required: <br>
						<?=$f->input("num_poles",$tssr["num_poles"],"placeholder='' type='number' step='any'".$background,"");?> pcs
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Any private property which will be affected by<br> pole location and Right of way for the PLN connection:<br>
						<?=$f->input("any_private","1","style='height:13px;' type='radio' ".$any_private[1]);?> Yes&emsp;
						<?=$f->input("any_private","2","style='height:13px;' type='radio' ".$any_private[2]);?> No<br>
						<i>(Please show in the drawing.)</i>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:8 0 5 0"><b>Connect to Building:</b></td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Type of supply available:<br>
						<?=$f->input("type_supply","1","style='height:13px;' type='radio' ".$type_supply[1]);?> single phase&emsp;
						<?=$f->input("type_supply","2","style='height:13px;' type='radio' ".$type_supply[2]);?> three phase
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Spare breakers available for use: <br>(capacity and qty) <br>
						<?=$f->input("spare_breaker",$tssr["spare_breaker"],"placeholder='' step='any'".$background,"");?> 
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Length of power cable from the source <br>to our proposed sub-meter <br>
						<?=$f->input("length_power",$tssr["length_power"],"placeholder='' type='number'  step='any'".$background,"");?> m
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Length of cable from sub meter to ACPDB <br>
						<?=$f->input("length_cable",$tssr["length_cable"],"placeholder='' type='number'  step='any'".$background,"");?> m
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Demolition necessary:<br>
						<?=$f->input("demolition","1","style='height:13px;' type='radio' ".$demolition[1]);?> Yes&emsp;
						<?=$f->input("demolition","2","style='height:13px;' type='radio' ".$demolition[2]);?> No
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Specify type and length <br>
						<?=$f->input("spec_type",$tssr["spec_type"],"placeholder='' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:8 0 5 0"><b>Supply permanent Generator:</b></td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Explain the need for permanent generator <br>
						<?=$f->input("explain_generator",$tssr["explain_generator"],"placeholder='' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Distance of the proposed location from site<br>
						<?=$f->input("distance_proposed",$tssr["distance_proposed"],"placeholder='' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Soundproof required:<br>
						<?=$f->input("soundproof","1","style='height:13px;' type='radio' ".$soundproof[1]);?> Yes&emsp;
						<?=$f->input("soundproof","2","style='height:13px;' type='radio' ".$soundproof[2]);?> No
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Available space:<br>
						<?=$f->input("available","1","style='height:13px;' type='radio' ".$available[1]);?> Rooftop&emsp;
						<?=$f->input("available","2","style='height:13px;' type='radio' ".$available[2]);?> Others
						<?=$f->input("available_other",$tssr["available_other"],"placeholder='Specify Jika Other' step='any'".$background,"");?>
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:8 0 5 0">
					<b>Other important information / special requirement:</b><br>
					<?=$f->textarea("other_important",$tssr["other_important"],"placeholder='Specify Jika Other' step='any' style='width:250px'","");?>
					</td>
				</tr>
				
				
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_07.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_09.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#near_end_site").focus(); </script>
<?php include_once "footer.php";?>