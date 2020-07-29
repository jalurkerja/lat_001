<?php include_once "head.php";?>
<div class="bo_title">Change Password</div>
<?php
	if(isset($_POST["save"])){
		$current_password = $db->fetch_single_data("users","password",["id" => $__user_id]);
		if($_POST["password"] != $_POST["rewrite_password"]) $_SESSION["errormessage"] = "Password baru Salah";
		if(base64_encode($_POST["old_password"]) != $current_password) $_SESSION["errormessage"] = "Password tidak cocok";
		
		if($_SESSION["errormessage"] == ""){
			$db->addtable("users");					$db->where("id",$__user_id);
			$db->addfield("password");				$db->addvalue(base64_encode($_POST["password"]));
			$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");			$db->addvalue($__username);
			$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$_SESSION["message"] = "Password berhasil di ubah";
				javascript("window.location='index.php';");
				exit();
			} else {
				javascript("alert('Saving data failed');");
			}
		}
	}
	
	$txt_old_password 			= $f->input("old_password","","type='password'");
	$txt_password 				= $f->input("password","","type='password'");
	$txt_rewrite_password 		= $f->input("rewrite_password","","type='password'");
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["Old Password",$txt_old_password]);?>
		<?=$t->row(["New Password",$txt_password]);?>
		<?=$t->row(["Rewrite Password",$txt_rewrite_password]);?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?>
<?=$f->end();?>
<?php include_once "footer.php";?>