<?php include_once "head.php";?>
<?php
if(@$_SESSION["group_id"] == 0){
?>
	<div class="bo_title">Add Users Privileges</div>
	<?php
		if(isset($_POST["save"])){
			$_errormessage	= "";
			if($_errormessage == ""){
				$db->addtable("users_privileges");
				$db->addfield("module_name");			$db->addvalue($_POST["module"]);
				$db->addfield("in_menus");				$db->addvalue($_POST["in_menus"]);
				$db->addfield("add_user_ids");			$db->addvalue($_POST["add_users"]);
				$db->addfield("edit_user_ids");			$db->addvalue($_POST["edit_users"]);
				$db->addfield("delete_user_ids");		$db->addvalue($_POST["delete_users"]);
				$db->addfield("approve_user_ids");		$db->addvalue($_POST["approve_users"]);
				$db->addfield("view_user_ids");			$db->addvalue($_POST["view_users"]);
				$inserting = $db->insert();
				if($inserting["affected_rows"] >= 0){
					$_SESSION["users_privileges_group"] = "";
					$_SESSION["users_privileges_add"] = "";
					$_SESSION["users_privileges_edit"] = "";
					$_SESSION["users_privileges_delete"] = "";
					$_SESSION["users_privileges_approve"] = "";
					$_SESSION["users_privileges_view"] = "";
					javascript("alert('Data Saved');");
					javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
					exit();
				} else {
					javascript("alert('Saving data failed');");
				}
			}
		}
		$module			= $f->input("module",@$_POST["module"],"classinput style='width:300px'");
		$in_menus		= $f->textarea("in_menus",@$_POST["in_menus"],"classinput style='width:300px'");
		$add_users 		= $f->select_window("add_users","Hak Akses Add",@$_POST["add_users"],"users","id","name","win_users_privileges_add.php");
		$edit_users 	= $f->select_window("edit_users","Hak Akses Edit",@$_POST["edit_users"],"users","id","name","win_users_privileges_edit.php");
		$delete_users 	= $f->select_window("delete_users","Hak Akses Delete",@$_POST["delete_users"],"users","id","name","win_users_privileges_delete.php");
		$approve_users 	= $f->select_window("approve_users","Hak Akses Approve",@$_POST["approve_users"],"users","id","name","win_users_privileges_approve.php");
		$view_users 	= $f->select_window("view_users","Hak Akses View",@$_POST["view_users"],"users","id","name","win_users_privileges_view.php");
	?>
	<center><b><?=@$_errormessage;?></b></center>
	<?=$f->start("","POST","","enctype='multipart/form-data'");?>
		<?=$t->start("","editor_content");?>
			<?=$t->row(array("Module",$module));?>
			<?=$t->row(array("Menu Terkait",$in_menus));?>
			<?=$t->row(array("Access Add",$add_users));?>
			<?=$t->row(array("Access Edit",$edit_users));?>
			<?=$t->row(array("Access Delete",$delete_users));?>
			<?=$t->row(array("Access Approve",$approve_users));?>
			<?=$t->row(array("Access View",$view_users));?>
		<?=$t->end();?>
		<?=$f->input("save","Save","type='submit'","btn btn-primary");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"","btn btn-warning");?>
	<?=$f->end();?>
<?php
} else {
		javascript("alert('Sorry, you can not access this page!');");
		javascript("window.location=history.go(-1);");
		exit();
	}
?>
<?php include_once "footer.php";?>