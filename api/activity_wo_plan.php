<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	
	$site_id_detail = $db->fetch_all_data("indottech_sites",[],"id ='".$_SESSION["site_activity"]."'")[0];
	//start user auto app tahap 1
		$module = "Activities";
		$mode = "approve";
		$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$__user_id."|%:LIKE"]);
	//end user auto app tahap 1
	
	if(isset($_POST["save"])){
		if ($access){
			$cordinator_mail = $_SESSION["username"];
		} else {
			$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
		}
		$attendance_id = $db->fetch_single_data("attendance","id",["user_id" => $user_id,"tap_time" => date("Y-m-d")."%:LIKE", "in_out" => "in"],["tap_time desc"]);
		$_errormessage="";
		if($_POST["kategori"] == 1 && !$_POST["project_id"]) $_errormessage = "<p style='color:red'>Saving data failed, please fill all colums!</p>";
		if ($_errormessage == ""){
			$db->addtable("attendance_activity");
			$db->addfield("attendance_id"); 		$db->addvalue($attendance_id);
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			if($_POST["kategori"] == 1){
				$db->addfield("attendance_status"); 	$db->addvalue("1");
				$db->addfield("site_id"); 				$db->addvalue($site_id_detail["id"]);
				$db->addfield("site_name");				$db->addvalue("[".$site_id_detail["kode"]."] ".$site_id_detail["name"]);
				$db->addfield("cost_center_id"); 		$db->addvalue($_POST["project_id"]);
				$db->addfield("sow_ids"); 				$db->addvalue(sel_to_pipe($_SESSION["sow_activity"]));
				} else {
				$db->addfield("attendance_status"); 	$db->addvalue("7");
				$db->addfield("site_id"); 				$db->addvalue("");
				$db->addfield("site_name");				$db->addvalue("");
				$db->addfield("cost_center_id"); 		$db->addvalue("");
				$db->addfield("sow_ids"); 				$db->addvalue("");
				}
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			$db->addfield("nopol"); 				$db->addvalue($_POST["nopol"]);
			$db->addfield("description"); 			$db->addvalue("<b>W/O Plan - </b>".$_POST["description"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				$_SESSION["site_activity"] = "";
				$_SESSION["mode"] = "";
				javascript("alert('Please Take Photo');");
				// if (!$access){
					// javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
				// } else {
					javascript("window.location='activity_wo_plan_edit.php?token=".$_GET["token"]."&activity_id=".$inserting["insert_id"]."&mode=wo_plan';");
				// }
				exit();
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
		$project 			= $db->fetch_select_data("cost_centers","id","concat('[',code,'] ',name)","",["code"],"",true);
		$project_id 		= $f->select("project_id",$project,$_POST["project_id"]," style='width:80%'");
		$cordinator			= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
		$cordinator_id 		= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
		$nopol 				= $f->input("nopol",$_POST["nopol"]," style='width:80%'","classinput");
		$description 		= $f->textarea("description",$_POST["description"],"required style='width:80%;height:80px;'","classinput");
		$kategori 			= $f->select("kategori",["" => "","1" => "Working","2" => "Stand By"],$_POST["kategori"],"required style='width:80%'");
?>
	<center><h4><b>Add Activity W/O Plan</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>">
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
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&mode=wo_plan\";'","btn btn-success");
					} else {
						foreach(pipetoarray($activity["sow_ids"]) as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Select SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&mode=wo_plan\";'","btn btn-primary");
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Sitename*</td><td width="50px">
				<?php
					if($_SESSION["site_activity"]) {
						echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
						echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&mode=wo_plan\";'","btn btn-success");
					} else {
						echo $f->input("","Select Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&mode=wo_plan\";'","btn btn-primary");
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
				<td>Date</td><td width="50px"><?=date("d-M-Y");?></td>
			</tr>
			<tr>
				<td>Vehicle*</td><td><?=$nopol;?></td>
			</tr>
			<tr>
				<td>Description</td><td><?=$description;?></td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_attendance.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<p style='font-size:5px'>&emsp;* Jika Category adalah Working <br> &emsp;** Cordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>