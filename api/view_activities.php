<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	if(strpos($_GET["plan_id"],"|") > 0){
		$params = explode("|",$_GET["plan_id"]);
		$_GET["plan_id"] = $params[0];
		$_GET["plan_site_id"] = $params[1];
	}
	$activity = $db->fetch_all_data("indottech_plan_activities",[],"id ='".$_GET["plan_id"]."'")[0];
	
	$filename = "activityphoto_".$user_id."_".$_GET["plan_id"]."_".$_GET["plan_site_id"].".jpg";
	if(isset($_POST["save"])){
		if($_SESSION["sow_activity"]){$sow_new_id = sel_to_pipe($_SESSION["sow_activity"]);}else{$sow_new_id = $activity["sow_ids"];}
		if($_SESSION["site_activity"]){$site_new_id = $_SESSION["site_activity"];}else{$site_new_id = $_GET["plan_site_id"];}
		$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$site_new_id."'")[0];
		
		$_errormessage="";
		if(!file_exists("../geophoto/".$filename)) $_errormessage = "<p style='color:red'>Please Take Photo!</p>";
		if($site_new_id == "") $_errormessage = "<p style='color:red'>Penyimpanan gagal silahkan pilih site terlebih dahulu!</p>";
		if($sow_new_id == "") $_errormessage = "<p style='color:red'>Penyimpanan gagal silahkan pilih SOW terlebih dahulu</p>";
		if ($_errormessage == ""){
			$attendance_id = $db->fetch_single_data("attendance","id",["user_id" => $user_id,"tap_time" => date("Y-m-d")."%:LIKE", "in_out" => "in"],["tap_time desc"]);
			$db->addtable("attendance_activity");
			$db->addfield("attendance_id"); 		$db->addvalue($attendance_id);
			$db->addfield("indottech_plan_id"); 	$db->addvalue($_GET["plan_id"]);
			$db->addfield("plan_site_id"); 			$db->addvalue($_GET["plan_site_id"]);
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("site_id"); 				$db->addvalue($site_details["id"]);
			$db->addfield("site_name");				$db->addvalue("[".$site_details["kode"]."] ".$site_details["name"]);
			$db->addfield("attendance_status"); 	$db->addvalue("1");
			$db->addfield("cost_center_id"); 		$db->addvalue($activity["cost_center_id"]);
			$db->addfield("sow_ids"); 				$db->addvalue($sow_new_id);
			$db->addfield("nopol"); 				$db->addvalue($_POST["nopol"]);
			$db->addfield("description"); 			$db->addvalue($_POST["description"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				$_SESSION["site_activity"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
	$nopol 			= $f->input("nopol",$activity["nopol"],"required style='width:80%'","classinput");
	$description 	= $f->textarea("description",$_POST["description"],"style='width:80%;height:80px;' required","classinput");
	$plan_at 		= format_tanggal($activity["plan_at"],"d-M-Y");
?>
	<center><h4><b>AKTIFITAS HARI INI</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&plan_id=<?=$_GET["plan_id"]?>&plan_site_id=<?=$_GET["plan_site_id"]?>">
		<table id="data_content" width="100%">
			<tr>
				<td colspan="2"><b>Rencana Dari Kordinator</b></td>
			</tr>
			<tr>
				<td>Project</td><td><?=$activity["cost_center_name"]?></td>
			</tr>
			<tr>
				<td style="width:20%">Tanggal</td><td><?=$plan_at?></td>
			</tr>
			<tr>
				<td>Teams</td>
				<td>
				<?php
					foreach(pipetoarray($activity["user_ids"]) as $_team_user_id){
						$i++;
						$user_name = $db->fetch_single_data("users","name",["id" => $_team_user_id]);
						echo $i.". ".$user_name."<br>";
					}
				?>
				</td>
			</tr>
			<tr>
				<td>SOW</td>
				<td>
				<?php
					foreach(pipetoarray($activity["sow_ids"]) as $sow_id){
						$no++;
						$sow_name = $db->fetch_single_data("indottech_sow","name",["id" => $sow_id]);
						echo $no.". ".$sow_name."<br>";
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Site</td><td><?=$db->fetch_single_data("indottech_sites","concat('[',kode,'] ',name)",["id" => $_GET["plan_site_id"]]);?></td>
			</tr>
			<tr>
				<td>Kendaraan</td><td><?=$activity["nopol"];?></td>
			</tr>
			<tr>
				<td>Deskripsi</td><td><?=$activity["description"];?></td>
			</tr>
		</table>
		<br>
		<table id="data_content" width="100%">
			<?php 
				if(file_exists("../geophoto/".$filename)){
			?>
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
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&plan_id=".$_GET["plan_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-success");
						} else {
							foreach(pipetoarray($activity["sow_ids"]) as $key_sow => $sow_id){
								$_i++;
								$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
								echo $_i.". ".$sow_id_detail["name"]."<br>";
							}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&plan_id=".$_GET["plan_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-primary");
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
							echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&plan_id=".$_GET["plan_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-success");
						} else {
							$site_id_detail 	= $db->fetch_all_data("indottech_sites",[],"id ='".$_GET["plan_site_id"]."'")[0];
							echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
							echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&plan_id=".$_GET["plan_id"]."&plan_site_id=".$_GET["plan_site_id"]."\";'","btn btn-primary");
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
					<img onclick="zoomimage('<?=$filename;?>');" src="../geophoto/<?=$filename;?>" width="150">
			<?php 
			} else {
						echo "<center><p style='color:red;'>Mohon Take photo anda terlebih dahulu!</p></center>";
					} 
			?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$_GET["token"];?>&plan_id=<?=$_GET["plan_id"];?>&plan_site_id=<?=$_GET["plan_site_id"];?>&takeactivityphoto=<?=$_GET["plan_id"];?>|<?=$_GET["plan_site_id"];?>';">
				</td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"plan_activities.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
<?php include_once "footer.php";?>
