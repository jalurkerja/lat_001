<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	include_once "../ajax/custom_js.php"; 
	include_once "attendance_activity_js.php";

	$day		= date("N");
	$temp_name	= $_GET["filename"];
	$filename	= $temp_name.".jpg";
	$hari		= date("l");
	$txt_text	= ["Activity Report","Selfie Photo","Job Category","Sub Category","Notes","Select Image","Save","Back"];
	if($__group_id == "23"){
		$hari		= hari($day);
		$txt_text	= ["Laporan Aktivitas","Foto Selfie","Kategori Pekerjaan","Sub Kategori","Keterangan","Pilih Gambar","Simpan","Kembali"];
	}
	
	
	$clue			= "parent_id";
	$parent_id		= 2;
	if($__group_id == 12){	//team tis
		$clue			= "id";
		$parent_id		= "8,9,100:IN";
	}
	if($__group_id == 14){	//Admin
		$clue			= "id";
		$parent_id		= "7,100:IN";
	}
	if($__group_id == 24){	//Patner
		$clue			= "id";
		$parent_id		= "10";
	}
	if($__group_id == 25){	//Team PMS
		$clue			= "id";
		$parent_id		= "8,9,100:IN";
	}
	
	$category		= $f->select("category",$db->fetch_select_data("activities","id","name",[$clue => $parent_id],array(),"",true),$_POST["category"],"onchange='show_select();'","dropdown-product selectpicker");
	$key_1			= 1;
	$key_2			= 2;
	if($_POST["category_id"]){
		$key_1		= "parent_id";
		$key_2		= $_POST["category"];
	}
	$sub_category	= $f->select("category_id",$db->fetch_select_data("activities","id","name",[$key_1 => $key_2],array(),"",true),$_POST["category_id"],"required","dropdown-product selectpicker");
	
	if(isset($_POST["save"])){
		$tap			= date("Y-m-d H:i:s");
		$latitude 		= "0";
		$longitude 		= "0";
		$_errormessage 	= "";
		$cek_photo		= $db->fetch_all_data("attendance_photos",[],"filename LIKE '%".$filename."%' order by id desc")[0];
		if($cek_photo){
			$latitude 	= $cek_photo["latitude"];
			$longitude 	= $cek_photo["longitude"];
			$ex_lat		= explode(".",$latitude);
			$ex_long	= explode(".",$longitude);
			$est_lat	= $ex_lat[0].".".substr($ex_lat[1],0,3);
			$est_long	= $ex_long[0].".".substr($ex_long[1],0,3);
			// $est_site	= "";
			// $est_site	= $db->fetch_all_data("indottech_sites",[],"created_at >= '2019-11-11 00:00:01' AND latitude LIKE '".$est_lat."%' AND longitude LIKE '".$est_long."%' order by created_at desc")[0];
			// if(!$est_site){
				// $est_lat	= $ex_lat[0].".".substr($ex_lat[1],0,2);
				// $est_long	= $ex_long[0].".".substr($ex_long[1],0,2);
				// $est_site	= "";
				// $est_site	= $db->fetch_all_data("indottech_sites",[],"created_at >= '2019-11-11 00:00:01' AND latitude LIKE '".$est_lat."%' AND longitude LIKE '".$est_long."%' order by created_at desc")[0];
			// }
			// if(!$est_site){
				// $_errormessage	= "Anda berada diluar batas kordinat site, silahkan ulangi foto atau dekati titik kordinat site!";
			// }
		}
		
		if($_errormessage == ""){
			$val_attendance_id	= "";
			$val_attendance_id	= $db->fetch_single_data("users","attendance_id",["id" => $user_id]);
			$db->addtable("attendance");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("attendance_id"); 		$db->addvalue($val_attendance_id);
			$db->addfield("tap_time"); 				$db->addvalue($tap);
			$db->addfield("longitude"); 			$db->addvalue($longitude);
			$db->addfield("latitude"); 				$db->addvalue($latitude);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$attendance_id = $inserting["insert_id"];
				// $db->addtable("attendance_activity");
				// $db->addfield("attendance_id"); 		$db->addvalue($attendance_id);
				// $db->addfield("user_id"); 				$db->addvalue($__user_id);
				// $db->addfield("activity_id"); 			$db->addvalue($_POST["category_id"]);
				// $db->addfield("attendance_status"); 	$db->addvalue("21");
				// if($est_site){
					// $db->addfield("site_id"); 				$db->addvalue($est_site["id"]);
					// $db->addfield("site_name"); 			$db->addvalue($est_site["name"]);
				// }
				// // $db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
				// $db->addfield("description"); 			$db->addvalue($_POST["keterangan"]);
				// $db->addfield("filephoto"); 			$db->addvalue("activityphoto_".$filename);
				// $db->addfield("longitude"); 			$db->addvalue($longitude);
				// $db->addfield("latitude"); 				$db->addvalue($latitude);
				// $db->addfield("attachment"); 			$db->addvalue($attachment_name);
				// $inserting = $db->insert();
				
				// if($inserting["affected_rows"] > 0){
					// if($_POST["attachment"] >= 1){
						// javascript("window.location='attendance_activity_edit.php?token=".$_GET["token"]."&imagepick=".$temp_name."|".$inserting["insert_id"]."|1';");
					// } else {
						javascript("window.location='my_attendance_v2.php?token=".$_GET["token"]."';");
					// }
					exit();
				// }
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
				<!--
				<div class="col-lg-3 col-md-2 col-xs-12">
				-->
				<div class="col-xs-12">
					<?php
						if(file_exists("../geophoto/activityphoto_".$filename)){
							?>
								<a onclick="window.location='attendance_activity_add.php?token=<?=$_GET["token"];?>&filename=<?=$_GET["filename"];?>&takeactivityphoto=<?=$_GET["filename"];?>';">
									<div class="icon">
										<img class="img-rounded zoom" src="../geophoto/activityphoto_<?=$filename;?>" alt="" style="width:100%">
									</div>
								</a>
							<?php 
						} else {
							?>
							<a onclick="window.location='attendance_activity_add.php?token=<?=$_GET["token"];?>&filename=<?=$_GET["filename"];?>&takeactivityphoto=<?=$_GET["filename"];?>';">
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
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&filename=<?=str_replace(".jpg","",$filename);?>">
					<!--
					<div class="form-group">
						<label class="control-label"><?=$txt_text[2];?></label>
						<div class="search-category-container">
							<label class="styled-select">
								<?=$category;?>
							</label>
						</div>
					</div> 
					<div class="form-group">
						<label class="control-label"><?=$txt_text[3];?></label>
						<div class="search-category-container">
							<label class="styled-select">
								<?=$sub_category;?>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label"><?=$txt_text[4];?></label>
						<?= $f->textarea("keterangan",$_POST["keterangan"],"style='height:200px;'","form-control"); ?>
					</div>  
					<div class="custom-file mb-3">
						<?= $f->input("attachment",$_POST["attachment"],"type='hidden'",""); ?>
						<?= $f->input("lampiran",$_POST["lampiran"],"Xrequired accept='image/*' onclick='attach_yes();'","custom-file-input"); ?>
						<label class="custom-file-label form-control" for="file" style="padding-top:0px !important;"><?=$txt_text[5];?>...</label>
					</div>
					-->
					<br>
					<br>
					<br>
					<?=$f->input("save",$txt_text[6],"type='submit'","btn btn-common");?>
					&emsp;
					<a href="my_attendance_v2.php?token=<?=$token;?>" class="btn btn-common"><?=$txt_text[7];?></a>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End -->  
<?php include_once "footer.php"; ?>