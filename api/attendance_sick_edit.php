<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	if($_GET["id"]){
		$id = $_GET["id"];
	} else {
		$id = explode("|",$_GET["filename"])[1];
	}
	if(!$id){exit();}
	$data			= $db->fetch_all_data("attendance_activity",[],"id = '".$id."'")[0];
	$day			= date("N",strtotime($data["leave_start"]));
	$hari			= date("l",$day);
	$filename		= $data["filephoto"];
	$kode_photo		= "";
	$kode_photo		= str_replace(".jpg","",$filename);
	$kode_photo		= str_replace("sick_","",$kode_photo);
	$txt_text		= ["Absence - Sick","Photo of SKD","Start Date","To Date","Diagnosis","Save","Back","Delete"];
	if($__group_id == "23"){
		$hari		= hari($day);
		$txt_text	= ["Ketidakhadiran - Sakit","Foto SKD","Mulai Tanggal","Selesai Tanggal","Diagnosa/Gejala","Simpan","Kembali","Hapus"];
	}
	
	if(isset($_POST["save"])){
		$_errormessage 	= "";
		$attendance_notes	= $db->fetch_single_data("attendance_notes","id",["user_id" => $user_id, "tanggal" => date("Y-m-d",strtotime($_POST["leave_start"]))]);
		$attendance_notes_2	= $db->fetch_single_data("attendance_activity","id",["user_id" => $user_id, "leave_start" => date("Y-m-d",strtotime($_POST["leave_start"]))]);
		if ($attendance_notes > 0 || ($attendance_notes_2 > 0 && $attendance_notes_2 != $_GET["activity_id"])) $_errormessage = "<p style='color:red'>Penyimpanan gagal!!</p>";
		
		if($_errormessage == ""){
			$db->addtable("attendance_activity");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("description"); 			$db->addvalue($_POST["keterangan"]);
			$db->where("id",$_GET["id"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				javascript("window.location='my_attendance.php?token=".$_GET["token"]."';");
				exit();
			}
		}
	}
	if($_GET["deleting"] && $data["attendance_status"] != "35"){
		$db->addtable("attendance_activity");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		javascript("window.location='my_attendance.php?token=".$_GET["token"]."';");
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
				<div class="col-lg-3 col-md-2 col-xs-12">
					<?php
						if(file_exists("../geophoto/".$filename)){
							?>
								<a onclick="window.location='attendance_sick_edit.php?token=<?=$_GET["token"];?>&filename=<?=$kode_photo;?>&takeactivityphoto=<?=$kode_photo;?>|<?=$id;?>';">
									<div class="icon">
										<img class="img-rounded zoom" src="../geophoto/<?=$filename;?>" alt="" style="width:100%">
									</div>
								</a>
							<?php 
						} else {
							?>
							<a onclick="window.location='attendance_sick_edit.php?token=<?=$_GET["token"];?>&filename=<?=$kode_photo;?>&takeactivityphoto=<?=$kode_photo;?>|<?=$id;?>';">
								<div class="icon">
									<img src="../icons/I_takephoto.png" style="width:100%;">
								</div>
							</a>
							<label style="color:#43579C !important;"><?=$txt_text[1];?></label>
							<?php
						}
					?>
                </div>
				&emsp;
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&id=<?=$id;?>">
					<div class="form-group">
						<label class="control-label"><?=$txt_text[4];?></label>
						<?= $f->textarea("keterangan",$data["description"],"style='height:200px;'","form-control"); ?>
					</div>  
					<br>
					<br>
					<br>
					<?=$f->input("save",$txt_text[5],"type='submit'","btn btn-common");?>
					&emsp;
					<a href="my_attendance.php?token=<?=$token;?>" class="btn btn-common"><?=$txt_text[6];?></a>
					&ensp;
					<a href="?token=<?=$token;?>&deleting=<?=$_GET["id"];?>&id=<?=$_GET["id"];?>" class="btn btn-danger"><?=$txt_text[7];?></a>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End --> 
<?php include_once "footer.php"; ?>