<?php 
	include_once "header.php";
	$has_parent = $db->fetch_single_data("indottech_photo_items","parent_id",["id" => $_GET["photo_items_id"]]);
	if($has_parent > 0) $_GET["photo_items_id"] = $has_parent;
	$atd_id = $_GET["atd_id"];
	$project_id = $db->fetch_single_data("indottech_tag_photo_projects","project_id",["id" => $atd_id]);
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("atd_id",$atd_id); $db->delete_();
	}
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
	$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $_GET["photo_items_id"]]);
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&atd_id=<?=$atd_id;?>&photo_items_id=<?=$_GET["photo_items_id"];?>&delete_photo=" + photos_id;
		}
	}
</script>
<center><h4><b>PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td>[<?=$db->fetch_single_data("indottech_tag_photo_projects","site_code",["id" => $atd_id]);?>] <?=$db->fetch_single_data("indottech_tag_photo_projects","site_name",["id" => $atd_id]);?></td></tr>
	<?php if($is_parent){ ?>
		<tr><td>PHOTO ITEM</td><td>:</td><td><b><?=$db->fetch_single_data("indottech_photo_items","name",["id" => $_GET["photo_items_id"]]);?></b></td></tr>
	<?php } ?>
</table>
<table width="100%"><tr>
	<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tag_photo_project.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<?php
		$whereclause = "id='".$_GET["photo_items_id"]."' AND project_id='".$project_id."'";
		if($is_parent) $whereclause = "parent_id='".$_GET["photo_items_id"]."' AND project_id='".$project_id."'";
		$photos = $db->fetch_all_data("indottech_photo_items",[],$whereclause,"seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"atd_id='".$atd_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			if(strlen($photo["name"]) > 48) $photo["name"] = substr($photo["name"],0,48)."...";
	?>
		<table width="100%" border="1">
			<tr><td align="center"colspan="<?=count($indottech_photos);?>" nowrap>
				<h5><b><?=$photo["name"];?></b></h5>
				<input style="font-size:10px;" type="button" value="Take Photo" onclick="window.location='?token=<?=$token;?>&atd_id=<?=$atd_id;?>&photo_items_id=<?=$_GET["photo_items_id"];?>&takephoto=<?=$atd_id;?>|<?=$photo["id"];?>';">
				<input style="font-size:10px;" type="button" value="From Galery" onclick="window.location='?token=<?=$token;?>&atd_id=<?=$atd_id;?>&photo_items_id=<?=$_GET["photo_items_id"];?>&imagepick=<?=$atd_id;?>|<?=$photo["id"];?>';">
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