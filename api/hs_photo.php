<?php include_once "header.php";?>
<?php
	if($_GET["id"]){
		$id = $_GET["id"];
		$indottech_hs 	= $db->fetch_all_data("indottech_hs",[],"id='".$id."'")[0];
		$site_id		= $indottech_hs["site_id"];
	} else {
		$site_id	= $_GET["site_id"];
		$id 		= $db->fetch_single_data("indottech_hs","id",["site_id"=>$site_id, "created_by"=>$__username]);
	}
	$parent_id = $_GET["parent_id"] * 1;
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&id=<?=$id;?>&site_id=<?=$site_id;?>&delete_photo=" + photos_id;
		}
	}
</script>
<center><h4><b>HS PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("indottech_sites","name",["id" => $site_id]);?></td></tr>
</table>
<?php
	$back = $f->input("back","Back","type='button' onclick='window.location=\"hs_add.php?token=".$token."&id=".$id."&site_id=".$site_id."&mode=hs\";'","btn btn-warning");
	if($parent_id > 0){
		$back = $f->input("back","Back","type='button' onclick='window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."\";'","btn btn-warning");
	}
?>
<table width="100%"><tr>
	<td><?=$back;?></td>
</tr></table>
<?php
	$site_name = $db->fetch_single_data("indottech_sites","name",["id" => $site_id]);
	$photos = $db->fetch_all_data("indottech_photo_items",[],"parent_id=".$parent_id." AND project_id=29 AND doctype LIKE 'hs_%'","seqno");
	foreach($photos as $photo){
		$indottech_photos = $db->fetch_all_data("indottech_photos",[],"id='".$id."' AND photo_items_id='".$photo["id"]."'","seqno");
		$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $photo["id"]]);
		if($is_parent > 0){
			$url_takephoto = "hs_photo.php?token=".$token."&id=".$id."&site_id=".$site_id."&photo_items_id=".$photo["id"]."&parent_id=".$photo["id"];
			$url_imagepick = "";
		} else {
			$url_takephoto = "hs_photo.php?token=".$token."&id=".$id."&site_id=".$site_id."&photo_items_id=".$photo["id"]."&parent_id=".$parent_id."&photo_name=".$photo["name"]."&site_name=".$site_name."&takephoto_offline=".$id."|".$photo["id"];
			$url_imagepick = "hs_photo.php?token=".$token."&id=".$id."&site_id=".$site_id."&photo_items_id=".$photo["id"]."&parent_id=".$parent_id."&photo_name=".$photo["name"]."&site_name=".$site_name."&imagepick=".$id."|".$photo["id"];
		}
?>
	<table width="100%" border="1">
		<tr><td align="center"colspan="<?=count($indottech_photos);?>" nowrap>
			<h5><b><?=wordwrap($photo["name"],30,"<br>");?></b></h5>
			<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='<?=$url_takephoto;?>';">
			<?php if($url_imagepick != "" && false){ ?> <input style="font-size:10px;" type="button" value="From Galery" onclick="window.location='<?=$url_imagepick;?>';"> <?php } ?>
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
<?php include_once "footer.php";?>