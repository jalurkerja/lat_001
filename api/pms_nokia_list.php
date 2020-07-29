<?php include_once "header.php";?>

<table width="100%">
	<tr>
		<td align="left"><h4><b>Self Inspection Report Checklist</b></h4></td>
		<!--
			<td align="right" style="padding: 5;"><a href="?btnMode=mainmenu&token=<?=$token;?>"><img src="../icons/menu.png" style="width:30px; height:30px;"></a></td>
		-->
	</tr>
</table>
<center><?=$_errormessage;?></center>

<!--
<form method="GET">
	<input type="hidden" name="token" value="<?=$_GET["token"];?>">
	<table>
		<tr><td><b><u>Filter:</u></b></td></tr>
		<?=$t->row(["Site",$f->input("txt_site",$_GET["txt_site"])]);?>
		<?=$t->row(["City Provice",$f->input("txt_city_provice",$_GET["txt_city_provice"])]);?>
		<?=$t->row(["Cust PO",$f->input("txt_po",$_GET["txt_po"])]);?>
		<tr><td colspan="2">
			<?=$f->input("search","Search","type='submit'","btn btn-info");?>&nbsp;
			<?=$f->input("","Reset","type='button' onclick='window.location=\"?token=".$_GET["token"]."\";'","btn btn-warning");?>
		</td></tr>
	</table>
</form>	
-->

<?php
	$start_date	= date("Y-m-d",mktime(0,0,0,date("m")-6,date("d"),date("Y")));
	$end_date	= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
	$whereclause = "";
	if($_GET["txt_site"] != "") {
		$whereclause .= "(site_id LIKE '%".$_GET["txt_site"]."%' OR site_name LIKE '%".$_GET["txt_site"]."%') AND ";
	}
	if($_GET["txt_city_provice"] != "") {
		$whereclause .= "(city_prov LIKE '%".$_GET["txt_city_provice"]."%') AND ";
	}
	if($_GET["txt_po"] != "") {
		$whereclause .= "(cust_po LIKE '%".$_GET["txt_po"]."%') AND ";
	}
	$whereclause .= "user_id_creator = '".$__user_id."' AND ";
		
	$db->addtable("pms_nokia");
	$db->limit("200");
	$db->awhere(substr($whereclause,0,-4));
	$db->order("created_at DESC");
	$pms_nokia = $db->fetch_data(true);
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-success");
?>
<?=$f->input("","Add","type='button' onclick='window.location=\"pms_nokia_add_01.php?token=".$_GET["token"]."\";'","btn btn-primary");?>&ensp;
<br>

<div style="overflow-x:auto;">
	<table width="100%" align="center" border="0" rules="" id="data_content">
		<tr>
			<th width="3%">No</th>
			<th>Site ID</th>
			<th>Site Name</th>
			<th>Project Name</th>
			<th>Team Leader</th>
			<th>Subcontractor</th>
			<th>Tanggal Audit</th>
		</tr>
		<?php
			$no = 1;
			foreach($pms_nokia as $_pms_nokia){
				$onclick = "onclick=\"window.location='pms_nokia_add_01.php?token=".$token."&pms_id=".$_pms_nokia["id"]."';\"";
				?>
				<tr <?=$onclick;?>>
					<td align="right"><?=$no++;?></td>	
					<td><?=$_pms_nokia["site_id"];?></td>
					<td><?=$_pms_nokia["site_name"];?></td>
					<td><?=$_pms_nokia["project_name"];?></td>
					<td><?=$_pms_nokia["team_leader"];?></td>
					<td><?=$_pms_nokia["sub_con"];?></td>
					<td align="right"><?=format_tanggal($_pms_nokia["tanggal_audit"],"d-M-Y");?></td>
				</tr>
				<?php
			}
		?>
	</table>
</div>
<?php include_once "footer.php";?>