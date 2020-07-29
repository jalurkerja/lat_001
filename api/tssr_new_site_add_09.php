<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_09_gs",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_09_gs");
		if($tssr["id"] > 0) 						$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");					$db->addvalue($tssr_id);
		$db->addfield("grounding");					$db->addvalue($_POST["grounding"]);
		$db->addfield("grounding_available");		$db->addvalue($_POST["grounding_available"]);
		$db->addfield("possibility");				$db->addvalue($_POST["possibility"]);
		$db->addfield("estimed");					$db->addvalue($_POST["estimed"]);
		$db->addfield("demotion");					$db->addvalue($_POST["demotion"]);
		$db->addfield("demotion_spec");				$db->addvalue($_POST["demotion_spec"]);
		$db->addfield("other_important");			$db->addvalue($_POST["other_important"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_09.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
		echo $inserting[sql];
	}
	$grounding[$tssr["grounding"]] = "checked";
	$possibility[$tssr["possibility"]] = "checked";
	$estimed[$tssr["estimed"]] = "checked";
	$demotion[$tssr["demotion"]] = "checked";
	$background = " style='background:Gainsboro'";
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<center><h5><u>Grounding System</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Grounding System Available:<br>
						<?=$f->input("grounding","1","style='height:13px;' type='radio' ".$grounding[1]);?> Yes&emsp;
						<?=$f->input("grounding","2","style='height:13px;' type='radio' ".$grounding[2]);?> No<br>
						Reading of available grounding (Existing) <?=$f->input("grounding_available",$tssr["grounding_available"],"placeholder='' type='number'  step='any'".$background,"");?> ohms
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Possibility to connect with existing grounding (please discuss with owner):<br>
						<?=$f->input("possibility","1","style='height:13px;' type='radio' ".$possibility[1]);?> Yes&emsp;
						<?=$f->input("possibility","2","style='height:13px;' type='radio' ".$possibility[2]);?> No
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Estimated length of exposed (yellow green) grounding cable required: <br>
						<?=$f->input("estimed",$tssr["estimed"],"placeholder='' type='number'  step='any'".$background,"");?> m
					</td>
				</tr>
				<tr>
					<td colspan="2" Align="Left">
						Demolition required for the installation of the copper rods:<br>
						<?=$f->input("demotion","1","style='height:13px;' type='radio' ".$demotion[1]);?> Yes (specify type and qty)
						<?=$f->input("demotion_spec",$tssr["demotion_spec"],"placeholder=''  step='any'".$background,"");?> &emsp;
						<?=$f->input("demotion","2","style='height:13px;' type='radio' ".$demotion[2]);?> No
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
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_08.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=09\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_10.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#near_end_site").focus(); </script>
<?php include_once "footer.php";?>