<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	
	$user_created_at = $db->fetch_single_data("users","created_at",["id" => $user_id]);
	$d_created = date("d",strtotime($user_created_at));
	$m_created = date("m",strtotime($user_created_at));
	$Y_created = date("Y",strtotime($user_created_at));
	if($d_created > 20){
		$min_date = date("Y-m-d",mktime(0,0,0,$m_created,21, $Y_created));
		$max_date = date("Y-m-d",mktime(0,0,0,$m_created+1,19, $Y_created));
	} else {
		$min_date = date("Y-m-d",mktime(0,0,0,$m_created-1,21, $Y_created));
		$max_date = date("Y-m-d",mktime(0,0,0,$m_created,19, $Y_created));
	}
	
	if(isset($_POST["save"])){
		$_errormessage="";
		// if(!preg_match("#^[a-zA-Z0-9 \.,\?_/'!£\$%&*()+=\r\n-]+$#",$_POST["description"])) $_errormessage = "<p style='color:red'>Cek kembali karakter input anda!</p>";
		if (date("Y-m-d") < $max_date && ($_POST["date"] > date("Y-m-d") || $_POST["date"] < $min_date)) $_errormessage = "<p style='color:red'>Tanggal tidak boleh melebihi dari tanggal hari ini atau tanggal periode tutup buku sebelumnya</p>";
		$attendance_notes	= $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "tanggal" => date("Y-m-d",strtotime($_POST["date"]))]);
		$attendance_notes_2	= $db->fetch_single_data("attendance_activity","id",["user_id" => $user_id, "leave_start" => date("Y-m-d",strtotime($_POST["date"]))]);
		if($attendance_notes > 0 || $attendance_notes_2 > 0) $_errormessage = "<p style='color:red'>Penyimpanan gagal, anda sudah memiliki catatan ketidakhadiran ditanggal ".format_tanggal($_POST["date"],"d-M-Y")."!</p>";
		if ($_errormessage == ""){
			if ($__group_id == 11 || $__group_id == 12 || $__group_id == 14 || $__group_id == 18){
				$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
			} else {
				$cordinator_mail = $_SESSION["username"];
			}
			$db->addtable("attendance_activity");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("attendance_status"); 	$db->addvalue("51");
			$db->addfield("description"); 			$db->addvalue("<b>Sick - </b>".$_POST["description"]);
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			if (date("Y-m-d") < $max_date){
				$db->addfield("leave_start"); 		$db->addvalue($_POST["date"]);
				$db->addfield("created_at"); 		$db->addvalue($_POST["date"]);
			} else {                                
				$db->addfield("leave_start"); 		$db->addvalue(date("Y-m-d"));
			}
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				javascript("alert('Please Take Photo');");
				javascript("window.location='attendance_sick_edit.php?token=".$_GET["token"]."&activity_id=".$inserting["insert_id"]."';");
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
	$description 	= $f->textarea("description",$_POST["description"],"style='width:80%;height:80px;'","classinput");
	$date			= $f->input("date",$_POST["date"],"required type='date' style='width:80%'","classinput");
	$cordinator		= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11,15,16:IN", "hidden" => "0", "id" => $__user_id.":!="],["name"],"",true);
	$cordinator_id 	= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
?>
	<center><h4><b>KETIDAKHADIRAN - SAKIT</b></h4></center>
	<center><?=$_errormessage;?></center>
	<br>
	<form method="POST" action="?token=<?=$token;?>">
		<table id="data_content" width="100%">
			<tr>
				<td style="width:20%">Tanggal</td>
				<?php
					if (date("Y-m-d") < $max_date){
						echo "<td>".$date."</td>";
					} else {
						echo "<td>".format_tanggal($__now,"d-M-Y")."</td>";
					}
				?>
			</tr>
			<?php
				if ($__group_id == 11 || $__group_id == 12 || $__group_id == 14 || $__group_id == 18){
					?>
						<tr>
							<td>Kordinator**</td><td width="50px"><?=$cordinator_id;?></td>
						</tr>
					<?php
				}
			?>
			<tr>
				<td>Deskripsi</td><td><?=$description;?></td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<!--<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_attendance.php?token=".$token."\";'","btn btn-warning");?></td>-->
			<td><?=$f->input("back","Back","type='button' onclick='history.go(-1);'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<p style='font-size:5px'>&emsp;** Kordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>