<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("tssr_id",$tssr_id); $db->delete_();
	}
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
	
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."&page=".$_GET["page"]."\";'","btn btn-success");
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>&delete_photo=" + photos_id;
		}
	}
</script>


<center><h4><b>TSSR PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("indottech_tssr_01","concat(site_id,' - ',site_name)",["id" => $tssr_id]);?></td></tr>
</table>
<?php
	$page_back = $_GET["page"];
	if($_GET["page"] == "16") $page_back = 15;
	$back = $f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_".$page_back.".php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");
?>
<table width="100%"><tr>
	<td><?=$back;?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>&page=<?=$_GET["page"];?>">
	<?php
		$whereclause = "";
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
		$photos = $db->fetch_all_data("indottech_photo_items",[],$whereclause,"seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"tssr_id='".$tssr_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $photo["id"]]);
			if($is_parent > 0){
				$url_takephoto = "tssr_new_site_add_photo_detail.php?token=".$token."&tssr_id=".$tssr_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"];
				$url_imagepick = "";
			} else {
				$url_takephoto = "tssr_new_site_add_photo_detail.php?token=".$token."&tssr_id=".$tssr_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"]."&takephoto=".$tssr_id."|".$photo["id"]."|".$_GET["page"];
				$url_imagepick = "tssr_new_site_add_photo_detail.php?token=".$token."&tssr_id=".$tssr_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"]."&imagepick=".$tssr_id."|".$photo["id"]."|".$_GET["page"];
			}
	?>
		<table width="100%" border="1">
			<tr><td align="center"colspan="<?=count($indottech_photos);?>" nowrap>
				<h5><b><?=$photo["name"];?></b></h5>
				<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='<?=$url_takephoto;?>';">
				<?php if($url_imagepick != ""){ ?> <input style="font-size:10px;" type="button" value="From Galery" onclick="window.location='<?=$url_imagepick;?>';"> <?php } ?>
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
<?php include_once "footer.php";?>