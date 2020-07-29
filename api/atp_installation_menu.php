<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"]; 
	$project_name = $db->fetch_single_data("indottech_atd_cover","project_name",["id" => $atd_id]);
	$site_name = $db->fetch_single_data("indottech_atd_cover","site_name",["id" => $atd_id]);
	$is_rectifier = $db->fetch_single_data("indottech_atd_cover","id",["id" => $atd_id,"worktype_ids" => "%|3|%:LIKE"]);
	if(!$is_rectifier) $is_rectifier = $db->fetch_single_data("indottech_atd_cover","id",["id" => $atd_id,"doctype" => "rectifier"]);
	$is_btssran = $db->fetch_single_data("indottech_atd_cover","id",["id" => $atd_id,"doctype" => "bts_sran"]);
?>
<center><h4><b>ACCEPTANCE TEST DOCUMENT</b></h4></center>
<table>
	<tr><td>PROJECT NAME</td><td>:</td><td><?=$project_name;?></td></tr>
	<tr><td>SITE</td><td>:</td><td><?=$site_name;?></td></tr>
</table>
<?php if($is_btssran){ ?>
<button class="big_button" onclick="window.location='atp_acceptance_certificate.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Site Acceptance Certificate</button>
<button class="big_button" onclick="window.location='bts_sran_1_1_1.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">1.1.1. Antenna Configuration</button>
<button class="big_button" onclick="window.location='bts_sran_1_1_2.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">1.1.2. Antenna Line Configuration</button>
<button class="big_button" onclick="window.location='bts_sran_1_1_3.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">1.1.3. Antenna lines VSWR value</button>
<button class="big_button" onclick="window.location='bts_sran_1_1_4.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">1.1.4. Supply Voltages information</button>
<button class="big_button" onclick="window.location='bts_sran_2_1_1.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.1.1. BTS Information</button>
<button class="big_button" onclick="window.location='bts_sran_2_1_2.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.1.2. Antenna Line Information</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_1.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.1. Transmission Information</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_2.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.2. BTS Information</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_2_1.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.2.1. Transmission Link Information</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_3.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.3. Remote Access Test</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_4.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.4. External Alarm test</button>
<button class="big_button" onclick="window.location='bts_sran_2_2_5.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.2.5. TRX/Carrier Configuration</button>
<button class="big_button" onclick="window.location='bts_sran_2_3_1.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.3.1. 2G Test Call</button>
<button class="big_button" onclick="window.location='bts_sran_2_3_2.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.3.2. 3G Test Call</button>
<button class="big_button" onclick="window.location='bts_sran_2_3_3.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">2.3.3. LTE Test Call</button>
<button class="big_button" onclick="window.location='bts_sran_7.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">7. Remark</button>
<button class="big_button" onclick="window.location='bts_sran_8.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">8. ATP Approval Sheet</button>
<button class="big_button" onclick="window.location='bts_sran_9.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">9. Document History</button>
<?php } ?>
<?php if($is_rectifier){ ?>
<button class="big_button" onclick="window.location='atp_installation_ba.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Berita Acara Uji Terima</button>
<button class="big_button" onclick="window.location='atp_installation_rps.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Acceptance Test Rectifier</button>
<button class="big_button" onclick="window.location='atp_installation_breaker.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Breaker</button>
<button class="big_button" onclick="window.location='atp_installation_batteries.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Batteries</button>
<?php } ?>
<button class="big_button" onclick="window.location='atp_installation_photos.php?token=<?=$token;?>&atd_id=<?=$atd_id;?>';">Photos</button>
<br><br>
<button class="big_button" onclick="window.location='atp_installation.php?token=<?=$token;?>';">BACK</button>
<?php include_once "footer.php";?>