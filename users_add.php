<?php include_once "head.php";?>
<?php include_once "users_js.php";?>
<?php include_once "func.sendingmail.php"; ?>
<div class="bo_title">Add User</div>
<?php
//start set access
$module = "Users";
$url = explode("_",$_SERVER["PHP_SELF"]);
$mode = explode(".",end($url))[0];
$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$_SESSION["user_id"]."|%:LIKE"]);
if(@$_SESSION["group_id"] == 0 || $access){
	if(isset($_POST["save"])){
		$users = $db->fetch_all_data("users",["id"],"email= '".strtolower($_POST["email"])."'")[0];
		$errormessage = "";
		if($users["id"] > 0) $errormessage = "Saving data failed, Email has registered!";
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  $errormessage = "Invalid email format"; 
		}
		if($errormessage == ""){
			$db->addtable("users");
			$db->addfield("group_id");				$db->addvalue(@$_POST["group_id"]);
			$db->addfield("forbidden_chr_dashboards");$db->addvalue($__main_menu_id);
			$db->addfield("email");					$db->addvalue(strtolower($_POST["email"]));
			$db->addfield("password");				$db->addvalue(base64_encode(@$_POST["password"]));
			$db->addfield("name");					$db->addvalue(@$_POST["name"]);
			$db->addfield("job_title");				$db->addvalue(@$_POST["job_title"]);
			$db->addfield("job_division");			$db->addvalue(@$_POST["job_division"]);
			$db->addfield("pm_user_id");			$db->addvalue(@$_POST["pm_user_id"]);
			$db->addfield("region_id");				$db->addvalue(@$_POST["region_id"]);
			$db->addfield("attendance_id");			$db->addvalue(@$_POST["attendance_id"]);
			$db->addfield("candidate_code");		$db->addvalue(strtoupper($_POST["candidate_code"]));
			$db->addfield("leave_num");				$db->addvalue(@$_POST["leave_num"]);
			$db->addfield("on_board");				$db->addvalue(@$_POST["sel_on_board"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				$insert_id = $inserting["insert_id"];
				if($_POST["sel_parent_user_id"] != ""){
					$db->addtable("indottech_group");
					$db->addfield("user_id");		$db->addvalue($insert_id);
					$db->addfield("parent_user_id");$db->addvalue($_POST["sel_parent_user_id"]);
					$db->insert();
				}
				$db->addtable("indottech_leave_rights");
				$db->addfield("user_id");		$db->addvalue($insert_id);
				$db->addfield("leave_rights");	$db->addvalue(@$_POST["leave_num"]);
				$db->addfield("year");			$db->addvalue(date("Y"));
				$db->insert();
				
				$message = "Dear <b><i>".ucwords($_POST["name"])."</i></b>, <br><br><br>
							Akun anda sudah ditambahkan pada Indottech Dashboard silahkan login menggunakan alamat email anda dengan password <b>".$_POST["password"]."</b> <br><br>
							<a target='blank' href=\"http://dashboard.corphr.com/indottech/index.php\">Login Ke Indottech dashboards</a> <br>
							<a target='blank' href=\"https://play.google.com/store/apps/details?id=com.indottech\">Download Indottech Apps</a> <br><br>
							<br>
							<p style='font-family: Courier 10 Pitch; font-weight:bolder'>
							Tim IT<br>
							PT. Indo Human Resource<br>
							Epicentrum Walk Office 7th Floor, Suite 0709A<br>
							Kompleks Rasuna Epicentrum  Jl. HR. Rasuna Said - Kuningan<br>
							Jakarta Selatan 12940<br>
							Phone       : 021-2994 1058/59
							</p>
							<img src='http://dashboard.corphr.com/indottech/images/logo indottech.jpg' width=20% height=20%>";
				sendingmail("Indottech Notification",$_POST["email"],$message);
				
				javascript("alert('Data Saved');");
				javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
			} else {
				echo $inserting["error"];
				javascript("alert('Saving data failed');");
			}
		} else {
				javascript("alert('".$errormessage."');");
		}
	}
	$readonly = "";
	if(@$_SESSION["group_id"] > 0){$readonly = "readonly"; $hidden = "hidden"; $__group_app = "11,12,14,18,23,24"; $notes = "*Group Leader Indottech adalah Cordinator <br> *Leader team lapangan masuk ke gruop Team Indottech <br> *Indottech Admin 2 adalah team admin yang tidak berkaitan dengan keuangan / PRF";}
	$txt_email 			= $f->input("email",@$_POST["email"],"required style='width:100%'");
	$sel_group 			= $f->select("group_id",$db->fetch_select_data("groups","id","name",["id" => $__group_app.":IN"],array("name"),"",true),@$_POST["group_id"],"required style='height:25px;width:100%'");
	$txt_password 		= $f->input("password","","required type='password' autocomplete='new-password' style='width:100%'");
	$txt_name 			= $f->input("name",@$_POST["name"],"required style='width:100%'");
	$txt_job_title 		= $f->input("job_title",@$_POST["job_title"],"style='width:100%'");
	$sel_under_pm		= $f->select("pm_user_id",$db->fetch_select_data("users","id","name",["group_id" => "13,15,16,17:IN" , "id" => "185:!=", "hidden" => "0"],array("name"),"",true),@$_POST["pm_user_id"],"style='width:100%; height:25px'");
	$txt_job_division 	= $f->input("job_division","Indottech",$readonly." style='width:100%';");
	$parents 			= $db->fetch_select_data("users","id","concat(email,' -- ',name)",["forbidden_chr_dashboards" => $__main_menu_id, "group_id" => "11,15,16:IN", "hidden" => "0"],["email"],"",true);
	$sel_parent_user_id = $f->select("sel_parent_user_id",$parents,@$_POST["sel_parent_user_id"],"style='height:25px; width:100%'");
	$txt_leave_num 		= $f->input("leave_num",@$_POST["leave_num"],"type='number' step='1' style='width:100%'");
	$txt_candidate_code		= $f->input("candidate_code",@$_POST["candidate_code"],"style='width:100%'");
	// $sel_candidate_id	= $f->select_window("candidate_id","Candidate",$_POST["candidate_id"],"candidates","id","name","win_indottech_candidates.php");
	$region_id			= $db->fetch_select_data("indottech_regions","id","name",["hidden" => "0"],["name"],"",true);
	$sel_region			= $f->select("region_id",$region_id,@$_POST["region_id"],"style ='height:25px; width:100%'","");
	$sel_on_board 		= $f->input("sel_on_board",@$_POST["sel_on_board"],"type='date' style='width:100%'");
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["Employee Code",$txt_candidate_code]);?>
		<?=$t->row(["Name",$txt_name]);?>
		<?=$t->row(["Job Title",$txt_job_title]);?>
		<?=$t->row(["Job Division",$txt_job_division]);?>
		<?=$t->row(["Email",$txt_email]);?>
		<?=$t->row(["Password",$txt_password]);?>
        <?=$t->row(["Group",$sel_group]);?>
		<?=$t->row(["Team Leader",$sel_parent_user_id]);?>
		<?=$t->row(["Under PM",$sel_under_pm]);?>
		<?=$t->row(["Region",$sel_region]);?>
		<?=$t->row(["On Board",$sel_on_board]);?>
		<?=$t->row(["Jumlah Cuti",$txt_leave_num]);?>
	<?=$t->end();?>
	<br><?=@$notes;?><br>
	<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
<?=$f->end();?>
<script>
	<?php 
		if(isset($_POST["save"])){
			$code = $db->fetch_single_data("candidates","code",["id" => $_POST["candidate_id"]]);
			?> document.getElementById("sw_caption_candidate_id").innerHTML = "<?=$code;?>"; <?php 
		} 
	?>
</script>
<?php
} else {
		javascript("alert('Sorry, you can not access this page!');");
		javascript("window.location=history.go(-1);");
		exit();
	}
//end set access
?>
<?php include_once "footer.php";?>