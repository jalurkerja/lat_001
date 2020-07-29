<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	$txt_text	= ["Leave List", "Date", "Notes", "Available", "Annual Leave", "Special Leave","Submission Waiting Approval","Status"];
	$txt_notes	= ["Submission","App. by Coordinator","App. by PM","Submission Rejected"];
	if($__group_id == "23"){
		$txt_text	= ["Rekap Cuti Tahunan", "Tanggal", "Keterangan", "Sisa Cuti", "Cuti Tahunan", "Cuti Khusus","Pengajuan Menunggu Approval", "Status"];
		$txt_notes	= ["Pengajuan","Disetujui Kordinator","Disetujui PM","Pengajuan Ditolak"];	
	}
	$s_1 = "<img src='../icons/I_wait.png' style='width:15px;'>";
	$s_2 = "<img src='../icons/I_yes.png' style='width:15px;'>";
	$s_3 = "<img src='../icons/I_yes.png' style='width:15px;'><img src='../icons/I_yes.png' style='width:15px;'>";
	$s_4 = "<img src='../icons/I_no.png' style='width:15px;'>";
?>
<div class="container">
	<div class="post-job box">
		<h3 class="job-title" style="color: black !important;"><?=$txt_text[0];?></h3>
		<div class="table-responsive-sm">          
			<table class="table table-bordered table-striped" style="color: black !important;">
				<thead>
					<tr>
						<th><?=$txt_text[1];?></th>
						<th><?=$txt_text[2];?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$leaves = array();
						$db->addtable("day_off"); $db->where("tanggal",date("Y")."-%","s","LIKE"); $db->where("is_leave","1");
						$arrays = $db->fetch_data(true);
						foreach($arrays as $leave){ $leaves[$leave["tanggal"]] = $leave["keterangan"]; }
						$db->addtable("attendance_notes"); $db->where("tanggal",date("Y")."-%","s","LIKE"); $db->where("cuti","1"); $db->where("user_id",$__user_id);
						$arrays = $db->fetch_data(true);
						foreach($arrays as $leave){ $leaves[$leave["tanggal"]] = $leave["notes"]; }
						ksort($leaves);
						$jatahCuti = $db->fetch_single_data("users","leave_num",["id" => $__user_id]);
						$jmlCuti = 0;
						
						foreach($leaves as $tanggalCuti => $LeaveNotes){
							$jmlCuti++;
							echo $t->row([format_tanggal($tanggalCuti),$LeaveNotes]);
						}
						$sisaCuti = $jatahCuti - $jmlCuti;
						echo $t->row([$txt_text[3],$jatahCuti." - ".$jmlCuti." = ".$sisaCuti],["style='font-weight:bolder;'"]);
					?>
				</tbody>
			</table>
		</div>
		<?php
			if($sisaCuti > 0){
				?>
					<a href="attendance_leave_add.php?token=<?=$token;?>&sisacuti=<?=$sisaCuti;?>" class="btn btn-common"><b>+</b> <?=$txt_text[4];?></a>
					&nbsp;
				<?php
			}
			?>
			<a href="attendance_special_leave_add.php?token=<?=$token;?>&sisacuti=<?=$sisaCuti;?>" class="btn btn-common"><b>+</b> <?=$txt_text[5];?></a>
			<br>&emsp;
			<br>&emsp;
			<?php
			$pengajuan	= $db->fetch_all_data("attendance_activity",[],"user_id = '".$__user_id."' AND attendance_status IN (25,26,29,30) order by leave_start");
			if($pengajuan){
		?>
				<h3 class="job-title" style="color: black !important;"><?=$txt_text[6];?></h3>
				<div class="table-responsive-sm">          
					<table class="table table-bordered table-striped" style="color: black !important;">
						<thead>
							<tr>
								<th><?=$txt_text[1];?></th>
								<th><?=$txt_text[2];?></th>
								<th><?=$txt_text[7];?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($pengajuan as $_pengajuan){
									$onclick	= "";
									$img_status	= "";
									if($_pengajuan["attendance_status"] == 25){
										$onclick	= "onclick=\"window.location='attendance_leave_edit.php?token=".$_GET["token"]."&id=".$_pengajuan["id"]."';\"";
										$img_status = $s_1;
									}
									if($_pengajuan["attendance_status"] == 29){
										$onclick	= "onclick=\"window.location='attendance_special_leave_edit.php?token=".$_GET["token"]."&id=".$_pengajuan["id"]."';\"";
										$img_status = $s_1;
									}
									echo $t->row([format_tanggal($_pengajuan["leave_start"]),$_pengajuan["description"],$img_status],[$onclick]);
								}
							?>
						</tbody>
					</table>
				</div>
		<?php
			}
		?>
	</div>
	<div class="col-lg-12 col-md-12 col-xs-12">
		<!-- Start Pagination -->
		<ul class="pagination">              
			<li><?=$_next;?></li>
			<li><?=$next;?></li>
			<li><?=$prev;?></li>
		</ul>
		<!-- End Pagination -->
	</div>
</div>

<!-- Go To Top Link -->
<a href="#" class="back-to-top">
	<i class="lni-arrow-up"></i>
</a> 

<?php include_once "footer.php"; ?>