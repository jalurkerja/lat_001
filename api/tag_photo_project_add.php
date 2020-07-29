<?php 
	include_once "header.php";
	$project_id = $_GET["project_id"];
	$project_name = $db->fetch_single_data("indottech_projects","name",["id" => $project_id]);
	if(isset($_POST["save"])){
		$site_name = $db->fetch_single_data("indottech_sites","name",["id" => $_POST["site_id"]]);
		$site_code = $db->fetch_single_data("indottech_sites","site_code",["id" => $_POST["site_id"]]);
		$latitude = $db->fetch_single_data("indottech_sites","latitude",["id" => $_POST["site_id"]]);
		$longitude = $db->fetch_single_data("indottech_sites","longitude",["id" => $_POST["site_id"]]);
		
		$db->addtable("indottech_tag_photo_projects");
		$db->addfield("project_id");		$db->addvalue($project_id);
		$db->addfield("user_id");			$db->addvalue($user_id);
		$db->addfield("site_id");			$db->addvalue($_POST["site_id"]);
		$db->addfield("site_code");			$db->addvalue($site_code);
		$db->addfield("site_name");			$db->addvalue($site_name);
		$db->addfield("latitude");			$db->addvalue($latitude);
		$db->addfield("longitude");			$db->addvalue($longitude);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("window.location=\"tag_photo_project.php?token=".$token."&atd_id=".$inserting["insert_id"]."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => $project_id],["name"],"",true);
?>
	<center><h4><b>GEOTAGGING PHOTO <?=strtoupper($project_name);?></b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&project_id=<?=$project_id;?>">
		<table>
			<tr><td>SITE</td><td>:</td><td><?=$f->select("site_id",$sites,"","required","classinput");?></td></tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.history.back();'");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
		</tr></table>
	</form>
<?php include_once "footer.php";?>