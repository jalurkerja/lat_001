<?php include_once "header.php";?>
<table width="100%">
	<tr>
		<td align="left"><h4><b>Photo Attachments</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>
<center><?=$_errormessage;?></center>

<form method="GET">
	<input type="hidden" name="token" value="<?=$_GET["token"];?>">
	<table>
		<tr><td><b><u>Filter:</u></b></td></tr>
		<?=$t->row(["Site Name",$f->input("txt_site_name",$_GET["txt_site_name"])]);?>
		<tr><td colspan="2">
			<?=$f->input("search","Search","type='submit'","btn btn-info");?>&nbsp;
			<?=$f->input("","Reset","type='button' onclick='window.location=\"?token=".$_GET["token"]."\";'","btn btn-warning");?>
		</td></tr>
	</table>
</form>	

<?php
	$start_date	= date("Y-m-d",mktime(0,0,0,date("m")-6,date("d"),date("Y")));
	$end_date	= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));

	$_whereclause = "";
	if($_GET["txt_site_name"] != "") {
		$indottech_tag_photo_projects = $db->fetch_all_data("indottech_tag_photo_projects",["id"],"site_name LIKE '%".$_GET["txt_site_name"]."%'");
		$in_ids = "";
		foreach($indottech_tag_photo_projects as $indottech_tag_photo_project){
			$in_ids .=$indottech_tag_photo_project["id"].",";
		}
		$_whereclause .= "tag_photo_id IN (".substr($in_ids,0,-1).") AND ";
	} 
	if($_GET["txt_site_name"] == "") $whereclause .= "created_at between '".$start_date."' AND '".$end_date."' AND ";
	
	$db->addtable("indottech_h3i_photo_attachments");
	$db->limit("200");
	$db->awhere(substr($whereclause,0,-4));
	$db->order("created_at DESC");
	$indottech_h3i_photo_attachments = $db->fetch_data(true);
?>
<?=$f->input("","Add ATP Dism PAR","type='button' onclick='window.location=\"h3i_atp_par_add.php?token=".$_GET["token"]."&project_id=3\";'","btn btn-primary");?>&ensp;
<br>

<div style="overflow-x:auto;">
	<table width="320" align="center" border="0" rules="" id="data_content">
		<tr>
			<th width="3%">No</th>
			<th>Document Name</th>
			<th>Site Name</th>
			<th>Created At</th>
			<th>Last Downloaded By</th>
			<th>Last Downloaded At</th>
		</tr>
		<?php
			$no = 1;
			foreach($indottech_h3i_photo_attachments as $indottech_h3i_photo_attachment){
				$onclick = "onclick=\"window.location='tag_photo_project.php?token=".$token."&atd_id=".$indottech_h3i_photo_attachment["id"]."';\"";
				$sites_detail = $db->fetch_all_data("indottech_tag_photo_projects",[],"id = '".$indottech_h3i_photo_attachment["tag_photo_id"]."'")[0];
				?>
				<tr <?=$onclick;?>>
					<td align="right"><?=$no++;?></td>	
					<td><?=$indottech_h3i_photo_attachment["doc_name"];?></td>
					<td><?="[".$sites_detail["site_code"]."] ".$sites_detail["site_name"];?></td>
					<td align="right"><?=format_tanggal($indottech_h3i_photo_attachment["created_at"],"d-M-Y");?></td>
					<td><?=$indottech_h3i_photo_attachment["last_downloaded_by"];?></td>
					<td align="right"><?php if($indottech_h3i_photo_attachment["last_downloaded_at"] != "0000-00-00") echo format_tanggal($indottech_h3i_photo_attachment["last_downloaded_at"],"d-M-Y");?></td>
				</tr>
				<?php
			}
		?>
	</table>
</div>
<?php include_once "footer.php";?>