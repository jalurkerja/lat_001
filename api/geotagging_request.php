<html>
	<head>
		<meta http-equiv="refresh" content="5">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
		<style>
		   #map {
			min-height:300px;
			height: 100%;
			width: 100%;
		   }
		</style>
	</head>
	<body id="bodyid" style="margin:0px;">
<?php 
	include_once "../common.php";
	include_once "user_info.php";
	if($db->fetch_single_data("backoffice_menu_privileges","id",["group_id"=>$group_id,"backoffice_menu_id"=>"97"]) <= 0){ echo "Forbidden Page!"; exit(); } 
	if($group_id == "12" || $group_id == "" || $token == "") { echo "Forbidden Page!"; exit(); } 
	if(!isset($_GET["mode"])){//listing
		$db->addtable("indottech_geotagging_req");
		$db->awhere("status > -1");
		$db->order("status,id DESC");
		$db->limit("200");
		$indottech_geotagging_reqs = $db->fetch_data(true);
		?>
		<h2>Request List</b></h2>
		<table id="data_content">
			<tr>
				<th>Name</th>
				<th>Sitename</th>
				<th>Location</th>
				<th>Request At</th>
				<th>Status</th>
			</tr>
		<?php
			foreach($indottech_geotagging_reqs as $indottech_geotagging_req){
				$trstyle = "";
				$id = $indottech_geotagging_req["id"];
				$lat = $indottech_geotagging_req["latitude"];
				$long = $indottech_geotagging_req["longitude"];
				if($indottech_geotagging_req["status"] == 0){
					$trstyle = "style='background-color:red;'";
					$status = "<input type='button' value='View' onclick='window.location=\"?mode=showmap&token=".$token."&lat=".$lat."&long=".$long."&id=".$id."\"'>";
				}
				if($indottech_geotagging_req["status"] == 1){
					$status = "Approved";
					$status = "<a href='?mode=showmap&token=".$token."&lat=".$lat."&long=".$long."&id=".$id."'>Approved</a>";
				}
				if($indottech_geotagging_req["status"] == 2){
					$status = "<b>Approved</b>";
					$status = "<b><a href='?mode=showmap&token=".$token."&lat=".$lat."&long=".$long."&id=".$id."'>Approved</a></b>";
				}
				if($indottech_geotagging_req["status"] == -1 || $indottech_geotagging_req["status"] == -2){
					$status = "<b style='color:red;'>Rejected</b>";
				}
				if($indottech_geotagging_req["fsfl_mode"] == 1){
					$indottech_geotagging_req["sitename"] .= " <b>[FSFL]</b>";
				}
		?>
			<tr <?=$trstyle;?>>
				<td nowrap valign="top"><?=$db->fetch_single_data("users","name",["id" => $indottech_geotagging_req["user_id"]]);?></td>
				<td nowrap valign="top">[<?=$indottech_geotagging_req["site_id"];?>] <?=$indottech_geotagging_req["sitename"];?></td>
				<td valign="top"><?=$lat;?> ; <?=$long;?></td>
				<td nowrap valign="top"><?=format_tanggal($indottech_geotagging_req["created_at"]);?></td>
				<td nowrap valign="top"><?=$status;?></td>
			</tr>
		<?php
			}
		?>
		</table>
<?php
	} else if($_GET["mode"] == "showmap"){
			$id = $_GET["id"];
			$data = $db->fetch_all_data("indottech_geotagging_req",[],"id='".$id."'")[0];
			$status = $data["status"];
			if($status == "0") $btn_approve = "Approve";
			else $btn_approve = "View Photo Items";
		?>
			<h2>Geotagging Request</b></h2>
			<b><?="[".$data["site_id"]."] ".$data["sitename"];?> ==> Requested By <?=$db->fetch_single_data("users","name",["id" => $data["user_id"]]);?></b><br><br>
			<input type="button" value="Back" style="width:100%;height:50px;font-size:20px;font-weight:bolder;" onclick="window.location='?token=<?=$token;?>';"><br>
			<?php if($status != "-1"){ ?>
				<input type="button" value="<?=$btn_approve;?>" style="width:100%;height:50px;font-size:20px;font-weight:bolder;" onclick="window.location='geotagging_approving.php?token=<?=$token;?>&id=<?=$id;?>&id=<?=$id;?>&lat=<?=$_GET["lat"];?>&long=<?=$_GET["long"];?>';">
			<?php } ?>
			<?php if($status == "0"){ ?>
				<input type="button" value="Reject" style="width:100%;height:50px;font-size:20px;font-weight:bolder;" onclick="window.location='geotagging_approving.php?token=<?=$token;?>&reject=1&id=<?=$id;?>&lat=<?=$_GET["lat"];?>&long=<?=$_GET["long"];?>';">
			<?php } ?>
			<div id="map"></div>
			<script>
			  function initMap() {
				var uluru = {lat: <?=$_GET["lat"];?>, lng: <?=$_GET["long"];?>};
				var map = new google.maps.Map(document.getElementById('map'), {
				  zoom: 14,
				  center: uluru
				});
				var marker = new google.maps.Marker({
				  position: uluru,
				  map: map
				});
			  }
			</script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHByn7VH9j_uyzwIzM5WMsAJgQ43gdI7Q&callback=initMap">
			</script>
		<?php
	}
?>
	</body>
</html>
