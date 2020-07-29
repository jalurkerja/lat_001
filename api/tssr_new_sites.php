<?php include_once "header.php";?>

<center><h4><b>TSSR New Site</b></h4></center>
<center><?=$_errormessage;?></center>

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
		
	$db->addtable("indottech_tssr_01");
	$db->limit("200");
	$db->awhere(substr($whereclause,0,-4));
	$db->order("created_at DESC");
	$tssrs = $db->fetch_data(true);
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-success");
?>
<?=$f->input("","Add","type='button' onclick='window.location=\"tssr_new_site_add_01.php?token=".$_GET["token"]."\";'","btn btn-primary");?>&ensp;
<br>

<div style="overflow-x:auto;">
<table width="100%" align="center" border="0" rules="" id="data_content">
	<tr>
		<th width="3%">No</th>
		<th>Site ID</th>
		<th>Site Name</th>
		<th>City Province</th>
		<th>Customer PO</th>
		<th>Created At</th>
		<th>Last Downloaded By</th>
		<th>Last Downloaded At</th>
	</tr>
	<?php
		$no = 1;
		foreach($tssrs as $tssr){
			$onclick = "onclick=\"window.location='tssr_new_site_add_01.php?token=".$token."&tssr_id=".$tssr["id"]."';\"";
			?>
			<tr <?=$onclick;?>>
				<td align="right"><?=$no++;?></td>	
				<td><?=$tssr["site_id"];?></td>
				<td><?=$tssr["site_name"];?></td>
				<td><?=$tssr["city_prov"];?></td>
				<td><?=$tssr["cust_po"];?></td>
				<td align="right"><?=format_tanggal($tssr["created_at"],"d-M-Y");?></td>
				<td><?=$db->fetch_single_data("users","name",["email" => $tssr["last_downloaded_by"]]);?></td>
				<td align="right"><?php if($tssr["last_downloaded_at"] != "0000-00-00") echo format_tanggal($tssr["last_downloaded_at"],"d-M-Y");?></td>
			</tr>
			<?php
		}
	?>
</table>
</div>
<?php include_once "footer.php";?>