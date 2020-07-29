<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_2_2 = $db->fetch_all_data("indottech_bts_sran_2_2_2",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_2_2");
		if($bts_sran_2_2_2["id"] > 0) 		$db->where("id",$bts_sran_2_2_2["id"]);
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
		$db->addfield("v14");							$db->addvalue($_POST["v14"]);
		$db->addfield("v15");							$db->addvalue($_POST["v15"]);
		$db->addfield("v16");							$db->addvalue($_POST["v16"]);
		if($bts_sran_2_2_2["id"] > 0) $inserting = $db->update();
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
<center>2.2.2 BTS Information</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>No</b></td>
					<td><b>BTS Information</b></td>
					<td><b>VALUE</b></td>
				</tr>
				<tr>
					<td>1</td>
					<td>Tower ID</td>
					<td><?=$f->input("v1",$bts_sran_2_2_2["v1"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>2</td>
					<td>BTS Name</td>
					<td><?=$f->input("v2",$bts_sran_2_2_2["v2"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>3</td>
					<td>BTS Profile</td>
					<td><?=$f->input("v3",$bts_sran_2_2_2["v3"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>4</td>
					<td>SBTS ID</td>
					<td><?=$f->input("v4",$bts_sran_2_2_2["v4"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>5</td>
					<td>Site ID G900</td>
					<td><?=$f->input("v5",$bts_sran_2_2_2["v5"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>6</td>
					<td>Site ID G1800</td>
					<td><?=$f->input("v6",$bts_sran_2_2_2["v6"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>7</td>
					<td>Site ID 3G1800</td>
					<td><?=$f->input("v7",$bts_sran_2_2_2["v7"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>8</td>
					<td>Site ID 3G2100</td>
					<td><?=$f->input("v8",$bts_sran_2_2_2["v8"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>9</td>
					<td>Site ID LTE1800</td>
					<td><?=$f->input("v9",$bts_sran_2_2_2["v9"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>10</td>
					<td>SW Load</td>
					<td><?=$f->input("v10",$bts_sran_2_2_2["v10"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>11</td>
					<td>BSC Name</td>
					<td><?=$f->input("v11",$bts_sran_2_2_2["v11"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>12</td>
					<td>BSC ID</td>
					<td><?=$f->input("v12",$bts_sran_2_2_2["v12"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>13</td>
					<td>RNC Name</td>
					<td><?=$f->input("v13",$bts_sran_2_2_2["v13"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>14</td>
					<td>RNC ID</td>
					<td><?=$f->input("v14",$bts_sran_2_2_2["v14"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>15</td>
					<td>MME Name</td>
					<td><?=$f->input("v15",$bts_sran_2_2_2["v15"],"Xrequired","classinput");?></td>
				</tr>
				<tr>
					<td>16</td>
					<td>MME ID</td>
					<td><?=$f->input("v16",$bts_sran_2_2_2["v16"],"Xrequired","classinput");?></td>
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