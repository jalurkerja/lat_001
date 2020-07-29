<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	include_once "../ajax/custom_js.php"; 
	include_once "attendance_activity_js.php";
	
	if($_GET["id"]){
		$id = $_GET["id"];
	} else {
		$id = explode("|",$_GET["filename"])[1];
	}
	if(!$id){exit();}
	$data			= $db->fetch_all_data("attendance_activity",[],"id = '".$id."'")[0];
	$day			= date("N", strtotime($data["created_at"]));
	$hari			= date("l",$day);
	$filename		= $data["filephoto"];
	$sub_activities	= $db->fetch_all_data("activities",[],"id = '".$data["activity_id"]."'")[0];
	$btn_delete		= "";
	$btn_back		= "";
	$btn_save		= "";
	$txt_text	= ["Activity Report","Selfie Photo","Job Category","Sub Category","Notes","Select Image","Save","Back"];
	if($__group_id == "23"){
		$hari		= hari($day);
		$txt_text	= ["Laporan Aktivitas","Foto Selfie","Kategori Pekerjaan","Sub Kategori","Keterangan","Pilih Gambar","Simpan","Kembali"];
	}
	if($_GET["doc_mode"]) {$doc_mode = $_GET["doc_mode"];}
	if(!$doc_mode || $doc_mode == "2"){ // mode edit
		// $btn_delete	= "delete";
		$btn_back	= "<a href='my_attendance.php?token=".$token."' class='btn btn-common'>".$txt_text[7]."</a>";
		$btn_save	= $f->input("save",$txt_text[6],"type='submit'","btn btn-common");
	}
	if($doc_mode == "1"){ // mode add
		// $btn_delete	= "hiden";
		$btn_back	= "<a href='attendance_activity_edit.php?token=".$token."&deleting=".$_GET["id"]."&id=".$_GET["id"]."' class='btn btn-common'>".$txt_text[7]."</a>";
		$btn_save	= $f->input("save",$txt_text[6],"type='submit'","btn btn-common");
	}
	
	$clue			= "parent_id";
	$parent_id		= 2;
	if($__group_id == 12){ //team indotech as enginer lapangan
		$clue			= "id";
		$parent_id		= "8,9:IN";
	}
	if($__group_id == 14){ // admin as dokumen
		$clue			= "id";
		$parent_id		= "7";
	}
	if($__group_id == 24){ // patner as project mba flo
		$clue			= "id";
		$parent_id		= "10";
	}
	
	$category		= $f->select("category",$db->fetch_select_data("activities","id","name",[$clue => $parent_id],array(),"",true),$sub_activities["parent_id"],"onchange='show_select_edit();'","dropdown-product selectpicker");
	$key			= $db->fetch_single_data("activities","parent_id",["id" => $data["activity_id"]]);
	$sub_category	= $f->select("category_id",$db->fetch_select_data("activities","id","name",["parent_id" => $key],array(),"",true),$data["activity_id"],"required","dropdown-product selectpicker");
	
	if($_GET["deleting"]){
		$db->addtable("attendance_activity");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		javascript("window.location='my_attendance.php?token=".$_GET["token"]."';");
		exit();
	}
	if(isset($_POST["save"])){
		$_errormessage 	= "";
		
		if(!file_exists("../geophoto/".$filename)){
			$_errormessage = "Harap foto selfie aktifitas anda!";
		}
		if($_errormessage == ""){
			$db->addtable("attendance_activity");
			$db->addfield("user_id"); 				$db->addvalue($__user_id);
			$db->addfield("activity_id"); 			$db->addvalue($_POST["category_id"]);
			$db->addfield("attendance_status"); 	$db->addvalue("21");
			// $db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			$db->addfield("description"); 			$db->addvalue($_POST["keterangan"]);
			$db->where("id",$_GET["id"]);
			$inserting = $db->update();
			
			if($inserting["affected_rows"] > 0){
				if($_POST["attachment"] >= 1){
					if(!$doc_mode || $doc_mode == "2"){
						javascript("window.location='attendance_activity_edit.php?token=".$_GET["token"]."&imagepick=".str_replace(".jpg","",str_replace("activityphoto_","",$filename))."|".$_GET["id"]."|2';");
					}
					if($doc_mode == "1"){
						javascript("window.location='attendance_activity_edit.php?token=".$_GET["token"]."&imagepick=".$filename."|".$_GET["id"]."|1';");
					}
				} else {
					javascript("window.location='my_attendance.php?token=".$_GET["token"]."';");
				}
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
					<font style="font-size:12px;"><?=$hari.", ".date("d-M-Y", strtotime($data["created_at"]));?></font>
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
								<img class="img-rounded zoom" src="../geophoto/<?=$filename;?>" alt="" style="width:100%">
							<?php 
						}
					?>
                </div>
				&emsp;
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&id=<?=$_GET["id"];?>">
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
						<?= $f->textarea("keterangan",$data["description"],"style='height:200px;'","form-control"); ?>
					</div>  
						<?php
							if($data["attachment"]){
								echo "Aktivitas sudah memiliki lampiran.";
							}
						?>
					<div class="custom-file mb-3">
						<?= $f->input("attachment",$_POST["attachment"],"type='hidden'",""); ?>
						<?= $f->input("lampiran",$_POST["lampiran"],"Xrequired accept='image/*' onclick='attach_yes();'","custom-file-input"); ?>
						<?php
							$text	=$txt_text[5]."...";
							if($data["attachment"]){
								$text	= "Lampiran.jpg";
							}
						?>
						<label class="custom-file-label form-control" for="file" style="padding-top:0px !important;"><?=$text;?></label>
					</div>
					<br>
					<br>
					<br>
					<?=$btn_save;?>
					&emsp;
					<?=$btn_back;?>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End -->  
<?php include_once "footer.php"; ?>