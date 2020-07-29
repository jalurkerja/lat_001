<?php
	include_once "win_head.php";
	$_title = "Site List";
	$_tablename = "indottech_sites";
	$_id_field = "id";
	$_caption_field = "name";
	
	if($_GET["remove"]){
		$_SESSION["plan_site"] = array_diff($_SESSION["plan_site"],array($_GET["remove"]));
		$_title = "<p style='color:green; font-size:15px'>Site deleted!</p>";
		$_SERVER["QUERY_STRING"] = str_replace("&remove=".$_GET["remove"],"",$_SERVER["QUERY_STRING"]);
	}
		
	if($_GET["add"]){
		if(in_array($_GET["add"],$_SESSION["plan_site"])) {
			$_title = "<p style='color:red; font-size:15px'>Please select other site!</p>";
		} else {
			if(!$_SESSION["plan_site"]) {
				$_SESSION["plan_site"] = array($_GET["add"]);
			} else {
				$_SESSION["plan_site"] = array_merge($_SESSION["plan_site"],array($_GET["add"]));
			}
			$_title = "<p style='color:green; font-size:15px'>Site added!</p>";
		}
		$_SERVER["QUERY_STRING"] = str_replace("&add=".$_GET["add"],"",$_SERVER["QUERY_STRING"]);
	}
	
	$site_ids = "";
	$site_values = "";
	foreach($_SESSION["plan_site"] as $key_site => $site_id){
		$site = $db->fetch_all_data("indottech_sites",[],"id ='".$site_id."'")[0];
		$site_ids .= "|".$site_id."|";
		$site_values .= "- [".$site["kode"]."] ".$site["name"]."<br>";
	}
?>
<h3><b><?=$_title;?></b></h3>
<center><?=$_message;?></center>
<h3><b>Sites Selected</b></h3>
	<table id="data_content">
		<tr>
			<th width="15%">Site ID</th>
			<th width="15%">Site Code</th>
			<th>Site Name</th>
			<th width="50">Action</th>
		</tr>
		<?php
			foreach($_SESSION["plan_site"] as $no => $plan_site){
			$site_detail = $db->fetch_all_data($_tablename,[],"id ='".$plan_site."'")[0];
				?>
				<tr>
					<td align="center"><?=$site_detail[$_id_field];?></td>
					<td><?=$site_detail["kode"];?></td>
					<td><?=$site_detail[$_caption_field];?></td>
					<td><?="<a href=\"?".$_SERVER["QUERY_STRING"]."&remove=".$site_detail["id"]."\">Remove</a>";?></td>
				</tr>
				<?php	
			}
		?>
	</table>

<?=$f->input("close","Commit","type='button' onclick=\"parent_load('".$_name."','".$site_ids."','".$site_values."');\"");?>

<br><br>
<?php
	$_title = "Site List";
	$db->addtable($_tablename);
	if($_POST["keyword"] != "")	$whereclause = "kode LIKE '%".$_POST["keyword"]."%' OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%'";
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order("xtimestamp DESC");
	$_data = $db->fetch_data(true);
?>

<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
	<br>
	<table id="data_content">
		<tr>
			<th width="15%">Site ID</th>
			<th width="15%">Site Code</th>
			<th>Site Name</th>
			<th width="50">Action</th>
		</tr>
		<?php
			foreach($_data as $no => $data){
			$onclick = "onclick=\"window.location='?".$_SERVER["QUERY_STRING"]."&add=".$data["id"]."';\"";
		?>
		<tr <?=$onclick;?>>
			<td align="center"><?=$data[$_id_field];?></td>
			<td><?=$data["kode"];?></td>
			<td><?=$data[$_caption_field];?></td>
			<td><a>Add</a></td>
		</tr>
		<?php	
			}
		?>
	</table>
