<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$_SESSION["sow_activity"] = "";
	
	$_today = date("Y-m-d");
	$cek_attd_notes = $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "attended" => "0", "tanggal" => "%".$_today."%:LIKE"]);
	$cek_activity_tidak_hadir = $db->fetch_single_data("attendance_activity","id",["attendance_status" => "4,5,6,10,11,12,13,14,51:IN", "user_id" => $user_id, "leave_start" => "%".$_today."%:LIKE"]);
	if(!$cek_attd_notes AND !$cek_activity_tidak_hadir){
?>

	<table width="100%">
		<tr>
			<td align="left"><h4><b>Rencana Kegiatan</b></h4></td>
			<!--
				<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
			-->
		</tr>
	</table>

	<div style="overflow-x:auto;">
		<table id="data_content" width="100%">
			<tr>
				<th width="5%">Tanggal</th>
				<th width="30%">Project</th>
				<th width="30%">SOW</th>
				<th width="30%">Sitename</th>
				<th width="5%">Action</th>
			</tr>
		<?php
			$plan_activities = $db->fetch_all_data("indottech_plan_activities",[],"user_ids LIKE '%|".$__user_id."|%' AND plan_at LIKE '%".date("Y-m-d")."%'","plan_at ASC");
			foreach($plan_activities as $plan_activity){
				foreach(pipetoarray($plan_activity["site_ids"]) as $site_id){
					$i=1;
					echo "<tr>";
						echo "<td>".format_tanggal($plan_activity["plan_at"],"d-M-Y")."</td>";
						echo "<td>".$plan_activity["cost_center_name"]."</td>";
						echo "<td>";
							foreach(pipetoarray($plan_activity["sow_ids"]) as $sow_id){
								$sow_name = $db->fetch_single_data("indottech_sow","name",["id" => $sow_id]);
								echo $i++.". ".$sow_name."<br>";
							}
						echo "</td>";
						echo "<td>".$db->fetch_single_data("indottech_sites","name",["id" => $site_id])."</td>";
						$attendance_activity_site =	$db->fetch_single_data("attendance_activity","id",["user_id" => $__user_id, "indottech_plan_id" => $plan_activity["id"], "plan_site_id" => $site_id]);
						if($attendance_activity_site > 0){
							echo "<td>".$f->input("","View","type='button' onclick='window.location=\"view_activities.php?token=".$_GET["token"]."&plan_id=".$plan_activity["id"]."&plan_site_id=".$site_id."\";'","btn btn-success")." ".$myaction."</td>";
						} else {
							echo "<td>".$f->input("","View","type='button' onclick='window.location=\"view_activities.php?token=".$_GET["token"]."&plan_id=".$plan_activity["id"]."&plan_site_id=".$site_id."\";'","btn btn-warning")." ".$myaction."</td>";
						}
					echo "</tr>";
				}
			}
		echo "</table></div>";
		echo "<br><center><h6><b style='color:green;'>Tombol berubah warna menjadi hijau jika sudah ada rencana kegiatan yang dikerjakan.</b></h6></center>";
	} else {
		echo "<br><center><h6><b style='color:red;'>Anda memiliki pengajuan ketidakhadiran di hari ini.</b></h6></center>";
	}
	?>
	<br>
<?php include_once "footer.php";?>