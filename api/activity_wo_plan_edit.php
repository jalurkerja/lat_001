<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$my_activity	= $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["activity_id"]."'")[0];
	//start user auto app tahap 1
		$module = "Activities";
		$mode = "approve";
		$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$__user_id."|%:LIKE"]);
	//end user auto app tahap 1
	$filename 	= "activityphoto_".$user_id."_".$_GET["activity_id"]."_.jpg";
	if(isset($_POST["save"])){
		if($_SESSION["site_activity"]) {$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$_SESSION["site_activity"]."'")[0];} 
			else {$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$my_activity["site_id"]."'")[0];}
		if($_SESSION["sow_activity"]){$sow__new__ids = sel_to_pipe($_SESSION["sow_activity"]);}else{$sow__new__ids = $my_activity["sow_ids"];}
		if ($access){
			$cordinator_mail = $_SESSION["username"];
		} else {
			$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
		}
		$_errormessage="";
		if($_POST["kategori"] == 1 && !$_POST["project_id"]) $_errormessage = "<p style='color:red'>Saving data failed, please fill all colums!</p>";
		if ($_errormessage == ""){
			$attendance_id = $db->fetch_single_data("attendance","id",["user_id" => $user_id,"tap_time" => date("Y-m-d")."%:LIKE", "in_out" => "in"],["tap_time desc"]);
			$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
			$db->addtable("attendance_activity");	$db->where("id",$_GET["activity_id"]);
			if($_POST["kategori"] == 1){
				$db->addfield("site_id"); 				$db->addvalue($site_details["id"]);
				$db->addfield("site_name");				$db->addvalue("[".$site_details["kode"]."] ".$site_details["name"]);
				$db->addfield("attendance_status"); 	$db->addvalue("1");
				$db->addfield("cost_center_id"); 		$db->addvalue($_POST["project_id"]);
				$db->addfield("sow_ids"); 				$db->addvalue($sow__new__ids);
				$db->addfield("nopol"); 				$db->addvalue($_POST["nopol"]);
			} else {
				$db->addfield("site_id"); 				$db->addvalue("");
				$db->addfield("site_name");				$db->addvalue("");
				$db->addfield("attendance_status"); 	$db->addvalue("7");
				$db->addfield("cost_center_id"); 		$db->addvalue("");
				$db->addfield("sow_ids"); 				$db->addvalue("");
			}
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			$db->addfield("description"); 			$db->addvalue("<b>W/O Plan - </b>".$_POST["description"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["site_activity"] = "";
				$_SESSION["sow_activity"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
				exit();
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
			$my_cordinator	= $db->fetch_single_data("users","id",["email" => $my_activity["approved_by"].":LIKE"]);
			// $date				= $f->input("date",date("Y-m-d",strtotime($my_activity["created_at"])),"required type='date' style='width:80%'","classinput");
			$project 			= $db->fetch_select_data("cost_centers","id","concat('[',code,'] ',name)","",["code"],"",true);
			$project_id 		= $f->select("project_id",$project,$my_activity["cost_center_id"]," style='width:80%'");
			$cordinator			= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
			$cordinator_id 		= $f->select("cordinator_id",$cordinator,$my_cordinator,"required style='width:80%'");
			$nopol 				= $f->input("nopol",$my_activity["nopol"]," style='width:80%'","classinput");
			$description 		= $f->textarea("description",substr($my_activity["description"],18)," style='width:80%;height:80px;'","classinput");
			if($my_activity["attendance_status"] == 2 || $my_activity["attendance_status"] == 1 || $my_activity["attendance_status"] == 0){
				$_POST["kategori"] = 1;
			} else {
				$_POST["kategori"] = 2;
			}
			$kategori 			= $f->select("kategori",["" => "","1" => "Working","2" => "Stand By"],$_POST["kategori"],"required style='width:80%'");
?>
	<center><h4><b>Activity W/O Plan</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&activity_id=<?=$_GET["activity_id"];?>">
		<table id="data_content" width="100%">
			<tr>
				<td>Category</td>
				<td><?=$kategori;?></td>
			</tr>
			<tr>
				<td style="width:20%">SOW*</td>
				<td>
				<?php
					if($_SESSION["sow_activity"]) {
						foreach($_SESSION["sow_activity"] as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan\";'","btn btn-success");
					} else {
						foreach(pipetoarray($my_activity["sow_ids"]) as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan\";'","btn btn-primary");
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
						echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan\";'","btn btn-success");
					} else {
						if ($my_activity["site_id"] != 0){
							$site_id_detail 	= $db->fetch_all_data("indottech_sites",[],"id ='".$my_activity["site_id"]."'")[0];
							echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
						}
						echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan\";'","btn btn-primary");
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Project*</td><td width="50px"><?=$project_id;?></td>
			</tr>
			<?php
				if (!$access){
					?>
						<tr>
							<td>Cordinator**</td><td width="50px"><?=$cordinator_id;?></td>
						</tr>
					<?php
				}
			?>
			<tr>
				<td>Date</td><td width="50px"><?=format_tanggal($my_activity["created_at"],"d-M-Y");?></td>
			</tr>
			<tr>
				<td>Vehicle*</td><td><?=$nopol;?></td>
			</tr>
			<tr>
				<td>Description</td><td><?=$description;?></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$_GET["token"];?>&activity_id=<?=$_GET["activity_id"];?>&takeactivityphoto=<?=$_GET["activity_id"];?>';">
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<?php 
						if(file_exists("../geophoto/".$filename)){
							?>	<img onclick="zoomimage('<?=$filename;?>');" src="../geophoto/<?=$filename;?>" width="150"> <?php 
						} 
					?>
				</td>
			</tr>
		</table>
		<br>
		
		
		<?php 
			if(file_exists("../geophoto/".$filename)){
		?>
			<table width="100%"><tr>
				<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_activities.php?token=".$token."\";'","btn btn-warning");?></td>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			</tr></table>
		<?php
			}
		?>
		<p style='font-size:5px'>&emsp;* Jika Category adalah Working <br> &emsp;** Cordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>