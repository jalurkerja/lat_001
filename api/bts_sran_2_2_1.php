<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_2_1 = $db->fetch_all_data("indottech_bts_sran_2_2_1",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_2_1");
		if($bts_sran_2_2_1["id"] > 0) 					$db->where("id",$bts_sran_2_2_1["id"]);
		$db->addfield("atd_id");						$db->addvalue($atd_id);
		$db->addfield("v1");							$db->addvalue($_POST["v1"]);
		$db->addfield("v2");							$db->addvalue($_POST["v2"]);
		$db->addfield("v3");							$db->addvalue($_POST["v3"]);
		$db->addfield("v4");							$db->addvalue($_POST["v4"]);
		$db->addfield("v5");							$db->addvalue($_POST["v5"]);
		$db->addfield("v6");							$db->addvalue($_POST["v6"]);
		$db->addfield("v7");							$db->addvalue($_POST["v7"]);
		$db->addfield("v8");							$db->addvalue($_POST["v8"]);
		$db->addfield("v9");							$db->addvalue($_POST["v9"]);
		$db->addfield("v10");							$db->addvalue($_POST["v10"]);
		$db->addfield("v11");							$db->addvalue($_POST["v11"]);
		$db->addfield("v12");							$db->addvalue($_POST["v12"]);
		$db->addfield("v13");							$db->addvalue($_POST["v13"]);
		if($bts_sran_2_2_1["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
?>
<center><h5><b>2.2 Commissioning Record</b></h5></center>
<center>2.2.1 Transmission Information</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>No</b></td>
					<td><b>TRS Information</b></td>
					<td><b>VALUE</b></td>
				</tr>
				<tr>
					<td>1</td>
					<td>Gateway UPlane</td>
					<td><?=$f->input("v1",$bts_sran_2_2_1["v1"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>2</td>
					<td>Gateway CPlane</td>
					<td><?=$f->input("v2",$bts_sran_2_2_1["v2"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>3</td>
					<td>Gateway MPlane</td>
					<td><?=$f->input("v3",$bts_sran_2_2_1["v3"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>4</td>
					<td>Gateway SPlane</td>
					<td><?=$f->input("v4",$bts_sran_2_2_1["v4"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>5</td>
					<td>OMUSIG IP Address</td>
					<td><?=$f->input("v5",$bts_sran_2_2_1["v5"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>6</td>
					<td>Ethernet Interface (port IDU)</td>
					<td><?=$f->input("v6",$bts_sran_2_2_1["v6"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>7</td>
					<td>User plane IP</td>
					<td><?=$f->input("v7",$bts_sran_2_2_1["v7"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>8</td>
					<td>Control Plane IP</td>
					<td><?=$f->input("v8",$bts_sran_2_2_1["v8"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>9</td>
					<td>Management Plane IP</td>
					<td><?=$f->input("v9",$bts_sran_2_2_1["v9"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>10</td>
					<td>Synchronization Plane IP</td>
					<td><?=$f->input("v10",$bts_sran_2_2_1["v10"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>11</td>
					<td>Neighbour Node Discovery</td>
					<td><?=$f->input("v11",$bts_sran_2_2_1["v11"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>12</td>
					<td>NTP IP</td>
					<td><?=$f->input("v12",$bts_sran_2_2_1["v12"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>13</td>
					<td>Timing Over Packet IP</td>
					<td><?=$f->input("v13",$bts_sran_2_2_1["v13"],"Xrequired","classinput");?></td>
				</tr>
			</table>
			<br>
			<table width="100%">
				<tr>
					<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
					<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>