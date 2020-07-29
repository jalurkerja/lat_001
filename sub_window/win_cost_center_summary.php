<?php
	include_once "win_head.php";
	$cc_name = $db->fetch_single_data("cost_centers","concat('[',code,'] ',name)",["id" => $_GET["cc_id"]]);
	
	$whereclause = "cost_center_id = '".$_GET["cc_id"]."' AND attendance_status = 3 AND created_at BETWEEN '".$_GET["from"]."' AND '".date("Y-m-d 23:59:59",strtotime($_GET["end"]))."' order by created_at ASC AND ";
	$db->addtable("attendance_activity");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
	$_data = $db->fetch_data(true);
?>

<?php
	if($_data){
?>
	<h3><b><?=$cc_name;?></b></h3>
	<br><br>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No","Date","Team","Description"));?>
	<?php 
		foreach($_data as $no => $data){
		?>
			<tr>
				<td align="center"><?=$no+1;?></td>
				<td><?=format_tanggal($data["created_at"],"d-M-Y");?></td>
				<td><?=$db->fetch_single_data("users","name",["id" => $data["user_id"]]);?></td>
				<td><?=$data["description"];?></td>
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