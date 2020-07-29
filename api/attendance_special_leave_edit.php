<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	$data			= $db->fetch_all_data("attendance_activity",[],"id = '".$_GET["id"]."'")[0];
	$day			= date("N",$data["leave_start"]);
	$hari			= date("l",$day);
	$txt_text		= ["Submission - Special Leave", "Notes", "Save", "Back", "Delete"];
	if($__group_id == "23"){
		$hari		= hari($day);
		$txt_text	= ["Pengajuan - Cuti Khusus", "Keterangan", "Perbaharui", "Kembali", "Hapus"];
	}
	
	if(isset($_POST["save"])){
		$_errormessage 	= "";
		if($_errormessage == ""){
			$db->addtable("attendance_activity");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("description"); 			$db->addvalue($_POST["keterangan"]);
			$db->where("id",$_GET["id"]);
			$inserting = $db->update();
				
			if($inserting["affected_rows"] > 0){
				javascript("window.location='attendance_leave_list.php?token=".$_GET["token"]."';");
				exit();
			}
		}
	}
	
	if($_GET["deleting"] && $data["	attendance_status"] != "31"){
		$db->addtable("attendance_activity");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		javascript("window.location='attendance_leave_list.php?token=".$_GET["token"]."';");
		exit();
	}
?>
<!-- Content section Start --> 
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-9 col-md-12 col-xs-12">
			<div class="post-job box">
				<h3 class="job-title"><?=$txt_text[0];?><br> 
					<font style="font-size:12px;"><?=$hari.", ".date("d-M-Y",strtotime($data["leave_start"]));?></font>
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
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&id=<?=$_GET["id"];?>">
					<div class="form-group">
						<label class="control-label"><?=$txt_text[1];?></label>
						<?= $f->textarea("keterangan",$data["description"],"required style='height:200px;'","form-control"); ?>
					</div>  
					<br>
					<br>
					<br>
					<?=$f->input("save",$txt_text[2],"type='submit'","btn btn-common");?>
					&ensp;
					<a href="attendance_leave_list.php?token=<?=$token;?>" class="btn btn-common"><?=$txt_text[3];?></a>
					&ensp;
					<a href="?token=<?=$token;?>&deleting=<?=$_GET["id"];?>" class="btn btn-danger"><?=$txt_text[4];?></a>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End -->  
<?php include_once "footer.php"; ?>