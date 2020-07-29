<?php include_once "head.php";?>
<script>
	function selectAllAllowedUser(){
		var elements = document.getElementById("AllowedUsers").getElementsByTagName("input");
		for(var ii = 0 ; ii < elements.length ; ii++){
			elements[ii].checked = "checked";
		}
	}
	
	function unselectAllAllowedUser(){
		var elements = document.getElementById("AllowedUsers").getElementsByTagName("input");
		for(var ii = 0 ; ii < elements.length ; ii++){
			elements[ii].checked = false;
		}
	}
</script>
<?php
	if($_GET["mode"] == "edit" || $_GET["deleting"]){
		if($_GET["deleting"]) $_GET["id"] = $_GET["deleting"];
		$uploader_id = $db->fetch_single_data("storage","user_id",["id" => $_GET["id"]]);
		if($uploader_id != $__user_id){
			?> <script> window.location="?"; </script> <?php
			exit();
		}
	}
	function randtoken($len){
		$return = "";
		while(strlen($return) < $len){
			if(rand(0,1) == 0){//angka
				$return .= rand(0,9);
			} else {//huruf
				$return .= chr(rand(65,90));
			}
		}
		return $return;
	}
	
	function getPhysicalname(){
		global $db,$__user_id,$__isloggedin;
		if($__user_id && $__isloggedin){
			$looping = true;
			while($looping){
				$physicalname = randtoken(20)."_".$__user_id;
				if($db->fetch_single_data("storage","id",["physicalname" => $physicalname]) <= 0 ){
					$looping = false;
				}
			}
			return $physicalname;
		}
		return "";
	}
	
	if($_GET["deleting"]){
		$physicalname = $db->fetch_single_data("storage","physicalname",["id" => $_GET["deleting"]]);
		unlink("storage_share/".$physicalname);
		$db->addtable("storage"); $db->where("id",$_GET["deleting"]); $db->delete_();
	}
	
	if($_POST["save_trx"] || $_POST["edit_trx"]){
		if($_POST["edit_trx"]) $_physicalname = $db->fetch_single_data("storage","physicalname",["id" => $_POST["id"]]);
		else $_physicalname = getPhysicalname();
		if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], "storage_share/".$_physicalname) || $_FILES["uploadFile"]["tmp_name"] == "") {
			chmod("storage_share/".$_physicalname, 0755);
			$db->addtable("storage");
			$db->addfield("user_id");			$db->addvalue($__user_id);
			$db->addfield("allowed_user_ids");	$db->addvalue(sel_to_pipe($_POST["allowed_user_ids"]));
			if($_FILES["uploadFile"]["tmp_name"] != ""){
				$db->addfield("filename");		$db->addvalue($_FILES["uploadFile"]["name"]);
			}
			$db->addfield("physicalname");		$db->addvalue($_physicalname);
			$db->addfield("expired_at");		$db->addvalue($_POST["expired_at"]);		
			$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");		$db->addvalue($__username);
			$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
			if($_POST["edit_trx"]) {
				$db->where("id",$_POST["id"]);
				$inserting = $db->update();
				$storage_id = $_POST["id"];
			} else {
				$db->addfield("created_at");	$db->addvalue(date("Y-m-d H:i:s"));
				$db->addfield("created_by");	$db->addvalue($__username);
				$db->addfield("created_ip");	$db->addvalue($_SERVER["REMOTE_ADDR"]);
				$inserting = $db->insert();
				$storage_id = $inserting["insert_id"];
			}
			if($inserting["affected_rows"] > 0){
				$filename = $db->fetch_single_data("storage","filename",["id" => $storage_id]);
				$message = $__username. " telah membagi file `".$filename."` kepada Anda, Silakan lihat di menu `<a href=\"storage_list.php\">General -> Storage</a>`";
				foreach($_POST["allowed_user_ids"] as $key => $_allowed_user_id){
					sendMessage("0",$_allowed_user_id,$message);
				}
				$error_messages = "<font style='color:green;'><b><h3>Storage Saved</h3></b></font>";
				$_GET["mode"] = "";
			}
		} else {
			$error_messages = "<font style='color:red;'><b><h3>Failed to upload</h3></b></font>";
		}
	}
?>
<div class="bo_title">Share Storage</div>
<?=$error_messages;?>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
                $trx_uploader = $f->input("trx_uploader",@$_GET["trx_uploader"]);
                $trx_filename = $f->input("trx_filename",@$_GET["trx_filename"]);
			?>
			<?=$t->row(array("Uploader",$trx_uploader));?>
			<?=$t->row(array("File Name",$trx_filename));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	if($__group_id > 0) $whereclause = "(allowed_user_ids LIKE '%|".$__user_id."|%' OR user_id = '".$__user_id."') AND ";
	if(@$_GET["trx_uploader"]!="") $whereclause .= "user_id IN (SELECT id FROM users WHERE email LIKE '%".$_GET["trx_uploader"]."%' OR name LIKE '%".$_GET["trx_uploader"]."%') AND ";
	if(@$_GET["trx_filename"]!="") $whereclause .= "filename LIKE '%".$_GET["trx_filename"]."%' AND ";
	
	$db->addtable("storage");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
	if(@$_GET["sort"] == "") $_GET["sort"] = "id";
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$storages = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' class='btn btn-primary' onclick=\"window.location='storage_list.php?mode=add';\"");?>
	<?=$t->start("","data_content");?>
	<?=$t->header( ["No",
					"<div onclick=\"sorting('user_id');\">Uploader</div>",
					"<div onclick=\"sorting('filename');\">Filename</div>",
					"<div onclick=\"sorting('expired_at');\">Expired At</div>",
					"<div onclick=\"sorting('created_at');\">Upload At</div>",
					""]);?>
					
	<?php					
		if($_GET["mode"] == "add" || $_GET["mode"] == "edit"){
			$_allowed_user_ids = "";
			$_filename = "";
			$_expired_at = "";
			$_save_button = "save_trx";
			if($_GET["mode"] == "edit"){
				$db->addtable("storage");$db->where("id",$_GET["id"]);$db->limit(1);
				$data = $db->fetch_data();
				$_allowed_user_ids = pipetoarray($data["allowed_user_ids"]);
				$_filename = $data["filename"];
				$_expired_at = $data["expired_at"];
				$_save_button = "edit_trx";
			}
			
			$sel_allowed_user_ids = "<b>Pilih user yang diperbolehkan download:</b><br>";
			$sel_allowed_user_ids .= "<a href='javascript:selectAllAllowedUser();'>[Pilih Semua]</a> ";
			$sel_allowed_user_ids .= "<a href='javascript:unselectAllAllowedUser();'>[Hilangkan Pilihan]</a> ";
			$sel_allowed_user_ids .= "<div id='AllowedUsers' style='overflow:scroll; height:200px;width:300px;border:1px solid grey;'>";
			$_allowed_users = $db->fetch_select_data("users","id","email",["forbidden_chr_dashboards" => 6, "id" => $__user_id.":<>"],["email"]);
			foreach($_allowed_users as $_allowed_user_id => $_allowed_user_email){
				$checked = "";
				if(in_array($_allowed_user_id,$_allowed_user_ids)) $checked = "checked";
				$sel_allowed_user_ids .= "<input type='checkbox' ".$checked." id='allowed_user_ids[".$_allowed_user_id."]' name='allowed_user_ids[".$_allowed_user_id."]' value='".$_allowed_user_id."'> ".$_allowed_user_email."<br>";
			}
			$sel_allowed_user_ids .= "</div>";
			
			$txt_filename = $f->input("uploadFile","","type='file'");
			if($_filename != "") $txt_filename .= "<br>".$_filename;
			$txt_expired_at = $f->input("expired_at",$_expired_at,"type='date' required");
			$btn_save = $f->input($_save_button,"Save","type='submit'","btn btn-primary");
			if($_GET["mode"] == "edit") $btn_save .= $f->input("id",$_GET["id"],"type='hidden'");
			
			echo $f->start("","POST","?".$_SERVER["QUERY_STRING"],"enctype='multipart/form-data'");
			echo $t->row(["",$sel_allowed_user_ids,$txt_filename,$txt_expired_at,"",$btn_save],["align='center' valign='top'",""]);
			echo $f->end();
		}
		
		$total = 0;
		foreach($storages as $no => $storage){
			if($__user_id == $storage["user_id"]){
				$actions = "<a href=\"storage_list.php?mode=edit&id=".$storage["id"]."\">Edit</a> |
							<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$storage["id"]."';}\">Delete</a>
							";
			} else { $actions = ""; }
			$filename = "<a href='storage_download.php?id=".$storage["id"]."' target='_BLANK'>".$storage["filename"]."</a>";
			echo $t->row( [$no+$start+1,
						$db->fetch_single_data("users","name",["id" => $storage["user_id"]]),
						$filename,
						format_tanggal($storage["expired_at"]),
						format_tanggal($storage["updated_at"]),
						$actions],
					["align='center' valign='top'",""]
				);
		}
		echo $t->end();
	?>
<?php include_once "footer.php";?>