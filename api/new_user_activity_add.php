<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
 	
	$site_id_detail = $db->fetch_all_data("indottech_sites",[],"id ='".$_SESSION["site_activity"]."'")[0];
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
	if(isset($_POST["save"])){
		$attendance_id = $db->fetch_single_data("attendance","id",["user_id" => $user_id,"tap_time" => date("Y-m-d",strtotime($_POST["date"]))."%:LIKE", "in_out" => "in"],["tap_time"]);
		$attendance_tap_time = $db->fetch_single_data("attendance","tap_time",["user_id" => $user_id,"tap_time" => date("Y-m-d",strtotime($_POST["date"]))."%:LIKE", "in_out" => "in"],["tap_time"]);
		if ($__group_id == 12 || $__group_id == 14 || $__group_id == 18){
			$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
		} else {
			$cordinator_mail = $_SESSION["username"];
		}
		$_errormessage="";
		if($_POST["date"] > date("Y-m-d") || $_POST["date"] < $min_date || $_POST["date"] > $max_date) $_errormessage = "<p style='color:red'>Date can't bigger than today or ".format_tanggal($max_date,"d-M-Y")." and can't less than ".format_tanggal($min_date,"d-M-Y")."</p>";
		$cek_cuti = $db->fetch_all_data("attendance_notes",["id","notes"],"user_id = '".$user_id."' AND tanggal LIKE '%".$_POST["date"]."%'")[0];
		if($cek_cuti["id"] > 0) $_errormessage .= " Maaf anda memiliki catatan ketidakhadiran pada tangal ".format_tanggal($_POST["date"],"dMY")." !";
		
		if ($_errormessage == ""){
			$tap_time = date("Y-m-d",strtotime($_POST["date"]));
			if($attendance_tap_time) $tap_time = $attendance_tap_time;
			$db->addtable("attendance_activity");
			$db->addfield("attendance_id"); 		$db->addvalue($attendance_id);
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("created_at"); 			$db->addvalue($tap_time);
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
			if($indottech_request_backdate["id"] != ""){
				$db->addfield("description"); 			$db->addvalue("<b>Backdate - </b>".$_POST["description"]);
			} else {
				$db->addfield("description"); 			$db->addvalue("<b>New User - </b>".$_POST["description"]);
			}
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				$_SESSION["site_activity"] = "";
				$_SESSION["mode"] = "";
				javascript("alert('Data Saved');");
				if ($__group_id == 12 || $__group_id == 14 || $__group_id == 18){
					javascript("window.location='my_activities.php?token=".$token."';");
				} else {
					javascript("window.location='new_user_activity_edit.php?token=".$_GET["token"]."&activity_id=".$inserting["insert_id"]."&user_is=new';");
				}
					exit();
				} else {
					javascript("alert('Data failed to save!');");
				}
		}
	}

		$date				= $f->input("date",$_POST["date"],"required type='date' style='width:80%'","classinput");
		$project 			= $db->fetch_select_data("cost_centers","id","concat('[',code,'] ',name)","",["code"],"",true);
		$project_id 		= $f->select("project_id",$project,$_POST["project_id"]," style='width:80%'");
		$cordinator			= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
		$cordinator_id 		= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
		$nopol 				= $f->input("nopol",$_POST["nopol"]," style='width:80%'","classinput");
		$description 		= $f->textarea("description",$_POST["description"],"required style='width:80%;height:80px;'","classinput");
		$kategori 			= $f->select("kategori",["" => "","1" => "Working","2" => "Stand By"],$_POST["kategori"],"required style='width:80%'");
?>
	<center><h4><b>Tambah Aktifitas Tgl Sebelumnya</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>">
		<table id="data_content" width="100%">
			<tr>
				<td>Kategory</td>
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
						echo $f->input("","Pilih SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&plan_id=".date("Ymd")."\";'","btn btn-success");
					} else {
						foreach(pipetoarray($activity["sow_ids"]) as $key_sow => $sow_id){
							$_i++;
							$sow_id_detail 	= $db->fetch_all_data("indottech_sow",[],"id ='".$sow_id."'")[0];
							echo $_i.". ".$sow_id_detail["name"]."<br>";
						}
						echo $f->input("","Pilih SOW","type='button' onclick='window.location=\"sow_activities.php?token=".$_GET["token"]."&plan_id=".date("Ymd")."\";'","btn btn-primary");
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Sitename*</td><td width="50px">
				<?php
					if($_SESSION["site_activity"]) {
						echo "[".$site_id_detail["kode"]."] - ".$site_id_detail["name"]."<br>";
						echo $f->input("","Pilih Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&plan_id=".date("Ymd")."\";'","btn btn-success");
					} else {
						echo $f->input("","Pilih Site","type='button' onclick='window.location=\"site_activities.php?token=".$_GET["token"]."&plan_id=".date("Ymd")."\";'","btn btn-primary");
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