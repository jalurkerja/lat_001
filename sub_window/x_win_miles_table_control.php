<?php
	include_once "win_head.php";
	// $_title = "Teams List";
	// $_tablename = "users";
	// $_id_field = "id";
	// $_caption_field = "name";
	
	if($_GET["remove"]){
		$_SESSION[$_tablename] = array_diff($_SESSION[$_tablename],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>Data deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if($_GET["add"]){
		if(!$_SESSION[$_tablename]) {
			$_SESSION[$_tablename] = array($_GET["add"]);
		} else {
			$_SESSION[$_tablename] = array_merge($_SESSION[$_tablename],array($_GET["add"]));
		}
		$_title = "<p style='color:green; font-size:15px'>Data added!</p>";
	$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$data_ids = "";
	$data_values = "";
	foreach($_SESSION[$_tablename] as $key_user => $data_id){
		$__data = $db->fetch_all_data($_tablename,[],"id ='".$data_id."'")[0];
		$data_ids .= "|".$data_id."|";
		$data_values .= "- ".$__data["name"]."<br>";
	}
?>
<h3><b><?=$_title;?></b></h3>
<center><?=$_message;?></center>
<h3><b>Data Selected</b></h3>
	<table id="data_content">
		<tr>
			<th width="5%">No</th>
			<th>Name</th>
			<th width="5%">Action</th>
		</tr>
		<?php
			$_num = 1;
			// $_SESSION[$_tablename] = array_diff($_SESSION[$_tablename],array("1"));
			foreach($_SESSION[$_tablename] as $no => $_data_id){
			$data_selected = $db->fetch_all_data($_tablename,[],"id ='".$_data_id."'")[0];
				?>
				<tr>
					<td align="center"><?=$_num++;?></td>
					<td><?=$data_selected[$_caption_field];?></td>
					<td><?="<a href=\"?".$_SERVER["QUERY_STRING"]."&remove=".$data_selected["id"]."\">Remove</a>";?></td>
				</tr>
				<?php	
			}
		?>
	</table>

<?=$f->input("close","Commit","type='button' onclick=\"parent_load('".$_name."','".$data_ids."','".$data_values."');\"");?>

<br><br>
<?php
	$db->addtable($_tablename);
	$whereclause = "";
	if($_POST["keyword"] != "")
		$whereclause .= $_caption_field." LIKE '%".$_POST["keyword"]."%' AND ";
	if($_SESSION[$_tablename]){
		$arr_add = "";
		foreach($_SESSION[$_tablename] as $arr){
			$arr_add .="id != ".$arr." AND ";
		}
		$whereclause .= substr($arr_add,0,-4)." AND ";
	}
	$whereclause .= "id != '1' AND parent_id = '0' AND indottech_project_id ='".$_SESSION["indottech_project_id"]."' AND ";
	$db->awhere($whereclause = substr($whereclause,0,-4));
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="5%">No</th>
			<th>Name</th>
			<th width="5%">Action</th>
		</tr>
		<?php
			$num = 1;
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$num++;?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
