<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	
	$temp		= date("Ymd")."_".$__user_id."_";
	$filephoto	= $db->fetch_all_data("attendance_activity",[],"user_id = '".$__user_id."' AND filephoto LIKE '%".$temp."%' order by filephoto DESC")[0];
	
	if(!$filephoto){
		$filename	= $temp."00";
	} else {
		$filename	= $temp.sprintf("%02d",(explode(".",(explode($temp,$filephoto["filephoto"])[1]))[0] + 1));
	}
?>
<script>
	window.location.replace("attendance_activity_add.php?token=<?=$_GET["token"];?>&filename=<?=$filename;?>&takeactivityphoto=<?=$filename;?>");
</script>
<?php include_once "footer.php"; ?>