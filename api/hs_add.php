<?php include_once "header.php";?>
<?php 
	if($_GET["id"]){
		$id = $_GET["id"];
		$indottech_hs 	= $db->fetch_all_data("indottech_hs",[],"id='".$id."'")[0];
		$site_id		= $indottech_hs["site_id"];
	} else {
		$site_id	= $_GET["site_id"];
		$id 		= $db->fetch_single_data("indottech_hs","id",["site_id"=>$site_id]);
	}
	
	$site_details 	= $db->fetch_all_data("indottech_sites",[],"id='".$site_id."'")[0];
	$indottech_hs_01 = $db->fetch_all_data("indottech_hs_01",[],"hs_id = '".$id."'")[0];
	$hs_k3 		= "../images_doc/hs_k3.png";
	$hs_nokia 	= "../images_doc/hs_nokia.png";
	if(isset($_POST["save"])){
		if(!$id) {
			$db->addtable("indottech_hs");
			$db->addfield("site_id");				$db->addvalue($site_id);
			$inserting = $db->insert();
			$id = $inserting["insert_id"];
		}
	
		$db->addtable("indottech_hs_01");
		$db->addfield("hs_id");				$db->addvalue($id);
		$db->addfield("project_name");		$db->addvalue($_POST["txt_proyek"]);
		$db->addfield("regional");			$db->addvalue($_POST["txt_regional"]);
		$db->addfield("site_name");			$db->addvalue($_POST["txt_nama_site"]);
		$db->addfield("site_code");			$db->addvalue($_POST["txt_kode_site"]);
		$db->addfield("wp_id");				$db->addvalue($_POST["txt_wp_id"]);
		$db->addfield("activity");			$db->addvalue($_POST["txt_aktifitas"]);
		$db->addfield("subcon");			$db->addvalue("PT. INDOHR");
		$db->addfield("tl_name");			$db->addvalue($_POST["txt_nama_tl"]);
		$db->addfield("tl_hp");				$db->addvalue($_POST["txt_no_hp"]);
		$db->addfield("tl_wah");			$db->addvalue($_POST["txt_no_wah"]);
		$db->addfield("ss_name");			$db->addvalue($_POST["txt_nama_ss"]);
		$db->addfield("ss_hp");				$db->addvalue($_POST["txt_no_hp_ss"]);
		$db->addfield("inspection_date");	$db->addvalue($_POST["txt_datetime"]);
		$db->addfield("inspection_name");	$db->addvalue($_POST["txt_nama_ins"]);
		$db->addfield("inspection_hp");		$db->addvalue($_POST["txt_no_hp_ins"]);
		$db->addfield("work_finish");		$db->addvalue($_POST["txt_tgl_selesai"]);
		if(!$indottech_hs_01["id"]){
			$inserting = $db->insert();
		} else {
			$db->where("id",$indottech_hs_01["id"]);
			$inserting = $db->update();
		}
		if($inserting["affected_rows"] >= 0){
			javascript("window.location=\"".str_replace("_add","_add_01",$_SERVER["PHP_SELF"])."?token=".$token."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";");
		}
	}
	
	if(!$_POST["txt_proyek"]){$_POST["txt_proyek"] = $indottech_hs_01["project_name"];}
	if(!$_POST["txt_regional"]){$_POST["txt_regional"] = $indottech_hs_01["regional"];}
	if(!$_POST["txt_wp_id"]){$_POST["txt_wp_id"] = $indottech_hs_01["wp_id"];}
	if(!$_POST["txt_aktifitas"]){$_POST["txt_aktifitas"] = $indottech_hs_01["activity"];}
	if(!$_POST["txt_nama_tl"]){$_POST["txt_nama_tl"] = $indottech_hs_01["tl_name"];}
	if(!$_POST["txt_no_hp"]){$_POST["txt_no_hp"] = $indottech_hs_01["tl_hp"];}
	if(!$_POST["txt_no_wah"]){$_POST["txt_no_wah"] = $indottech_hs_01["tl_wah"];}
	if(!$_POST["txt_nama_ss"]){$_POST["txt_nama_ss"] = $indottech_hs_01["ss_name"];}
	if(!$_POST["txt_no_hp_ss"]){$_POST["txt_no_hp_ss"] = $indottech_hs_01["ss_hp"];}
	if(!$_POST["txt_datetime"]){$_POST["txt_datetime"] = $indottech_hs_01["inspection_date"];}
	if(!$_POST["txt_nama_ins"]){$_POST["txt_nama_ins"] = $indottech_hs_01["inspection_name"];}
	if(!$_POST["txt_no_hp_ins"]){$_POST["txt_no_hp_ins"] = $indottech_hs_01["inspection_hp"];}
	if(!$_POST["txt_tgl_selesai"]){$_POST["txt_tgl_selesai"] = $indottech_hs_01["work_finish"];}
	$txt_proyek 		= $f->input("txt_proyek",$_POST["txt_proyek"],"style='width:100% !important;' ","classinput");
	$txt_regional 		= $f->input("txt_regional",$_POST["txt_regional"],"style='width:100% !important;' ","classinput");
	$txt_nama_site 		= $f->input("txt_nama_site",$site_details["name"],"style='width:100% !important;' readonly","classinput");
	$txt_kode_site 		= $f->input("txt_kode_site",$site_details["kode"],"style='width:100% !important;' readonly","classinput");
	$txt_wp_id 			= $f->input("txt_wp_id",$_POST["txt_wp_id"],"style='width:100% !important;' ","classinput");
	$txt_aktifitas 		= $f->textarea("txt_aktifitas",$_POST["txt_aktifitas"],"style='width:100% !important;' ","classinput");
	$txt_nama_subcon 	= $f->input("txt_nama_subcon","PT. INDOHR","style='width:100% !important;' readonly","classinput");
	$txt_nama_tl 		= $f->input("txt_nama_tl",$_POST["txt_nama_tl"],"style='width:100% !important;' ","classinput");
	$txt_no_hp 			= $f->input("txt_no_hp",$_POST["txt_no_hp"],"style='width:100% !important;' ","classinput");
	$txt_no_wah 		= $f->input("txt_no_wah",$_POST["txt_no_wah"],"style='width:100% !important;' ","classinput");
	$txt_nama_ss 		= $f->input("txt_nama_ss",$_POST["txt_nama_ss"],"style='width:100% !important;' ","classinput");
	$txt_no_hp_ss 		= $f->input("txt_no_hp_ss",$_POST["txt_no_hp_ss"],"style='width:100% !important;' ","classinput");
	$txt_datetime 		= $f->input("txt_datetime",$_POST["txt_datetime"],"style='width:100% !important;' type='date'","classinput");
	$txt_nama_ins 		= $f->input("txt_nama_ins",$_POST["txt_nama_ins"],"style='width:100% !important;' ","classinput");
	$txt_no_hp_ins 		= $f->input("txt_no_hp_ins",$_POST["txt_no_hp_ins"],"style='width:100% !important;' ","classinput");
	$txt_tgl_selesai 	= $f->input("txt_tgl_selesai",$_POST["txt_tgl_selesai"],"style='width:100% !important;' type='date'","classinput");
	$txt_nilai_hs 		= $f->input("txt_nilai_hs",$_POST["txt_nilai_hs"],"style='width:100% !important;' readonly","classinput");
	$txt_nilai_ns 		= $f->input("txt_nilai_ns",$_POST["txt_nilai_ns"],"style='width:100% !important;' readonly","classinput");
	$txt_nilai_nsn 		= $f->input("txt_nilai_nsn",$_POST["txt_nilai_nsn"],"style='width:100% !important;' readonly","classinput");
	$txt_nilai_cs 		= $f->input("txt_nilai_cs",$_POST["txt_nilai_cs"],"style='width:100% !important;' readonly","classinput");

	$last_seqno			= $db->fetch_single_data("indottech_hs_02","seqno",["hs_id" => $id],["seqno DESC"]);
	$indottech_hs_02	= $db->fetch_all_data("indottech_hs_02",[],"hs_id = '".$id."' AND seqno = '".$last_seqno."'");
	
	$val_ad		= "";
	$val_j		= "";
	$val_k		= "";
	$val_l		= "";
	foreach($indottech_hs_02 as $key => $data_02){
		if($data_02["insp_result"] == "2"){
			$val_ad += $db->fetch_single_data("indottech_checklist","nilai_inspection",["id" => $data_02["checklist_id"]]);
		}
		if($data_02["responsible"] == "NS"){
			$val_j++;
		}
		if($data_02["responsible"] == "NSN"){
			$val_k++;
		}
		if($data_02["responsible"] == "Cust"){
			$val_l++;
		}
	}
	
?>
<style>
	.tdbreak {
		white-space: normal; 
	}
</style>

<form method="POST" action="?token=<?=$token;?>&site_id=<?=$site_id;?>&id=<?=$id;?>&mode=hs&user_id=<?=$__user_id;?>">
	<table width="100%" align="center" style="color:black;">
		<tr>
			<td colspan="12" style="font-weight: bolder;" align="center">NOKIA NETWORKS</td>
		</tr>
		<tr>
			<td colspan="12" style="font-weight: bolder;" align="center">Health & Safety Site Inspection Self Assessment Form</td>
		</tr>
		<tr>
			<td colspan="12" style="font-weight: bolder;" align="center">Telecommunications Implementation (TI)</td>
		</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr>
			<td colspan="8">&nbsp;</td>
			<td colspan="3" align="right" style="padding-right:20px; border:1px solid black;">Rev. 2.1-2014</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
			<td colspan="3" align="right" style="padding-right:20px; border:1px solid black;">20.10.2014</td>
			<td>&nbsp;</td>
		</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr>
			<td colspan="12" style="font-weight: bolder; background-color: #ccccb3;" align="center">I. INFORMASI UMUM</td>
		</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr><td>&nbsp;</td>
			<td colspan="11">Isilah semua bagian yang diperlukan</td>
		</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr>
			<td width="1%">&nbsp;</td>
			<td width="20%" colspan="3" style="color:red;">1. Proyek</td>
			<td width="1%" style="color:red;" align="center">*</td>
			<td colspan="6" style="background-color:#ffff99"><?=$txt_proyek;?></td>
			<td width="1%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">2. Regional/Zone</td>
			<td>&nbsp;</td>
			<td colspan="6" style="background-color:#ffff99"><?=$txt_regional;?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">3. Detail Site</td>
			<td>&nbsp;</td>
			<td colspan="6">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right">Nama Site</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99" class="tdbreak"><?=$txt_nama_site;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right">Kode Site (Site ID)</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_kode_site;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right">Work Package ID</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99" align="left"><?=$txt_wp_id;?></td>
				<td>&nbsp;</td>
			</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="tdbreak">4. Aktifitas & detail pekerjaan</td>
			<td>&nbsp;</td>
			<td colspan="6" style="background-color:#ffff99"><?=$txt_aktifitas;?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3">5. Nama Subcontractor</td>
			<td>&nbsp;</td>
			<td colspan="6" style="background-color:#ffff99"><?=$txt_nama_subcon;?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="tdbreak">6. Team Leader Subcontractor</td>
			<td>&nbsp;</td>
			<td colspan="6">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right">Nama</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_nama_tl;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right">No. HP</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99" align="left"><?=$txt_no_hp;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" style="color:red;" align="right" class="tdbreak">no. Sertifikat W@H training</td>
				<td style="color:red;" align="center">*</td>
				<td colspan="6" style="background-color:#ffff99; color:red;"><?=$txt_no_wah;?></td>
				<td>&nbsp;</td>
			</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="tdbreak">7. Site Supervisor / Inspektor NSN</td>
			<td>&nbsp;</td>
			<td colspan="6">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right">Nama</td>
				<td style="color:red;"></td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_nama_ss;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right">No. HP</td>
				<td ></td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_no_hp_ss;?></td>
				<td>&nbsp;</td>
			</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" style="color:red;" class="tdbreak">8. Tanggal Inspeksi / Jam</td>
			<td style="color:red;" align="center">*</td>
			<td colspan="6" style="background-color:#ffff99" align="left"><?=$txt_datetime;?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="tdbreak">9. yang Melakukan Inspeksi</td>
			<td>&nbsp;</td>
			<td colspan="6">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right">Nama</td>
				<td style="color:red;"></td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_nama_ins;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right">No. HP</td>
				<td></td>
				<td colspan="6" style="background-color:#ffff99"><?=$txt_no_hp_ins;?></td>
				<td>&nbsp;</td>
			</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr><td></td>
			<td colspan="11"><i>Pernyataann Selesainya Pekerjaan.</i></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="10" align="center"  style="background-color: #4da6ff; white-space: normal;">
				Dengan ini saya menyatakan bahwasanya pekerjaan tersebut diatas telah selesai dilaksanakan dan selama pekerjaan berlangsung ampai dengan selesai, tidak terjadi insiden dan kecelakaan yang menyebabkan kerugian bagi semua pihak, baik kerugian materi kerugian terhadap jiwa pekerja dan lingkungan.
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="border-left:2px solid #4da6ff; border-bottom:2px solid #4da6ff;" colspan="3" align="right" class="tdbreak">Tanggal Selesai Pekerjaan</td>
			<td style="border-bottom:2px solid #4da6ff;">:</td>
			<td style="border-bottom:2px solid #4da6ff;" colspan="2" style="background-color: red;" align="left"><?=$txt_tgl_selesai;?></td>
			<td style="border-left:2px solid #4da6ff; border-right:2px solid #4da6ff; border-bottom:2px solid #4da6ff;" colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr><td colspan="12">&nbsp;</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" align="right" class="tdbreak">Nilai H&S Total</td>
			<td></td>
			<td colspan="4" style="background-color: #99e699" align="center"><?=$val_ad;?></td>
			<td colspan="2" style="white-space: normal;">Nilai H&S yang diterima adalah di bawah 3.5</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" align="right" class="tdbreak">Tanggung Jawab NS</td>
			<td></td>
			<td colspan="4" style="background-color: #ffbf80" align="center"><?=$val_j;?></td>
			<td colspan="2" > poin(lihat rincian)</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" align="right" class="tdbreak">Tanggung Jawab NSN</td>
			<td></td>
			<td colspan="4" style="background-color: #ffbf80" align="center"><?=$val_k;?></td>
			<td colspan="2" > poin(lihat rincian)</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" align="right" class="tdbreak">Tanggung Jawab Customer</td>
			<td></td>
			<td colspan="4" style="background-color: #ffbf80" align="center"><?=$val_l;?></td>
			<td colspan="2" > poin	(lihat rincian)</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<br>
	<?=$f->input("","Back","type='button' onclick='window.location=\"hs_sa_menu.php?token=".$_GET["token"]."&site_id=".$site_id."\";'","btn btn-warning");?>&ensp;
	<?=$f->input("save","Next","type='submit' ","btn btn-primary");?>&ensp;
</form>	
	
	
	
<?php include_once "footer.php";?>
