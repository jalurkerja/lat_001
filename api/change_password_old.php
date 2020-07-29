<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
	</head>
	<body>
<?php
	include_once "../common.php";
	include_once "user_info.php";
?>
<?php
	if(isset($_POST["save"])){
		$error_message = "";
		$_oldpassword = base64_decode($db->fetch_single_data("users","password",["id"=>$user_id]));
		if($_oldpassword != $_POST["oldpassword"] || $_POST["password"] != $_POST["repassword"] || strlen($_POST["password"]) < 6){
			$error_message = "<font color='red'>Password salah, silakan ulangi lagi!</font>";			
		}
		
		if($error_message == ""){
			$db->addtable("users");					$db->where("id",$user_id);
			$db->addfield("password");				$db->addvalue(base64_encode($_POST["password"]));
			$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");			$db->addvalue($username);
			$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$error_message = "<font color='blue'>Password berhasil diubah</font>";
			} else {
				$error_message = "<font color='red'>Password gagal diubah, silakan ulangi lagi!</font>";
			}
		}
		echo $error_message."<br>";
	}
	
	$txt_oldpassword 		= $f->input("oldpassword","","type='password'");
	$txt_password 			= $f->input("password","","type='password'");
	$txt_repassword 		= $f->input("repassword","","type='password'");
?>
<table width="100%">
	<tr>
		<td align="left"><h4><b>Change Password</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>

<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("Password Lama<br>".$txt_oldpassword));?>
		<?=$t->row(array("Password Baru<br>".$txt_password));?>
		<?=$t->row(array("Ulangi Password<br>".$txt_repassword));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?>
<?=$f->end();?>
	</body>
</html>