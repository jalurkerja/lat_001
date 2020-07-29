<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	
	if(date("H") >= 5 && date("H") < 12){
		$greeting = "Good Morning,";
	} else if (date("H") >= 12 && date("H") < 18){
		$greeting = "Good Afternoon,";
	} else if (date("H") >= 18 && date("H") < 22){
		$greeting = "Good Evening,";
	} else {
		$greeting = "Good Night,";
	}
	
	$add_attd	= false;
	if($__group_id == "23"){ // external
		$menu_01[] = ["../icons/I_pekerjaan.png", "hs_sa_menu", "Pekerjaan"];
		$menu_01[] = ["../icons/I_upload_data.png", "upload_data", "Upload Data"];
		$menu_01[] = ["../icons/I_ganti_password.png", "change_password", "<font style='white-space: normal;'>Ganti Password</font>"];
		$menu_01[] = ["../icons/I_logout.png", "logout", "Log Out"];
		$menu_01[] = ["../icons/I_exit.png", "exit", "Exit"];
	}
	if($__group_id == "24"){ // patner
		$menu_01[] = ["../icons/I_rekapan_kehadiran.png", "my_attendance", "Attendance"];
		$menu_01[] = ["../icons/I_ganti_password.png", "change_password", "<font style='white-space: normal;'>Change Password</font>"];
		$menu_01[] = ["../icons/I_logout.png", "logout", "Log Out"];
		$menu_01[] = ["../icons/I_exit.png", "exit", "Exit"];
		$add_attd	= true;
	}
	if($__group_id == "25"){
		$menu_01[] = ["../icons/I_rekapan_kehadiran.png", "my_attendance", "Attendance"];
		$menu_01[] = ["../icons/I_cuti.png", "attendance_leave_list", "Leave"];
		$menu_01[] = ["../icons/I_ganti_password.png", "change_password", "<font style='white-space: normal;'>Change Password</font>"];
		$menu_01[] = ["../icons/I_logout.png", "logout", "Log Out"];
		$menu_01[] = ["../icons/I_exit.png", "exit", "Exit"];
		$add_attd	= true;
	}
	if($__group_id != "23" && $__group_id != "24" && $__group_id != "25"){
		$menu_01[] = ["../icons/I_rekapan_kehadiran.png", "my_attendance", "Attendance"];
		// $menu_01[] = ["../icons/I_rekapan_kehadiran.png", "coming_soon", "Attendance"];
		$menu_01[] = ["../icons/I_cuti.png", "attendance_leave_list", "Leave"];
		$menu_01[] = ["../icons/I_offline.png", "offline", "Offline Mode"];
		$menu_01[] = ["../icons/I_ganti_password.png", "change_password", "<font style='white-space: normal;'>Change Password</font>"];
		$menu_01[] = ["../icons/I_logout.png", "logout", "Log Out"];
		$menu_01[] = ["../icons/I_exit.png", "exit", "Exit"];
	}
	
	$icon_show	= 2;
	$count_01	= count($menu_01);
	$div_01		= round(($count_01 / $icon_show),0);
	if($__group_id == "25") {
		$div_01 = $count_01/$icon_show;
		$exp_div = explode(".",$div_01);
		if($exp_div[1] > 0){
			$div_01 = $exp_div[0]+1;
		}
	}
	$start_01	= 0;
	$end_01		= 1;
	
	$temp		= date("Ymd")."_".$__user_id."_";
	$filephoto	= $db->fetch_all_data("attendance_activity",[],"user_id = '".$__user_id."' AND filephoto LIKE '%".$temp."%' order by filephoto DESC")[0];
	
	if(!$filephoto){
		$filename	= $temp."00";
	} else {
		$filename	= $temp.sprintf("%02d",(explode(".",(explode($temp,$filephoto["filephoto"])[1]))[0] + 1));
	}
	
	$start_01	= 0;
	$end_01		= 2;
	$td_width	= 100/($end_01+1)."%";
	?>
	<style>
		@font-face {
		  font-family: 'Anggada_FREE';
		  src: url('../font/Anggada_FREE.ttf')  format('truetype'); /* Safari, Android, iOS */
		}
		p, span, a {
			color:#43579C !important;
		}
	</style>
	 <!-- Testimonial Section Start -->
		<div id="testimonials" class="touch-slider owl-carousel">
		 <div class="item">
			<div class="testimonial-item" style="box-shadow: 0px 0px 10px #a6b1d9; padding:5px !important;">
				<p style="float:left; font-family:Anggada_FREE; font-size:18px;"><?=$greeting;?> <?=ucwords($nama_user);?>!</p>
			  <div class="author">
				<div class="img-thumb">
				  <img src="../icons/I_avatar.png" alt="" style="width:20%;">
				</div>
			  </div>
			  <div class="content-inner">
				<div style="width:100%; border:1px;">
					<div style="width:50%; float:left; white-space: normal;">
						<font style="color:#43579C !important;"><?=date("l");?>,</font><br>
						<font style="color:#43579C !important; font-size:22px;"><?=date("d/m");?></font><br>
						<font style="color:#43579C !important;"><?=date("Y");?></font><br>
					</div>
					<?php 
						if($add_attd == true){
						$add_activity = "onclick=\"window.location='?token=".$token."&btnMode=my_attendance_directphoto';\"";
					?>
						<div style="width:50%; float:right; white-space: nowrap; padding: 2% 0 0 0;" <?=$add_activity;?>>
							<font style="font-weight:bolder; color:#43579C !important;">Add Activity</font>
							<img src="../icons/I_activity2.png" alt="" style="width:30%;">
						</div>
					<?php } ?>
				</div>
			  </div>
			</div>
		  </div>
	  </div>
	<!-- Testimonial Section End -->  
	
	<style>
		.rad_bor {
			border-collapse: collapse;
			border-radius: 30px;
			border-style: hidden; /* hide standard table (collapsed) border */
			box-shadow: 0 0 0 1px #43579C; /* this draws the table border  */ 
		}

	</style>
	<!-- Category Section Start -->
		<table style="width:95%;" class="rad_bor" align="center">
			<tr><td style="padding:10px;">
				<table style="width:100%" border="0px" >
					<?php
						for($i=1; $i<=$div_01; $i++){
							echo "<tr>";
								for($ii=$start_01; $ii<=$end_01; $ii++){
									$onclick = "";
									if($ii < $count_01){
										$onclick = "onclick=\"window.location='?token=".$token."&btnMode=".$menu_01[$ii][1]."';\"";
										echo "<td style='width:".$td_width."; padding:12px;' align='center' ".$onclick.">
												<img src='".$menu_01[$ii][0]."' style='width:70%;'><br>
												<font style='color:#43579C !important; font-weight:bolder; font-size:12px;'>".$menu_01[$ii][2]."</font>
												</td>";
									} else {
										echo "<td>&nbsp;</td>";
									}
								}
							echo "</tr>";
							$start_01	+= $icon_show+1;
							$end_01		+= $icon_show+1;
						}
					?>
				</table>
			</td></tr>
		</table>
	<!-- Category Section End -->  

<?php include_once "footer.php"; ?>