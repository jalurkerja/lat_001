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
	$site_kode_name = str_replace(" ","_",$site_details["kode"]."_".$site_details["name"]);
	$back 			=$f->input("","Back","type='button' onclick='window.location=\"hs_add_01.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";'","btn btn-warning");
	$next			= "";
	
	if(isset($_POST["save"])){
		if(!$id) {
			$db->addtable("indottech_hs");
			$db->addfield("site_id");				$db->addvalue($site_id);
			$inserting = $db->insert();
			$id = $inserting["insert_id"];
		}
		$db->addtable("indottech_hs_01");
		$db->where("hs_id",$id);
		$db->addfield("tl_name");				$db->addvalue($_POST["tl_name"]);
		$db->addfield("tl_wah");				$db->addvalue($_POST["txt_cert"][1]);
		$db->addfield("tl_ktp");				$db->addvalue($_POST["tl_ktp"]);
		$db->addfield("member1_name");			$db->addvalue($_POST["member1_name"]);
		$db->addfield("member1_wah");			$db->addvalue($_POST["txt_cert"][2]);
		$db->addfield("member1_ktp");			$db->addvalue($_POST["member1_ktp"]);
		$db->addfield("member2_name");			$db->addvalue($_POST["member2_name"]);
		$db->addfield("member2_wah");			$db->addvalue($_POST["txt_cert"][3]);
		$db->addfield("member2_ktp");			$db->addvalue($_POST["member2_ktp"]);
		$db->addfield("member3_name");			$db->addvalue($_POST["member3_name"]);
		$db->addfield("member3_wah");			$db->addvalue($_POST["txt_cert"][4]);
		$db->addfield("member3_ktp");			$db->addvalue($_POST["member3_ktp"]);
		$db->addfield("member4_name");			$db->addvalue($_POST["member4_name"]);
		$db->addfield("member4_wah");			$db->addvalue($_POST["txt_cert"][5]);
		$db->addfield("member4_ktp");			$db->addvalue($_POST["member4_ktp"]);
		$db->addfield("member5_name");			$db->addvalue($_POST["member5_name"]);
		$db->addfield("member5_wah");			$db->addvalue($_POST["txt_cert"][6]);
		$db->addfield("member5_ktp");			$db->addvalue($_POST["member5_ktp"]);
		$db->addfield("qty_harness");			$db->addvalue($_POST["qty_harness"]);
		$inserting = $db->update();
		if($inserting["affected_rows"] >= 0){
			$db->addtable("indottech_hs_03");
			$db->where("hs_id",$id);
			$db->delete_();
			foreach($_POST["nilai"] as $point_list => $value){
				if($point_list == "9"){
					foreach($_POST["nilai"][$point_list] as $key => $list_9){
						$db->addtable("indottech_hs_03");
						$db->addfield("hs_id");				$db->addvalue($id);
						$db->addfield("point_list");		$db->addvalue($point_list."_".$key);
						$db->addfield("nilai");				$db->addvalue($list_9);
						$db->insert();
					}
				} else {
					$db->addtable("indottech_hs_03");
					$db->addfield("hs_id");				$db->addvalue($id);
					$db->addfield("point_list");		$db->addvalue($point_list);
					$db->addfield("nilai");				$db->addvalue($value);
					$db->insert();
				}
			}
			javascript("window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";");
		}
	}
	
	if($id){
		$next			=$f->input("","Finish","type='button' onclick='window.location=\"hs_sa_menu.php?token=".$_GET["token"]."&site_id=".$site_id."&user_id=".$__user_id."\";'","btn btn-success");
	} else {
		foreach($_POST["insp_result"] as $key => $post){
			$checked_1[$key] = "";
			$checked_2[$key] = "";
			$checked_3[$key] = "";
			if($post == 1){
				$checked_1[$key] = "checked";
			}
			if($post == 2){
				$checked_2[$key] = "checked";
			}
			if($post == 3){
				$checked_3[$key] = "checked";
			}
		}
	}
	
	$save		=$f->input("save","Save","type='submit'","btn btn-success");
		
	$hs_k3 		= "../images_doc/hs_k3.png";
	$hs_nokia 	= "../images_doc/hs_nokia.png";
	
	$hs_data_01 	= $db->fetch_all_data("indottech_hs_01",[],"hs_id = '".$id."'")[0];
	$txt_nama_tl 	= $f->input("tl_name",$hs_data_01["tl_name"],"onkeyup='nama_tl();' style='width:100% !important;'","classinput");
	$txt_ktp_tl 	= $f->input("tl_ktp",$hs_data_01["tl_ktp"],"style='width:100% !important;'","classinput");
	$txt_member_1 	= $f->input("member1_name",$hs_data_01["member1_name"],"onkeyup='nama_1(); 'style='width:100% !important;'","classinput");
	$txt_ktp_1 		= $f->input("member1_ktp",$hs_data_01["member1_ktp"],"style='width:100% !important;'","classinput");
	$txt_member_2 	= $f->input("member2_name",$hs_data_01["member2_name"],"onkeyup='nama_2();' style='width:100% !important;'","classinput");
	$txt_ktp_2 		= $f->input("member2_ktp",$hs_data_01["member2_ktp"],"style='width:100% !important;'","classinput");
	$txt_member_3 	= $f->input("member3_name",$hs_data_01["member3_name"],"onkeyup='nama_3();' style='width:100% !important;'","classinput");
	$txt_ktp_3 		= $f->input("member3_ktp",$hs_data_01["member3_ktp"],"style='width:100% !important;'","classinput");
	$txt_member_4 	= $f->input("member4_name",$hs_data_01["member4_name"],"onkeyup='nama_4();' style='width:100% !important;'","classinput");
	$txt_ktp_4 		= $f->input("member4_ktp",$hs_data_01["member4_ktp"],"style='width:100% !important;'","classinput");
	$txt_member_5 	= $f->input("member5_name",$hs_data_01["member5_name"],"onkeyup='nama_5();' style='width:100% !important;'","classinput");
	$txt_ktp_5 		= $f->input("member5_ktp",$hs_data_01["member5_ktp"],"style='width:100% !important;'","classinput");
	$txt_jumlah 	= $f->input("qty_harness",$hs_data_01["qty_harness"],"style='width:10% !important;'","classinput");
	
	for($radio=1; $radio<=15; $radio++){
		$checked[$radio][1] = "";
		$checked[$radio][2] = "";
		$val = $db->fetch_single_data("indottech_hs_03","nilai",["hs_id" => $id, "point_list" => $radio]);
		if($val == "1"){
			$checked[$radio][1] = "checked";
			$checked[$radio][2] = "";
		}
		if($val == "2"){
			$checked[$radio][1] = "";
			$checked[$radio][2] = "checked";
		}
		$nilai[$radio][1] = $f->input("nilai[".$radio."]","1","style='height:20px;' type='radio' ".$checked[$radio][1]);
		$nilai[$radio][2] = $f->input("nilai[".$radio."]","2","style='height:20px;' type='radio' ".$checked[$radio][2]);
		if($radio == 9){
			for($_radio=1; $_radio<=6; $_radio++){
				$checked[9][1][$_radio] = "";
				$checked[9][2][$_radio] = "";
				$val = $db->fetch_single_data("indottech_hs_03","nilai",["hs_id" => $id, "point_list" => $radio."_".$_radio]);
				if($val == "1"){
					$checked[9][1][$_radio] = "checked";
					$checked[9][2][$_radio] = "";
				}
				if($val == "2"){
					$checked[9][1][$_radio] = "";
					$checked[9][2][$_radio] = "checked";
				}
				
				$_nilai[$radio][1][$_radio] = $f->input("nilai[".$radio."][".$_radio."]","1","style='height:20px;' type='radio' ".$checked[$radio][1][$_radio]);
				$_nilai[$radio][2][$_radio] = $f->input("nilai[".$radio."][".$_radio."]","2","style='height:20px;' type='radio' ".$checked[$radio][2][$_radio]);
			}
		}
	}
?>
<style>
	.tdbreak {
		white-space: normal; 
	}
</style>
<table width="100%">
	<tr>
		<td width="50%" align="left"><?=$back;?></td>
		<td width="50%" align="right"><?=$next;?></td>
	</tr>
	<tr>
		<td colspan="2">Site : <?=$site_kode_name;?></td>
	</tr>
</table>

<form method="POST" action="?token=<?=$token;?>&site_id=<?=$site_id;?>&id=<?=$id;?>&mode=hs&user_id=<?=$__user_id;?>">
	<table width="100%" align="center" style="color:black;">
		<tr>
			<td>&nbsp;</td>
			<td colspan="7" align="center" style="font-size:12px; font-weight: bolder; background-color: #ccccb3;">Healt and Safety Checklist</td>
			<td colspan="2" style="background-color: #ccccb3;"><img src=<?=$hs_nokia;?> height="10" width="55"></td>
			<td>&nbsp;</td>
		</tr>
		<tr><td colspan="11">&nbsp;</td></tr>
		<tr>
			<td width="2%">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Project :</td>
			<td align="Left" ><?=$hs_data_01["project_name"];?></td>
			<td colspan="4">&nbsp;</td>
			<td width="2%">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Site Name :</td>
			<td align="Left"  class="tdbreak"><?=$site_details["name"];?></td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Site ID :</td>
			<td align="Left" ><?=$site_details["kode"];?></td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Work Package ID :</td>
			<td align="Left" ><?=$hs_data_01["wp_id"];?></td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Subcon Name :</td>
			<td align="Left" ><?=$hs_data_01["subcon"];?></td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Team Leader Name :</td>
			<td align="Left" ><?=$txt_nama_tl;?></td>
			<td >no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_tl;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Member name 1 :</td>
			<td align="Left" ><?=$txt_member_1;?></td>
			<td>no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_1;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Member name 2 :</td>
			<td align="Left" ><?=$txt_member_2;?></td>
			<td>no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_2;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Member name 3 :</td>
			<td align="Left" ><?=$txt_member_3;?></td>
			<td>no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_3;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Member name 4 :</td>
			<td align="Left" ><?=$txt_member_4;?></td>
			<td>no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_4;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Member name 5 :</td>
			<td align="Left" ><?=$txt_member_5;?></td>
			<td>no KTP :</td>
			<td colspan="4"  align="left"><?=$txt_ktp_5;?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td colspan="3" align="right">Inspection date / hour :</td>
			<td align="Left" ><?=format_tanggal($hs_data_01["inspection_date"],"d-M-y");?></td>
			<td colspan="4">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="100%" align="center" style="color:black;" id="data_content">
		<tr>
			<td style="font-weight:bolder">&nbsp;</td>
			<td style="font-weight:bolder" width="2%" align="center">No</td>
			<td style="font-weight:bolder" align="center" colspan="6" class="tdbreak">Items</td>
			<td style="font-weight:bolder" width="5%" align="center">OK</td>
			<td style="font-weight:bolder" width="5%" align="center">NOK</td>
			<td style="font-weight:bolder">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td width="2%" align="center">1</td>
			<td align="Left" colspan="6" class="tdbreak">Nomor Telepon Darurat (Emergency Call Number)</td>
			<td width="5%" align="center"><?=$nilai[1][1];?></td>
			<td width="5%" align="center"><?=$nilai[1][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">2</td>
			<td align="Left" colspan="6">Alat Pemadam Api Ringan (Fire Estinguisher)</td>
			<td align="center"><?=$nilai[2][1];?></td>
			<td align="center"><?=$nilai[2][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">3</td>
			<td align="Left" colspan="6">Kotak P3K (First Aid Kit) </td>
			<td align="center"><?=$nilai[3][1];?></td>
			<td align="center"><?=$nilai[3][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">4</td>
			<td align="Left" colspan="6">Penilaian Resiko (Risk Assessment)</td>
			<td align="center"><?=$nilai[4][1];?></td>
			<td align="center"><?=$nilai[4][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">5</td>
			<td align="Left" colspan="6">Rambu Keselamatan (Safety Sign)</td>
			<td align="center"><?=$nilai[5][1];?></td>
			<td align="center"><?=$nilai[5][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">6</td>
			<td align="Left" colspan="6">Pita Pembatas (Barricade Tape)</td>
			<td align="center"><?=$nilai[6][1];?></td>
			<td align="center"><?=$nilai[6][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">7</td>
			<td align="Left" colspan="6" class="tdbreak">Laporan briefing keselamatan kerja (Toolbox Meeting Report)</td>
			<td align="center"><?=$nilai[7][1];?></td>
			<td align="center"><?=$nilai[7][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">8</td>
			<td align="Left" colspan="6" class="tdbreak">Fullbody Harness, lengkap dengan shock absorbing lanyard & horizonal lanyard</td>
			<td align="center"><?=$nilai[8][1];?></td>
			<td align="center"><?=$nilai[8][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td align="Left" colspan="6">Jumlah: <?=$txt_jumlah;?> set</td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">9</td>
			<td align="Left" colspan="6" class="tdbreak">Sertifikat pelatihan bekerja di ketinggian (w@h training certificate)</td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php
			for($i=1; $i<=6; $i++){
			$hs_data_[1] = $hs_data_01["tl_name"];
			$cert_data_[1] = $hs_data_01["tl_wah"];
			if($i>1){
				$hs_data_[$i] = $hs_data_01["member".($i-1)."_name"];
				$cert_data_[$i] = $hs_data_01["member".($i-1)."_wah"];
			}
			
			$txt_nama[$i] = $f->input("txt_nama[".$i."]",$hs_data_[$i],"style='width:50%;' readonly","classinput");
			$txt_cert[$i] = $f->input("txt_cert[".$i."]",$cert_data_[$i],"style='width:50%;'","classinput");
				?>
				<tr>
					<td>&nbsp;</td>
					<td align="center">&nbsp;</td>
					<td align="Left" colspan="4">Atas Nama : <?=$txt_nama[$i];?></td>
					<td align="Left" colspan="2">certificate no : <?=$txt_cert[$i];?></td>
					<td align="center"><?=$_nilai[9][1][$i];?></td>
					<td align="center"><?=$_nilai[9][2][$i];?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
			}
		?>
		<tr>
			<td>&nbsp;</td>
			<td align="center">10</td>
			<td align="Left" colspan="6">Helm proyek (Safety Helmet)</td>
			<td align="center"><?=$nilai[10][1];?></td>
			<td align="center"><?=$nilai[10][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">11</td>
			<td align="Left" colspan="6">Sepatu keselamatan (Safety Shoes)</td>
			<td align="center"><?=$nilai[11][1];?></td>
			<td align="center"><?=$nilai[11][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">12</td>
			<td align="Left" colspan="6">Sarung tangan keselamatan</td>
			<td align="center"><?=$nilai[12][1];?></td>
			<td align="center"><?=$nilai[12][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">13</td>
			<td align="Left" colspan="6">Kacamata keselamatan – bila diperlukan</td>
			<td align="center"><?=$nilai[13][1];?></td>
			<td align="center"><?=$nilai[13][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">14</td>
			<td align="Left" colspan="6" class="tdbreak">Peralatan keselamatan lain bila diperlukan (mis: Safety Cone, Safety Vest, dsb)</td>
			<td align="center"><?=$nilai[14][1];?></td>
			<td align="center"><?=$nilai[14][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="center">15</td>
			<td align="Left" colspan="6">Wrist Strap (anti statik untuk pekerjaan TI)</td>
			<td align="center"><?=$nilai[15][1];?></td>
			<td align="center"><?=$nilai[15][2];?></td>
			<td>&nbsp;</td>
		</tr>
		<tr><td>&nbsp;</td><td colspan="9" class="tdbreak" style="background-color: #4da6ff;">Dengan ini saya menyatakan bahwa apa yang saya tulis di atas adalah sesuai dengan kondisi yang sebenarnya. Saya bersedia menerima sangsi apabila diketahui melakukan manipulasi data/informasi di atas.
		</td><td>&nbsp;</td></tr>
	</table>

	<table width="100%">
		<tr>
			<td width="33%" align="left"><?=$back;?></td>
			<td align="center"><?=$save;?></td>
			<td width="33%" align="right"><?=$next;?></td>
		</tr>
	</table>
</form>	
<?php
	foreach($_POST["responsible"] as $key => $post){
		?><script>
			document.getElementById("responsible[<?=$key;?>]").value = "<?=$post;?>";
			document.getElementById("description[<?=$key;?>]").value = "<?=$_POST["description"][$key];?>";
		</script><?php
	}
?>
<script>
	function nama_tl (){
		document.getElementById("txt_nama[1]").value = document.getElementById("tl_name").value;
	}
	function nama_1 (){
		document.getElementById("txt_nama[2]").value = document.getElementById("member1_name").value;
	}
	function nama_2 (){
		document.getElementById("txt_nama[3]").value = document.getElementById("member2_name").value;
	}
	function nama_3 (){
		document.getElementById("txt_nama[4]").value = document.getElementById("member3_name").value;
	}
	function nama_4 (){
		document.getElementById("txt_nama[5]").value = document.getElementById("member4_name").value;
	}
	function nama_5 (){
		document.getElementById("txt_nama[6]").value = document.getElementById("member5_name").value;
	}
</script>
<?php include_once "footer.php";?>