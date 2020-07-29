<?php include_once "header.php";?>
<table width="100%">
	<tr>
		<td align="left"><h4><b>DWDM ALU</b></h4></td>
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
	$start_date	= date("Y-m-d H:i:s",mktime(0,0,0,date("m")-6,date("d"),date("Y")));
	$end_date	= date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")+1,date("Y")));
	$whereclause = "";
	if($_GET["txt_site_name"] != "") $whereclause .= "site_name LIKE '%".$_GET["txt_site_name"]."%' AND ";
	if($_GET["txt_site_name"] == "") $whereclause .= "created_at between '".$start_date."' AND '".$end_date."' AND ";
	$whereclause .= "created_by = '".$__username."' AND ";
		
	$db->addtable("indottech_dwdm");
	$db->limit("200");
	$db->awhere(substr($whereclause,0,-4));
	$db->order("created_at DESC");
	$indottech_dwdms = $db->fetch_data(true);
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-success")."&emsp;";
?>
<?=$f->input("","Add","type='button' onclick='window.location=\"indosat_dwdm_add.php?token=".$_GET["token"]."&project_id=17\";'","btn btn-primary");?>&ensp;
<br>

<div style="overflow-x:auto;">
	<table width="100%" align="center" border="0" rules="" id="data_content">
		<tr>
			<th width="3%">No</th>
			<th>Action</th>
			<th>Project</th>
			<th>Site Name</th>
			<th>Equipment</th>
			<th>Created At</th>
			<th>Last Downloaded</th>
		</tr>
		<?php
			$no = 1;
			foreach($indottech_dwdms as $indottech_dwdm){
				$onclick = "onclick=\"window.location='indosat_dwdm_add.php?token=".$token."&dwdm_id=".$indottech_dwdm["id"]."';\"";
				?>
				<tr <?=$onclick;?>>
					<td align="right"><?=$no++;?></td>	
					<td>View</td>
					<td><?=$indottech_dwdm["project"];?></td>
					<td><?=$indottech_dwdm["site_name"];?></td>
					<td><?=$indottech_dwdm["equipment"];?></td>
					<td align="right"><?=format_tanggal($indottech_dwdm["created_at"],"d-M-Y");?></td>
					<td>
						<?=$db->fetch_single_data("users","name",["email" => $indottech_dwdm["last_downloaded_by"]]);?>
						<?php
							if ($indottech_dwdm["last_downloaded_by"] != "") echo " [".format_tanggal($indottech_dwdm["last_downloaded_at"],"d-M-Y")."]";
						?>
					</td>
				</tr>
				<?php
			}
		?>
	</table>
</div>
<?php include_once "footer.php";?>