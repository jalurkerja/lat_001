<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_01",[],"id='".$tssr_id."'")[0];
	
	if(isset($_POST["check"])){
		$site_detail = $db->fetch_all_data("indottech_sites",[],"kode = '".$_POST["site_id"]."' AND project_id = '3'")[0];
		if(isset($site_detail)){
			$data 		= "Ada";
			$site_id 	= $site_detail["id"];
			$site_name 	= $site_detail["name"];
			$latitude 	= $site_detail["latitude"];
			$longitude 	= $site_detail["longitude"];
		} else {
			$data 	= "TidakAda";
		}
	}
	if(isset($_POST["lanjutkan"]) || $tssr_id > 0){
		$data 		= "Ada";
	}
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_01");
		if($tssr_id > 0) 									$db->where("id",$tssr_id);
		$db->addfield("site_id");							$db->addvalue($_POST["site_id"]);
		$db->addfield("site_name");							$db->addvalue($_POST["site_name"]);
		$db->addfield("candidate");							$db->addvalue($_POST["candidate"]);
		$db->addfield("city_prov");							$db->addvalue($_POST["city_prov"]);
		$db->addfield("cust_po");							$db->addvalue($_POST["cust_po"]);
		$db->addfield("latitude");							$db->addvalue($_POST["latitude"]);
		$db->addfield("longitude");							$db->addvalue($_POST["longitude"]);
		$db->addfield("antenna_height");					$db->addvalue($_POST["antenna_height"]);
		$db->addfield("user_id_creator");					$db->addvalue($__user_id);
		if($tssr_id > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			if($tssr_id == "") $tssr_id = $inserting["insert_id"];
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_01.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if(!$tssr["site_id"]) 	$tssr["site_id"] 	= $_POST["site_id"];
	if(!$tssr["site_name"]) $tssr["site_name"] 	= $site_name;
	if(!$tssr["latitude"]) 	$tssr["latitude"] 	= $latitude;
	if(!$tssr["longitude"]) $tssr["longitude"] 	= $longitude;
	
	if($data == "Ada") {
		$btn_save = $f->input("save","Save","type='submit'","btn btn-primary");
		$style	= "readonly";
	} else {
		$btn_check = $f->input("check","Check","type='submit'","btn btn-primary");
	}
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>Information of Candidates</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="0">
				<tr>
					<td>Site ID</td>
					<td>
						<?=$f->input("site_id",$tssr["site_id"],$style,"classinput");?> &ensp;
						<?=$btn_check;?>
					</td>
				</tr>
				<?php
					if(@($data == "TidakAda")){
					?>
					<tr>
						<td colspan="2" align="center">
							Site ID <b><?=$tssr["site_id"];?></b> belum terdaftar pada database, silahkan Check kembali jika Anda salah input Site ID. Atau Anda ingin melanjutkan dengan tahap Photo Online?<br>
							<?=$f->input("lanjutkan","Lanjutkan","type='submit'","btn btn-danger");?>
						</td>
					</tr>
					<?php	
					}
					
					if(@($data == "Ada")){
				?>
					<tr>
						<td>Site Name</td>
						<td><?=$f->input("site_name",$tssr["site_name"],"","classinput");?></td>
					</tr>
					<tr>
						<td>Candidate</td>
						<td><?=$f->input("candidate",$tssr["candidate"],"","classinput");?></td>
					</tr>
					<tr>
						<td>City/Provice</td>
						<td><?=$f->input("city_prov",$tssr["city_prov"],"","classinput");?></td>
					</tr>
					<tr>
						<td>Customer PO</td>
						<td><?=$f->input("cust_po",$tssr["cust_po"],"","classinput");?></td>
					</tr>
					<tr>
						<td>Latitude</td>
						<td><?=$f->input("latitude",$tssr["latitude"],"","classinput");?></td>
					</tr>
					<tr>
						<td>Longitude</td>
						<td><?=$f->input("longitude",$tssr["longitude"],"","classinput");?></td>
					</tr>
					<tr>
						<td>Antenna Height</td>
						<td><?=$f->input("antenna_height",$tssr["antenna_height"],"","classinput");?></td>
					</tr>
				<?php
				}
				?>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_sites.php?token=".$token."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$btn_save;?></td>
			<?php } else {?>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_02.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#site_id").focus(); </script>
<?php include_once "footer.php";?>