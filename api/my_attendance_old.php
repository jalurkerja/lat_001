<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
		<script src="../scripts/jquery-1.10.1.min.js"></script>
	</head>
	<body>
<?php
	// include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	include_once "new_user_auto_update_cuti.php";
	if(!$token){
		echo "<h2 style='color:red'><b>Mohon login ulang!</b></h2>";
		exit();
	} else {
		
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
?>

		<table width="100%">
			<tr>
				<td align="left"><h4><b>Daftar Kehadiran</b></h4></td>
				<!--
				<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
			-->
			</tr>
		</table>
		
		<?=$f->input("sakit","Sakit","type='button' onclick=\"window.location='attendance_sick_add.php?token=".$_GET["token"]."';\"","btn btn-danger");?>
		&ensp;
		<?=$f->input("cuti_khusus","Cuti Khusus","type='button' onclick=\"window.location='attendance_special_leave_add.php?token=".$_GET["token"]."';\"","btn btn-info");?>
		&ensp;
		<?php
			if ($sisaCuti > 0){
				echo $f->input("cuti","Cuti","type='button' onclick=\"window.location='attendance_leave_add.php?token=".$_GET["token"]."';\"","btn btn-success");
			}
		?>
		<br>
		<br>
<?php
		//start new user back date activities
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
		//end new user back date activities
			
			// $indottech_request_backdate = $db->fetch_all_data("indottech_request_backdate",[],"user_ids LIKE '%|".$user_id."|%' AND akses_mulai <= '".date("Y-m-d")."' AND akses_selesai >= '".date("Y-m-d")."'","id DESC")[0];
			// if($indottech_request_backdate["id"] != ""){
				// $min_date = date("Y-m-d",strtotime($indottech_request_backdate["akses_mulai"]));
				// $max_date = date("Y-m-d",strtotime($indottech_request_backdate["akses_selesai"]));
			// }
			
			if(date("Y-m-d") <= $max_date){
				echo "<p style='font-size:5px'>Jika akun anda baru dibuat, harap lengkapi absensi ditanggal sebelumnya melalui tombol berikut ini.</p>";
				echo $f->input("","Manual Absen","type='button' onclick='window.location=\"new_user_attendance_add.php?token=".$_GET["token"]."\";'","btn btn-danger");
				echo "<br>";
			}
?>
		<?=$f->start();?>
			<?=$t->start("width='100%'","editor_content");?>
				<?=$t->header(["","Tanggal","Jam Datang","Jam Pulang"]);?>
				<?php
					$no=-1;
					$dates = $db->fetch_all_data("attendance",["concat(date(tap_time))"],"user_id='".$user_id."' AND xtimestamp BETWEEN '".date("Y-m-d H:i:s", mktime(0,0,0, date("m")-1, 20, date("Y")))."' AND '".date(date("Y-m-d H:i:s", mktime(0,0,0, date("m"), date("d")+1, date("Y"))))."' group by date(tap_time) order by date(tap_time) DESC");

					$today = date("Y-m-d");
					$indottech_plan_activities = $db->fetch_single_data("indottech_plan_activities","id",["user_ids" => "%|".$user_id."|%:LIKE", "plan_at" => "%".$today."%:LIKE"]);
					$cek_attd_notes = $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "attended" => "0", "tanggal" => "%".$today."%:LIKE"]);
					$cek_activity_tidak_hadir = $db->fetch_single_data("attendance_activity","id",["attendance_status" => "4,5,6,10,11,12,13,14,51:IN", "user_id" => $user_id, "leave_start" => "%".$today."%:LIKE"]);
					
					if($indottech_plan_activities AND !$cek_attd_notes AND !$cek_activity_tidak_hadir){
						$link = $f->input("","Activity","type='button' onclick=\"window.location='plan_activities.php?token=".$_GET["token"]."';\"","btn btn-primary");
					} else if(!$indottech_plan_activities AND !$cek_attd_notes AND !$cek_activity_tidak_hadir) {
						$link = $f->input("","W/O Plan","type='button' onclick=\"window.location='activity_wo_plan.php?token=".$_GET["token"]."&mode=wo_plan';\"","btn btn-primary");
					} else {
						$link = "";
					}
					foreach($dates as $date){
						if(date("Y-m-d",strtotime($date[0])) == $today)	{$link = $link;} else {$link = "";}
						
						$no++;
						$attendance_id_in = $db->fetch_single_data("attendance","id",["project_id" => $project_id,"user_id" => $user_id,"in_out"=>"in","tap_time" => $date[0]."%:LIKE"],["tap_time"]);
						$attendance_id_out = $db->fetch_single_data("attendance","id",["project_id" => $project_id,"user_id" => $user_id,"in_out"=>"out","tap_time" => $date[0]."%:LIKE"],["tap_time DESC"]);
						
						$jamdatang = substr($db->fetch_single_data("attendance","tap_time",["id" => $attendance_id_in]),11,8);
						$jampulang = substr($db->fetch_single_data("attendance","tap_time",["id" => $attendance_id_out]),11,8);
						// $coordinateIn = $db->fetch_single_data("attendance","concat(latitude,':',longitude)",["id" => $attendance_id_in]);
						// $coordinateOut = $db->fetch_single_data("attendance","concat(latitude,':',longitude)",["id" => $attendance_id_out]);
						echo $t->row([$link,format_tanggal($date[0],"dFY"),$jamdatang,$jampulang],["align='right'"]);
					}
				?>
			<?=$t->end();?>
		<?=$f->end();?>
<?php 
	if($sisaCuti > 0) echo "<p style='font-size:5px'>Cuti tahunan anda tersisa ".$sisaCuti." Hari.</p>";
	}
?>
	</body>
</html>