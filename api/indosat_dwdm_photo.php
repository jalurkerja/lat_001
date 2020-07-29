<?php 
	include_once "header.php";
	$dwdm_id = $_GET["dwdm_id"];
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("dwdm_id",$dwdm_id); $db->delete_();
	}
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&dwdm_id=<?=$dwdm_id;?>&delete_photo=" + photos_id;
		}
	}
</script>


<center><h4><b>DWDM PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("indottech_dwdm","site_name",["id" => $dwdm_id]);?></td></tr>
</table>
<?php
	$back = $f->input("back","Back","type='button' onclick='window.location=\"indosat_dwdm_add.php?token=".$token."&dwdm_id=".$dwdm_id."\";'","btn btn-warning");
?>
<table width="100%"><tr>
	<td><?=$back;?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&dwdm_id=<?=$dwdm_id;?>">
	<?php
		$photos = $db->fetch_all_data("indottech_photo_items",[],"parent_id=0 AND project_id=17 AND doctype LIKE '%dwdm_%'","seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"dwdm_id='".$dwdm_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $photo["id"]]);
			if($is_parent > 0){
				$url_takephoto = "indosat_dwdm_photo_detail.php?token=".$token."&dwdm_id=".$dwdm_id."&photo_items_id=".$photo["id"];
				$url_imagepick = "";
			} else {
				$url_takephoto = "indosat_dwdm_photo_detail.php?token=".$token."&dwdm_id=".$dwdm_id."&photo_items_id=".$photo["id"]."&takephoto=".$dwdm_id."|".$photo["id"];
				$url_imagepick = "indosat_dwdm_photo_detail.php?token=".$token."&dwdm_id=".$dwdm_id."&photo_items_id=".$photo["id"]."&imagepick=".$dwdm_id."|".$photo["id"];
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