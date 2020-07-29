<?php include_once "header.php";?>
<table width="100%">
	<tr>
		<td align="left"><h4><b>ATP Installation</b></h4></td>
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
			$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => 13],["name"],"",true);
		?>
		<?=$t->row(["Work Type",$f->select("sel_doctype",["" => "","rectifier" => "RECTIFIER","bts_sran" => "BTS SRAN"],$_GET["sel_doctype"])]);?>
		<?=$t->row(["Project Name",$f->input("txt_project_name",$_GET["txt_project_name"])]);?>
		<?=$t->row(["Site",$f->select("sel_site",$sites,$_GET["sel_site"])]);?>
		<?=$t->row(["Created At",$f->input("txt_created_at",$_GET["txt_created_at"],"type='date'")]);?>
		<tr><td colspan="2"><input type="submit" name="search" value="Search">&nbsp;<input type="button" value="Reset" onclick="window.location='?token=<?=$_GET["token"];?>';"></td></tr>
	</table>
</form>
<?php
	$whereclause = "";
	if($_GET["sel_doctype"] != "") $whereclause .= "doctype='".$_GET["sel_doctype"]."' AND ";
	if($_GET["txt_project_name"] != "") $whereclause .= "project_name LIKE '%".$_GET["txt_project_name"]."%' AND ";
	if($_GET["sel_site"] != "") $whereclause .= "site_id='".$_GET["sel_site"]."' AND ";
	if($_GET["txt_created_at"] != "") $whereclause .= "created_at LIKE '".$_GET["txt_created_at"]."%' AND ";
	if($_SESSION["username"] != "") $whereclause .= "created_by='".$_SESSION["username"]."' AND ";
	$whereclause = substr($whereclause,0,-4);
?>
<button onclick="window.location='atp_installation_cover_add.php?token=<?=$token;?>&doctype=rectifier';">New Rectifier Doc</button>
&nbsp;
<button onclick="window.location='atp_installation_cover_add.php?token=<?=$token;?>&doctype=bts_sran';">New BTS SRAN Doc</button>
<br>

<div style="overflow-x:auto;">
	<table id="data_content">
		<tr>
			<th>No</th>
			<th>Work Type</th>
			<th>Vendor</th>
			<th>Project Name</th>
			<th>Site Name</th>
			<th nowrap>Acceptance At</th>
			<th>Acceptance Status</th>
			<th>Created At</th>
		</tr>
		<?php 
		// fetch_all_data($table,$fields = array(),$where = "",$order="",$limit=""){
			$atd_covers = $db->fetch_all_data("indottech_atd_cover",[],$whereclause);
			foreach($atd_covers as $no => $atd_cover){ 
				if($atd_cover["acceptance_status"] == 0) $acceptance_status = "";
				if($atd_cover["acceptance_status"] == 1) $acceptance_status = "PASS, NO PENDING ITEMS";
				if($atd_cover["acceptance_status"] == 2) $acceptance_status = "PASS WITH PENDING ITEMS";
				if($atd_cover["acceptance_status"] == 3) $acceptance_status = "REJECTED BY XL AXIATA";
				if($atd_cover["doctype"] == "rectifier") $doctype = "RECTIFIER";
				if($atd_cover["doctype"] == "bts_sran") $doctype = "BTS SRAN";
				$onclick = "onclick=\"window.location='atp_installation_menu.php?token=".$token."&atd_id=".$atd_cover["id"]."';\"";
		?>
			<tr <?=$onclick;?>>
				<td align="center"><?=($no+1);?></td>
				<td><?=$doctype;?></td>
				<td><?=$atd_cover["vendor"];?></td>
				<td><?=$atd_cover["project_name"];?></td>
				<td><?=$atd_cover["site_name"];?></td>
				<td><?=format_tanggal($atd_cover["acceptance_at"]);?></td>
				<td><?=$acceptance_status;?></td>
				<td><?=format_tanggal($atd_cover["created_at"]);?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<?php include_once "footer.php";?>