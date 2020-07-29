<?php include_once "header.php";?>
<table width="100%">
	<tr>
		<td align="left"><h4><b>Indosat Survey</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>

<form method="GET">
	<input type="hidden" name="token" value="<?=$_GET["token"];?>">
	<table>
		<tr><td><b><u>Filter:</u></b></td></tr>
		<?php
			$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => 17],["name"],"",true);
		?>
		<?=$t->row(["Site",$f->select("sel_site",$sites,$_GET["sel_site"])]);?>
		<?=$t->row(["Created At",$f->input("txt_created_at",$_GET["txt_created_at"],"type='date'")]);?>
		<tr><td colspan="2"><input type="submit" name="search" value="Search">&nbsp;<input type="button" value="Reset" onclick="window.location='?token=<?=$_GET["token"];?>';"></td></tr>
	</table>
</form>
<?php
	$whereclause = "project_id = 17 AND ";//Indosat
	if($_GET["sel_site"] != "") $whereclause .= "site_id='".$_GET["sel_site"]."' AND ";
	if($_GET["txt_created_at"] != "") $whereclause .= "created_at LIKE '".$_GET["txt_created_at"]."%' AND ";
	if($_SESSION["username"] != "") $whereclause .= "created_by='".$_SESSION["username"]."' AND ";
	$whereclause = substr($whereclause,0,-4);
?>
<button onclick="window.location='tag_photo_project_add.php?token=<?=$token;?>&project_id=17';">New Indosat Survey</button>
<br>

<div style="overflow-x:auto;">
	<table id="data_content">
		<tr>
			<th>No</th>
			<th>Site Name</th>
			<th>Created At</th>
		</tr>
		<?php 
			$tag_photo_projects = $db->fetch_all_data("indottech_tag_photo_projects",[],$whereclause);
			foreach($tag_photo_projects as $no => $tag_photo_project){ 
				$onclick = "onclick=\"window.location='tag_photo_project.php?token=".$token."&atd_id=".$tag_photo_project["id"]."';\"";
		?>
			<tr <?=$onclick;?>>
				<td align="center"><?=($no+1);?></td>
				<td><?=$tag_photo_project["site_name"];?></td>
				<td><?=format_tanggal($tag_photo_project["created_at"]);?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<?php include_once "footer.php";?>