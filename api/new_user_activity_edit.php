<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	
	$user_created_at = $db->fetch_single_data("users","created_at",["id" => $user_id]);
	if($user_created_at != ""){
		$d_created = date("d",strtotime($user_created_at));
		$m_created = date("m",strtotime($user_created_at));
		$Y_created = date("Y",strtotime($user_created_at));
		if($d_created > 20){
			$min_date = date("Y-m-d",mktime(0,0,0,$m_created,19, $Y_created));
			$max_date = date("Y-m-d",mktime(0,0,0,$m_created+1,22, $Y_created));
		} else {
			$min_date = date("Y-m-d",mktime(0,0,0,$m_created-1,19, $Y_created));
			$max_date = date("Y-m-d",mktime(0,0,0,$m_created,22, $Y_created));
		}
	}
	
	$indottech_request_backdate = $db->fetch_all_data("indottech_request_backdate",[],"user_ids LIKE '%|".$user_id."|%' AND akses_mulai <= '".date("Y-m-d")."' AND akses_selesai >= '".date("Y-m-d")."'","id DESC")[0];
	if($indottech_request_backdate["id"] != ""){
		$min_date = date("Y-m-d",strtotime($indottech_request_backdate["tanggal_mulai_aktifitas"]));
		$max_date = date("Y-m-d",strtotime($indottech_request_backdate["tanggal_selesai_aktifitas"]));
	}
	
	$my_activity	= $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["activity_id"]."'")[0];
	
	if(isset($_POST["save"])){
		if($_SESSION["site_activity"]) {$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$_SESSION["site_activity"]."'")[0];} 
			else {$site_details = $db->fetch_all_data("indottech_sites", [], "id = '".$my_activity["site_id"]."'")[0];}
		if($_SESSION["sow_activity"]){$sow__new__ids = sel_to_pipe($_SESSION["sow_activity"]);}else{$sow__new__ids = $my_activity["sow_ids"];}
		if ($__group_id == 12 || $__group_id == 14 || $__group_id == 18){
			$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
		} else {
			$cordinator_mail = $_SESSION["username"];
		}
		$_errormessage="";
		if ($_POST["date"] > date("Y-m-d") || $_POST["date"] < $min_date || $_POST["date"] > $max_date) $_errormessage = "<p style='color:red'>Date can't bigger than today or ".format_tanggal($max_date,"d-M-Y")." and can't less than ".format_tanggal($min_date,"d-M-Y")."</p>";
		$cek_cuti = $db->fetch_all_data("attendance_notes",["id","notes"],"user_id = '".$user_id."' AND tanggal LIKE '%".$_POST["date"]."%'")[0];
		if($cek_cuti["id"] > 0) $_errormessage .= " Maaf anda memiliki catatan ketidakhadiran pada tangal ".format_tanggal($_POST["date"],"dMY")." !";
		
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
			$db->addfield("created_at"); 			$db->addvalue($_POST["date"]);
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			if($indottech_request_backdate["id"] != ""){
				$db->addfield("description"); 			$db->addvalue("<b>Backdate - </b>".$_POST["description"]);
			} else {
				$db->addfield("description"); 			$db->addvalue("<b>New User - </b>".$_POST["description"]);
			}
			$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				$_SESSION["site_activity"] = "";
				$_SESSION["sow_activity"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='my_activities.php?token=".$token."';");
				exit();
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
			$my_cordinator	= $db->fetch_single_data("users","id",["email" => $my_activity["approved_by"].":LIKE"]);
			$date				= $f->input("date",date("Y-m-d",strtotime($my_activity["created_at"])),"required type='date' style='width:80%'","classinput");
			$project 			= $db->fetch_select_data("cost_centers","id","concat('[',code,'] ',name)","",["code"],"",true);
			$project_id 		= $f->select("project_id",$project,$my_activity["cost_center_id"]," style='width:80%'");
			$cordinator			= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
			$cordinator_id 		= $f->select("cordinator_id",$cordinator,$my_cordinator,"required style='width:80%'");
			$sites 				= $db->fetch_select_data("indottech_sites","id","concat('[',kode,'] ',name)","",["name"],"",true);
			$site_id 			= $f->select("site_id",$sites,$my_activity["site_id"]," style='width:80%'");
			$nopol 				= $f->input("nopol",$my_activity["nopol"]," style='width:80%'","classinput");
			$description 		= $f->textarea("description",substr($my_activity["description"],18)," style='width:80%;height:80px;'","classinput");
			if($my_activity["attendance_status"] == 2 || $my_activity["attendance_status"] == 1 || $my_activity["attendance_status"] == 0){
				$_POST["kategori"] = 1;
			} else {
				$_POST["kategori"] = 2;
			}
			$kategori 			= $f->select("kategori",["" => "","1" => "Working","2" => "Stand By"],$_POST["kategori"],"required style='width:80%'");
			
			if(preg_match("/New User/i", $my_activity["description"])){
				$user_is		= "&user_is=new";
			}
			if(preg_match("/Backdate/i", $my_activity["description"])){
				$user_is		= "&user_is=backdate";
			}
?>
	<center><h4><b>Aktifitas Tgl Sebelumnya</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&activity_id=<?=$_GET["activity_id"];?>">
		<table id="data_content" width="100%">
			<tr>
				<td>Kategori</td>
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
						echo $f->input("","Pilih SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"].$user_is."\";'","btn btn-success");
					} else {
						foreach(pipetoarray($my_activity["sow_ids"]) as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Pilih SOW","type='button' onclick='window.location=\"sow_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"].$user_is."\";'","btn btn-primary");
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
						echo $f->input("","Pilih Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"].$user_is."\";'","btn btn-success");
					} else {
						if ($my_activity["site_id"] != 0){
							$site_id_detail 	= $db->fetch_all_data("indottech_sites",[],"id ='".$my_activity["site_id"]."'")[0];
							echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
						}
						echo $f->input("","Pilih Site","type='button' onclick='window.location=\"site_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"].$user_is."\";'","btn btn-primary");
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Project*</td><td width="50px"><?=$project_id;?></td>
			</tr>
			<?php
				if ($__group_id == 12 || $__group_id == 14 || $__group_id == 18){
					?>
						<tr>
							<td>Kordinator**</td><td width="50px"><?=$cordinator_id;?></td>
						</tr>
					<?php
				}
			?>
			<tr>
				<td>Tanggal</td><td width="50px"><?=$date;?></td>
			</tr>
			<tr>
				<td>Kendaraan*</td><td><?=$nopol;?></td>
			</tr>
			<tr>
				<td>Deskripsi</td><td><?=$description;?></td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_activities.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<p style='font-size:5px'>&emsp;* Jika Kategori adalah Working <br> &emsp;** Kordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>