<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_02",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_02");
		if($tssr["id"] > 0) 						$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");					$db->addvalue($tssr_id);
		$db->addfield("toco_id");					$db->addvalue($_POST["toco_id"]);
		$db->addfield("owner");						$db->addvalue($_POST["owner"]);
		$db->addfield("other_party");				$db->addvalue($_POST["other_party"]);
		$db->addfield("site_sharing");				$db->addvalue($_POST["site_sharing"]);
		$db->addfield("site_sharing_oth");			$db->addvalue($_POST["site_sharing_oth"]);
		$db->addfield("address");					$db->addvalue($_POST["address"]);
		$db->addfield("area");						$db->addvalue($_POST["area"]);
		$db->addfield("area_other");				$db->addvalue($_POST["area_other"]);
		$db->addfield("existing_height");			$db->addvalue($_POST["existing_height"]);
		$db->addfield("existing");					$db->addvalue(sel_to_pipe($_POST["existing"]));
		$db->addfield("existing_other");			$db->addvalue($_POST["existing_other"]);
		$db->addfield("physical");					$db->addvalue($_POST["physical"]);
		$db->addfield("d_escribe");					$db->addvalue($_POST["describe"]);
		$db->addfield("s_pace");					$db->addvalue($_POST["space"]);
		$db->addfield("bracket");					$db->addvalue($_POST["bracket"]);
		$db->addfield("equipment_colo");			$db->addvalue($_POST["equipment_colo"]);
		$db->addfield("equipment_space");			$db->addvalue($_POST["equipment_space"]);
		$db->addfield("equipment_m");				$db->addvalue($_POST["equipment_m"]);
		$db->addfield("cable");						$db->addvalue($_POST["cable"]);
		$db->addfield("other_comments");			$db->addvalue($_POST["other_comments"]);
		$db->addfield("proposed");					$db->addvalue($_POST["proposed"]);
		$db->addfield("existing_access");			$db->addvalue($_POST["existing_access"]);
		$db->addfield("dim_l");						$db->addvalue($_POST["dim_l"]);
		$db->addfield("dim_m");						$db->addvalue($_POST["dim_m"]);
		$db->addfield("other_important");			$db->addvalue($_POST["other_important"]);
		$db->addfield("sector_1");					$db->addvalue($_POST["sector_1"]);
		$db->addfield("sector_2");					$db->addvalue($_POST["sector_2"]);
		$db->addfield("sector_3");					$db->addvalue($_POST["sector_3"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_02.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	echo $inserting[sql];
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
	$re_width = " style = 'width : 100%';"; $re_width_2 = " style = 'width : 90%';";
	
	foreach(pipetoarray($tssr["existing"]) as $val_1){
		$existing[$val_1] = "checked";
	}
	$site_sharing[$tssr["site_sharing"]] = "checked";
	$area[$tssr["area"]] = "checked";
	$physical[$tssr["physical"]] = "checked";
	$bracket[$tssr["bracket"]] = "checked";
	$equipment_colo[$tssr["equipment_colo"]] = "checked";
	$equipment_space[$tssr["equipment_space"]] = "checked";
	$cable[$tssr["cable"]] = "checked";
	$proposed[$tssr["proposed"]] = "checked";
	$existing_access[$tssr["existing_access"]] = "checked";
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>General Site Sharing information</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>ToCo ID</td>
					<td><?=$f->input("toco_id",$tssr["toco_id"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Principal Owner</td>
					<td><?=$f->input("owner",$tssr["owner"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Other Party</td>
					<td><?=$f->input("other_party",$tssr["other_party"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Site Sharing Use</td>
					<td>
						<?=$f->input("site_sharing","1","style='height:13px;' type='radio' ".$site_sharing[1]);?> BTS<br>
						<?=$f->input("site_sharing","2","style='height:13px;' type='radio' ".$site_sharing[2]);?> UMTS<br>
						<?=$f->input("site_sharing","3","style='height:13px;' type='radio' ".$site_sharing[3]);?> HUB<br>
						<?=$f->input("site_sharing","4","style='height:13px;' type='radio' ".$site_sharing[4]);?> BSC<br>
						<?=$f->input("site_sharing","5","style='height:13px;' type='radio' ".$site_sharing[5]);?> Others<br>
						<?=$f->input("site_sharing_oth",$tssr["site_sharing_oth"],"placeholder='*Isi jika other'".$re_width,"classinput");?>
					</td>
				</tr>
				<tr>
					<td>Candidate Address</td>
					<td><?=$f->textarea("address",$tssr["address"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Area/Location</td>
					<td>
						<?=$f->input("area","1","style='height:13px;' type='radio' ".$area[1]);?> School compound<br>
						<?=$f->input("area","2","style='height:13px;' type='radio' ".$area[2]);?> Hospital/Clinic<br>
						<?=$f->input("area","3","style='height:13px;' type='radio' ".$area[3]);?> Military Compound<br>
						<?=$f->input("area","4","style='height:13px;' type='radio' ".$area[4]);?> Hotel<br>
						<?=$f->input("area","5","style='height:13px;' type='radio' ".$area[5]);?> Residential<br>
						<?=$f->input("area","6","style='height:13px;' type='radio' ".$area[6]);?> Road side<br>
						<?=$f->input("area","7","style='height:13px;' type='radio' ".$area[7]);?> Others<br>
						<?=$f->input("area_other",$tssr["area_other"],"placeholder='*Isi jika other'".$re_width,"classinput");?>
					</td>
				</tr>
				<tr>
					<td>Existing Tower type</td>
					<td>
						<?=$f->input("existing_height",$tssr["existing_height"],"placeholder='Existing Height (m)' type='number'","classinput");?><br>
						<?=$f->input("existing[0]","1","style='height:13px;' type='checkbox' ".$existing[1]);?> 3 Legged tower Height<br>
						&emsp;<?=$f->input("existing[1]","2","style='height:13px;' type='checkbox' ".$existing[2]);?> MD – A/T<br>
						&emsp;<?=$f->input("existing[2]","3","style='height:13px;' type='checkbox' ".$existing[3]);?> HD – A/T<br>
						<?=$f->input("existing[3]","4","style='height:13px;' type='checkbox' ".$existing[4]);?> 4 Legged tower Height<br>
						&emsp;<?=$f->input("existing[4]","5","style='height:13px;' type='checkbox' ".$existing[5]);?> MD – A/T<br>
						&emsp;<?=$f->input("existing[5]","6","style='height:13px;' type='checkbox' ".$existing[6]);?> HD – A/T<br>
						<?=$f->input("existing[6]","7","style='height:13px;' type='checkbox' ".$existing[7]);?> Monopole Height<br>
						<?=$f->input("existing[7]","8","style='height:13px;' type='checkbox' ".$existing[8]);?> Others<br>
						<?=$f->input("existing_other",$tssr["existing_other"],"placeholder='*Isi jika other'".$re_width,"classinput");?>
					</td>
				</tr>
				<tr>
					<td>Physical appearance<br>of the tower</td>
					<td>
						<?=$f->input("physical","1","style='height:13px;' type='radio' ".$physical[1]);?> Good<br>
						<?=$f->input("physical","2","style='height:13px;' type='radio' ".$physical[2]);?> Not Good<br>
					</td>
				</tr>
				<tr>
					<td>Describe</td>
					<td><?=$f->textarea("describe",$tssr["d_escribe"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Height available for Installation <br>of antennas</td>
					<td><?=$f->input("space",$tssr["s_pace"],"placeholder='height (m)' type='number'","classinput");?></td>
				</tr>
				<tr>
					<td>Brackets required</td>
					<td>
						<?=$f->input("bracket","1","style='height:13px;' type='radio' ".$bracket[1]);?> Yes<br>
						<?=$f->input("bracket","2","style='height:13px;' type='radio' ".$bracket[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Collocate with CKD shelter possible</td>
					<td>
						<?=$f->input("equipment_colo","1","style='height:13px;' type='radio' ".$equipment_colo[1]);?> Yes<br>
						<?=$f->input("equipment_colo","2","style='height:13px;' type='radio' ".$equipment_colo[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>If no, space for new outdoor unit Available</td>
					<td>
						<?=$f->input("equipment_space","1","style='height:13px;' type='radio' ".$equipment_space[1]);?> Yes<br>
						<?=$f->input("equipment_space","2","style='height:13px;' type='radio' ".$equipment_space[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Distance from proposed <br>equipment location to the tower</td>
					<td><?=$f->input("equipment_m",$tssr["equipment_m"],"placeholder='height (m)' type='number'","classinput");?></td>
				</tr>
				<tr>
					<td>Cable tray available for usage</td>
					<td>
						<?=$f->input("cable","1","style='height:13px;' type='radio' ".$cable[1]);?> Yes<br>
						<?=$f->input("cable","2","style='height:13px;' type='radio' ".$cable[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Other Comments</td>
					<td><?=$f->textarea("other_comments",$tssr["other_comments"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Proposed equipment</td>
					<td>
						<?=$f->input("proposed","1","style='height:13px;' type='radio' ".$proposed[1]);?> Outdoor unit<br>
						<?=$f->input("proposed","2","style='height:13px;' type='radio' ".$proposed[2]);?> CKD Shelter<br>
						<?=$f->input("proposed","3","style='height:13px;' type='radio' ".$proposed[3]);?> Indoor room<br>
					</td>
				</tr>
				<tr>
					<td>Existing Access road</td>
					<td>
						<?=$f->input("existing_access","1","style='height:13px;' type='radio' ".$existing_access[1]);?> Yes<br>
						<?=$f->input("existing_access","2","style='height:13px;' type='radio' ".$existing_access[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Dimension</td>
					<td>
						<?=$f->input("dim_l",$tssr["dim_l"],"placeholder='Length (m)' type='number'","classinput");?><br>
						<?=$f->input("dim_m",$tssr["dim_m"],"placeholder='Width (m)' type='number'","classinput");?><br>
					</td>
				</tr>
				<tr>
					<td>Other important information</td>
					<td><?=$f->textarea("other_important",$tssr["other_important"],"","classinput");?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding: 5 0 5 0;"><center><b>Objective Coverage</b></center></td>
				</tr>
				<tr>
					<td>Sector 1</td>
					<td><?=$f->textarea("sector_1",$tssr["sector_1"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Sector 2</td>
					<td><?=$f->textarea("sector_2",$tssr["sector_2"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Sector 3</td>
					<td><?=$f->textarea("sector_3",$tssr["sector_3"],"","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_01.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
			<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=02\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_03.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#toco_id").focus(); </script>
<?php include_once "footer.php";?>