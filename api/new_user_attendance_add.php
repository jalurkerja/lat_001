<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	$user_created_at = $db->fetch_single_data("users","created_at",["id" => $user_id]);
	if($user_created_at != ""){
		$d_created = date("d",strtotime($user_created_at));
		$m_created = date("m",strtotime($user_created_at));
		$Y_created = date("Y",strtotime($user_created_at));
		if($d_created > 20){
			$min_date = date("Y-m-d",mktime(0,0,0,$m_created,19, $Y_created));
			$max_date = date("Y-m-d",mktime(0,0,0,$m_created+1,22, $Y_created));
		} else {
			$min_date = date("Y-m-d",mktime(0,0,0,$m_created-1,19, $Y_created));
			$max_date = date("Y-m-d",mktime(0,0,0,$m_created,22, $Y_created));
		}
	}
	
	$indottech_request_backdate = $db->fetch_all_data("indottech_request_backdate",[],"user_ids LIKE '%|".$user_id."|%' AND akses_mulai <= '".date("Y-m-d")."' AND akses_selesai >= '".date("Y-m-d")."'","id DESC")[0];
	if($indottech_request_backdate["id"] != ""){
		$min_date = date("Y-m-d",strtotime($indottech_request_backdate["tanggal_mulai_aktifitas"]));
		$max_date = date("Y-m-d",strtotime($indottech_request_backdate["tanggal_selesai_aktifitas"]));
	}
	
	if(isset($_POST["save"])){
		$_errormessage="";
		if($_POST["date"] > date("Y-m-d") || $_POST["date"] < $min_date || $_POST["date"] > $max_date) $_errormessage = "<p style='color:red'>Date can't bigger than today or ".format_tanggal($max_date,"d-M-Y")." and can't less than ".format_tanggal($min_date,"d-M-Y")."</p>";
		if ($_errormessage == ""){
			$Y	= date("Y",strtotime($_POST["date"]));
			$m	= date("m",strtotime($_POST["date"]));
			$d	= date("d",strtotime($_POST["date"]));
			$H	= date("H",strtotime($_POST["time"]));
			$i	= date("i",strtotime($_POST["time"]));
			$tap_time = date("Y-m-d H:i:s",mktime($H,$i,0,$m,$d,$Y));
			// if($_POST["in_out"] = 1) {$__in_out = "in";} else {$__in_out = "out";}
			$db->addtable("attendance");
			$db->addfield("user_id"); 				$db->addvalue($user_id);
			$db->addfield("tap_time"); 				$db->addvalue($tap_time);
			$db->addfield("in_out"); 				$db->addvalue($_POST["in_out"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				javascript("alert('Data berhasil disimpan mohon input aktifitas pada tombol -Activity-');");
				javascript("window.location='my_attendance.php?token=".$_GET["token"]."';");
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
		$date		= $f->input("date",$_POST["date"],"type='date' required style='width:80%'","classinput");
		$time		= $f->input("time",$_POST["time"],"type='time' required style='width:80%'","classinput");
		$in_out 	= $f->select("in_out",["" => "","in" => "In","out" => "Out"],$_POST["in_out"]," required style='width:80%'");
?>
	<center><h4><b>Tambah In / Out Absen</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>">
		<table id="data_content" width="100%">
			<tr>
				<td width="20%">Tanggal</td><td><?=$date;?></td>
			</tr>
			<tr>
				<td>Jam</td><td><?=$time;?></td>
			</tr>
			<tr>
				<td>In / Out</td><td><?=$in_out;?></td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<!--<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_activities.php?token=".$token."\";'","btn btn-warning");?></td>-->
			<td><?=$f->input("back","Back","type='button' onclick='history.go(-1);'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<br>
		<!--<p style="font-size:5px">AM : Menyatakan waktu Tengah Malam hingga Siang hari (Contoh jam datang 07:45 AM)<br> PM : Menyatakan waktu Siang hari hingga Tengah Malam (Contoh jam pulang 05:15 PM)</p>-->
		
<?php include_once "footer.php";?>