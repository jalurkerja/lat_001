<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$my_activity 		= $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["activity_id"]."'")[0];
	$plan_activity 		= $db->fetch_all_data("indottech_plan_activities",[],"id ='".$my_activity["indottech_plan_id"]."'")[0];
	$filename = "activityphoto_".$user_id."_".$my_activity["indottech_plan_id"]."_".$my_activity["plan_site_id"].".jpg";
	if(isset($_POST["save"])){
		$_errormessage="";
		if($_SESSION["sow_activity"]){$sow__new__ids = sel_to_pipe($_SESSION["sow_activity"]);}else{$sow__new__ids = $my_activity["sow_ids"];}
		if($_SESSION["site_activity"]){$site__new__ids = $_SESSION["site_activity"];}else{$site__new__ids = $my_activity["site_id"];}
		$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$site__new__ids."'")[0];
		if(!$_POST["description"]) $_errormessage = "<p style='color:red'>Saving data failed, Please fill description!</p>";
		if($sow__new__ids == "") $_errormessage = "<p style='color:red'>Please select actual SOW</p>";
		if ($_errormessage == ""){
			$db->addtable("attendance_activity");	$db->where("id",$_GET["activity_id"]);
			$db->addfield("site_id"); 				$db->addvalue($site_details["id"]);
			$db->addfield("site_name");				$db->addvalue("[".$site_details["kode"]."] ".$site_details["name"]);
			$db->addfield("attendance_status"); 	$db->addvalue("1");
			$db->addfield("cost_center_id"); 		$db->addvalue($plan_activity["cost_center_id"]);
			$db->addfield("sow_ids"); 				$db->addvalue($sow__new__ids);
			$db->addfield("nopol"); 				$db->addvalue($_POST["nopol"]);
			$db->addfield("description"); 			$db->addvalue($_POST["description"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				$_SESSION["site_activity"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
				exit();
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
	
	if($_POST["save"] OR $inserting["affected_rows"] > 0){
		$sites 				= $db->fetch_select_data("indottech_sites","id","concat('[',kode,'] ',name)","",["kode"],"",true);
		$site_id 			= $f->select("site_id",$sites,$_POST["site_id"],"required style='width:80%'");
		$nopol 				= $f->input("nopol",$_POST["nopol"],"required style='width:80%'","classinput");
		$description 		= $f->textarea("description",$_POST["description"],"style='width:80%;height:80px;'","classinput");
	} else {
		$sites 				= $db->fetch_select_data("indottech_sites","id","concat('[',kode,'] ',name)","",["kode"],"",true);
		$site_id 			= $f->select("site_id",$sites,$my_activity["site_id"],"required style='width:80%'");
		$nopol 				= $f->input("nopol",$my_activity["nopol"],"required style='width:80%'","classinput");
		$description 		= $f->textarea("description",$my_activity["description"],"style='width:80%;height:80px;'","classinput");
	}
	$plan_at 			= format_tanggal($plan_activity["plan_at"],"d-M-Y");
?>
</script>
	<center><h4><b>EDIT AKTIFITAS</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&activity_id=<?=$_GET["activity_id"]?>">
		<table id="data_content" width="100%">
			<tr>
				<td colspan="2"><b>Rencana Dari Kordinator</b></td>
			</tr>
			<tr>
				<td>Project</td><td><?=$plan_activity["cost_center_name"]?></td>
			</tr>
			<tr>
				<td style="width:20%">Tanggal</td><td><?=$plan_at?></td>
			</tr>
			<tr>
				<td>Teams</td>
				<td>
				<?php
					foreach(pipetoarray($plan_activity["user_ids"]) as $user_id){
						$i++;
						$user_name = $db->fetch_single_data("users","name",["id" => $user_id]);
						echo $i.". ".$user_name."<br>";
					}
				?>
				</td>
			</tr>
			<tr>
				<td>SOW</td>
				<td>
				<?php
					foreach(pipetoarray($plan_activity["sow_ids"]) as $sow_id){
						$no++;
						$sow_name = $db->fetch_single_data("indottech_sow","name",["id" => $sow_id]);
						echo $no.". ".$sow_name."<br>";
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Site</td><td><?=$db->fetch_single_data("indottech_sites","concat('[',kode,'] ',name)",["id" => $my_activity["plan_site_id"]]);?></td>
			</tr>
			<tr>
				<td>Kendaraan</td><td><?=$plan_activity["nopol"];?></td>
			</tr>
			<tr>
				<td>Deskripsi</td><td><?=$plan_activity["description"];?></td>
			</tr>
		</table>
		<br>
		<table id="data_content" width="100%">
			<tr>
				<td colspan="2"><b>Aktual Aktifitas</b></td>
			</tr>
			<tr>
				<td style="width:20%">Aktual SOW</td>
				<td>
				<?php
					if($_SESSION["sow_activity"]) {
						foreach($_SESSION["sow_activity"] as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-success");
					} else {
						foreach(pipetoarray($my_activity["sow_ids"]) as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-primary");
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Sitename*</td><td width="50px">
					<?php
						if($_SESSION["site_activity"]) {
						$site_id_detail 	= $db->fetch_all_data("indottech_sites",[],"id ='".$_SESSION["site_activity"]."'")[0];
							echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
							echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-success");
						} else {
							$site_id_detail 	= $db->fetch_all_data("indottech_sites",[],"id ='".$my_activity["site_id"]."'")[0];
							echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
							echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-primary");
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Kendaraan</td><td><?=$nopol;?></td>
			</tr>
			<tr>
				<td>Deskripsi</td><td><?=$description;?></td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<?php 
						if(file_exists("../geophoto/".$filename)){
					?>
							<img onclick="zoomimage('<?=$filename;?>');" src="../geophoto/<?=$filename;?>" width="150">
					<?php } ?>
				</td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_activities.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
<?php include_once "footer.php";?>