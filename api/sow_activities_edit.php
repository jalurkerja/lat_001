<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$_title = "<center><h4><b>SOW List</b></h4></center>";
	$_tablename = "indottech_sow";
	$_id_field = "id";
	$_caption_field = "name";
	
	$attendance_activity = $db->fetch_single_data("attendance_activity","sow_ids",["id" => $_GET["activity_id"]]);
	if(!$_SESSION["sow_activity"]) {$_SESSION["sow_activity"] = pipetoarray($attendance_activity);}
	 
	if($_GET["remove"]){
		$_SESSION["sow_activity"] = array_diff($_SESSION["sow_activity"],array($_GET["remove"]));
		$_title = "<center><h4 style='color:green;'><b>SOW deleted!</b></h4></center>";
	}
		
	if($_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["sow_activity"])) {
			$_title = "<center><h4 style='color:red;'><b>Please select other SOW!</b></h4></center>";
			} else {
				if(!$_SESSION["sow_activity"]) {
					$_SESSION["sow_activity"] = array($_GET["add"]);
				} else {
					$_SESSION["sow_activity"] = array_merge($_SESSION["sow_activity"],array($_GET["add"]));
				}
				$_title = "<center><h4 style='color:green;'><b>SOW added!</b></h4></center>";
		}
	}
?>
<h3><b><?=$_title;?></b></h3>
<center><?=$_message;?></center>
<h4><b>SOW Selected</b></h4>
	<table id="data_content">
		<tr>
			<th width="100">SOW ID</th>
			<th>SOW Name</th>
			<th width="50">Action</th>
		</tr>
		<?php
			foreach($_SESSION["sow_activity"] as $key_sow => $sow_id){
			$sow_id_detail = $db->fetch_all_data($_tablename,[],"id ='".$sow_id."'")[0];
				?>
				<tr>
					<td align="center"><?=$sow_id_detail[$_id_field];?></td>
					<td><?=$sow_id_detail[$_caption_field];?></td>
					<td><?php
					if ($_GET["mode"] == "wo_plan"){
						echo "<a href=\"?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&remove=".$sow_id_detail["id"]."&mode=wo_plan\">Remove</a>";
					} else {
						echo "<a href=\"?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&remove=".$sow_id_detail["id"]."\">Remove</a>";
					}
					?></td>
				</tr>
				<?php	
			}
		?>
	</table>
<?php
	// $new_user = $db->fetch_single_data("attendance_activity","id",["description" => "%New User%:LIKE", "id" => $_GET["activity_id"]]);
	if($_GET["user_is"]){
		echo $f->input("close","Commit","type='button'  onclick=\"window.location='new_user_activity_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&user_is=".$_GET["user_is"]."';\"","btn btn-primary");
	} else if ($_GET["mode"] == "wo_plan"){
		echo $f->input("close","Commit","type='button'  onclick=\"window.location='activity_wo_plan_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan';\"","btn btn-primary");
	} else {
		echo $f->input("close","Commit","type='button'  onclick=\"window.location='view_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."';\"","btn btn-primary");
	}
?>

<br><br>
<?php
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") {
		$db->awhere(
			$_id_field." = '".$_POST["keyword"]."' 
			OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%'"
		);
		$_title = "SOW List";
	}
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"width='50%'");?>&nbsp;<?=$f->input("search","Load","type='submit'","btn btn-info");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="100">SOW ID</th>
			<th>SOW Name</th>
			<th width="50">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			if($_GET["mode"] == "wo_plan"){
				$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."&mode=wo_plan';\"";
			} else {
				$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
			}
			// $action = "<a href=\"?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&add=".$data["id"]."\">Add</a>";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$data[$_id_field];?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
<?php include_once "footer.php";?>