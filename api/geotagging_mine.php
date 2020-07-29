<?php
$fromlist = $_GET["fromlist"];
$current = $_GET["current"];
?>
<html>
	<head>
		<?php if(!$current && !$fromlist && !isset($_GET["retake"])){ ?>
		<meta http-equiv="refresh" content="5">
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
	</head>
	<body>
		<style>
			body{
				font-size:10px;
			}
			a{
				text-decoration:none;
				color:#43579C;
			}
			.title {
				font-weight:bolder;
				font-family:Comic Sans MS;
				padding:0 0 5 0;
			}
		</style>
<?php 
	include_once "../common.php";
	include_once "user_info.php";
	include_once "func.photo_items.php";
	$tagging_at = $_GET["tagging_at"];
	$sitename = $_GET["sitename"];
	$site_id = $_GET["site_id"];
	$indottech_geotagging_req_id = $_GET["indottech_geotagging_req_id"];
	$sitename = $db->fetch_single_data("indottech_geotagging_req","sitename",["id" => $indottech_geotagging_req_id]);
	if($_GET["user_id"] != ""){
		$user_id = $_GET["user_id"];
		$back = "<input type='button' value='Back' style='width:100%;height:50px;font-size:20px;font-weight:bolder;' onclick=\"window.location='geotagging_mine.php?token=".$token."&sitename=".$sitename."&site_id=".$site_id."';\">";
	}
		
	$is_parent = false;
	$XXXuser_id = $db->fetch_single_data("users","id",["token" => $token]);
	$XXXgroup_id = $db->fetch_single_data("users","group_id",["id" => $XXXuser_id]);
	if($db->fetch_single_data("indottech_group","id",["parent_user_id" => $XXXuser_id]) > 0) $is_parent = true;
	if($XXXgroup_id == 13 || $XXXgroup_id == 11 || $XXXgroup_id < 4) $is_parent = true;

	if($current || $fromlist){
		if($fromlist && !isset($_GET["retake"])) $btnPhoto = "<a href='?".$_SERVER["QUERY_STRING"]."&retake=".$site_id."||".$sitename."||".$tagging_at."||".$indottech_geotagging_req_id."'><img src='../icons/cam.png' width='30'> Take Photo</a>";
		if($fromlist && isset($_GET["retake"])) $btnPhoto = "<span style='color:red;font-size:20px;'>Getting Location Coordinate, Please Wait...</span>";
?>
	<?=$back;?>
	<h4>Site : <b>[<?=$site_id;?>] <?=$sitename;?></b><br><?=$btnPhoto;?></h4>
	<?php
		$captureds = array();
		$db->addtable("indottech_geotagging");
		$db->where("indottech_geotagging_req_id",$indottech_geotagging_req_id);
		$db->order("photo_item_id");
		$indottech_geotaggings = $db->fetch_data(true);
		echo "<ul>";
		foreach($indottech_geotaggings as $indottech_geotagging){
			$captureds[$indottech_geotagging["photo_item_id"]] = 1;
		}
		
		$photo_item_ids = pipetoarray($db->fetch_single_data("indottech_geotagging_req","photo_item_ids",["id" => $indottech_geotagging_req_id]));
		$photo_items = photo_items_list($photo_item_ids);
		foreach($photo_items as $photo_item){
			if(!$captureds[$photo_item["id"]]){
				if($fromlist){
					$notcomplete = true;
					break;
				}
				/* if(!isset($_GET["skipItem"])){
					?> <script> window.location = "?token=<?=$_GET["token"];?>&tagging_at=<?=$_GET["tagging_at"];?>&current=1&site_id=<?=$_GET["site_id"];?>&indottech_geotagging_req_id=<?=$indottech_geotagging_req_id;?>&skipItem=<?=$photo_item["id"];?>||<?=get_complete_name($photo_item["id"]);?>"; </script> <?php
					exit();
				} */
				echo "<li>";
				echo "<a href='?token=".$_GET["token"]."&tagging_at=".$_GET["tagging_at"]."&current=1&site_id=".$_GET["site_id"]."&indottech_geotagging_req_id=".$indottech_geotagging_req_id."&skipItem=".$photo_item["id"]."||".get_complete_name($photo_item["id"])."'>";
				echo "<img src='../icons/cam.png' width='20'> ".get_complete_name($photo_item["id"]);
				echo "</a>";
				echo "</li>";
			}
		}
		
		foreach($indottech_geotaggings as $indottech_geotagging){
			echo "<li>";
			echo "<a style='font-weight: bolder;' href=\"geotagging_img_detail.php?fromlist=".$fromlist."&current=".$current."&user_id=".$_GET["user_id"]."&token=".$token."&sitename=".$sitename."&site_id=".$site_id."&id=".$indottech_geotagging["id"]."&indottech_geotagging_req_id=".$indottech_geotagging_req_id."&photo_item_id=".$indottech_geotagging["photo_item_id"]."&dl_url=".$_GET["dl_url"]."\">";
			echo "<img src='../icons/search_window.png' width='20'> ".get_complete_name($indottech_geotagging["photo_item_id"]);
			echo "</a>";
			echo "</li>";
		}
		echo "</ul>";
	?>
<?php } else { ?>
	<!--
		<div class="title">
			<a href="?btnMode=arsip_menus&token=<?=$token;?>"><img src="../icons/back.png" style="width:10px; height:10px;"> &ensp;Back</a>
		</div>
	-->
	<div style="overflow-x:auto;">
		<table id="data_content">
			<tr>
				<?php if($is_parent){ ?>
					<th>Name</th>
				<?php } ?>
				<th>Sitename</th>
				<th>Tagging At</th>
				<th>Photo</th>
			</tr>
		<?php
			$db->addtable("indottech_geotagging");
			if($XXXgroup_id == 13 || $XXXgroup_id == 11 || $XXXgroup_id < 4){
				$db->awhere("1=1 GROUP BY user_id,site_id,tagging_at ");
			} else {
				$db->awhere("site_id <>'' AND user_id = '".$user_id."' OR user_id IN (SELECT user_id FROM indottech_group WHERE parent_user_id = '".$user_id."') GROUP BY user_id,site_id,tagging_at ");
			}
			$db->order("id DESC");
			$db->limit("100");
			$indottech_geotaggings = $db->fetch_data(true);
			foreach($indottech_geotaggings as $indottech_geotagging){
				$user_id = $indottech_geotagging["user_id"];
				$site_id = $indottech_geotagging["site_id"];
				$_indottech_geotagging_req_id = $indottech_geotagging["indottech_geotagging_req_id"];
				$sitename = $db->fetch_single_data("indottech_geotagging_req","sitename",["id" => $_indottech_geotagging_req_id]);
				$fsfl_mode = $db->fetch_single_data("indottech_geotagging_req","fsfl_mode",["id" => $_indottech_geotagging_req_id]);
				if($fsfl_mode != 1){
					if($db->fetch_single_data("indottech_geotagging_req","id",["id" => $indottech_geotagging_req_id, "photo_item_ids" => "%|615|%:LIKE"])) $fsfl_mode = 1;
				}
				
				$tagging_at = $indottech_geotagging["tagging_at"];
				$name = $db->fetch_single_data("users","name",["id" => $user_id]);
				$photo = $db->fetch_single_data("indottech_geotagging","count(0)",["user_id" => $indottech_geotagging["user_id"],"site_id"=>$site_id,"tagging_at"=>$tagging_at]);
				$photo .= "/".count(photo_items_list(pipetoarray($db->fetch_single_data("indottech_geotagging_req","photo_item_ids",["id" => $_indottech_geotagging_req_id]))));
				$dl_url = "../geophoto/geotag_".$user_id."_".$site_id."_".$tagging_at.".zip";
				
				echo "<tr onclick=\"window.location='?token=".$token."&user_id=".$user_id."&fromlist=1&sitename=".$sitename."&site_id=".$site_id."&tagging_at=".$tagging_at."&indottech_geotagging_req_id=".$_indottech_geotagging_req_id."&dl_url=".$dl_url."'\">";
					if($is_parent){
						echo "<td>".$name."</td>";
					}
					if($fsfl_mode == 1) $sitename .= " <b>[FSFL]</b>";
					echo "<td>[".$site_id."] ".$sitename."</td>";
					echo "<td>".format_tanggal($indottech_geotagging["tagging_at"],"dMY")."</td>";
					echo "<td>".$photo."</td>";
				echo "</tr>";
			}
		?>
		</table>
	</div>
<?php } ?>
	</body>
</html>
