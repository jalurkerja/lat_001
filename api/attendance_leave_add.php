<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	$day			= date("N");
	$hari			= date("l",$day);
	$leave_start	= $f->input("leave_start",$_POST["leave_start"],"required max='".date("Y-m-d", mktime(0,0,0,12,31,date("y")))."' min='".date("Y-m-d", mktime(0,0,0,date("m")-1,20,date("y")))."' type='date' autocomplete='off'","form-control");
	$leave_end		= $f->input("leave_end",$_POST["leave_end"]," max='".date("Y-m-d", mktime(0,0,0,12,31,date("y")))."' min='".date("Y-m-d", mktime(0,0,0,date("m")-1,20,date("y")))."' type='date' autocomplete='off'","form-control");
	$txt_text		= ["Submission - Annual Leave", "Start Date", "To Date", "Notes", "Save", "Back"];
	if($__group_id == "23"){
		$hari		= hari($day);
		$txt_text	= ["Pengajuan - Cuti Tahunan", "Mulai Tanggal", "Selesai Tanggal", "Keterangan", "Simpan", "Kembali"];
	}
	
	if(isset($_POST["save"])){
		$_errormessage 	= "";
		if(!$_POST["leave_end"]) $_POST["leave_end"] = $_POST["leave_start"];
		$attendance_notes	= $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "tanggal" => date("Y-m-d",strtotime($_POST["leave_start"]))]);
		$attendance_notes_2	= $db->fetch_single_data("attendance_activity","id",["user_id" => $user_id, "leave_start" => date("Y-m-d",strtotime($_POST["leave_start"])).":>=", "leave_end" => date("Y-m-d",strtotime($_POST["leave_end"])).":<="]);
		
		if($attendance_notes > 0 || $attendance_notes_2 > 0) $_errormessage = "<p style='color:red'>Penyimpanan gagal!!</p>";
		if($_POST["leave_start"] > $_POST["leave_end"]){
			$_errormessage = "Penyimpanan Gagal!";
		}
		$datetime1 	= new DateTime(date("Y-m-d",strtotime($_POST["leave_start"])));
		$datetime2 	= new DateTime(date("Y-m-d",strtotime($_POST["leave_end"])));
		$difference = $datetime1->diff($datetime2);
		$numdate	= $difference->days+1;
		if($numdate > $_GET["sisacuti"]){
			$_errormessage = "Sisa Cuti Anda Tiak Mencukupi!";
		}
		
		if($_errormessage == ""){
			for($x=0; $x<$numdate; $x++){
				$m = substr($_POST["leave_start"],5,2);
				$d = substr($_POST["leave_start"],8,2) + $x;
				$y = substr($_POST["leave_start"],0,4);
				$currentDate = date("Y-m-d",mktime(0,0,0,$m,$d,$y));
				
				$db->addtable("attendance_activity");
				$db->addfield("user_id"); 				$db->addvalue($user_id);
				$db->addfield("attendance_status"); 	$db->addvalue("25");
				$db->addfield("activity_id"); 			$db->addvalue("5");
				$db->addfield("description"); 			$db->addvalue($_POST["keterangan"]);
				// $db->addfield("attachment"); 			$db->addvalue($attachment_name);
				// $db->addfield("original_attachment"); 	$db->addvalue($_FILES['lampiran']['name']);
				// $db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
				$db->addfield("leave_start"); 			$db->addvalue($currentDate);
				$db->addfield("leave_end"); 			$db->addvalue($currentDate);
				$db->addfield("created_at"); 			$db->addvalue($currentDate);
				$db->addfield("leave_form_created"); 	$db->addvalue($__now);
				$inserting = $db->insert();
			}
				
			if($inserting["affected_rows"] > 0){
				javascript("window.location='attendance_leave_list.php?token=".$_GET["token"]."';");
				exit();
			}
		}
	}
	
?>
<!-- Content section Start --> 
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-9 col-md-12 col-xs-12">
			<div class="post-job box">
				<h3 class="job-title"><?=$txt_text[0];?><br> 
					<font style="font-size:12px;"><?=$hari.", ".date("d-M-Y");?></font>
					<?php
						if($_errormessage){
							echo "<br><font style='font-size:12px; color:red;' id='_errormessage'>".$_errormessage."</font>";
							?>
							<script>
								setTimeout(function(){ 
									$("#_errormessage").fadeOut("slow");
								}, 3000)
							</script>
							<?php
						}
					?>
				</h3>
				&emsp;
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&sisacuti=<?=$_GET["sisacuti"];?>">
					<div class="form-group">
						<label class="control-label"><?=$txt_text[1];?></label>
						<?= $leave_start;?>
					</div>  
					<div class="form-group">
						<label class="control-label"><?=$txt_text[2];?></label>
						<?= $leave_end;?>
					</div> 
					<div class="form-group">
						<label class="control-label"><?=$txt_text[3];?></label>
						<?= $f->textarea("keterangan",$_POST["keterangan"],"required style='height:200px;'","form-control"); ?>
					</div>  
					<br>
					<br>
					<br>
					<?=$f->input("save",$txt_text[4],"type='submit'","btn btn-common");?>
					&emsp;
					<a href="attendance_leave_list.php?token=<?=$token;?>" class="btn btn-common"><?=$txt_text[5];?></a>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End -->  
<?php include_once "footer.php"; ?>