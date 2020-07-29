<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	
	if(isset($_POST["save"])){
		$date1=$_POST["sel_date_1"];
		$date2=date("Y-m-d");
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$difference = $datetime1->diff($datetime2);
		$_errormessage="";
		if(!preg_match("#^[a-zA-Z0-9 \.,\?_/'!£\$%&*()+=\r\n-]+$#",$_POST["description"])) $_errormessage = "<p style='color:red'>Penyimpanan gagal, periksa ejaan kolom deskripsi!</p>";
		if(!$_POST["description"]) $_errormessage = "<p style='color:red'>Penyimpanan gagal, tolong isi kolom deskripsi!</p>";
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
			$db->addfield("attendance_status"); 	$db->addvalue("12");
			$db->addfield("description"); 			$db->addvalue("<b>Cuti Khusus (".format_tanggal($_POST["date"],"d-m-y").")</b> ".$_POST["description"]);
			$db->addfield("leave_start");	 		$db->addvalue($_POST["date"]);
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				javascript("alert('Penyimpanan berhasil, dan sedang menunggu persetujuan kordinator');");
				javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
			} else {
				javascript("alert('Penyimpanan gagal!');");
			}
		}
	}
	
		$description 	= $f->textarea("description",$_POST["description"],"style='width:80%;height:80px;'","classinput");
		$cordinator		= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0", "id" => $__user_id.":!="],["name"],"",true);
		$cordinator_id 	= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
		$date			= $f->input("date",$_POST["date"],"required type='date' style='width:80%'","classinput");
?>

	<center><h4><b>KETIDAKHADIRAN - CUTI KHUSUS</b></h4></center>
	<center><?=$_errormessage;?></center>
	<br>
	<form method="POST" action="?token=<?=$token;?>">
		<table id="data_content" width="100%">
			<tr>
				<td style="width:20%">Tanggal</td>
				<td><?=$date;?></td>
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
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_attendance.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<p style='font-size:5px'>&emsp;** Kordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>