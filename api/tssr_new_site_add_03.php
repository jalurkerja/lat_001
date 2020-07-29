<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$Information 	= ["support","noa","size","beam","gain","frequency","model","height","azimuth","mdt","edt","totalTilting","feederSize","feederLength"];
	$sectored 		= ["2G","3G","LTE"];
	$sub_sectored 	= ["1","2","3"];
	$tssr 			= $db->fetch_all_data("indottech_tssr_03_rnp",[],"tssr_id='".$tssr_id."'")[0];
	$tssr_val		= array();
	foreach($Information as $key => $info){
		foreach($sectored as $_key => $sector){
			foreach($sub_sectored as $__key => $sub_sector){
				$xx = $db->fetch_single_data("indottech_tssr_03_rnp","value",["tssr_id" => $tssr_id, "information" => $info, "sectored" => $sector, "sub_sectored" => $sub_sector]);
				$tssr_val[$info."_".$sector."_".$sub_sector] = $xx;
			}
		}
	}

	if(isset($_POST["save"])){
		if($tssr["id"] > 0) {
			$db->addtable("indottech_tssr_03_rnp");
			$db->where("tssr_id",$tssr_id);
			$db->delete_();
		}
		
		foreach($Information as $key => $info){
			foreach($sectored as $_key => $sector){
				foreach($sub_sectored as $__key => $sub_sector){
					$db->addtable("indottech_tssr_03_rnp");
					$db->addfield("tssr_id");					$db->addvalue($tssr_id);
					$db->addfield("information");				$db->addvalue($info);
					$db->addfield("sectored");					$db->addvalue($sector);
					$db->addfield("sub_sectored");				$db->addvalue($sub_sector);
					$db->addfield("value");						$db->addvalue($_POST[$info."_".$sector."_".$sub_sector]);
					$inserting = $db->insert();
				}
			}
		}
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_03.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>Radio Network Planning</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td rowspan="2" align="center">Information</td>
					<td colspan="3" align="center"> Sectored 2G</td>
					<td colspan="3" align="center"> Sectored 3G</td>
					<td colspan="3" align="center"> Sectored LTE</td>
				</tr>
				<tr>
					<td align="center">Sec1</td>
					<td align="center">Sec2</td>
					<td align="center">Sec3</td>
					<td align="center">Sec1</td>
					<td align="center">Sec2</td>
					<td align="center">Sec3</td>
					<td align="center">Sec1</td>
					<td align="center">Sec2</td>
					<td align="center">Sec3</td>
				</tr>
				<tr>
					<td>Support/pole no.</td>
					<td align="center"><?=$f->input("support_2G_1",$tssr_val["support_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_2G_2",$tssr_val["support_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_2G_3",$tssr_val["support_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_3G_1",$tssr_val["support_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_3G_2",$tssr_val["support_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_3G_3",$tssr_val["support_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_LTE_1",$tssr_val["support_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_LTE_2",$tssr_val["support_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("support_LTE_3",$tssr_val["support_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Number of antennas</td>
					<td align="center"><?=$f->input("noa_2G_1",$tssr_val["noa_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_2G_2",$tssr_val["noa_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_2G_3",$tssr_val["noa_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_3G_1",$tssr_val["noa_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_3G_2",$tssr_val["noa_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_3G_3",$tssr_val["noa_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_LTE_1",$tssr_val["noa_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_LTE_2",$tssr_val["noa_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("noa_LTE_3",$tssr_val["noa_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Size<br>(HxWxD)</td>
					<td align="center"><?=$f->input("size_2G_1",$tssr_val["size_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_2G_2",$tssr_val["size_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_2G_3",$tssr_val["size_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_3G_1",$tssr_val["size_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_3G_2",$tssr_val["size_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_3G_3",$tssr_val["size_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_LTE_1",$tssr_val["size_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_LTE_2",$tssr_val["size_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("size_LTE_3",$tssr_val["size_LTE_3"],"step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Beam Width<br>(Horizontal)</td>
					<td align="center"><?=$f->input("beam_2G_1",$tssr_val["beam_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_2G_2",$tssr_val["beam_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_2G_3",$tssr_val["beam_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_3G_1",$tssr_val["beam_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_3G_2",$tssr_val["beam_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_3G_3",$tssr_val["beam_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_LTE_1",$tssr_val["beam_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_LTE_2",$tssr_val["beam_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("beam_LTE_3",$tssr_val["beam_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Gain<br>(dBi)</td>
					<td align="center"><?=$f->input("gain_2G_1",$tssr_val["gain_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_2G_2",$tssr_val["gain_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_2G_3",$tssr_val["gain_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_3G_1",$tssr_val["gain_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_3G_2",$tssr_val["gain_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_3G_3",$tssr_val["gain_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_LTE_1",$tssr_val["gain_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_LTE_2",$tssr_val["gain_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("gain_LTE_3",$tssr_val["gain_LTE_3"],"step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Frequency</td>
					<td align="center"><?=$f->input("frequency_2G_1",$tssr_val["frequency_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_2G_2",$tssr_val["frequency_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_2G_3",$tssr_val["frequency_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_3G_1",$tssr_val["frequency_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_3G_2",$tssr_val["frequency_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_3G_3",$tssr_val["frequency_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_LTE_1",$tssr_val["frequency_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_LTE_2",$tssr_val["frequency_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("frequency_LTE_3",$tssr_val["frequency_LTE_3"],"step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Manufacture<br>/ Model</td>
					<td align="center"><?=$f->input("model_2G_1",$tssr_val["model_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_2G_2",$tssr_val["model_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_2G_3",$tssr_val["model_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_3G_1",$tssr_val["model_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_3G_2",$tssr_val["model_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_3G_3",$tssr_val["model_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_LTE_1",$tssr_val["model_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_LTE_2",$tssr_val["model_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("model_LTE_3",$tssr_val["model_LTE_3"],"step='any' ","");?></td>
				</tr>
				<tr>
					<td>Antenna Height</td>
					<td align="center"><?=$f->input("height_2G_1",$tssr_val["height_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_2G_2",$tssr_val["height_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_2G_3",$tssr_val["height_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_3G_1",$tssr_val["height_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_3G_2",$tssr_val["height_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_3G_3",$tssr_val["height_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_LTE_1",$tssr_val["height_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_LTE_2",$tssr_val["height_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("height_LTE_3",$tssr_val["height_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Azimuth</td>
					<td align="center"><?=$f->input("azimuth_2G_1",$tssr_val["azimuth_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_2G_2",$tssr_val["azimuth_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_2G_3",$tssr_val["azimuth_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_3G_1",$tssr_val["azimuth_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_3G_2",$tssr_val["azimuth_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_3G_3",$tssr_val["azimuth_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_LTE_1",$tssr_val["azimuth_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_LTE_2",$tssr_val["azimuth_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("azimuth_LTE_3",$tssr_val["azimuth_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Mechanical Tilt<br>(MDT)</td>
					<td align="center"><?=$f->input("mdt_2G_1",$tssr_val["mdt_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_2G_2",$tssr_val["mdt_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_2G_3",$tssr_val["mdt_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_3G_1",$tssr_val["mdt_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_3G_2",$tssr_val["mdt_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_3G_3",$tssr_val["mdt_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_LTE_1",$tssr_val["mdt_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_LTE_2",$tssr_val["mdt_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("mdt_LTE_3",$tssr_val["mdt_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Electrical Tilt<br>(EDT)</td>
					<td align="center"><?=$f->input("edt_2G_1",$tssr_val["edt_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_2G_2",$tssr_val["edt_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_2G_3",$tssr_val["edt_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_3G_1",$tssr_val["edt_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_3G_2",$tssr_val["edt_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_3G_3",$tssr_val["edt_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_LTE_1",$tssr_val["edt_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_LTE_2",$tssr_val["edt_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("edt_LTE_3",$tssr_val["edt_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Total Tilting</td>
					<td align="center"><?=$f->input("totalTilting_2G_1",$tssr_val["totalTilting_2G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_2G_2",$tssr_val["totalTilting_2G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_2G_3",$tssr_val["totalTilting_2G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_3G_1",$tssr_val["totalTilting_3G_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_3G_2",$tssr_val["totalTilting_3G_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_3G_3",$tssr_val["totalTilting_3G_3"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_LTE_1",$tssr_val["totalTilting_LTE_1"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_LTE_2",$tssr_val["totalTilting_LTE_2"],"type='number' step='any' ","");?></td>
					<td align="center"><?=$f->input("totalTilting_LTE_3",$tssr_val["totalTilting_LTE_3"],"type='number' step='any' ","");?></td>
				</tr>
				<tr>
					<td>Feeder size<br>/type</td>
					<td align="center"><?=$f->input("feederSize_2G_1",$tssr_val["feederSize_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_2G_2",$tssr_val["feederSize_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_2G_3",$tssr_val["feederSize_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_3G_1",$tssr_val["feederSize_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_3G_2",$tssr_val["feederSize_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_3G_3",$tssr_val["feederSize_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_LTE_1",$tssr_val["feederSize_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_LTE_2",$tssr_val["feederSize_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederSize_LTE_3",$tssr_val["feederSize_LTE_3"],"step='any' ","");?></td>
				</tr>
				<tr>
					<td>Feeder length<br>/Feeder Less</td>
					<td align="center"><?=$f->input("feederLength_2G_1",$tssr_val["feederLength_2G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_2G_2",$tssr_val["feederLength_2G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_2G_3",$tssr_val["feederLength_2G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_3G_1",$tssr_val["feederLength_3G_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_3G_2",$tssr_val["feederLength_3G_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_3G_3",$tssr_val["feederLength_3G_3"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_LTE_1",$tssr_val["feederLength_LTE_1"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_LTE_2",$tssr_val["feederLength_LTE_2"],"step='any' ","");?></td>
					<td align="center"><?=$f->input("feederLength_LTE_3",$tssr_val["feederLength_LTE_3"],"step='any' ","");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_02.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_04.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#support_2G_1").focus(); </script>
<?php include_once "footer.php";?>