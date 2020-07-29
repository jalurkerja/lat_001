<?php
	include_once "win_head.php";

	$nama_user	= $db->fetch_single_data("users","name",["id" => $_GET["user_id"]]);
	$_title = "Details Cuti Tahun ".date("Y")." - ".$nama_user;
	
	$cuti_bersama 		= $db->fetch_all_data("day_off",[],"tanggal LIKE '%".date("Y")."-%' AND is_leave = '1'");
	$cuti_individual 	= $db->fetch_all_data("attendance_notes",[],"tanggal LIKE '%".date("Y")."-%' AND cuti = '1' AND user_id = '".$_GET["user_id"]."'");
?>

<?php
	if(!$cuti_individual && !$cuti_bersama){
		echo "<center><h3><b>Data Not Found!</h3></b></center>";
	} else {
?>
	<h3><b><?=$_title;?></b></h3>
	<br><br>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No","Tanggal","Keterangan"));?>
	<?php 
		$no = 1;
		foreach($cuti_bersama as $tgl_cuti_bersama){
			$do_aktifitas = $db->fetch_single_data("attendance_activity","id",["user_id" => $_GET["user_id"], "attendance_status" => "3,9:IN", "created_at" => "%".$tgl_cuti_bersama["tanggal"]."%:LIKE"]);
			if(!$do_aktifitas) {
			?>
				<tr>
					<td align="right" style="width:5%;" ><?=$no++;?></td>
					<td align="right" style="width:20%;" ><?=format_tanggal($tgl_cuti_bersama["tanggal"],"d-M-Y");?></td>
					<td align="center"><?=$tgl_cuti_bersama["keterangan"];?></td>
				</tr>
			<?php
			}
		}
		foreach($cuti_individual as $tgl_cuti_individual){
			$description = $db->fetch_single_data("attendance_activity","description",["user_id" => $_GET["user_id"], "attendance_status" => "6", "leave_start" => $tgl_cuti_individual["tanggal"].":>=", "leave_end" => $tgl_cuti_individual["tanggal"].":<="]);
			substr($description,44) == "" ? $_description = "Cuti Tahunan" : $_description = substr($description,44);
			?>
				<tr>
					<td align="right" style="width:5%;" ><?=$no++;?></td>
					<td align="right" style="width:20%;" ><?=format_tanggal($tgl_cuti_individual["tanggal"],"d-M-Y");?></td>
					<td align="center"><?=$_description;?></td>
				</tr>
			<?php
		}
		
	?>
	<?=$t->end();?>
<?php
	
	}
?>