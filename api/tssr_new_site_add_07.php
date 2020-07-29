<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_07_cme",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_07_cme");
		if($tssr["id"] > 0) 						$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");					$db->addvalue($tssr_id);
		$db->addfield("type_site");					$db->addvalue($_POST["type_site"]);
		$db->addfield("tower_type");				$db->addvalue($_POST["tower_type"]);
		$db->addfield("existing");					$db->addvalue($_POST["existing"]);
		$db->addfield("existing_m");				$db->addvalue($_POST["existing_m"]);
		$db->addfield("existing_other");			$db->addvalue($_POST["existing_other"]);
		$db->addfield("tower_lll");					$db->addvalue($_POST["tower_lll"]);
		$db->addfield("tower_wl");					$db->addvalue($_POST["tower_wl"]);
		$db->addfield("tower_dia");					$db->addvalue($_POST["tower_dia"]);
		$db->addfield("physical");					$db->addvalue($_POST["physical"]);
		$db->addfield("physical_des");				$db->addvalue($_POST["physical_des"]);
		$db->addfield("space_outdoor");				$db->addvalue($_POST["space_outdoor"]);
		$db->addfield("space_outdoor_comp");		$db->addvalue($_POST["space_outdoor_comp"]);
		$db->addfield("space_indoor");				$db->addvalue($_POST["space_indoor"]);
		$db->addfield("space_indoor_comp");			$db->addvalue($_POST["space_indoor_comp"]);
		$db->addfield("horisontal");				$db->addvalue($_POST["horisontal"]);
		$db->addfield("vertical");					$db->addvalue($_POST["vertical"]);
		$db->addfield("other");						$db->addvalue($_POST["other"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_07.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	$type_site[$tssr["type_site"]] = "checked";
	$tower_type[$tssr["tower_type"]] = "checked";
	$existing[$tssr["existing"]] = "checked";
	$physical[$tssr["physical"]] = "checked";
	$space_outdoor_comp[$tssr["space_outdoor_comp"]] = "checked";
	$space_indoor_comp[$tssr["space_indoor_comp"]] = "checked";
	$horisontal[$tssr["horisontal"]] = "checked";
	$vertical[$tssr["vertical"]] = "checked";
	
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<center><h5><u>Civil Mechanical and Electrical</u></h5></center>
			<table align="center" border="1">
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Type of Site</td>
					<td>
						<?=$f->input("type_site","1","style='height:13px;' type='radio' ".$type_site[1]);?> Greenfield<br>
						<?=$f->input("type_site","2","style='height:13px;' type='radio' ".$type_site[2]);?> Rooftop<br>
					</td>
				</tr>
				<tr>
					<td>Tower Type</td>
					<td>
						<?=$f->input("tower_type","1","style='height:13px;' type='radio' ".$tower_type[1]);?> Angular<br>
						<?=$f->input("tower_type","2","style='height:13px;' type='radio' ".$tower_type[2]);?> Tubular<br>
					</td>
				</tr>
				<tr>
					<td>Existing tower<br>type and height</td>
					<td>
						<?=$f->input("existing_m",$tssr["existing_m"],"placeholder='height (m)' step='any'","classinput");?><br>
						<?=$f->input("existing","1","style='height:13px;' type='radio' ".$existing[1]);?> 3 Legged tower<br>
						<?=$f->input("existing","2","style='height:13px;' type='radio' ".$existing[2]);?> 4 Legged tower<br>
						<?=$f->input("existing","3","style='height:13px;' type='radio' ".$existing[3]);?> Monopole<br>
						<?=$f->input("existing","4","style='height:13px;' type='radio' ".$existing[4]);?> Guyed pole<br>
						<?=$f->input("existing","5","style='height:13px;' type='radio' ".$existing[5]);?> Other<br>
						&emsp;<?=$f->input("existing_other",$tssr["existing_other"],"placeholder='Jika Other' step='any'","");?>
					</td>
				</tr>
				<tr>
					<td>Tower Leg<br>Measurement</td>
					<td>
						<?=$f->input("tower_lll",$tssr["tower_lll"],"placeholder='LxLxL' step='any'","classinput");?><br>
						<?=$f->input("tower_wl",$tssr["tower_wl"],"placeholder='WxL' step='any'","classinput");?><br>
						<?=$f->input("tower_dia",$tssr["tower_dia"],"placeholder='Diameter' step='any'","classinput");?><br>
					</td>
				</tr>
				<tr>
					<td>Physical appearance <br>of the tower</td>
					<td>
						<?=$f->input("physical","1","style='height:13px;' type='radio' ".$physical[1]);?> Good<br>
						<?=$f->input("physical","2","style='height:13px;' type='radio' ".$physical[2]);?> Not Good<br>
					</td>
				</tr>
				<tr>
					<td>Describe</td>
					<td>
						<?=$f->input("physical_des",$tssr["physical_des"],"step='any'","classinput");?><br>
					</td>
				</tr>
				<tr>
					<td>Space available <br>onsite - Outdoor</td>
					<td>
						<?=$f->input("space_outdoor",$tssr["space_outdoor"],"placeholder='WxL' step='any'","classinput");?><br>
					</td>
				</tr>
				<tr>
					<td>Space avail compare <br>with standard design </td>
					<td>
						<?=$f->input("space_outdoor_comp","1","style='height:13px;' type='radio' ".$space_outdoor_comp[1]);?> Yes<br>
						<?=$f->input("space_outdoor_comp","2","style='height:13px;' type='radio' ".$space_outdoor_comp[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Space available <br>onsite - Indoor</td>
					<td>
						<?=$f->input("space_indoor",$tssr["space_indoor"],"placeholder='WxL' step='any'","classinput");?><br>
					</td>
				</tr>
				<tr>
					<td>Space avail compare <br>with standard design </td>
					<td>
						<?=$f->input("space_indoor_comp","1","style='height:13px;' type='radio' ".$space_indoor_comp[1]);?> Yes<br>
						<?=$f->input("space_indoor_comp","2","style='height:13px;' type='radio' ".$space_indoor_comp[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Horisontal Cable <br>tray</td>
					<td>
						<?=$f->input("horisontal","1","style='height:13px;' type='radio' ".$horisontal[1]);?> Yes<br>
						<?=$f->input("horisontal","2","style='height:13px;' type='radio' ".$horisontal[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Vertical Cable <br>tray</td>
					<td>
						<?=$f->input("vertical","1","style='height:13px;' type='radio' ".$vertical[1]);?> Yes<br>
						<?=$f->input("vertical","2","style='height:13px;' type='radio' ".$vertical[2]);?> No<br>
					</td>
				</tr>
				<tr>
					<td>Other Comments</td>
					<td>
						<?=$f->input("other",$tssr["other"],"placeholder='WxL' step='any'","classinput");?><br>
					</td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_06.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_08.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#near_end_site").focus(); </script>
<?php include_once "footer.php";?>