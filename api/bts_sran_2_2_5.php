<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_2_5 = $db->fetch_all_data("indottech_bts_sran_2_2_5",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_2_5");
		if($bts_sran_2_2_5["id"] > 0) 					$db->where("id",$bts_sran_2_2_5["id"]);
		$db->addfield("atd_id");						$db->addvalue($atd_id);
		$db->addfield("arfcn_1");						$db->addvalue($_POST["arfcn_1"]);
		$db->addfield("arfcn_2");						$db->addvalue($_POST["arfcn_2"]);
		$db->addfield("arfcn_3");						$db->addvalue($_POST["arfcn_3"]);
		$db->addfield("arfcn_4");						$db->addvalue($_POST["arfcn_4"]);
		$db->addfield("arfcn_5");						$db->addvalue($_POST["arfcn_5"]);
		$db->addfield("arfcn_6");						$db->addvalue($_POST["arfcn_6"]);
		$db->addfield("arfcn_7");						$db->addvalue($_POST["arfcn_7"]);
		$db->addfield("arfcn_8");						$db->addvalue($_POST["arfcn_8"]);
		$db->addfield("arfcn_9");						$db->addvalue($_POST["arfcn_9"]);
		$db->addfield("arfcn_10");						$db->addvalue($_POST["arfcn_10"]);
		$db->addfield("arfcn_11");						$db->addvalue($_POST["arfcn_11"]);
		$db->addfield("arfcn_12");						$db->addvalue($_POST["arfcn_12"]);
		$db->addfield("arfcn_13");						$db->addvalue($_POST["arfcn_13"]);
		$db->addfield("arfcn_14");						$db->addvalue($_POST["arfcn_14"]);
		$db->addfield("arfcn_15");						$db->addvalue($_POST["arfcn_15"]);
		$db->addfield("arfcn_16");						$db->addvalue($_POST["arfcn_16"]);
		$db->addfield("arfcn_17");						$db->addvalue($_POST["arfcn_17"]);
		$db->addfield("arfcn_18");						$db->addvalue($_POST["arfcn_18"]);
		$db->addfield("arfcn_19");						$db->addvalue($_POST["arfcn_19"]);
		$db->addfield("arfcn_20");						$db->addvalue($_POST["arfcn_20"]);
		$db->addfield("arfcn_21");						$db->addvalue($_POST["arfcn_21"]);
		$db->addfield("arfcn_22");						$db->addvalue($_POST["arfcn_22"]);
		$db->addfield("arfcn_23");						$db->addvalue($_POST["arfcn_23"]);
		$db->addfield("arfcn_24");						$db->addvalue($_POST["arfcn_24"]);
		$db->addfield("psc_1");							$db->addvalue($_POST["psc_1"]);
		$db->addfield("psc_2");							$db->addvalue($_POST["psc_2"]);
		$db->addfield("psc_3");							$db->addvalue($_POST["psc_3"]);
		$db->addfield("pci_1");							$db->addvalue($_POST["pci_1"]);
		$db->addfield("pci_2");							$db->addvalue($_POST["pci_2"]);
		$db->addfield("pci_3");							$db->addvalue($_POST["pci_3"]);
		if($bts_sran_2_2_5["id"] > 0) $inserting = $db->update();
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
<center>2.2.5 TRX/Carrier Configuration</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td colspan="4"><b>2G</b></td>
				</tr>
				<tr align="center">
					<td width="50"><b>GSM</b></td>
					<td width="130">
						<?=$f->input("arfcn_1",$bts_sran_2_2_5["arfcn_1"],"placeholder ='ARFCN 1' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_2",$bts_sran_2_2_5["arfcn_2"],"placeholder ='ARFCN 2' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_3",$bts_sran_2_2_5["arfcn_3"],"placeholder ='ARFCN 3' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_4",$bts_sran_2_2_5["arfcn_4"],"placeholder ='ARFCN 4' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_5",$bts_sran_2_2_5["arfcn_5"],"placeholder ='ARFCN 5' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_6",$bts_sran_2_2_5["arfcn_6"],"placeholder ='ARFCN 6' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_7",$bts_sran_2_2_5["arfcn_7"],"placeholder ='ARFCN 7' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_8",$bts_sran_2_2_5["arfcn_8"],"placeholder ='ARFCN 8' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_9",$bts_sran_2_2_5["arfcn_9"],"placeholder ='ARFCN 9' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_10",$bts_sran_2_2_5["arfcn_10"],"placeholder ='ARFCN 10' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_11",$bts_sran_2_2_5["arfcn_11"],"placeholder ='ARFCN 11' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_12",$bts_sran_2_2_5["arfcn_12"],"placeholder ='ARFCN 12' Xrequired","classinput");?>
					</td>
					<td width="50"><b>DCS TRX</b></td>
					<td width="130">
						<?=$f->input("arfcn_13",$bts_sran_2_2_5["arfcn_13"],"placeholder ='ARFCN 13' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_14",$bts_sran_2_2_5["arfcn_14"],"placeholder ='ARFCN 14' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_15",$bts_sran_2_2_5["arfcn_15"],"placeholder ='ARFCN 15' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_16",$bts_sran_2_2_5["arfcn_16"],"placeholder ='ARFCN 16' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_17",$bts_sran_2_2_5["arfcn_17"],"placeholder ='ARFCN 17' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_18",$bts_sran_2_2_5["arfcn_18"],"placeholder ='ARFCN 18' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_19",$bts_sran_2_2_5["arfcn_19"],"placeholder ='ARFCN 19' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_20",$bts_sran_2_2_5["arfcn_20"],"placeholder ='ARFCN 20' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_21",$bts_sran_2_2_5["arfcn_21"],"placeholder ='ARFCN 21' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_22",$bts_sran_2_2_5["arfcn_22"],"placeholder ='ARFCN 22' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_23",$bts_sran_2_2_5["arfcn_23"],"placeholder ='ARFCN 23' Xrequired","classinput");?><br>
						<?=$f->input("arfcn_24",$bts_sran_2_2_5["arfcn_24"],"placeholder ='ARFCN 24' Xrequired","classinput");?>
					</td>
				</tr>
			</table>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td colspan="2"><b>3G</b></td>
					<td colspan="2"><b>LTE</b></td>
				</tr>
				<tr align="center">
					<td><b>CELL No</b></td>
					<td>
						<?=$f->input("psc_1",$bts_sran_2_2_5["psc_1"],"placeholder ='3g cell 1' Xrequired","classinput");?><br>
						<?=$f->input("psc_2",$bts_sran_2_2_5["psc_2"],"placeholder ='3g cell 2' Xrequired","classinput");?><br>
						<?=$f->input("psc_3",$bts_sran_2_2_5["psc_3"],"placeholder ='3g cell 3' Xrequired","classinput");?><br>
					</td>
					<td><b>CELL No</b></td>
					<td>
						<?=$f->input("pci_1",$bts_sran_2_2_5["pci_1"],"placeholder ='lte cell 1' Xrequired","classinput");?><br>
						<?=$f->input("pci_2",$bts_sran_2_2_5["pci_2"],"placeholder ='lte cell 2' Xrequired","classinput");?><br>
						<?=$f->input("pci_3",$bts_sran_2_2_5["pci_3"],"placeholder ='lte cell 3' Xrequired","classinput");?><br>
					</td>
				</tr>
			</table>
			<br>
			<table align="center" border="0">
				<tr><td><b>Note:</b></td></tr>
				<tr><td><b>ARFCN:</b> Absolute Radio Frequency Channel Number</td></tr>
				<tr><td><b>PSC:</b> Primary scrambling code</td></tr>
				<tr><td><b>PCI:</b> Physical Cell ID</td></tr>
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