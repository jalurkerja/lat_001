<?php
	include_once "win_head.php";

	// $whereclause = "user_id = '".$_GET["user_id"]."' AND (created_at LIKE '%".$_GET["date"]."%' OR leave_start LIKE '%".$_GET["date"]."%') AND ";
	$whereclause = "user_id = '".$_GET["user_id"]."' AND created_at LIKE '%".$_GET["date"]."%' AND ";
	
	$db->addtable("attendance_activity");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
	$_data = $db->fetch_data(true);
	$_title = "Activity on ".format_tanggal($_GET["date"],"d-M-Y");
?>

<?php
	if($_data){
?>
	<h3><b><?=$_title;?></b></h3>
	<br><br>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No","Project","Actual SOW","Actual Site","Description","Foto"));?>
	<?php 
		foreach($_data as $no => $data){
		$cost_center_name = $db->fetch_single_data("cost_centers","name",["code" => $data["cost_center_id"]]);
		$filename = "activityphoto_".$data["user_id"]."_".$data["indottech_plan_id"]."_".$data["plan_site_id"].".jpg"; 
		?>
			<tr>
				<td align="center"><?=$no+1;?></td>
				<td>
				<?php
					foreach(pipetoarray($data["cost_center_id"]) as $_num => $cc_id){
						$cc_name = $db->fetch_single_data("cost_centers","concat('[',code,'] ',name)",["id" => $cc_id]);
						echo $cc_name."<br>";
					}
				?>
				</td>
				<td>
					<?php
					foreach(pipetoarray($data["sow_ids"]) as $num => $sow_id){
						$sow_name = $db->fetch_single_data("indottech_sow","name",["id" => $sow_id]);
						echo ($num+1).". ".$sow_name."<br>";
					}
					?>
				</td>
				<td><?=$data["site_name"];?></td>
				<td><?=$data["description"];?></td>
				<td width="150">
					<?php
						if(file_exists("../geophoto/".$filename)){
							echo "<img src='../geophoto/".$filename."' width='150' height='150' onclick='window.open(\"../geophoto/".$filename."\");'>";
						}
					?>
				</td>
			</tr>
			<tr>
				<td colspan="6"><hr style='border: 0.5px solid #000;'></td>
			</tr>
		<?php
		} 
	?>
	<?=$t->end();?>
<?php
	} else {
		echo "<center><h3><b>Activity Not Found!</h3></b></center>";
	}
?>