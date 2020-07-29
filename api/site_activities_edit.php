<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$_title = "<center><h4><b>SOW List</b></h4></center>";
	$_tablename = "indottech_sites";
	$_id_field = "id";
	$_caption_field = "name";
	
	if($_GET["add"]){
		$_SESSION["site_activity"] = $_GET["add"];
		if($_GET["user_is"]){
			javascript("window.location='new_user_activity_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&user_is=".$_GET["user_is"]."';");
		} else if($_GET["mode"] == "wo_plan"){
			javascript("window.location='activity_wo_plan_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan';");
		} else {
			javascript("window.location='view_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."';");
		}
		exit();
	}
?>

<br><br>
<?php
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") {
		$db->awhere(
			"kode LIKE '$".$_POST["keyword"]."$' 
			OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%'"
		);
		$_title = "Site List";
	}
	$db->limit(1000);
	$db->order("kode");
	$_data = $db->fetch_data(true);
?>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"width='50%'");?>&nbsp;<?=$f->input("search","Load","type='submit'","btn btn-info");?>
<?php
	// $new_user = $db->fetch_single_data("attendance_activity","id",["description" => "%New User%:LIKE", "id" => $_GET["activity_id"]]);
	if($_GET["user_is"]){
		echo "&nbsp;".$f->input("close","Close","type='button'  onclick=\"window.location='new_user_activity_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&user_is=".$_GET["user_is"]."';\"","btn btn-primary");
	} else if ($_GET["mode"] == "wo_plan"){
		echo "&nbsp;".$f->input("close","Close","type='button'  onclick=\"window.location='activity_wo_plan_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&mode=wo_plan';\"","btn btn-primary");
	} else {
		echo "&nbsp;".$f->input("close","Close","type='button'  onclick=\"window.location='view_activities_edit.php?token=".$_GET["token"]."&activity_id=".$_GET["activity_id"]."&plan_site_id=".$_GET["plan_site_id"]."';\"","btn btn-primary");
	}
?>
	<br>
	<table id="data_content">
		<tr>
			<th>Site Code</th>
			<th>Site Name</th>
			<th>Longitude</th>
			<th>Latitude</th>
			<th width="7%">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
			// $action = "<a href=\"?token=".$_GET["token"]."&plan_id=".$_GET["plan_id"]."&add=".$data["id"]."\">Add</a>";
		?>
		<tr <?=$onclick;?>>
			<td align="left"><?=$data["kode"];?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><?=$data["longitude"];?></td>
			<td><?=$data["latitude"];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
<?php include_once "footer.php";?>