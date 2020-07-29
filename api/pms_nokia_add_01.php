<?php 
	include_once "header.php";
	$pms_id = $_GET["pms_id"];
	$pms = $db->fetch_all_data("pms_nokia",[],"id='".$pms_id."'")[0];
	$site_name = $_POST["site_name"];
	
	// if(isset($_POST["check"])){
		// $site_detail = $db->fetch_all_data("indottech_sites",[],"kode = '".$_POST["site_id"]."' AND project_id = '3'")[0];
		// if(isset($site_detail)){
			// $data 		= "Ada";
			// $site_id 	= $site_detail["id"];
			// $site_name 	= $site_detail["name"];
			// $latitude 	= $site_detail["latitude"];
			// $longitude 	= $site_detail["longitude"];
		// } else {
			// $data 	= "TidakAda";
		// }
	// }
	
	// if(isset($_POST["lanjutkan"]) || $pms_id > 0){
		// $data 		= "Ada";
	// }
		$data 		= "Ada";
	
	if(isset($_POST["save"])){
		$date_1 = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-30,date("Y")));
		$date_2 = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")+2,date("Y")));
		
		$cek_site= $db->fetch_all_data("pms_nokia",[],"user_id_creator = '".$__user_id."' AND site_id LIKE '".$_POST["site_id"]."' AND site_name LIKE '".$_POST["site_name"]."' AND project_name LIKE '".$_POST["project_name"]."' AND created_at BETWEEN '".$date_1."' AND '".$date_2."'","created_at DESC")[0];
		if($cek_site["id"] > 0 && !$pms_id){$_errormessage = "<font color='red'>Site ID, Site Name dan Project sudah pernah tercreated. Silahkan Edit data yang sudah ada!</font>";}	
			if($_errormessage == ""){
				$db->addtable("pms_nokia");
				if($pms_id > 0) 								$db->where("id",$pms_id);
				$db->addfield("site_id");						$db->addvalue($_POST["site_id"]);
				$db->addfield("site_name");						$db->addvalue($_POST["site_name"]);
				$db->addfield("project_name");					$db->addvalue($_POST["project_name"]);
				$db->addfield("team_leader");					$db->addvalue($_POST["team_leader"]);
				$db->addfield("sub_con");						$db->addvalue($_POST["sub_con"]);
				$db->addfield("telepon");						$db->addvalue($_POST["telepon"]);
				$db->addfield("email");							$db->addvalue($_POST["email"]);
				$db->addfield("tipe_site");						$db->addvalue($_POST["tipe_site"]);
				$db->addfield("customer");						$db->addvalue($_POST["customer"]);
				$db->addfield("region");						$db->addvalue($_POST["region"]);
				$db->addfield("tanggal_audit");					$db->addvalue($_POST["tanggal_audit"]);
				$db->addfield("tl_installation");				$db->addvalue($_POST["tl_installation"]);
				$db->addfield("wah_sertificate");				$db->addvalue($_POST["wah_sertificate"]);
				$db->addfield("no_telp");						$db->addvalue($_POST["no_telp"]);
				$db->addfield("wpid_nokia");					$db->addvalue($_POST["wpid_nokia"]);
				$db->addfield("user_id_creator");				$db->addvalue($__user_id);
				if($pms_id > 0) $inserting = $db->update();
				else $inserting = $db->insert();
				
				if($inserting["affected_rows"] > 0){
					if($pms_id == "") $pms_id = $inserting["insert_id"];
					javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
					javascript("window.location=\"pms_nokia_add_01.php?token=".$token."&pms_id=".$pms_id."\";");
					exit();
				} else {
					$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
					$data = "Ada";
				}
			}
	}
	
	if(!$pms["site_id"]) 			$pms["site_id"] 		= $_POST["site_id"];
	if(!$pms["site_name"]) 			$pms["site_name"] 		= $site_name;
	if(!$pms["project_name"]) 		$pms["project_name"] 	= $_POST["project_name"];
	if(!$pms["team_leader"]) 		$pms["team_leader"] 	= $_POST["team_leader"];
	if(!$pms["sub_con"]) 			$pms["sub_con"] 		= $_POST["sub_con"];
	if(!$pms["telepon"]) 			$pms["telepon"] 		= $_POST["telepon"];
	if(!$pms["email"]) 				$pms["email"] 			= $_POST["email"];
	if(!$pms["tipe_site"]) 			$pms["tipe_site"] 		= $_POST["tipe_site"];
	if(!$pms["customer"]) 			$pms["customer"] 		= $_POST["customer"];
	if(!$pms["region"]) 			$pms["region"] 			= $_POST["region"];
	if(!$pms["tanggal_audit"]) 		$pms["tanggal_audit"] 	= $_POST["tanggal_audit"];
	if(!$pms["tl_installation"]) 	$pms["tl_installation"] = $_POST["tl_installation"];
	if(!$pms["wah_sertificate"]) 	$pms["wah_sertificate"] = $_POST["wah_sertificate"];
	if(!$pms["no_telp"]) 			$pms["no_telp"] 		= $_POST["no_telp"];
	if(!$pms["wpid_nokia"]) 		$pms["wpid_nokia"] 		= $_POST["wpid_nokia"];
	
	// if($data == "Ada") {
		$btn_save = $f->input("save","Save","type='submit'","btn btn-primary");
		// $style	= "readonly";
	// } else {
		// $btn_check = $f->input("check","Check","type='submit'","btn btn-primary");
	// }
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&pms_id=".$pms_id."\";'","btn btn-success");
?>

<center><h4><b>PMS NOKIA</b></h4></center>
<center><h5><u>Self Inspection Report Checklist</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&pms_id=<?=$pms_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="0">
				<tr>
					<td>Site ID</td>
					<td>
						<?=$f->input("site_id",$pms["site_id"],$style." required","classinput");?> &ensp;
						<?=$btn_check;?>
					</td>
				</tr>
				<?php
					if(@($data == "TidakAda")){
					?>
					<tr>
						<td colspan="2" align="center">
							Site ID <b><?=$pms["site_id"];?></b> belum terdaftar pada database, silahkan Check kembali jika Anda salah input Site ID. Atau Anda ingin melanjutkan dengan tahap Photo Online?<br>
							<?=$f->input("lanjutkan","Lanjutkan","type='submit'","btn btn-danger");?>
						</td>
					</tr>
					<?php	
					}
					
					if(@($data == "Ada")){
					?>
						<tr>
							<td>Site Name</td>
							<td><?=$f->input("site_name",$pms["site_name"],"required","classinput");?></td>
						</tr>
						<tr>
							<td>Nama Project</td>
							<td><?=$f->input("project_name",$pms["project_name"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Team Leader</td>
							<td><?=$f->input("team_leader",$pms["team_leader"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Subcontractor</td>
							<td><?=$f->input("sub_con",$pms["sub_con"],"","classinput");?></td>
						</tr>
						<tr>
							<td>No Telepon</td>
							<td><?=$f->input("telepon",$pms["telepon"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?=$f->input("email",$pms["email"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Tipe Site</td>
							<td><?=$f->input("tipe_site",$pms["tipe_site"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Customer (Operator)</td>
							<td><?=$f->input("customer",$pms["customer"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Region</td>
							<td><?=$f->input("region",$pms["region"],"","classinput");?></td>
						</tr>
						<tr>
							<td>Tanggal Audit</td>
							<td><?=$f->input("tanggal_audit",$pms["tanggal_audit"],"Type='date'","classinput");?></td>
						</tr>
						<tr>
							<td>Nama Team Leader Instalasi</td>
							<td><?=$f->input("tl_installation",$pms["tl_installation"],"","classinput");?></td>
						</tr>
						<tr>
							<td>WAH Sertifikat</td>
							<td><?=$f->input("wah_sertificate",$pms["wah_sertificate"],"","classinput");?></td>
						</tr>
						<tr>
							<td>No Telp</td>
							<td><?=$f->input("no_telp",$pms["no_telp"],"","classinput");?></td>
						</tr>
						<tr>
							<td>WPID Nokia No</td>
							<td><?=$f->input("wpid_nokia",$pms["wpid_nokia"],"","classinput");?></td>
						</tr>
					<?php
				}
				?>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"pms_nokia_list.php?token=".$token."\";'","btn btn-warning");?></td>
			<?php if(!$pms["id"]) { ?>
				<td align="right"><?=$btn_save;?></td>
			<?php } else {?>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"pms_nokia_add_02.php?token=".$token."&pms_id=".$pms_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#site_id").focus(); </script>
<?php include_once "footer.php";?>