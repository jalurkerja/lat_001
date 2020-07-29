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
	
	$users_leave 		= $db->fetch_all_data("users",[],"id = '".$user_id."'")[0];
	$cuti_bersama 		= $db->fetch_all_data("day_off",[],"tanggal LIKE '%".date("Y")."-%' AND is_leave = '1'");
	$user_do_aktifitas 	= 0;
	foreach($cuti_bersama as $tgl_cuti_bersama){
		$do_aktifitas = $db->fetch_single_data("attendance_activity","id",["user_id" => $users_leave["id"], "attendance_status" => "3,9:IN", "created_at" => "%".$tgl_cuti_bersama["tanggal"]."%:LIKE"]);
		if($do_aktifitas > 0) $user_do_aktifitas++;
	}
	$cuti_bersama_count = count($cuti_bersama) - $user_do_aktifitas;
	$cuti_individual 	= count($db->fetch_all_data("attendance_notes",[],"tanggal LIKE '%".date("Y")."-%' AND cuti = '1' AND user_id = '".$users_leave["id"]."'"));
	$sisaCuti			= $users_leave["leave_num"] - $cuti_bersama_count - $cuti_individual;
	//start user auto app tahap 1
		$module = "Activities";
		$mode = "approve";
		$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$__user_id."|%:LIKE"]);
	//end user auto app tahap 1
	
	if(isset($_POST["save"])){
		$date1=$_POST["sel_date_1"];
		$date3=$_POST["sel_date_2"];
		$date2=date("Y-m-d");
		$datetime1 = new DateTime($date1);
		$datetime2 = new DateTime($date2);
		$datetime3 = new DateTime($date3);
		$difference = $datetime1->diff($datetime2);
		$lama_cuti = $datetime1->diff($datetime3);
		$_errormessage="";
		if($_POST["sel_date_2"] < $_POST["sel_date_1"]) $_errormessage = "<p style='color:red'>Penyimpanan gagal, tanggal selesai harus lebih besar dari tanggal awal cuti!</p>";
		if(!$_POST["sel_date_1"] || !$_POST["sel_date_2"]) $_errormessage = "<p style='color:red'>Penyimpanan gagal, harap isi tanggal awal atau selesai cuti!</p>";
		$attendance_notes	= $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "tanggal" => $_POST["sel_date_1"]."' AND '".$_POST["sel_date_2"].":BETWEEN"]);
		$attendance_notes_2	= $db->fetch_single_data("attendance_activity","id",["user_id" => $user_id, "leave_start" => $_POST["sel_date_1"].":>=", "leave_end" => $_POST["sel_date_2"].":<="]);
		if($attendance_notes > 0 || $attendance_notes_2 > 0) $_errormessage = "<p style='color:red'>Penyimpanan gagal, anda sudah memiliki catatan ketidakhadiran ditanggal antara tanggal yang anda pilih!</p>";
		if(date("Y-m-d") > $max_date && $difference->days < 6) $_errormessage = "<p style='color:red'>Penyimpanan gagal. Pengajuan cuti harus berjarak minimal satu minggu dari hari ini!</p>";
		if(($lama_cuti->days+1) > $sisaCuti) $_errormessage = "<p style='color:red'>Penyimpanan gagal. Anda hanya bisa mengajukan cuti tahunan selama ".$sisaCuti." Hari!</p>";
		if ($_errormessage == ""){
			if ($access){
				$cordinator_mail = $_SESSION["username"];
			} else {
				$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
			}
			$db->addtable("attendance_activity");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("attendance_status"); 	$db->addvalue("4");
			$db->addfield("description"); 			$db->addvalue("<b>Pengajuan Cuti (".format_tanggal($_POST["sel_date_1"],"d-m-y")." - ".format_tanggal($_POST["sel_date_2"],"d-m-y").")</b> ".$_POST["description"]);
			$db->addfield("leave_start");	 		$db->addvalue($_POST["sel_date_1"]);
			$db->addfield("leave_end");	 			$db->addvalue($_POST["sel_date_2"]);
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
	
	if(isset($_POST["save"])){
		$sel_date_1		= $f->input("sel_date_1",@$_POST["sel_date_1"],"type='date'");
		$sel_date_2		= $f->input("sel_date_2",@$_POST["sel_date_2"],"type='date'");
	} else {
		$sel_date_1		= $f->input("sel_date_1",date("Y-m-d", strtotime(date ("Y-m-d") . " +7 day")),"type='date'");
		$sel_date_2		= $f->input("sel_date_2",date("Y-m-d", strtotime(date ("Y-m-d") . " +7 day")),"type='date'");
	}
		$description 	= $f->textarea("description",$_POST["description"],"required style='width:80%;height:80px;'","classinput");
		$cordinator		= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
		$cordinator_id 	= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
?>

	<center><h4><b>KETIDAKHADIRAN - CUTI</b></h4></center>
	<center><?=$_errormessage;?></center>
	<br>
	<form method="POST" action="?token=<?=$token;?>">
		<table id="data_content" width="100%">
			<tr>
				<td style="width:20%">Dari Tanggal</td>
				<td><?=$sel_date_1;?></td>
			</tr>
			<tr>
				<td style="width:20%">Hingga Tanggal</td>
				<td><?=$sel_date_2;?></td>
			</tr>
			<?php
				if (!$access){
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