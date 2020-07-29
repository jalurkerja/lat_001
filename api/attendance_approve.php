<?php 
	include_once "header.php";
	include_once "user_info.php";
	include_once "../func.sendingmail.php";
		
	//start navigation
	$base_url = basename($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"];
	$_base_url = explode("page=",$base_url);
	$base_page = explode("&",$_base_url[1])[0];
	$temp = "&page=".$base_page;
	
	$__limit = "0,50";
	if(!$base_page) {
		$base_url_n = str_replace($temp,"",$base_url)."&page=".($base_page+1);
		$start = 1;
	} else {
		$num = $base_page*50;
		$start = $num + 1;
		$__limit = $num.",50";
		$base_url_p = str_replace($temp,"",$base_url)."&page=".($base_page-1);
		$base_url_n = str_replace($temp,"",$base_url)."&page=".($base_page+1);
	}
	//end navigation

	// echo "<center>".str_replace("page","xxx",$base_url)."</center>";
	// echo "<center> p ".$base_url_p."</center><br>";
	// echo "<center> n ".$base_url_n."</center><br>";
	// echo "<center> n ".$base_url."</center><br>";
	
	// if(@$_GET["sel_date_1"] == "") $_GET["sel_date_1"] = date("Y-m-d",mktime(0,0,0,date("m")-1,19,date("Y")));
	// if(@$_GET["sel_date_1"] == "") $_GET["sel_date_1"] = date("Y-m-d",mktime(0,0,0,date("m"),10,date("Y")));
	// if(@$_GET["sel_date_2"] == "") $_GET["sel_date_2"] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
	
	if(isset($_GET["approve"])){
		$attendance_detail = $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["approve"]."'")[0];
		$attendance_status = $attendance_detail["attendance_status"];
		if($attendance_status == "1") $_id_status = "2";
		if($attendance_status == "4") $_id_status = "5";
		if($attendance_status == "7") $_id_status = "8";
		if($attendance_status == "10") $_id_status = "11";
		if($attendance_status == "12") $_id_status = "13";
		$db->addtable("attendance_activity"); 	$db->where("id",$_GET["approve"]);
		$db->addfield("attendance_status");		$db->addvalue($_id_status);
		$db->addfield("approved_at");			$db->addvalue($__now);
		$db->addfield("approved_by");			$db->addvalue($__username);
		$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
		$inserting = $db->update();
		if($inserting["affected_rows"] >= 0){
			if($_id_status == "5"){
				$team_detail 	= $db->fetch_all_data("users",[],"id = '".$attendance_detail["user_id"]."'")[0];
				$send_to		= $db->fetch_single_data("users","email",["id" => $team_detail["pm_user_id"]]);
				$a_href 		= "attendance_activity_approve_list.php?personil_id=".str_replace(" ","+",$team_detail["name"])."&sel_date_1=".date("Y-m-d",strtotime($attendance_detail["created_at"]))."&sel_date_2=".date("Y-m-d",strtotime($attendance_detail["created_at"]))."&do_filter=Load";
				$isi_pesan 		= "<a href=\"$a_href\">".$team_detail["name"]."</a> menunggu Anda untuk menyetujui pengajuan Cuti Tahunannya pada tanggal ".date("d-M-Y",strtotime($attendance_detail["leave_start"]))." hingga ".date("d-M-Y",strtotime($attendance_detail["leave_end"])).".";
				sendingmail("Pengajuan Cuti -- Approve Request",$send_to,str_replace("attendance_activity_approve_list.php","http://103.253.113.201/indottech/attendance_activity_approve_list.php",$isi_pesan));
			}
			
			$db->addtable("attendance_notes");
			$db->addfield("user_id");			$db->addvalue($attendance_detail["user_id"]);
			if ($_id_status == "11" ){
				$db->addfield("tanggal");			$db->addvalue(format_tanggal($attendance_detail["created_at"],"Y-m-d"));
				$db->addfield("notes");				$db->addvalue("Sakit");
				$db->addfield("attended");			$db->addvalue("0");
				$db->addfield("surat_dokter");		$db->addvalue("1");
				$db->addfield("cuti");				$db->addvalue("0");
				$inserting = $db->insert();
			} else if ($_id_status == "13" ){
				$db->addfield("tanggal");			$db->addvalue(format_tanggal($attendance_detail["leave_start"],"Y-m-d"));
				$db->addfield("notes");				$db->addvalue("Cuti Khusus");
				$db->addfield("cuti_khusus");		$db->addvalue("1");
				$inserting = $db->insert();
				if($inserting["affected_rows"] >= 0){
					if(date("Y-m-d",strtotime($attendance_detail["leave_start"])) > date("Y-m-d",strtotime($attendance_detail["created_at"]))){
						$db->addtable("attendance_activity"); 	
						$db->addfield("user_id");				$db->addvalue($attendance_detail["user_id"]);
						$db->addfield("description");			$db->addvalue("Cuti khusus pengajuan tanggal ".date("d-M-Y",strtotime($attendance_detail["created_at"])));
						$db->addfield("leave_start");			$db->addvalue(date("Y-m-d",strtotime($attendance_detail["leave_start"])));
						$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i;s",strtotime($attendance_detail["leave_start"])));
						$db->addfield("attendance_status");		$db->addvalue("13");
						$db->addfield("approved_at");			$db->addvalue($__now);
						$db->addfield("approved_by");			$db->addvalue("System");
						$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
						$inserting = $db->insert();
					}
				}
			} else {
			}
			javascript("alert('Activity Submission for Approval');");
			javascript("window.location='?token=".$_GET["token"]."&cost_center_id=".$_GET["cost_center_id"]."&personil_id=".$_GET["personil_id"]."';");
		} else {
			javascript("alert('Approved data failed');");
			javascript("window.location='?token=".$_GET["token"]."';");
		}
	}
	
	if(isset($_POST["save"])){
		if(!$_POST["pilih"]){
			javascript("alert('Tidak ada aktifitas terpilih untuk di-Approve!');");
		} else {
			foreach($_POST["pilih"] as $selected){
				$attendance_detail = $db->fetch_all_data("attendance_activity",[],"id ='".$selected."'")[0];
				$attendance_status = $attendance_detail["attendance_status"];
				if($attendance_status == "1") {$_id_status = "2";}
				if($attendance_status == "4") {$_id_status = "5";}
				if($attendance_status == "7") {$_id_status = "8";}
				if($attendance_status == "10") {$_id_status = "11";}
				if($attendance_status == "12") {$_id_status = "13";}
				$db->addtable("attendance_activity"); 	$db->where("id",$selected);
				$db->addfield("attendance_status");		$db->addvalue($_id_status);
				$db->addfield("approved_at");			$db->addvalue($__now);
				$db->addfield("approved_by");			$db->addvalue($__username);
				$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
				$inserting = $db->update();
					if($inserting["affected_rows"] >= 0){
						$_attd_activity = $db->fetch_all_data("attendance_activity",[],"id ='".$selected."'")[0];
						if($_attd_activity["attendance_status"] == "11"){
							$db->addtable("attendance_notes");
							$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
							$db->addfield("tanggal");				$db->addvalue(format_tanggal($_attd_activity["created_at"],"Y-m-d"));
							$db->addfield("notes");					$db->addvalue("Sakit");
							$db->addfield("surat_dokter");			$db->addvalue("1");
							$inserting = $db->insert();
						}
						if($_attd_activity["attendance_status"] == "13"){
							$db->addtable("attendance_notes");
							$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
							$db->addfield("tanggal");				$db->addvalue(format_tanggal($_attd_activity["leave_start"],"Y-m-d"));
							$db->addfield("notes");					$db->addvalue("Cuti Khusus");
							$db->addfield("cuti_khusus");			$db->addvalue("1");
							$_inserting = $db->insert();
							if($_inserting["affected_rows"] >= 0){
								if(date("Y-m-d",strtotime($_attd_activity["leave_start"])) > date("Y-m-d",strtotime($_attd_activity["created_at"]))){
									$db->addtable("attendance_activity"); 	
									$db->addfield("user_id");				$db->addvalue($_attd_activity["user_id"]);
									$db->addfield("description");			$db->addvalue("Cuti khusus pengajuan tanggal ".date("d-M-Y",strtotime($_attd_activity["created_at"])));
									$db->addfield("leave_start");			$db->addvalue(date("Y-m-d",strtotime($_attd_activity["leave_start"])));
									$db->addfield("created_at");			$db->addvalue(date("Y-m-d H:i;s",strtotime($_attd_activity["leave_start"])));
									$db->addfield("attendance_status");		$db->addvalue("13");
									$db->addfield("approved_at");			$db->addvalue($__now);
									$db->addfield("approved_by");			$db->addvalue($__username);
									$db->addfield("approved_ip");			$db->addvalue($__remoteaddr);
									$inserting = $db->insert();
								}
							}
						}
						$error_message = "Aktifitas berhasil di Approve!";
					} else {
						$error_message = "Approved data failed!";
					}
			}
			javascript("alert('".$error_message."');");
			javascript("window.location='?token=".$_GET["token"]."';");
		}
	}
	
	if(isset($_POST["reject"])){
		$attendance_status = $db->fetch_single_data("attendance_activity","attendance_status",["id" => $_POST["reject_id"]]);
		if($attendance_status == "1") $_id_status = "0";
		if($attendance_status == "2") $_id_status = "0";
		if($attendance_status == "4") $_id_status = "16";
		if($attendance_status == "5") $_id_status = "16";
		if($attendance_status == "7") $_id_status = "17";
		if($attendance_status == "8") $_id_status = "17";
		if($attendance_status == "10") $_id_status = "18";
		if($attendance_status == "12") $_id_status = "19";
		$errormessage="";
		if($_POST["reason_reject"] =="") $errormessage = "Please fill the reason!";
		if($errormessage == ""){
			$db->addtable("attendance_activity");		$db->where("id",$_POST["reject_id"]);
			$db->addfield("reason_reject");				$db->addvalue($_POST["reason_reject"]);
			$db->addfield("attendance_status");			$db->addvalue($_id_status);
			$db->addfield("reject_at");					$db->addvalue($__now);
			$db->addfield("reject_by");					$db->addvalue($__username);
			$inserting = $db->update();
			if($inserting["affected_rows"] >= 0){
				javascript("alert('Activity Has Rejected');");
			} else {
				javascript("alert('Reject Failed');");
			}
		} else {
			javascript("alert('".$errormessage."');");
		}
	}
?>

	<!-- Start Filter Form -->
	<div class="conteainer-search" id="conteainer-search">
	   <div class="position_mode_form" id="position_mode_form">
			<div id="pop_up_title"></div>
			<span id="search_close" onclick="close_search();">X</span>
				<?=$f->start("filter","GET");?>
					<?=$t->start("width='100%'","editor_content");?>
					<?php
						if(@$_GET["sel_date_1"] == "") $_GET["sel_date_1"] = date("Y-m-d",mktime(0,0,0,date("m")-1,19,date("Y")));
						// if(@$_GET["sel_date_1"] == "") $_GET["sel_date_1"] = date("Y-m-d",mktime(0,0,0,date("m"),10,date("Y")));
						if(@$_GET["sel_date_2"] == "") $_GET["sel_date_2"] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
						$sel_CC			= $f->input("cost_center_id",@$_GET["cost_center_id"],"style='width:100%;'");
						$sel_personil	= $f->input("personil_id",@$_GET["personil_id"],"style='width:100%;'");
						$sel_site		= $f->input("site_id",@$_GET["site_id"],"style='width:100%;'");
						$sel_date_1		= $f->input("sel_date_1",@$_GET["sel_date_1"],"type='date'","style='width:100%;'");
						$sel_date_2		= $f->input("sel_date_2",@$_GET["sel_date_2"],"type='date'","style='width:100%;'");
					?>
					<?=$t->row(array("Project",$sel_CC));?>
					<?=$t->row(array("Team",$sel_personil));?>
					<?=$t->row(array("Site",$sel_site));?>
					<?=$t->row(array("Date",$sel_date_1));?>
					<?=$t->row(array("",$sel_date_2));?>
					<?=$t->end();?>
					<?=$f->input("token",@$_GET["token"],"type='hidden'");?>
					<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
					<?=$f->input("do_filter","Load","type='submit'","btn btn-primary");?>
					<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?token=".@$_GET["token"]."&reset=1';\"","btn btn-warning");?>
				<?=$f->end();?>
	   </div>
	</div>
	<!-- End Filter Form -->
	
	<!-- Start Filter Form -->
	<div class="conteainer-reject" id="conteainer-reject">
	   <div class="position_mode_form" id="position_mode_form">
			<div id="pop_up_title"></div>
			<span id="search_close" onclick="close_search();">X</span>
				<form method="POST" action="?token=<?=$_GET["token"];?>&cost_center_id=<?=$_GET["cost_center_id"];?>&personil_id=<?=$_GET["personil_id"];?>">
					<?=$t->start("width='100%'","editor_content");?>
					<?php
						$reason_reject		= $f->textarea("reason_reject",@$_GET["reason_reject"],"style='width:100%;height:80px;'","classinput");
					?>
					<?=$t->row(array("Reason Reject",$reason_reject));?>
					<?=$t->end();?>
					<?=$f->input("token",@$_GET["token"],"type='hidden'");?>
					<?=$f->input("reject_id",@$_GET["reject_id"],"type='hidden'");?>
					<?=$f->input("reject","Reject","type='submit'","btn btn-danger");?>
				</form>
	   </div>
	</div>
	<!-- End Filter Form -->

<table width="100%">
	<tr>
		<td align="left"><h4><b>Approve Teams Activities</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>
<center><?=$_message;?></center>

<script>
	function toggle(source) {
	  checkboxes = document.getElementsByName('pilih[]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	  }
	}
</script>

<?php
	$_GET["sel_date_1"] = date("Y-m-d 00:00:00",strtotime($_GET["sel_date_1"]));
	$_GET["sel_date_2"] = date("Y-m-d 23:59:59",strtotime($_GET["sel_date_2"]));
	$whereclause = "";

	if(@$_GET["cost_center_id"]!="")	$whereclause .= "cost_center_id IN (SELECT cost_centers.id FROM cost_centers WHERE cost_centers.code LIKE '%".$_GET["cost_center_id"]."%' OR cost_centers.name LIKE '%".$_GET["cost_center_id"]."%') AND ";
	if(@$_GET["site_id"]!="") 			$whereclause .= "site_id IN (SELECT indottech_sites.id FROM indottech_sites WHERE indottech_sites.kode LIKE '%".$_GET["site_id"]."%' OR indottech_sites.name LIKE '%".$_GET["site_id"]."%') AND ";
	if(@$_GET["personil_id"]!="") 		{$whereclause .= "user_id IN (SELECT users.id FROM users WHERE users.email LIKE '%".$_GET["personil_id"]."%' OR users.name LIKE '%".$_GET["personil_id"]."%') AND ";
										$db->order("user_id ASC");}
	
	if($_SESSION["group_id"] == "0") {
		$in_ids = "SELECT indottech_plan_activities.id FROM indottech_plan_activities WHERE indottech_plan_activities.id > 0";
	} else {
		$in_ids = "SELECT indottech_plan_activities.id FROM indottech_plan_activities WHERE indottech_plan_activities.created_by LIKE '%".$_SESSION["username"]."%'";
	}
	$whereclause .= "(indottech_plan_id IN (".$in_ids.") OR approved_by LIKE '%".$_SESSION["username"]."%') AND attendance_status IN (1,4,7,10,12) AND ";
	$whereclause .= "created_at BETWEEN '".$_GET["sel_date_1"]."' AND '".$_GET["sel_date_2"]."' AND ";
	
	$db->addtable("attendance_activity");
	$db->awhere(substr($whereclause,0,-4));
	$db->limit($__limit);
	$db->order("created_at ASC");

	$attendance_activities = $db->fetch_data(true);
	
	function hari($day){
		$arr[1] = "Senin";
		$arr[2] = "Selasa";
		$arr[3] = "Rabu";
		$arr[4] = "Kamis";
		$arr[5] = "Jumat";
		$arr[6] = "Sabtu";
		$arr[7] = "Minggu";
		return $arr[$day];
	}
	
	// echo $db->get_last_query();
	
	//start navigation
	$count_data =count($db->fetch_all_data("attendance_activity",["id"],substr($whereclause,0,-4)));
	$dividen = ceil($count_data/50);

	if($base_page >= 1) {$prev = "<a href=".$base_url_p."><font color='black' size='2px'>&#60;&#60; Prev</font></a>";}
	if($dividen > ($base_page+1)) {$next = "<a href=".$base_url_n."><font color='black' size='2px'>Next &#62;&#62;</font></a>";}
	$__pages = $prev."&emsp;".$next;
	//end navigation
?>

<form method="POST" action="?token=<?=$_GET["token"];?>">
	<?=$f->input("filter","Filter","type='button' onclick='open_search();'","btn btn-warning");?>
	<?php if($_GET["do_filter"]) echo $f->input("","Reset","type='button' onclick='window.location=\"?token=".$_GET["token"]."\";'","btn btn-danger");?>
	<?=$f->input("save","Approve","type='submit'","btn btn-primary");?>
	<br>
	&emsp;<?=$__pages;?>
	<?php $select_all = $f->input("select_all","Select All","type='checkbox' onClick='toggle(this)'"); ?>
	<div style="overflow-x:auto;">
		<table width="100%" id="data_content">
			<?=$t->header(array($select_all,
								"No",
								"Actions",
								"Date",
								"Project",
								"Personil",
								"Actual SOW",
								"Actual Site",
								"Description",
								"Status"
								));?>

		<?php
			$no=1;
			foreach($attendance_activities as $no => $attendance_activity){
				if($_SESSION["group_id"] == "0" || ($attendance_activity["attendance_status"] == "1" || $attendance_activity["attendance_status"] == "4" || $attendance_activity["attendance_status"] == "7" || $attendance_activity["attendance_status"] == "10" || $attendance_activity["attendance_status"] == "12")) {
					$i=1;
					$j=1;
					$team_name	= $db->fetch_single_data("users","name",["id" => $attendance_activity["user_id"]]);
					$attendance_longitude = $db->fetch_single_data("attendance","longitude",["id" => $attendance_activity["attendance_id"]]);
					$attendance_latitude = $db->fetch_single_data("attendance","latitude",["id" => $attendance_activity["attendance_id"]]);
					if($attendance_activity["longitude"] != "") $attendance_longitude = $attendance_activity["longitude"];
					if($attendance_activity["latitude"] != "") $attendance_latitude = $attendance_activity["latitude"];
					//start set access
					$module = "Activities";
					$mode = "approve";
					$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$_SESSION["user_id"]."|%:LIKE"]);
					if($_SESSION["group_id"] == 0 || $access || strtolower($_SESSION["username"]) == strtolower($_attendance_activity["approved_by"])){
						$actions = "<a href='#' onclick=\"window.location='?token=".$_GET["token"]."&approve=".$attendance_activity["id"]."&cost_center_id=".$_GET["cost_center_id"]."&personil_id=".$_GET["personil_id"]."'\">Approve</a> |
									<a href='#' onclick='open_reject(".$attendance_activity["id"].");'>Reject</a>";
					} else {
						$_actions = "";
					}
					//end set access
					$indottech_plan_activities = $db->fetch_all_data("indottech_plan_activities",[],"id = '".$attendance_activity["indottech_plan_id"]."'")[0];
					$cost_center_name 	= $db->fetch_single_data("cost_centers","name",["id" => $attendance_activity["cost_center_id"]]);
					$status 			= $db->fetch_single_data("attendance_activity_status","name",["id" => $attendance_activity["attendance_status"]]);
					
					//start tgl merah
					$day	= date("N",strtotime($attendance_activity["created_at"]));
					$red_1	= "";
					$red_2	= hari($day);
					if(date("N",strtotime($attendance_activity["created_at"])) == 7){
						$red_1 = "style='font-weight:bold; color:red;'";
					}
					$currentDate = date("Y-m-d",strtotime($attendance_activity["created_at"]));
					$day_off = $db->fetch_single_data("day_off","id",["tanggal" => "%".$currentDate."%:LIKE"]);
					if($day_off > 0){
						$red_1 = "style='font-weight:bold; color:red;'";
						$red_2 = "<br>Public Holiday";
					}
					//end tgl merah
					$_tag_cuti = "";
					if($attendance_activity["attendance_status"] == "4"){
						$_tag_cuti = "style = 'color: red;'";
					}
					?>
						<tr <?=$_tag_cuti;?>>
							<td align="center"><?=$f->input("pilih[]",$attendance_activity["id"],"style='height:20px;' type='checkbox' ");?></td>
							<td align="center"><?=$start++;?></td>
							<td><?=$actions;?></td>
							<td nowrap <?=$red_1;?>><?=$red_2;?><br><?=date("d-M-Y",strtotime($attendance_activity["created_at"]));?></td>
							<td><?=$cost_center_name;?></td>
							<td nowrap><?=$team_name;?></td>
							<td nowrap>
								<?php
									foreach(pipetoarray($attendance_activity["sow_ids"]) as $sow_id){
										echo $j++.". ".$db->fetch_single_data("indottech_sow","name",["id" => $sow_id])."<br>";
									}
								?>
							</td>
							<td><?=$attendance_activity["site_name"];?></td>
							<td><?=$attendance_activity["description"];?></td>
							<!--
							<td>
								<?php 
									$filename = "activityphoto_".$attendance_activity["user_id"]."_".$attendance_activity["indottech_plan_id"]."_".$attendance_activity["plan_site_id"].".jpg";
									if($attendance_activity["plan_site_id"] == 0) $filename = "activityphoto_".$attendance_activity["user_id"]."_".$attendance_activity["id"]."_.jpg"; 
									if(file_exists("../geophoto/".$filename)){
										echo "<img src='../geophoto/".$filename."' width='150' height='150' onclick='window.open(\"geophoto/".$filename."\");'>";
									}
								?>
							</td>
							-->
							<td><?=$status;?></td>
						</tr>
				<?php
				}	
			}	
		?>
		</table>
	</div>
	&emsp;<?=$__pages;?>
</form>

<?php include_once "pop_up_js.php";?>
<?php include_once "footer.php";?>