<?php
	include_once "win_head.php";
	$_title = "Teams List";
	$_tablename = "users";
	$_id_field = "id";
	$_caption_field = "name";
	
	if(@$_GET["remove"]){
		$_SESSION["plan_team"] = array_diff($_SESSION["plan_team"],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>Team deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if(@$_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["plan_team"])) {
			$_title = "<p style='color:red; font-size:15px'>Please select other personil!</p>";
		} else {
			if(!$_SESSION["plan_team"]) {
				$_SESSION["plan_team"] = array($_GET["add"]);
			} else {
				$_SESSION["plan_team"] = array_merge($_SESSION["plan_team"],array($_GET["add"]));
			}
			$_title = "<p style='color:green; font-size:15px'>Team added!</p>";
		}
		$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$user_ids = "";
	$user_values = "";
	$user = "";
	foreach($_SESSION["plan_team"] as $key_user => $user_id){
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
			<th width="15%">User ID</th>
			<th width="20%">User Name</th>
			<th width="30%">Email</th>
			<th width="20%">Posisi</th>
			<th width="15%">Action</th>
		</tr>
		<?php
			$personil_detail = "";
			foreach($_SESSION["plan_team"] as $no => $personil){
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
	$_title = "Teams List";
	$db->addtable($_tablename);
	$whereclause = "";
	$whereclause .= "forbidden_chr_dashboards = '6' AND hidden = '0'";

	if(@$_SESSION["plan_team"]){
		$arr_add = "";
		foreach($_SESSION["plan_team"] as $arr){
			$arr_add .="id != ".$arr." AND ";
		}
		$whereclause .= "AND ".substr($arr_add,0,-4);
	}
	if(@$_POST["keyword"] != "")
		$whereclause .= " AND (".$_caption_field." LIKE '%".@$_POST["keyword"]."%' OR email LIKE '%".@$_POST["keyword"]."%' OR id = '".@$_POST["keyword"]."')";
	if(@$_POST["under_pm"]!="") 
		$_SESSION["under_pm"] = $_POST["under_pm"];
	if(@$_SESSION["under_pm"]) 
		$whereclause .= " AND (pm_user_id = '".$_SESSION["under_pm"]."' OR id = '".$_SESSION["under_pm"]."')";
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",@$_POST["keyword"],"size='50'");?><br>
	Under  : &ensp;<?=$f->select("under_pm",$db->fetch_select_data("users","id","name",["group_id" => "13,15,16,17:IN" , "id" => "185:!=", "hidden" => "0"],array("name"),"",true),@$_SESSION["under_pm"],"style='height:20px; width:333px'");?>&nbsp;
	<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="10%">User ID</th>
			<th width="20%">User Name</th>
			<th width="30%">Email</th>
			<th width="10%">Posisi</th>
			<th>Under</th>
			<th width="5%">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$data[$_id_field];?></td>
			<td nowrap ><?=$data[$_caption_field];?></td>
			<td nowrap ><?=$data["email"];?></td>
			<td><?=$data["job_title"];?></td>
			<td nowrap ><?=$db->fetch_single_data("users","name",["id" => $data["pm_user_id"]]);?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
