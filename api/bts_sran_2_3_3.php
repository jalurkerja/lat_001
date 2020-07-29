<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_3_3 = $db->fetch_all_data("indottech_bts_sran_2_3_3",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_3_3");
		if($bts_sran_2_3_3["id"] > 0) 				$db->where("id",$bts_sran_2_3_3["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("cell_id_no_1");				$db->addvalue($_POST["cell_id_no_1"]);
		$db->addfield("cell_id_no_2");				$db->addvalue($_POST["cell_id_no_2"]);
		$db->addfield("cell_id_no_3");				$db->addvalue($_POST["cell_id_no_3"]);
		$db->addfield("network_attached_1");		$db->addvalue($_POST["network_attached_1"]);
		$db->addfield("network_attached_2");		$db->addvalue($_POST["network_attached_2"]);
		$db->addfield("network_attached_3");		$db->addvalue($_POST["network_attached_3"]);
		$db->addfield("network_detached_1");		$db->addvalue($_POST["network_detached_1"]);
		$db->addfield("network_detached_2");		$db->addvalue($_POST["network_detached_2"]);
		$db->addfield("network_detached_3");		$db->addvalue($_POST["network_detached_3"]);
		$db->addfield("dl_1");						$db->addvalue($_POST["dl_1"]);
		$db->addfield("dl_2");						$db->addvalue($_POST["dl_2"]);
		$db->addfield("dl_3");						$db->addvalue($_POST["dl_3"]);
		$db->addfield("ul_1");						$db->addvalue($_POST["ul_1"]);
		$db->addfield("ul_2");						$db->addvalue($_POST["ul_2"]);
		$db->addfield("ul_3");						$db->addvalue($_POST["ul_3"]);
		if($bts_sran_2_3_3["id"] > 0) $inserting = $db->update();
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
<center>2.3.3 LTE Test Call</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>Description</b></td>
					<td><b>Cell Number</b></td>
				</tr>
				<tr align="left">
					<td>Cell ID Number</td>
					<td>
						<?=$f->input("cell_id_no_1",$bts_sran_2_3_3["cell_id_no_1"],"Xrequired","classinput");?><br>
						<?=$f->input("cell_id_no_2",$bts_sran_2_3_3["cell_id_no_2"],"Xrequired","classinput");?><br>
						<?=$f->input("cell_id_no_3",$bts_sran_2_3_3["cell_id_no_3"],"Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="left">
					<td>Network Attached</td>
					<td>
						<?=$f->input("network_attached_1",$bts_sran_2_3_3["network_attached_1"],"Xrequired","classinput");?><br>
						<?=$f->input("network_attached_2",$bts_sran_2_3_3["network_attached_2"],"Xrequired","classinput");?><br>
						<?=$f->input("network_attached_3",$bts_sran_2_3_3["network_attached_3"],"Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="left">
					<td>Network Detach</td>
					<td>
						<?=$f->input("network_detached_1",$bts_sran_2_3_3["network_detached_1"],"Xrequired","classinput");?><br>
						<?=$f->input("network_detached_2",$bts_sran_2_3_3["network_detached_2"],"Xrequired","classinput");?><br>
						<?=$f->input("network_detached_3",$bts_sran_2_3_3["network_detached_3"],"Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="left">
					<td>DL Throughput [Mbps]</td>
					<td>
						<?=$f->input("dl_1",$bts_sran_2_3_3["dl_1"],"Xrequired","classinput");?><br>
						<?=$f->input("dl_2",$bts_sran_2_3_3["dl_2"],"Xrequired","classinput");?><br>
						<?=$f->input("dl_3",$bts_sran_2_3_3["dl_3"],"Xrequired","classinput");?>
					</td>
				</tr>
				<tr align="left">
					<td>UL Throughput [Mbps]</td>
					<td>
						<?=$f->input("ul_1",$bts_sran_2_3_3["ul_1"],"Xrequired","classinput");?><br>
						<?=$f->input("ul_2",$bts_sran_2_3_3["ul_2"],"Xrequired","classinput");?><br>
						<?=$f->input("ul_3",$bts_sran_2_3_3["ul_3"],"Xrequired","classinput");?>
					</td>
				</tr>
			</table>
			<br>
			<table align="center" border="0">
				<tr>
					<td>Note : Detail other functionality test is part of SSV<br> and SSA document</td>
				</tr>
			</table>
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