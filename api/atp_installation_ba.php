<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$ba = $db->fetch_all_data("indottech_ba_ujiterima",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		$site_name = $db->fetch_single_data("indottech_sites","concat(name,' [',site_code,']')",["id" => $_POST["site_id"]]);
		$db->addtable("indottech_ba_ujiterima");
		if($ba["id"] > 0) 				$db->where("id",$ba["id"]);
		$db->addfield("atd_id");		$db->addvalue($atd_id);
		$db->addfield("ba_at");			$db->addvalue($_POST["ba_at"]);
		$db->addfield("vendor");		$db->addvalue($_POST["vendor"]);
		$db->addfield("site_id");		$db->addvalue($_POST["site_id"]);
		$db->addfield("site_name");		$db->addvalue($site_name);
		$db->addfield("site_address");	$db->addvalue($_POST["site_address"]);
		$db->addfield("area");			$db->addvalue($_POST["area"]);
		$db->addfield("nbw_no");		$db->addvalue($_POST["nbw_no"]);
		$db->addfield("pono");			$db->addvalue($_POST["pono"]);
		$db->addfield("resv_no");		$db->addvalue($_POST["resv_no"]);
		
		if($ba["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if($ba["ba_at"] == "") $ba["ba_at"] = substr($__now,0,10);
	if($ba["vendor"] == "") $ba["vendor"] = $db->fetch_single_data("indottech_atd_cover","vendor",["id" => $atd_id]);
	if($ba["site_id"] == "") $ba["site_id"] = $db->fetch_single_data("indottech_atd_cover","site_id",["id" => $atd_id]);
	if($ba["site_address"] == "") $ba["site_address"] = $db->fetch_single_data("indottech_sites","address",["id" => $ba["site_id"]]);
	if($ba["area"] == "") $ba["area"] = $db->fetch_single_data("indottech_sites","area",["id" => $ba["site_id"]]);
	$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => "13"],["name"],"",true);
?>
<center><h4><b>BERITA ACARA UJI TERIMA</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<table>
		<tr><td>Tanggal Berita Acara</td><td>:</td><td><?=$f->input("ba_at",$ba["ba_at"],"type='date'");?></td></tr>
		<tr><td>Vendor</td><td>:</td><td><?=$f->input("vendor",$ba["vendor"],"required","classinput");?></td></tr>
		<tr><td>Site</td><td>:</td><td><?=$f->select("site_id",$sites,$ba["site_id"],"required","classinput");?></td></tr>
		<tr><td valign="top">Site Address</td><td valign="top">:</td><td valign="top"><?=$f->textarea("site_address",$ba["site_address"],"required","classinput");?></td></tr>
		<tr><td>Area</td><td>:</td><td><?=$f->input("area",$ba["area"],"required","classinput");?></td></tr>
		<tr><td>NBWO/EWO Number</td><td>:</td><td><?=$f->input("nbw_no",$ba["nbw_no"],"","classinput");?></td></tr>
		<tr><td>PO Number</td><td>:</td><td><?=$f->input("pono",$ba["pono"],"","classinput");?></td></tr>
		<tr><td valign="top">Reservation Number<br>(If Any)</td><td valign="top">:</td><td valign="top"><?=$f->input("resv_no",$ba["resv_no"],"","classinput");?></td></tr>
	</table>
	<br>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
		<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>