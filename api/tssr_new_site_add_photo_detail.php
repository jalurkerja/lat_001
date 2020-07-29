<?php 
	include_once "header.php";
	$has_parent = $db->fetch_single_data("indottech_photo_items","parent_id",["id" => $_GET["photo_items_id"]]);
	if($has_parent > 0) $_GET["photo_items_id"] = $has_parent;
	$tssr_id = $_GET["tssr_id"];
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("tssr_id",$tssr_id); $db->delete_();
	}
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
	$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $_GET["photo_items_id"]]);
	
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."&page=".$_GET["page"]."&photo_items_id=".$_GET["photo_items_id"]."&imagepick=".$_GET["imagepick"]."&takephoto=".$_GET["takephoto"]."\";'","btn btn-success");
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>&photo_items_id=<?=$_GET["photo_items_id"];?>&delete_photo=" + photos_id;
		}
	}
</script>
<center><h4><b>TSSR PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("indottech_tssr_01","concat(site_id,' - ',site_name)",["id" => $tssr_id]);?></td></tr>
	<?php if($is_parent){ ?>
		<tr><td>PHOTO ITEM</td><td>:</td><td><b><?=$db->fetch_single_data("indottech_photo_items","name",["id" => $_GET["photo_items_id"]]);?></b></td></tr>
	<?php } ?>
</table>
<table width="100%"><tr>
	<?php
		$page_back = $_GET["page"];
		if($_GET["page"] == "16") $page_back = 15;
	?>
	<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=".$page_back."\";'","btn btn-warning");?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>">
	<?php
		$whereclause = "id='".$_GET["photo_items_id"];
		if(!$is_parent) {
			if($_GET["page"] == "02") $whereclause = "id = '1192'";
			if($_GET["page"] == "04") $whereclause = "id BETWEEN '1193' AND '1263'";
			if($_GET["page"] == "05") $whereclause = "id BETWEEN '1264' AND '1267'";
			if($_GET["page"] == "06") $whereclause = "id BETWEEN '1268' AND '1270'";
			if($_GET["page"] == "09") $whereclause = "id BETWEEN '1271' AND '1284'";
			if($_GET["page"] == "10") $whereclause = "id BETWEEN '1285' AND '1288'";
			if($_GET["page"] == "11") $whereclause = "id BETWEEN '1289' AND '1292'";
			if($_GET["page"] == "12") $whereclause = "id BETWEEN '1293' AND '1298'";
			if($_GET["page"] == "13") $whereclause = "id BETWEEN '1299' AND '1302'";
			if($_GET["page"] == "14") $whereclause = "id BETWEEN '1303' AND '1306'";
			if($_GET["page"] == "15") $whereclause = "id BETWEEN '1307' AND '1316'";
			if($_GET["page"] == "16") $whereclause = "id BETWEEN '1192' AND '1316'";
		}
		$photos = $db->fetch_all_data("indottech_photo_items",[],$whereclause,"seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"tssr_id='".$tssr_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			
			if(strlen($photo["name"]) > 48) $photo["name"] = substr($photo["name"],0,48)."...";
	?>
		<table width="100%" border="1">
			<tr><td align="center"colspan="<?=count($indottech_photos);?>" nowrap>
				<h5><b><?=$photo["name"];?></b></h5>
				<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>&photo_items_id=<?=$_GET["photo_items_id"];?>&takephoto=<?=$tssr_id;?>|<?=$photo["id"];?>|<?=$_GET["page"];?>';">
				<input style="font-size:10px;" type="button" value="From Galery" onclick="window.location='?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>&photo_items_id=<?=$_GET["photo_items_id"];?>&imagepick=<?=$tssr_id;?>|<?=$photo["id"];?>|<?=$_GET["page"];?>';">
			</td></tr>
			<tr>
				<?php 
					foreach($indottech_photos as $indottech_photo){
				?>
					<td align="center">
						<img onclick="zoomimage('<?=$indottech_photo["filename"];?>');" src="../geophoto/<?=$indottech_photo["filename"];?>" width="100">
						<br><?=$f->input("delete","Delete","type='button' onclick=\"deletephoto('".$indottech_photo["id"]."');\"");?>
					</td>
				<?php } ?>
			</tr>
		</table>
		<br>
	<?php } ?>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>