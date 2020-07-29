<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	
	$_next 		= "";
	$next 		= "";
	if(!$_GET["page"] || $_GET["page"] == 1){
		$page 	= 1;
	} else {
		$page 	= $_GET["page"];
		$_next		= "<a onclick=\"window.location='?token=".$_GET["token"]."&page=1';\">&#60;&#60;&#60;</a> &nbsp;";
		$next		= "<a onclick=\"window.location='?token=".$_GET["token"]."&page=".($page-1)."';\">&#60;&#60;</a>";
	}
	$prev		= "<a onclick=\"window.location='?token=".$_GET["token"]."&page=".($page+1)."';\">&#62;&#62;</a>";
	
	$day_1		= $page * 7;
	$day_2		= $day_1 - 7;
	$start		= date("Y-m-d H:i:s", mktime(0, 0, 1, date("m"), (date("d") - $day_1), date("Y")));
	$end		= date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), (date("d") - $day_2), date("Y")));
	$awal_absen	= $db->fetch_single_data("attendance","tap_time",["user_id" => $__user_id],["tap_time"]);
	$datetime1 	= new DateTime($start);
	$datetime2 	= new DateTime($end);
	$difference = $datetime1->diff($datetime2);
	$numdate	= $difference->days+1;
	$temp		= date("Ymd")."_".$__user_id."_";
	$filephoto	= $db->fetch_all_data("attendance_activity",[],"user_id = '".$__user_id."' AND filephoto LIKE '%".$temp."%' order by filephoto DESC")[0];
	
	if(!$filephoto){
		$filename	= $temp."00";
	} else {
		$filename	= $temp.sprintf("%02d",(explode(".",(explode($temp,$filephoto["filephoto"])[1]))[0] + 1));
	}
	If ($start < $awal_absen) {
		$prev = "";
	}
	$s_1 = "<img src='../icons/I_wait.png' style='width:15px;'>";
	$s_2 = "<img src='../icons/I_yes.png' style='width:15px;'>";
	$s_3 = "<img src='../icons/I_yes.png' style='width:15px;'><img src='../icons/I_yes.png' style='width:15px;'>";
	$s_4 = "<img src='../icons/I_no.png' style='width:15px;'>";
	
	$txt_text 	= ["Present","Sick","Attendance list"];
	$txt_header	= ["Date","Tap_In","Coordinate","Tap_Out","Coordinate"];
	$txt_notes	= ["Submission","App. by Coordinator","App. by PM","Submission Rejected"];
	// if($__group_id == "23"){
		// $txt_text 	= ["Hadir","Sakit","Rekap Kehadiran"];
		// $txt_header	= ["Tanggal","Tap In","Koordinat","Tap Out","Kordinat"];
		// $txt_notes	= ["Pengajuan","Disetujui Kordinator","Disetujui PM","Pengajuan Ditolak"];		
	// }
?>
<div class="container">
	<div class="post-job box">
		<div class="row">
			<div class="col f-category">
				<a onclick="window.location='attendance_activity_add.php?token=<?=$_GET["token"];?>&filename=<?=$filename;?>&takeactivityphoto=<?=$filename;?>';">
					<div class="icon">
						<img src="../icons/I_hadir.png" style="width:75%;">
					<h3 style="color:#43579C !important;"><?=$txt_text[0];?></h3>
					</div>
				</a>
			</div>
			<!--
			<div class="col f-category">
				<a onclick="window.location='attendance_sick_add.php?token=<?=$_GET["token"];?>&filename=<?=$filename;?>';">
					<div class="icon">
						<img src="../icons/I_sakit.png" style="width:75%;">
					<h3 style="color:#43579C !important;"><?=$txt_text[1];?></h3>
					</div>
				</a>
			</div>
			-->
		</div>
		<br>
		<h3 class="job-title" style="color: black !important;"><?=$txt_text[2];?></h3>
		
		<div class="table-responsive-sm">          
			<table class="table table-bordered" style="color: black !important;">
				<thead>
					<tr>
						<th><?=$txt_header[0];?></th>
						<th><?=$txt_header[1];?></th>
						<th><?=$txt_header[2];?></th>
						<th><?=$txt_header[3];?></th>
						<th><?=$txt_header[4];?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$_max_jam_in	= date("H:i:s",strtotime("11:00:00"));
					$_min_jam_out	= date("H:i:s",strtotime("13:00:00"));
					for($xx = ($numdate-1); $xx >= 0; $xx--){
						$m = substr($start,5,2);
						$d = substr($start,8,2) + $xx;
						$y = substr($start,0,4);
						$currentDate = date("Y-m-d",mktime(0,0,0,$m,$d,$y));
						$day = date("N",mktime(0,0,0,$m,$d,$y));
						$day_off = $db->fetch_single_data("day_off","id",["tanggal" => "%".$currentDate."%:LIKE"]);
						$style_head = "";
						if($day == 7 || $day_off > 0) $style_head = "style='font-weight:bold; color:red;'";
						$attendance_in		 = "";
						$attendance_out		 = "";
						$tap_time_in		 = "";
						$tap_time_out		 = "";
						$cord_in			 = "";
						$cord_out			 = "";
						$attendance_in		 = $db->fetch_all_data("attendance",[],"user_id = '".$__user_id."' AND xtimestamp LIKE '".$currentDate."%' order by xtimestamp ASC")[0];
						$attendance_out		 = $db->fetch_all_data("attendance",[],"user_id = '".$__user_id."' AND xtimestamp LIKE '".$currentDate."%' order by xtimestamp DESC")[0];
						if($attendance_in["tap_time"] && date("H:i:s",strtotime($attendance_in["tap_time"])) <= $_max_jam_in){
							$tap_time_in		 = format_tanggal($attendance_in["tap_time"],"H:i:s");
							if($attendance_in["latitude"]){
								$cord_in		= $attendance_in["latitude"].", ".$attendance_in["longitude"];							
							}
						}
						if($attendance_out["tap_time"] && date("H:i:s",strtotime($attendance_out["tap_time"])) >= $_min_jam_out){
							$tap_time_out		 = format_tanggal($attendance_out["tap_time"],"H:i:s");
							if($attendance_out["latitude"]){
								$cord_out		= $attendance_out["latitude"].", ".$attendance_out["longitude"];							
							}
						}
						$onclick			 = "";
						
						echo "<tr>";
						echo "<td style='background-color:white !important;' nowrap ".$style_head." ".$row_span.">".format_tanggal($currentDate,"d-m-y")."</td>";
						echo "<td ".$onclick." align='center'>".$tap_time_in."</td>";
						echo "<td ".$onclick.">".$cord_in."</td>";
						echo "<td ".$onclick." align='center'>".$tap_time_out."</td>";
						echo "<td ".$onclick.">".$cord_out."</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-12 col-md-12 col-xs-12">
		<!-- Start Pagination -->
		<ul class="pagination">              
			<li><?=$_next;?></li>
			<li><?=$next;?></li>
			<li><?=$prev;?></li>
		</ul>
		<!-- End Pagination -->
		<!--
			<table class="table table-bordered" border="1">
				<tr>
					<td align="center" width="10%"><?=$s_1;?></td><td>: <?=$txt_notes[0];?></td>
				</tr>
				<tr>
					<td align="center" width="10%"><?=$s_2;?></td><td>: <?=$txt_notes[1];?></td>
				</tr>
				<tr>
					<td align="center" width="10%"><?=$s_3;?></td><td>: <?=$txt_notes[2];?></td>
				</tr>
				<tr>
					<td align="center" width="10%"><?=$s_4;?></td><td>: <?=$txt_notes[3];?></td>
				</tr>
			</table>
		-->
	</div>
</div>

<?php include_once "footer.php"; ?>