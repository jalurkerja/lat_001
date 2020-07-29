<?php
	include_once "win_head.php";
	$_title = "Teams List";
	$_tablename = "users";
	$_id_field = "id";
	$_caption_field = "name";
	
	if(@$_GET["remove"]){
		$_SESSION["users_privileges_edit"] = array_diff($_SESSION["users_privileges_edit"],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>Team deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if(@$_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["users_privileges_edit"])) {
			$_title = "<p style='color:red; font-size:15px'>Please select other personil!</p>";
		} else {
			if(!$_SESSION["users_privileges_edit"]) {
				$_SESSION["users_privileges_edit"] = array($_GET["add"]);
			} else {
				$_SESSION["users_privileges_edit"] = array_merge($_SESSION["users_privileges_edit"],array($_GET["add"]));
			}
			$_title = "<p style='color:green; font-size:15px'>Team added!</p>";
		}
		$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$user_ids = "";
	$user_values = "";
	$user = "";
	foreach($_SESSION["users_privileges_edit"] as $key_user => $user_id){
		$user = $db->fetch_all_data("users",[],"id ='".$user_id."'")[0];
		$user_ids .= "|".$user_id."|";
		$user_values .= "- ".$user["name"]." (".$user["job_title"].")<br>";
	}
	
?>
<h3><b><?=$_title;?></b></h3>
<center><?=@$_message;?></center>
<h3><b>Teams Selected</b></h3>
	<table id="data_content">
		<tr>
			<th width="15%">Team ID</th>
			<th width="20%">Team Name</th>
			<th width="30%">Email</th>
			<th width="20%">Posisi</th>
			<th width="15%">Action</th>
		</tr>
		<?php
			$personil_detail = "";
			foreach(@$_SESSION["users_privileges_edit"] as $no => $personil){
			$personil_detail = $db->fetch_all_data($_tablename,[],"id ='".$personil."'")[0];
				?>
				<tr>
					<td align="center"><?=$personil_detail[$_id_field];?></td>
					<td><?=$personil_detail[$_caption_field];?></td>
					<td><?=$personil_detail["email"];?></td>
					<td><?=$personil_detail["job_title"];?></td>
					<td><?="<a href=\"?".$_SERVER["QUERY_STRING"]."&remove=".$personil_detail["id"]."\">Remove</a>";?></td>
				</tr>
				<?php	
			}
		?>
	</table>

<?=$f->input("close","Commit","type='button' onclick=\"parent_load('".$_name."','".$user_ids."','".$user_values."');\"");?>

<br><br>
<?php
	$whereclause = "";
	// $whereclause .= "forbidden_chr_dashboards = '6' AND ";
	$whereclause .= "hidden = '0'";
	if(@$_SESSION["users_privileges_edit"]){
		$arr_add = "";
		foreach(@$_SESSION["users_privileges_edit"] as $arr){
			$arr_add .="id != ".$arr." AND ";
		}
		$whereclause .= "AND ".substr($arr_add,0,-4);
	}
	$_title = "Teams List";
	$db->addtable($_tablename);
	if(@$_POST["group_id"] != "") $_SESSION["users_privileges_group"] = $_POST["group_id"];
	if(@$_SESSION["users_privileges_group"]) {$whereclause .=" AND group_id = '".$_SESSION["users_privileges_group"]."'";}
	if(@$_POST["keyword"] != "")
		$whereclause .= " AND (".$_id_field." = '".$_POST["keyword"]."' OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%' OR email LIKE '%".$_POST["keyword"]."%')";
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);	
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	<?php
		$group_id = $db->fetch_select_data("groups","id","name",["id" => "11,12,13,14,15,16,17,18:IN"],["name"],"",true);
	?>
	Search : <?=$f->input("keyword",@$_POST["keyword"],"style='width:175px'");?><br>
	Group &nbsp;: <?=$f->select("group_id",$group_id,$_SESSION["users_privileges_group"],"","classinput");?>
	<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="15%">Team ID</th>
			<th width="20%">Team Name</th>
			<th width="30%">Email</th>
			<th width="20%">Posisi</th>
			<th width="15%">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$data[$_id_field];?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><?=$data["email"];?></td>
			<td><?=$data["job_title"];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
