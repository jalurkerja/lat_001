<?php
	include_once "header.php";
	include_once "user_info.php";
?>
<style>
	body{
		font-size:10px;
	}
	
	table {
	  border-collapse: collapse;
	  border-spacing: 0;
	  width: 100%;
	  border: 1px solid #ddd;
	}

	th, td {
	  text-align: center;
	  padding: 8px;
	  font-size:12px;
	  /*border: 1px solid black;*/
	  /*white-space: nowrap;*/
	}

	tr:nth-child(even){background-color: #f2f2f2}
	
	.nokia tr:nth-child(even){background-color: #ccddff}
	.h3i tr:nth-child(even){background-color: #ffcccc}
	.indosat tr:nth-child(even){background-color: #fff5cc}
	.xl tr:nth-child(even){background-color: #d9ffcc}
	
	.clearfix {
	  overflow: auto;
	}
	
	.head{
		background-color:#007bff;
		width:100%;
		height:30px;
		color:white;
		font-weight:bolder;
		font-size:12px;
	}
	
	.title {
			font-size: 12px;
		font-weight:bolder;
		font-family:Comic Sans MS;
		padding:0 0 5 0;
	}
</style>
<?php
	$arsip[] = ["../icons/fsfl.png", "fsfl_pick_site", "Dok FSFL"];
	$arsip[] = ["../icons/my_geo.png", "geotagging_mine", "My Geotagging"];
	$arsip[] = ["../icons/req_geo.png", "ReqGeotagging", "Request Geotagging"];
	
	$width = " style='width:25%;'";
?>

<div class="title">
	<!--
		<a href="?&token=<?=$_GET["token"];?>btnMode=mainmenu"><img src="../icons/back.png" style="width:10px; height:10px;"> &ensp;Arsip</a>
	-->
	Arsip
</div>
<div style="overflow-x:auto;">
  <table>
	<tr>
		<?php
			foreach($arsip as $_arsip){
				$onclick = "onclick=\"window.location='?token=".$_GET["token"]."&btnMode=".$_arsip[1]."';\"";
				// $onclick = "onclick=\"window.location='".$_arsip[1].".php?token=".$_GET["token"]."&btnMode".$_arsip[1]."';\"";
				echo "<td ".$width." ".$onclick."><img src='".$_arsip[0]."' style='width:50px; height:50px;'></td>";
			}
			// for($i=count($arsip); $i<=3; $i++){
				// echo "<td ".$width."><img src='../icons/blank.png' style='width:50px; height:50px;'></td>";
			// }
		?>
	</tr>
	<tr>
		<?php
			foreach($arsip as $_arsip){
				$onclick = "onclick=\"window.location='?token=".$_GET["token"]."&btnMode=".$_arsip[1]."';\"";
				echo "<td align='center' ".$onclick.">".$_arsip[2]."</td>";
			}
			// for($i=count($arsip); $i<=3; $i++){
				// echo "<td> </td>";
			// }
		?>
	</tr>
  </table>
</div>		
<div class="clearfix">&nbsp;</div>

<?php include_once "footer.php";?>