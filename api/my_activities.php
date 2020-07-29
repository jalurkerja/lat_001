<?php 
	// include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	include_once "new_user_auto_update_cuti.php";
	$_SESSION["sow_activity"] = "";
	$_SESSION["site_activity"] = "";
	$_SESSION["mode"] = "";
	
	//start user auto app tahap 1
		$module = "Activities";
		$mode = "approve";
		$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$__user_id."|%:LIKE"]);
	//end user auto app tahap 1
	if($access > 0){
		$act_ids = $db->fetch_all_data("attendance_activity",[],"user_id ='".$user_id."'");
		foreach($act_ids as $act_id){
			$id__status 	= $act_id["attendance_status"];

			if($id__status == "1") $_id_status = "2";
			if($id__status == "4") $_id_status = "5";
			if($id__status == "7") $_id_status = "8";
			//autoapprove ke 1 for leader keatas
			if($access > 0 && ($id__status == 1 || $id__status == 4 || $id__status == 7)){
				$db->addtable("attendance_activity"); 	$db->where("id",$act_id["id"]);
				$db->addfield("attendance_status");		$db->addvalue($_id_status);
				$db->addfield("approved_at");			$db->addvalue($__now);
				$db->addfield("approved_by");			$db->addvalue($__username);
				$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
				$inserting = $db->update();
			}
			//end autoapprove ke 1 for leader keatas
		}
	}
?>

<table width="100%">
	<tr>
		<td align="left"><h4><b>Kegiatan Saya</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>
<center><?=$_message;?></center>

<!--
<table width="100%">
	<tr>
		<td style="font-size:14px;" width="35%"><b>Name</b></td>
		<td style="font-size:14px;"><b>:</b></td>
		<td style="font-size:14px;"><b><?=$db->fetch_single_data("users", "name", ["id" => $user_id]);?></b></td>
	</tr>
	<tr>
		<td style="font-size:14px;"><b>User</b></td>
		<td style="font-size:14px;"><b>:</b></td>
		<td style="font-size:14px;"><b><?=$user_id;?></b></td>
	</tr>
	<?php 
		//start peminjaman material
		$material_transactions = $db->fetch_all_data("material_transactions",[],"personil_id = '".$__user_id."' AND approved_by = '' AND (request_at LIKE '%".date("Y-m-d")."%' OR request_at > '".date("Y-m-d")."')","created_at DESC")[0];
		if($material_transactions) {
		echo "<tr>";
			echo "<td style='font-size:14px;'><b>Pass Code</b></td>";
			echo "<td style='font-size:14px;'><b>:</b></td>";
			echo "<td style='font-size:14px;'><b>".$material_transactions["token"]."</b></td>";
		echo "</tr>";
		}
		//end peminjaman material
	?>
</table>
<br>
<form method="GET">
	<input type="hidden" name="token" value="<?=$_GET["token"];?>">
	<table>
		<tr><td><b><u>Filter:</u></b></td></tr>
		<?=$t->row(["From Date",$f->input("date_start",$_GET["date_start"],"type='date'","classinput")]);?>
		<?=$t->row(["Until Date",$f->input("date_end",$_GET["date_end"],"type='date'","classinput")]);?>
		<!--
		<?=$t->row(["SOW",$f->input("txt_sow",$_GET["txt_sow"],"","classinput")]);?>
		<?=$t->row(["Site",$f->input("txt_site",$_GET["txt_site"],"","classinput")]);?>
		<tr><td colspan="2">
			<?=$f->input("search","Search","type='submit'","btn btn-info");?>&nbsp;
			<?=$f->input("","Reset","type='button' onclick='window.location=\"?token=".$_GET["token"]."\";'","btn btn-warning");?>
		</td></tr>
	</table>
</form>
-->

<?php
	$today 			= date("Y-m-d");
	$d_today		= date("d",strtotime($today));
	$m_today		= date("m",strtotime($today));
	$Y_today		= date("Y",strtotime($today));
	$date_start		= date("Y-m-d",mktime(0,0,0,$m_today-1,20,$Y_today));
	$date_end		= date("Y-m-d",mktime(0,0,0,$m_today,$d_today+1,$Y_today));
	$whereclause = "";
	if(($_GET["date_start"] != "") AND ($_GET["date_end"] != "")) {
		$whereclause .= "created_at BETWEEN '".$_GET["date_start"]."' AND '".date('Y-m-d', strtotime("+1 day", strtotime($_GET["date_end"])))."' AND ";
		} else {
		$whereclause .= "created_at BETWEEN '".$date_start."' AND '".$date_end."' AND ";
		}
	if($_GET["txt_sow"] != "") {
		$filter_sow_ids	= $db->fetch_all_data("indottech_sow", [], "name LIKE '%".$_GET["txt_sow"]."%'");
		$whereclause_2 .= "(";
			foreach($filter_sow_ids as $filter_sow_id){
			$whereclause_2 .= "sow_ids LIKE '%|".$filter_sow_id["id"]."|%' OR ";
			}
		$whereclause_2 .= ") AND ";
		$whereclause .= str_replace("OR )",")",$whereclause_2);
	}
	if($_GET["txt_site"] != "") $whereclause .= "site_name LIKE '%".$_GET["txt_site"]."%' AND ";
	$whereclause .= "user_id='".$user_id."' order by created_at DESC AND ";
	$whereclause = substr($whereclause,0,-4);
	$attendance_activities = $db->fetch_all_data("attendance_activity",[],$whereclause);
	$no=1;
	
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
	
	// $indottech_request_backdate = $db->fetch_all_data("indottech_request_backdate",[],"user_ids LIKE '%|".$user_id."|%' AND akses_mulai <= '".date("Y-m-d")."' AND akses_selesai >= '".date("Y-m-d")."'","id DESC")[0];
	// if($indottech_request_backdate["id"] != ""){
		// $min_date = date("Y-m-d",strtotime($indottech_request_backdate["akses_mulai"]));
		// $max_date = date("Y-m-d",strtotime($indottech_request_backdate["akses_selesai"]));
	// }
	
	if(date("Y-m-d") <= $max_date){
		echo "<p style='font-size:5px'>Jika akun anda baru dibuat, harap lengkapi aktifitas-aktifitas ditanggal sebelumnya melalui tombol berikut ini.</p>";
		echo $f->input("","Manual Absen","type='button' onclick='window.location=\"new_user_attendance_add.php?token=".$_GET["token"]."\";'","btn btn-danger");
		echo "&nbsp";
		echo $f->input("","Aktifitas Tgl Sebelumnya","type='button' onclick='window.location=\"new_user_activity_add.php?token=".$_GET["token"]."\";'","btn btn-danger");
		echo "&nbsp";
	}
	if(date("Y-m-d") <= $max_date && $indottech_request_backdate["id"] == ""){
		echo $f->input("","Sakit","type='button' onclick='window.location=\"attendance_sick_add.php?token=".$_GET["token"]."\";'","btn btn-danger");
	}
	//end new user back date activities
	
	echo $f->input("","My Plan","type='button' onclick='window.location=\"plan_activities.php?token=".$_GET["token"]."\";'","btn btn-info");	
?>

<div style="overflow-x:auto;">
	<table width="100%" id="data_content">
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Project</th>
			<th>SOW</th>
			<th>Sitename</th>
			<th>Deskripsi</th>
			<th>Status</th>
			<th>Direject Oleh</th>
		</tr>
		<?php
			foreach($attendance_activities as $attendance_activity){
				$id_status 	= $attendance_activity["attendance_status"];
				$status 	= $db->fetch_single_data("attendance_activity_status","name",["id" => $attendance_activity["attendance_status"]]);
				if ($attendance_activity["attendance_status"] == 0 || $attendance_activity["attendance_status"] == 16 || $attendance_activity["attendance_status"] == 17 || $attendance_activity["attendance_status"] == 18 || $attendance_activity["attendance_status"] == 19){
					$status .= " - ".$attendance_activity["reason_reject"];
				}

				$onclick 	= "";
				if((preg_match("/New User/i", $attendance_activity["description"]) || preg_match("/Backdate/i", $attendance_activity["description"])) && ($id_status == "0" || $id_status == "1" || $id_status == "7" || $id_status == "17")){
					$onclick = "onclick=\"window.location='new_user_activity_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."&user_is=new';\"";
				}else if(preg_match("/O Plan/i", $attendance_activity["description"]) && ($id_status == "0" || $id_status == "1" || $id_status == "7" || $id_status == "17")){
					$onclick = "onclick=\"window.location='activity_wo_plan_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."&mode=wo_plan';\"";
				}else if($id_status == "0" || $id_status == "1"){
					$onclick = "onclick=\"window.location='view_activities_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."&plan_site_id=".$attendance_activity["plan_site_id"]."';\"";
				} else if($id_status == "4" || $id_status == "16"){
					$onclick = "onclick=\"window.location='attendance_leave_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."&plan_site_id=".$attendance_activity["plan_site_id"]."';\"";
				} else if($id_status == "7" || $id_status == "17"){
					$onclick = "onclick=\"window.location='attendance_stand_by_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."';\"";
				} else if($id_status == "10" || $id_status == "18" || $id_status == "51"){
					$onclick = "onclick=\"window.location='attendance_sick_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."';\"";
				} else if($id_status == "12" || $id_status == "19"){
					$onclick = "onclick=\"window.location='attendance_special_leave_edit.php?token=".$_GET["token"]."&activity_id=".$attendance_activity["id"]."';\"";
				} else {
					$onclick 	= "";
				}
				
				?>
				<tr <?=$onclick;?>>
					<td align="center" width="3%"><?=$no++;?></td>
					<td width="5%"><?=format_tanggal($attendance_activity["created_at"],"d-M-Y");?></td>
					<td width="5%"><?=$db->fetch_single_data("cost_centers","concat('[',code,'] ',name)",["id" => $attendance_activity["cost_center_id"]]);?></td>
					<td>
						<?php
						$i=1;
							foreach(pipetoarray($attendance_activity["sow_ids"]) as $sow_id){
								echo $i++.". ".$db->fetch_single_data("indottech_sow","name",["id" => $sow_id])."<br>";
							}
						?>
					</td>
					<td><?=$attendance_activity["site_name"];?></td>
					<td><?=$attendance_activity["description"];?></td>
					<td><?=$status;?></td>
					<td><?=$db->fetch_single_data("users","name",["email" => $attendance_activity["reject_by"]]);?></td>
				</tr>
				<?php
			}
		?>
	</table>
</div>
<br>
<?php include_once "footer.php";?>