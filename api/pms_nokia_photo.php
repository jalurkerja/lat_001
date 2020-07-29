<?php 
	include_once "header.php";
	$pms_id = $_GET["pms_id"];
	$atd_id = $db->fetch_single_data("pms_nokia","atd_id",["id" => $pms_id]);
	if(isset($_GET["delete_photo"])){
		$db->addtable("indottech_photos"); $db->where("id",$_GET["delete_photo"]); $db->where("pms_id",$pms_id); $db->delete_();
	}
	if(isset($_GET["takephoto"])) $_errormessage = "<font color='red'>Harap tunggu, sedang memuat koordinat GPS</font>";
	
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&pms_id=".$pms_id."&page=".$_GET["page"]."\";'","btn btn-success");
?>
<script>
	function deletephoto(photos_id){
		if(confirm("Anda yakin akan menghapus foto ini?")){
			window.location="?token=<?=$token;?>&pms_id=<?=$pms_id;?>&page=<?=$_GET["page"];?>&delete_photo=" + photos_id;
		}
	}
</script>


<center><h4><b>PMS Nokia - PHOTOS</b></h4></center>
<center><?=$_errormessage;?></center>
<table>
	<tr><td>SITE</td><td>:</td><td><?=$db->fetch_single_data("pms_nokia","concat(site_id,' - ',site_name)",["id" => $pms_id]);?></td></tr>
</table>
<?php
	$page_back = $_GET["page"]; $page_next = $_GET["page"]+1;
	$back = $f->input("back","Back","type='button' onclick='window.location=\"pms_nokia_add_".$page_back.".php?token=".$token."&pms_id=".$pms_id."\";'","btn btn-warning");
	$next = $f->input("next","Next","type='button' onclick='window.location=\"pms_nokia_add_0".$page_next.".php?token=".$token."&pms_id=".$pms_id."\";'","btn btn-info");
	if($_GET["page"] == "04") $next = $f->input("next","Next","type='button' onclick='window.location=\"pms_nokia_photo.php?token=".$token."&pms_id=".$pms_id."&page=05\";'","btn btn-info");
	if($_GET["page"] == "05") {
		$next = $f->input("next","Home","type='button' onclick='window.location=\"pms_nokia_list.php?token=".$token."\";'","btn btn-success");
		$back = $f->input("back","Back","type='button' onclick='window.location=\"pms_nokia_photo.php?token=".$token."&pms_id=".$pms_id."&page=04\";'","btn btn-warning");
	}
?>
<table width="100%"><tr>
	<td align="left"><?=$back;?></td>
	<td align="right"><?=$next;?></td>
</tr></table>
<form method="POST" action="?token=<?=$token;?>&pms_id=<?=$pms_id;?>&page=<?=$_GET["page"];?>">
	<?php
		$whereclause = "";
		if($_GET["page"] == "02") $whereclause = "id BETWEEN '1436' AND '1442'";
		if($_GET["page"] == "03") $whereclause = "id = '1443'";
		if($_GET["page"] == "04") $whereclause = "id = '1444'";
		if($_GET["page"] == "05") $whereclause = "id BETWEEN '1445' AND '1447'";
		$photos = $db->fetch_all_data("indottech_photo_items",[],$whereclause,"seqno");
		foreach($photos as $photo){
			$indottech_photos = $db->fetch_all_data("indottech_photos",[],"atd_id='".$atd_id."' AND photo_items_id='".$photo["id"]."'","seqno");
			$is_parent = $db->fetch_single_data("indottech_photo_items","id",["parent_id" => $photo["id"]]);
			if($is_parent > 0){
				$url_takephoto = "pms_nokia_photo_detail.php?token=".$token."&pms_id=".$pms_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"];
				$url_imagepick = "";
			} else {
				$url_takephoto = "pms_nokia_photo_detail.php?token=".$token."&pms_id=".$pms_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"]."&takephoto=".$pms_id."|".$photo["id"]."|".$_GET["page"];
				$url_imagepick = "pms_nokia_photo_detail.php?token=".$token."&pms_id=".$pms_id."&page=".$_GET["page"]."&photo_items_id=".$photo["id"]."&imagepick=".$pms_id."|".$photo["id"]."|".$_GET["page"];
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