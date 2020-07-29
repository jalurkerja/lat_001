<?php 
	include_once "header.php";
	$pms_id = $_GET["pms_id"];
	$pms = $db->fetch_all_data("pms_nokia_ceklist",[],"pms_id='".$pms_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("pms_nokia_ceklist");
		if($pms["id"] > 0) 								$db->where("id",$pms["id"]);
		$db->addfield("pms_id");						$db->addvalue($pms_id);
		$db->addfield("hard_rak_1");					$db->addvalue($_POST["hard_rak_1"]);
		$db->addfield("hard_rak_2");					$db->addvalue($_POST["hard_rak_2"]);
		$db->addfield("hard_rak_3");					$db->addvalue($_POST["hard_rak_3"]);
		$db->addfield("hard_rak_4");					$db->addvalue($_POST["hard_rak_4"]);
		$db->addfield("hard_rak_5");					$db->addvalue($_POST["hard_rak_5"]);
		$db->addfield("base_1");						$db->addvalue($_POST["base_1"]);
		$db->addfield("base_2");						$db->addvalue($_POST["base_2"]);
		$db->addfield("base_3");						$db->addvalue($_POST["base_3"]);
		$db->addfield("base_4");						$db->addvalue($_POST["base_4"]);
		$db->addfield("base_5");						$db->addvalue($_POST["base_5"]);
		$db->addfield("base_6");						$db->addvalue($_POST["base_6"]);
		$db->addfield("base_7");						$db->addvalue($_POST["base_7"]);
		$db->addfield("base_8");						$db->addvalue($_POST["base_8"]);
		$db->addfield("hard_power_1");					$db->addvalue($_POST["hard_power_1"]);
		$db->addfield("hard_power_2");					$db->addvalue($_POST["hard_power_2"]);
		$db->addfield("hard_power_3");					$db->addvalue($_POST["hard_power_3"]);
		$db->addfield("hard_power_4");					$db->addvalue($_POST["hard_power_4"]);
		$db->addfield("hard_power_5");					$db->addvalue($_POST["hard_power_5"]);
		$db->addfield("hard_power_6");					$db->addvalue($_POST["hard_power_6"]);
		$db->addfield("hard_power_7");					$db->addvalue($_POST["hard_power_7"]);
		$db->addfield("hard_sinyal_1");					$db->addvalue($_POST["hard_sinyal_1"]);
		$db->addfield("hard_sinyal_2");					$db->addvalue($_POST["hard_sinyal_2"]);
		$db->addfield("hard_sinyal_3");					$db->addvalue($_POST["hard_sinyal_3"]);
		$db->addfield("hard_sinyal_4");					$db->addvalue($_POST["hard_sinyal_4"]);
		$db->addfield("hard_sinyal_5");					$db->addvalue($_POST["hard_sinyal_5"]);
		$db->addfield("hard_sinyal_6");					$db->addvalue($_POST["hard_sinyal_6"]);
		$db->addfield("hard_sinyal_7");					$db->addvalue($_POST["hard_sinyal_7"]);
		$db->addfield("hard_sinyal_8");					$db->addvalue($_POST["hard_sinyal_8"]);
		$db->addfield("label_1");						$db->addvalue($_POST["label_1"]);
		$db->addfield("alarm_1");						$db->addvalue($_POST["alarm_1"]);
		$db->addfield("alarm_2");						$db->addvalue($_POST["alarm_2"]);
		$db->addfield("kebersihan_1");					$db->addvalue($_POST["kebersihan_1"]);
		if($pms["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"pms_nokia_add_02.php?token=".$token."&pms_id=".$pms_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if(!$pms["hard_rak_1"])	    $hard_rak_1[$_POST["hard_rak_1"]] = "checked"; 		else $hard_rak_1[$pms["hard_rak_1"]]= "checked"; 	    
	if(!$pms["hard_rak_2"])	    $hard_rak_2[$_POST["hard_rak_2"]] = "checked"; 		else $hard_rak_2[$pms["hard_rak_2"]]= "checked"; 	    
	if(!$pms["hard_rak_3"])	    $hard_rak_3[$_POST["hard_rak_3"]] = "checked"; 		else $hard_rak_3[$pms["hard_rak_3"]]= "checked"; 	    
	if(!$pms["hard_rak_4"])	    $hard_rak_4[$_POST["hard_rak_4"]] = "checked"; 		else $hard_rak_4[$pms["hard_rak_4"]]= "checked"; 	    
	if(!$pms["hard_rak_5"])	    $hard_rak_5[$_POST["hard_rak_5"]] = "checked"; 		else $hard_rak_5[$pms["hard_rak_5"]]= "checked"; 	    
	if(!$pms["base_1"])		    $base_1[$_POST["base_1"]] = "checked"; 				else $base_1[$pms["base_1"]]= "checked"; 		    
	if(!$pms["base_2"])		    $base_2[$_POST["base_2"]] = "checked"; 				else $base_2[$pms["base_2"]]= "checked"; 		    
	if(!$pms["base_3"])		    $base_3[$_POST["base_3"]] = "checked"; 				else $base_3[$pms["base_3"]]= "checked"; 		    
	if(!$pms["base_4"])		    $base_4[$_POST["base_4"]] = "checked"; 				else $base_4[$pms["base_4"]]= "checked"; 		    
	if(!$pms["base_5"])		    $base_5[$_POST["base_5"]] = "checked"; 				else $base_5[$pms["base_5"]]= "checked"; 		    
	if(!$pms["base_6"])		    $base_6[$_POST["base_6"]] = "checked"; 				else $base_6[$pms["base_6"]]= "checked"; 		    
	if(!$pms["base_7"])		    $base_7[$_POST["base_7"]] = "checked"; 				else $base_7[$pms["base_7"]]= "checked"; 		    
	if(!$pms["base_8"])		    $base_8[$_POST["base_8"]] = "checked"; 				else $base_8[$pms["base_8"]]= "checked"; 		    
	if(!$pms["hard_power_1"])	$hard_power_1[$_POST["hard_power_1"]] = "checked"; 	else $hard_power_1[$pms["hard_power_1"]]= "checked"; 	
	if(!$pms["hard_power_2"])	$hard_power_2[$_POST["hard_power_2"]] = "checked"; 	else $hard_power_2[$pms["hard_power_2"]]= "checked"; 	
	if(!$pms["hard_power_3"])	$hard_power_3[$_POST["hard_power_3"]] = "checked"; 	else $hard_power_3[$pms["hard_power_3"]]= "checked"; 	
	if(!$pms["hard_power_4"])	$hard_power_4[$_POST["hard_power_4"]] = "checked"; 	else $hard_power_4[$pms["hard_power_4"]]= "checked"; 	
	if(!$pms["hard_power_5"])	$hard_power_5[$_POST["hard_power_5"]] = "checked"; 	else $hard_power_5[$pms["hard_power_5"]]= "checked"; 	
	if(!$pms["hard_power_6"])	$hard_power_6[$_POST["hard_power_6"]] = "checked"; 	else $hard_power_6[$pms["hard_power_6"]]= "checked"; 	
	if(!$pms["hard_power_7"])	$hard_power_7[$_POST["hard_power_7"]] = "checked"; 	else $hard_power_7[$pms["hard_power_7"]]= "checked"; 	
	if(!$pms["hard_sinyal_1"])	$hard_sinyal_1[$_POST["hard_sinyal_1"]] = "checked"; else $hard_sinyal_1[$pms["hard_sinyal_1"]]= "checked"; 	
	if(!$pms["hard_sinyal_2"])	$hard_sinyal_2[$_POST["hard_sinyal_2"]] = "checked"; else $hard_sinyal_2[$pms["hard_sinyal_2"]]= "checked"; 	
	if(!$pms["hard_sinyal_3"])	$hard_sinyal_3[$_POST["hard_sinyal_3"]] = "checked"; else $hard_sinyal_3[$pms["hard_sinyal_3"]]= "checked"; 	
	if(!$pms["hard_sinyal_4"])	$hard_sinyal_4[$_POST["hard_sinyal_4"]] = "checked"; else $hard_sinyal_4[$pms["hard_sinyal_4"]]= "checked"; 	
	if(!$pms["hard_sinyal_5"])	$hard_sinyal_5[$_POST["hard_sinyal_5"]] = "checked"; else $hard_sinyal_5[$pms["hard_sinyal_5"]]= "checked"; 	
	if(!$pms["hard_sinyal_6"])	$hard_sinyal_6[$_POST["hard_sinyal_6"]] = "checked"; else $hard_sinyal_6[$pms["hard_sinyal_6"]]= "checked"; 	
	if(!$pms["hard_sinyal_7"])	$hard_sinyal_7[$_POST["hard_sinyal_7"]] = "checked"; else $hard_sinyal_7[$pms["hard_sinyal_7"]]= "checked"; 	
	if(!$pms["hard_sinyal_8"])	$hard_sinyal_8[$_POST["hard_sinyal_8"]] = "checked"; else $hard_sinyal_8[$pms["hard_sinyal_8"]]= "checked"; 	
	if(!$pms["label_1"])		$label_1[$_POST["label_1"]] = "checked"; 			else $label_1[$pms["label_1"]]= "checked"; 		
	if(!$pms["alarm_1"])		$alarm_1[$_POST["alarm_1"]] = "checked"; 			else $alarm_1[$pms["alarm_1"]]= "checked"; 		
	if(!$pms["alarm_2"])		$alarm_2[$_POST["alarm_2"]] = "checked"; 			else $alarm_2[$pms["alarm_2"]]= "checked"; 		
	if(!$pms["kebersihan_1"])	$kebersihan_1[$_POST["kebersihan_1"]] = "checked"; 	else $kebersihan_1[$pms["kebersihan_1"]]= "checked"; 	
		
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&pms_id=".$pms_id."\";'","btn btn-success");
?>
<style type="text/css">
    #c_blue {
        background : rgb(204, 255, 255);
    }
    #c_yellow {
        background : rgb(255, 255, 0);
    }
	table { 
	  width: 100%; 
	  border-collapse: collapse; 
	}
	@media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {

		/* Force table to not be like tables anymore */
		table, thead, tbody, th, td, tr { 
			display: block; 
		}
		
		
		tr { border: 1px solid #ccc; }
		
		td { 
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee; 
			position: relative;
			word-wrap:break-word
		}
	}
</style>
<?php
// echo $width = " <script>document.write(screen.width); </script>"; 
?>
<center><h4><b>PMS NOKIA</b></h4></center>
<center><h5><u>Self Inspection Report Checklist</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&pms_id=<?=$pms_id;?>">

<div style="overflow-x:auto;">
<table width="100%"align="center" border="1">
	<tr>
		<td colspan="3" id="c_blue" align="center"><b>Informasi Audit</b></td>
	</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Hardware Quality Standard umum untuk instalasi rak/kabinet</b></td>
			</tr>
				<tr>
					<td  id="c_green" align="left">1. Untuk perangkat outdoor, pastikan waterproof dan <br>&emsp;anti korosi sudah diaplikasikan</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_1","1","style='height:12px;' type='radio' ".$hard_rak_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_1","2","style='height:12px;' type='radio' ".$hard_rak_1[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green">2. Kompenen pendukung rak/kabinet harus terpasang dengan benar,<br>&emsp;
					semua baut terpasang sesuai dengan kriteria. Jika memiliki <br>&emsp;
					komponen insulasi / isolator, harus dipasang dan pastikan fungsinya.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_2","1","style='height:12px;' type='radio' ".$hard_rak_2[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_2","2","style='height:12px;' type='radio' ".$hard_rak_2[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">3. Setiap lubang input/output kabel pada rak harus tertutup / sealant</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_3","1","style='height:12px;' type='radio' ".$hard_rak_3[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_3","2","style='height:12px;' type='radio' ".$hard_rak_3[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">4. Sisa-sisa potongan kabel atau ties harus dibersihkan, <br>&emsp;
					tidak boleh ada yang tersisa, baik itu di dalam, dibawah, <br>&emsp;atau diatas kabinet.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_4","1","style='height:12px;' type='radio' ".$hard_rak_4[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_4","2","style='height:12px;' type='radio' ".$hard_rak_4[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">5. Tidak ada cat yang terkelupas atau kotor di bagian manapun di rak<br>&emsp;
					/kabinet, jika terjadi maka harus di cat ulang atau dibersihkan.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_5","1","style='height:12px;' type='radio' ".$hard_rak_5[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_rak_5","2","style='height:12px;' type='radio' ".$hard_rak_5[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Base Station</b></td>
			</tr>
				<tr>
					<td  id="c_green" align="left">1. Periksa instalasi dan penempatan plinth sesuai dengan As Plan</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_1","1","style='height:12px;' type='radio' ".$base_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_1","2","style='height:12px;' type='radio' ".$base_1[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">2. Pastikan semua baut sudah dikencangkan dan lengkap,<br>&emsp;
					pastikan plinth terkoneksi ke sistem grounding dan kabel mengarah <br>&emsp;lurus kebawah</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_2","1","style='height:12px;' type='radio' ".$base_2[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_2","2","style='height:12px;' type='radio' ".$base_2[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">3. Pastikan modul yang diinstal sesuai dengan konfigurasi <br>&emsp;
					yang ada di as plan dan terkoneksi ke sistem grounding</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_3","1","style='height:12px;' type='radio' ".$base_3[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_3","2","style='height:12px;' type='radio' ".$base_3[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">4. Pastikan semua port yang digunakan atau tidak, tertutup <br>&emsp;rapat dengan IP Seal</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_4","1","style='height:12px;' type='radio' ".$base_4[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_4","2","style='height:12px;' type='radio' ".$base_4[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">5. Pastikan penutup flexi tertutup rapat</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_5","1","style='height:12px;' type='radio' ".$base_5[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_5","2","style='height:12px;' type='radio' ".$base_5[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">6. Routing kabel antar module harus terpasang rapi sesuai <br>&emsp;dengan standar nokia</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_6","1","style='height:12px;' type='radio' ".$base_6[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_6","2","style='height:12px;' type='radio' ".$base_6[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">7. Label untuk kabel harus terpasang dengan kuat dan benar</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_7","1","style='height:12px;' type='radio' ".$base_7[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_7","2","style='height:12px;' type='radio' ".$base_7[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">8. Sisa kepanjangan kabel optik harus diletakkan di bawah <br>&emsp;atau disamping BTS</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_8","1","style='height:12px;' type='radio' ".$base_8[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("base_8","2","style='height:12px;' type='radio' ".$base_8[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Hardware Quality Standard umum untuk Kabel Power <br>&emsp;dan Grounding</b></td>
			</tr>	
				<tr>
					<td  id="c_green" align="left">1. Kabel power harus terhubung dengan kuat dan benar dengan <br>&emsp;
					ring per dan ring pipih dengan urutan yang benar. Ketika ujung kabel<br>&emsp;
					power menggunakan skun, pastikan skun tersebut sudah di-press <br>&emsp;dengan kuat.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_1","1","style='height:12px;' type='radio' ".$hard_power_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_1","2","style='height:12px;' type='radio' ".$hard_power_1[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">2. Kabel power dan grounding harus dibuat dari bahan tembaga, <br>&emsp;
					tanpa ada persambungan ditengahnya.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_2","1","style='height:12px;' type='radio' ".$hard_power_2[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_2","2","style='height:12px;' type='radio' ".$hard_power_2[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">3. Sisa kabel power harus dipotong, tidak boleh digulung</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_3","1","style='height:12px;' type='radio' ".$hard_power_3[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_3","2","style='height:12px;' type='radio' ".$hard_power_3[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">4. Kabel sinyal dan kabel power harus terpisah (jarak min. 3cm)</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_4","1","style='height:12px;' type='radio' ".$hard_power_4[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_4","2","style='height:12px;' type='radio' ".$hard_power_4[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">5. Tidak ada serabut yang tampak pada koneksi kabel power <br>&emsp;
					dan groounding. Kabel yang terpasang harus sesuai spesifikasi.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_5","1","style='height:12px;' type='radio' ".$hard_power_5[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_5","2","style='height:12px;' type='radio' ".$hard_power_5[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">6. Ketika skun yang terpasang harus ditumpuk, maka harus <br>&emsp;
					memasang skun dengan perbedaan sudut 45 derajat / 90 derajat, <br>&emsp;
					kabel yang lebih besar harus ada dibawah yang lebih kecil.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_6","1","style='height:12px;' type='radio' ".$hard_power_6[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_6","2","style='height:12px;' type='radio' ".$hard_power_6[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">7. Diameter kabel power, kabel grounding, atau kabel <br>&emsp;
					equipotensial antar kabinet harus sesuai spesifikasi.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_7","1","style='height:12px;' type='radio' ".$hard_power_7[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_power_7","2","style='height:12px;' type='radio' ".$hard_power_7[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Hardware Quality Standard umum untuk Kabel Sinyal</b></td>
			</tr>	
				<tr>
					<td  id="c_green" align="left">1. Tidak ada kerusakan, terkelupas, atau sambungan pada <br>&emsp;kabel sinyal.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_1","1","style='height:12px;' type='radio' ".$hard_sinyal_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_1","2","style='height:12px;' type='radio' ".$hard_sinyal_1[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">2. Jangan pernah memasang kabel diatas ventilasi kabinet,<br>&emsp;
					yang bisa memberikan radiasi panas dan mengurangi umur kabel.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_2","1","style='height:12px;' type='radio' ".$hard_sinyal_2[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_2","2","style='height:12px;' type='radio' ".$hard_sinyal_2[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">3. Jalur kabel di dalam kabinet harus benar.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_3","1","style='height:12px;' type='radio' ".$hard_sinyal_3[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_3","2","style='height:12px;' type='radio' ".$hard_sinyal_3[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">4. Kabel yang terpasang harus terikat dengan jarak yang sama dan <br>&emsp;
					ketegangan yang sesuai. Ties kabel harus terpasang dengan rapi, <br>&emsp;
					dan ujungnya harus terpotong habis dan rapi sehingga tidak ada <br>&emsp;
					bagian yg tajam. Jalur kabel harus rapi &amp; bendingannya harus halus.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_4","1","style='height:12px;' type='radio' ".$hard_sinyal_4[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_4","2","style='height:12px;' type='radio' ".$hard_sinyal_4[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">5. Periksa instalasi kabel internal (bus, power modul) melalui <br>&emsp;Cable Entry sebelah kiri</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_5","1","style='height:12px;' type='radio' ".$hard_sinyal_5[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_5","2","style='height:12px;' type='radio' ".$hard_sinyal_5[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">6. Periksa instalasi kabel eksternal (E1, alarm, power DC) <br>&emsp;melalui Cable Entry sebelah kanan</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_6","1","style='height:12px;' type='radio' ".$hard_sinyal_6[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_6","2","style='height:12px;' type='radio' ".$hard_sinyal_6[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">7. Pastikan semua instalasi kabel outdoor menggunakan konduit</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_7","1","style='height:12px;' type='radio' ".$hard_sinyal_7[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_7","2","style='height:12px;' type='radio' ".$hard_sinyal_7[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">8. Pastikan semua label sudah dipasang</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_8","1","style='height:12px;' type='radio' ".$hard_sinyal_8[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("hard_sinyal_8","2","style='height:12px;' type='radio' ".$hard_sinyal_8[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Labels</b></td>
			</tr>	
				<tr>
					<td  id="c_green" align="left">1. Label untuk kabel harus terpasang dengan kuat dan benar. <br>&emsp;
					Harus rapi dan dalam posisi dan arah yang sama.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("label_1","1","style='height:12px;' type='radio' ".$label_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("label_1","2","style='height:12px;' type='radio' ".$label_1[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Instalasi external Alarm</b></td>
			</tr>	
				<tr>
					<td  id="c_green" align="left">1. Pastikan alarm untuk 2G sudah dipasang</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("alarm_1","1","style='height:12px;' type='radio' ".$alarm_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("alarm_1","2","style='height:12px;' type='radio' ".$alarm_1[2]);?> Fail</td>
				</tr>
				<tr>
					<td  id="c_green" align="left">2. Pastikan semua label sudah dipasang</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("alarm_2","1","style='height:12px;' type='radio' ".$alarm_2[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("alarm_2","2","style='height:12px;' type='radio' ".$alarm_2[2]);?> Fail</td>
				</tr>
			<tr>
				<td colspan="3" id="c_yellow" align="center"><b>Kebersihan Site</b></td>
			</tr>	
				<tr>
					<td  id="c_green" align="left">1. Ruang perangkat harus bersih dan rapi. Material dan kardus sisa <br>&emsp;
					harus dirapikan. Spare parts harus diatur dg rapi setelah instalasi.</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("kebersihan_1","1","style='height:12px;' type='radio' ".$kebersihan_1[1]);?> Pass</td>
					<td align="left" valign="middle" width="10%"><?=$f->input("kebersihan_1","2","style='height:12px;' type='radio' ".$kebersihan_1[2]);?> Fail</td>
				</tr>
			<tr>
		<tr>	
			<td colspan="3" style="padding-top:15;">	
				<?=$f->input("back","Back","type='button' onclick='window.location=\"pms_nokia_add_01.php?token=".$token."&pms_id=".$pms_id."\";'","btn btn-warning");?>
				<?php if(!$pms["id"]) { ?>
					&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
				<?php } else {?>
					&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					<?=$f->input("save","Update","type='submit'","btn btn-primary");?>
					&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
					<?=$f->input("nest","Next","type='button' onclick='window.location=\"pms_nokia_photo.php?token=".$token."&pms_id=".$pms_id."&page=02\";'","btn btn-info");?>
				<?php } ?>
			</td>
		</tr>
</table>
</div>
</form>	
<script> $("#site_id").focus(); </script>
<?php include_once "footer.php";?>