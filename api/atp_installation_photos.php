<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("atd_id",$atd_id); $db->delete_();
	}
	$atr = $db->fetch_all_data("indottech_acceptance_test_rectifier",[],"atd_id='".$atd_id."'")[0];
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
	$doctype = $db->fetch_single_data("indottech_atd_cover","doctype",["id" => $atd_id]);
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&atd_id=<?=$atd_id;?>&delete_photo=" + photos_id;
		}
	}
</script>
<center><h4><b>PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>PROJECT NAME</td><td>:</td><td><?=$db->fetch_single_data("indottech_atd_cover","project_name",["id" => $atd_id]);?></td></tr>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);?></td></tr>
</table>
<table width="100%"><tr>
	<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<?php
		$photos = $db->fetch_all_data("indottech_photo_items",[],"parent_id=0 AND doctype='".$doctype."'","seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"atd_id='".$atd_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $photo["id"]]);
			if($is_parent){
				$url_takephoto = "atp_installation_photos_detail.php?token=".$token."&atd_id=".$atd_id."&photo_items_id=".$photo["id"];
				$url_imagepick = "";
			} else {
				$url_takephoto = "atp_installation_photos_detail.php?token=".$token."&atd_id=".$atd_id."&photo_items_id=".$photo["id"]."&takephoto=".$atd_id."|".$photo["id"];
				$url_imagepick = "atp_installation_photos_detail.php?token=".$token."&atd_id=".$atd_id."&photo_items_id=".$photo["id"]."&imagepick=".$atd_id."|".$photo["id"];
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
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>