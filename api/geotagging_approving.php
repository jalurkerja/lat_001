<?php 
	include_once "../common.php";
	include_once "user_info.php";
	if($group_id == "12" || $group_id == "" || $token == "") { echo "Forbidden Page!"; exit(); } 
	if((isset($_POST["approved"]) && count($_POST["chk"]) > 0) || isset($_GET["reject"])){
		$id = $_GET["id"];
		$db->addtable("indottech_geotagging_req");
		$db->where("id",$id);
		if(isset($_GET["reject"])){
			$db->addfield("status");		$db->addvalue("-1");
		} else {
			$db->addfield("status");		$db->addvalue("1");
			$db->addfield("photo_item_ids");$db->addvalue(sel_to_pipe($_POST["chk"]));
		}
		$db->addfield("approved_by");	$db->addvalue($username);
		$db->addfield("approved_at");	$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("approved_ip");	$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->update();
		?><script> window.location="geotagging_request.php?token=<?=$token;?>"; </script><?php
	}
	$data = $db->fetch_all_data("indottech_geotagging_req",[],"id='".$_GET["id"]."'")[0];
	$photo_item_ids = pipetoarray($data["photo_item_ids"]);
?>
<input type="button" value="Back" style="width:100%;height:50px;font-size:20px;font-weight:bolder;" onclick="window.location='geotagging_request.php?token=<?=$token;?>';"><br>
<h3><b>Approving Geotagging</b></h3>
<table>
	<?=$t->row(["<b>Site ID</b>",":",$data["site_id"]]);?>
	<?=$t->row(["<b>Site Name</b>",":",$data["sitename"]]);?>
	<?=$t->row(["<b>Position</b>",":",$data["latitude"]." : ".$data["longitude"]]);?>
	<?=$t->row(["<b>Requested By</b>",":",$db->fetch_single_data("users","name",["id" => $data["user_id"]])]);?>
	<?=$t->row(["<b>Approve List</b>",":"]);?>
</table>
<form method="POST">
<?php
	if($data["fsfl_mode"] == "1" && $data["siteIdSelected"] > 0){
		$whereclause = "itemtype='9' AND parent_id='0'";
	} else {
		$whereclause = "parent_id='0'";
	}
	$indottech_photo_items = $db->fetch_all_data("indottech_photo_items",[],$whereclause." AND itemtype<>'10' AND project_id = 0");
	foreach($indottech_photo_items as $indottech_photo_item){
		$checked = "";
		if(in_array($indottech_photo_item["id"],$photo_item_ids)) $checked = "checked";
		echo $f->input("chk[]",$indottech_photo_item["id"],"type='checkbox' style='zoom:1.5' ".$checked).$indottech_photo_item["name"]."<br>";
	}
	$indottech_photo_items = $db->fetch_all_data("indottech_photo_items",[],"itemtype='10' AND parent_id > 0 AND is_childest=0");
	echo "<u>SIMO MIMO:</u><br>";
	foreach($indottech_photo_items as $indottech_photo_item){
		$checked = "";
		if(in_array($indottech_photo_item["id"],$photo_item_ids)) $checked = "checked";
		$parent_name = $db->fetch_single_data("indottech_photo_items","name",["id" => $indottech_photo_item["parent_id"]]);
		echo $f->input("chk[]",$indottech_photo_item["id"],"type='checkbox' ".$checked).$parent_name." -- ".$indottech_photo_item["name"]."<br>";
	}
	
	echo "<br>";
	echo $f->input("approved","Approved","type='submit' style='width:100%;height:50px;font-size:20px;'");
	echo "<br>";
?>
</form>
<?php include_once "footer.php";?>
