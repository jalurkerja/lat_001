<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$acceptance_certificate = $db->fetch_all_data("indottech_acceptance_certificate",[],"atd_id='".$atd_id."'")[0];
	$bts_sran_8 = $db->fetch_all_data("indottech_bts_sran_8",[],"atd_id='".$atd_id."'")[0];
		
	$arrworkIds = ["1" => "New Sites", "2" => "Swap BTS, Swap antenna", "3" => "Swap BTS, use antenna Existing", "4" => "Outorization 	"];
		$workTypeIds = "";
		foreach(pipetoarray($acceptance_certificate["worktype_ids"]) as $worktype_id){
			$workTypeIds .= $arrworkIds[$worktype_id].", ";
		}
		$workTypeIds = substr($workTypeIds,0,-2);		
	
	if(isset($_POST["save"])){			
		$db->addtable("indottech_bts_sran_8");
		if($bts_sran_8["id"] > 0) 					$db->where("id",$bts_sran_8["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("po_number");					$db->addvalue($acceptance_certificate["po_number"]);
		$db->addfield("site_id");					$db->addvalue($acceptance_certificate["site_id"]);
		$db->addfield("site_name");					$db->addvalue($acceptance_certificate["site_name"]);
		$db->addfield("worktype_ids");				$db->addvalue($acceptance_certificate["worktype_ids"]);
		$db->addfield("approval_at");				$db->addvalue($_POST["approval_at"]);
		$db->addfield("regional_manager_name");		$db->addvalue($_POST["regional_manager_name"]);
		$db->addfield("xl_representative_name");		$db->addvalue($_POST["xl_representative_name"]);
		if($bts_sran_8["id"] > 0) $inserting = $db->update();
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
<center><b>8. ATP APROVAL SHEET</b></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td>
					<table border="1">
						<tr align="left">
							<td>PO Number</td>
							<td><?=$f->input("po_number",$acceptance_certificate["po_number"],"Xrequired","classinput");?></td>
							</tr>
						<tr align="left">
							<td>Site ID</td>
							<td><?=$f->input("site_id",$acceptance_certificate["site_id"],"Xrequired","classinput");?></td>
							</tr>
						<tr align="left">
							<td>Site Name</td>
							<td><?=$f->input("site_name",$acceptance_certificate["site_name"],"Xrequired","classinput");?></td>
							</tr>
						<tr align="left">
							<td>Work type</td>
							<td><?=$f->textarea("worktype_ids",$workTypeIds,"Xrequired","classinput");?></td>
							</tr>
						<tr align="left">
							<td>Approval Date</td>
							<td><?=$f->input("approval_at",$bts_sran_8["approval_at"], "type='date'");?></td>
							</tr>
						<tr align="left">
							<td>Regional Manager Alita</td>
							<td><?=$f->input("regional_manager_name",$bts_sran_8["regional_manager_name"],"Xrequired","classinput");?></td>
							</tr>
						<tr align="left">
							<td>XL Representative</td>
							<td><?=$f->input("xl_representative_name",$bts_sran_8["xl_representative_name"],"Xrequired","classinput");?></td>
							</tr>
					</table>
					</td>
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