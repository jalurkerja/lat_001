<?php include_once "head.php";?>
<?php include_once "users_js.php";?>
<div class="bo_title">Edit User</div>
<?php
//start set access
$module = "Users";
$url = explode("_",$_SERVER["PHP_SELF"]);
$mode = explode(".",end($url))[0];
$access = $db->fetch_single_data("users_privileges","id",["module_name" => $module, $mode."_user_ids" => "%|".$_SESSION["user_id"]."|%:LIKE"]);
$group_target = $db->fetch_single_data("users","group_id",["id" => $_GET["id"]]);
$access_2 = "";
if((@$_SESSION["group_id"] == 11 || @$_SESSION["group_id"] == 14 || @$_SESSION["group_id"] == 15) && ($group_target == 11 || $group_target == 12 || $group_target == 14 ||$group_target == 18)) {$access_2 = 1;}
if(@$_SESSION["group_id"] == 0 || ($access || $access_2)){
	$users = $db->fetch_all_data("users",[],"id = '".$_GET["id"]."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("users");			$db->where("id",$_GET["id"]);
		$db->addfield("group_id");		$db->addvalue(@$_POST["group_id"]);
		$db->addfield("email");			$db->addvalue(strtolower(@$_POST["email"]));
		if($_POST["password"] !="" ) {
			$db->addfield("password");	$db->addvalue(base64_encode($_POST["password"]));
		}
		$db->addfield("name");			$db->addvalue(@$_POST["name"]);
		$db->addfield("job_title");		$db->addvalue(@$_POST["job_title"]);
		$db->addfield("job_division");	$db->addvalue(@$_POST["job_division"]);
		$db->addfield("hidden");		$db->addvalue(@$_POST["hidden"]);
		$db->addfield("pm_user_id");	$db->addvalue(@$_POST["pm_user_id"]);
		$db->addfield("candidate_code");	$db->addvalue(strtoupper($_POST["candidate_code"]));
		$db->addfield("region_id");		$db->addvalue(@$_POST["region_id"]);
		$db->addfield("attendance_id");	$db->addvalue(@$_POST["attendance_id"]);
		$db->addfield("leave_num");		$db->addvalue(@$_POST["leave_num"]);
		$db->addfield("on_board");		$db->addvalue(@$_POST["sel_on_board"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			if($_POST["sel_parent_user_id"] != ""){
				$indottech_group = $db->fetch_single_data("indottech_group","id",["user_id" => $_GET["id"], "parent_user_id" => $_POST["sel_parent_user_id"]]);
				if ($indottech_group > 0){
					$db->addtable("indottech_group");
					$db->where("user_id",$_GET["id"]);
					$db->addfield("parent_user_id");$db->addvalue($_POST["sel_parent_user_id"]);
					$db->update();
				} else {
					$db->addtable("indottech_group");
					$db->addfield("user_id");		$db->addvalue($_GET["id"]);
					$db->addfield("parent_user_id");$db->addvalue($_POST["sel_parent_user_id"]);
					$db->insert();
				}
			}
			$cek_hak_cuti = $db->fetch_single_data("indottech_leave_rights","id",["user_id" => $_GET["id"], "year" => date("Y")], ["id DESC"]);
			$db->addtable("indottech_leave_rights");
			$db->addfield("leave_rights");	$db->addvalue(@$_POST["leave_num"]);
			$db->addfield("year");			$db->addvalue(date("Y"));
			if($cek_hak_cuti > 0){
				$db->where("id",$cek_hak_cuti);
				$db->update();
			} else {
				$db->addfield("user_id");		$db->addvalue($_GET["id"]);
				$db->insert();
			}
			javascript("alert('Data Saved');");
			javascript("window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			javascript("alert('Saving data failed');");
		}
	}
	
	if($_POST["req_pass"]){
		
		$new_pass = "";
		for($i=1; $i<=6; $i++){
			$new_pass .=rand(0,9);
		}
		$db->addtable("users");			$db->where("id",$_GET["id"]);
		$db->addfield("password");		$db->addvalue(base64_encode($new_pass));
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			include_once "func.sendingmail.php";
			$message_1 = "Dear <b><i>".ucwords($users["name"])."</i></b>, <br><br><br>
						".ucwords($_SESSION["fullname"])." (<i>".$_SESSION["username"]."</i>), Telah melakukan proses reset password pada Akun Anda.
						<br>
						Berikut ini adalah password terbaru Anda:<br><br>
						<b>".$new_pass."</b><br><br>
						Silahkan Login menggunakan Alamat Email Anda dan Password tersebut, serta segera melakukan perubahan Password Login.
						<br><br>
						<a target='blank' href=\"https://dashboard.corphr.com/indottech/index.php\">Login Ke Indottech dashboards</a> <br>
						<a target='blank' href=\"https://play.google.com/store/apps/details?id=appinventor.ai_dhovekss.indottech&hl=in\">Download Indottech Apps</a> <br><br>
						<br>
						<p style='font-family: Courier 10 Pitch; font-weight:bolder'>
						Tim IT<br>
						PT. Indo Human Resource<br>
						Epicentrum Walk Office 7th Floor, Suite 0709A<br>
						Kompleks Rasuna Epicentrum  Jl. HR. Rasuna Said - Kuningan<br>
						Jakarta Selatan 12940<br>
						Phone       : 021-2994 1058/59
						</p>
						<img src='https://dashboard.corphr.com/indottech/images/logo indottech.jpg' width=20% height=20%>";
						
			$message_2 = "Dear <b><i>".ucwords($_SESSION["fullname"])."</i></b>, <br><br><br>
						Anda telah melakukan proses reset password untuk Akun <b><i>".ucwords($users["email"])."</i></b>.
						<br><br>
						Berikut ini adalah password terbaru untuk Akun Tersebut:<br><br>
						<b>".$new_pass."</b><br><br>
						Harap Informasikan ke Akun tersebut untuk Login menggunakan Password tersebut.
						<br><br>
						<a target='blank' href=\"https://dashboard.corphr.com/indottech/index.php\">Login Ke Indottech dashboards</a> <br>
						<a target='blank' href=\"https://play.google.com/store/apps/details?id=appinventor.ai_dhovekss.indottech&hl=in\">Download Indottech Apps</a> <br><br>
						<br>
						<p style='font-family: Courier 10 Pitch; font-weight:bolder'>
						Tim IT<br>
						PT. Indo Human Resource<br>
						Epicentrum Walk Office 7th Floor, Suite 0709A<br>
						Kompleks Rasuna Epicentrum  Jl. HR. Rasuna Said - Kuningan<br>
						Jakarta Selatan 12940<br>
						Phone       : 021-2994 1058/59
						</p>
						<img src='https://dashboard.corphr.com/indottech/images/logo indottech.jpg' width=20% height=20%>";
			sendingmail("Indottech Notification",$users["email"],$message_1);
			sendingmail("Indottech Notification",$_SESSION["username"],$message_2);

			$_SESSION["message"] = "Password Terbaru segera diemailkan ke alamat email Anda dan email User. Silahkan cek Inbox";
		}
	}
	
	// $sel_candidate_id	= $f->select_window("candidate_id","Candidate",$users["candidate_id"],"candidates","id","name","win_indottech_candidates.php");
	$txt_candidate_code		= $f->input("candidate_code",$users["candidate_code"],"style='width:100%'");
	
	@$readonly == ""; @$readonly_2 == ""; @$disable == "";
	if(@$_SESSION["group_id"] > 0){
		$readonly = "readonly"; $disable = "disabled"; $__group_app = "11,12,14,18,23,24"; $notes = "*Group Leader Indottech adalah Cordinator <br> *Leader team lapangan masuk ke gruop Team Indottech <br> *Indottech Admin 2 adalah team admin yang tidak berkaitan dengan keuangan / PRF";
		if(@$_SESSION["username"] != $db->fetch_single_data("users","created_by",["id" => $_GET["id"]])){
			$readonly_2 = "readonly";
			// $sel_candidate_id	= "<b>".$db->fetch_single_data("candidates","code",["id" => $users["candidate_id"]])."</b>";
			$txt_candidate_code		= $f->input("candidate_code",$users["candidate_code"],"style='width:100%'");
		}
	}
	
	$txt_email 			= $f->input("email",$users["email"], @$readonly_2." style='width:100%'");
	$sel_under_pm		= $f->select("pm_user_id",$db->fetch_select_data("users","id","name",["group_id" => "13,15,16,17:IN" , "id" => "185:!=", "hidden" => "0"],array("name"),"",true),$users["pm_user_id"],"style='width:100%; height:25px'");
	$txt_password 		= $f->input("password","",@$readonly_2." type='password' style='width:100%'");
	if($access_2)		$txt_password  = $f->input("req_pass","Reset Password","type='submit' style='height:30px;'","btn btn-danger");
	$txt_name 			= $f->input("name",$users["name"], "style='width:100%'");
	$txt_job_title 		= $f->input("job_title",$users["job_title"], "style='width:100%'");
	$txt_job_division 	= $f->input("job_division",$users["job_division"], @$readonly." style='width:100%'");
	$parent_user_id		= $db->fetch_single_data("indottech_group","parent_user_id",["user_id" => $_GET["id"]]);
	$parents 			= $db->fetch_select_data("users","id","concat(email,' -- ',name)",["forbidden_chr_dashboards" => $__main_menu_id, "hidden" => "0"],["email"],"",true);
	$sel_parent_user_id = $f->select("sel_parent_user_id",$parents,$parent_user_id,"style='width:100%; height:25px'");
	$txt_leave_num 		= $f->input("leave_num",$users["leave_num"],"readonly type='number' step='1' style='width:100%'");
	$hidden				= "";
	$sel_group			= "";
	if($_GET["id"] > 1){
		$sel_group 			= $f->select("group_id",$db->fetch_select_data("groups","id","name",["id"=>$__group_app.":IN"],array("name"),"",true),$users["group_id"],"style='width:100%; height:25px'");
		$hidden 			= $f->select("hidden",["0" => "Active", "1" => "Not Active"],$users["hidden"],@$disable." style='width:100%; height:25px'");
	}
	$region_id			= $db->fetch_select_data("indottech_regions","id","name",["hidden" => "0"],["name"],"",true);
	$sel_region			= $f->select("region_id",$region_id,$users["region_id"],"style ='height:25px; width:100%'","");
	$sel_on_board 		= $f->input("sel_on_board",$users["on_board"],"type='date' style='width:100%'");
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
		<?=$t->row(["Status",$hidden]);?>
		<?=$t->row(["On Board",$sel_on_board]);?>
		<?=$t->row(["Jumlah Cuti",$txt_leave_num]);?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
	<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
<?=$f->end();?>
<script>
	<?php 
		$code = $db->fetch_single_data("candidates","code",["id" => @$users["candidate_id"]]);
		?> try {document.getElementById("sw_caption_candidate_id").innerHTML = "<?=$code;?>"; } catch (e){}<?php 
	?>
</script>
<?php
} else {
		javascript("alert('Sorry, you can not access this page!');");
		javascript("window.location='users_list.php';");
		exit();
	}
//end set access
?>
<?php include_once "footer.php";?>