<?php 
	include_once "header.php";
	$pms_id = $_GET["pms_id"];
	$site = $db->fetch_single_data("pms_nokia","concat('[',site_id,'] ', site_name)", ["id"=>$pms_id]);
	$pms = $db->fetch_all_data("pms_nokia_after",[],"pms_id='".$pms_id."'");
	
	if(isset($_POST["save"])){
		$db->addtable("pms_nokia_after");
		$db->where("pms_id",$pms_id);
		$db->delete_();
		for($i=0; $i<=2; $i++){
			$db->addtable("pms_nokia_after");
			$db->addfield("pms_id");						$db->addvalue($pms_id);
			$db->addfield("antenna_type_b");				$db->addvalue($_POST["antenna_type_b"][$i]);
			$db->addfield("antenna_type_a");				$db->addvalue($_POST["antenna_type_a"][$i]);
			$db->addfield("antenna_height_b");				$db->addvalue($_POST["antenna_height_b"][$i]);
			$db->addfield("antenna_height_a");				$db->addvalue($_POST["antenna_height_a"][$i]);
			$db->addfield("azimuth_b");						$db->addvalue($_POST["azimuth_b"][$i]);
			$db->addfield("azimuth_a");						$db->addvalue($_POST["azimuth_a"][$i]);
			$db->addfield("mech_b");						$db->addvalue($_POST["mech_b"][$i]);
			$db->addfield("mech_a");						$db->addvalue($_POST["mech_a"][$i]);
			$db->addfield("elect_b");						$db->addvalue($_POST["elect_b"][$i]);
			$db->addfield("elect_a18");						$db->addvalue($_POST["elect_a18"][$i]);
			$db->addfield("elect_a21");						$db->addvalue($_POST["elect_a21"][$i]);
			$db->addfield("seqno");							$db->addvalue($i);
			$inserting = $db->insert();
		}
		if($inserting["affected_rows"] >= 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"pms_nokia_add_04.php?token=".$token."&pms_id=".$pms_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&pms_id=".$pms_id."\";'","btn btn-success");
	foreach($pms as $ke => $_pms){
		$pms["antenna_type_b"][$ke] = $_pms["antenna_type_b"];
		$pms["antenna_type_a"][$ke] = $_pms["antenna_type_a"];
		$pms["antenna_height_b"][$ke] = $_pms["antenna_height_b"];
		$pms["antenna_height_a"][$ke] = $_pms["antenna_height_a"];
		$pms["azimuth_b"][$ke] = $_pms["azimuth_b"];
		$pms["azimuth_a"][$ke] = $_pms["azimuth_a"];
		$pms["mech_b"][$ke] = $_pms["mech_b"];
		$pms["mech_a"][$ke] = $_pms["mech_a"];
		$pms["elect_b"][$ke] = $_pms["elect_b"];
		$pms["elect_a18"][$ke] = $_pms["elect_a18"];
		$pms["elect_a21"][$ke] = $_pms["elect_a21"];
	}
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
	td {
		padding: 1 0 1 0;
	}
</style>
<center><h4><b>PMS NOKIA - <?=$site;?></b></h4></center>
<center><h5><u>AFTER</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&pms_id=<?=$pms_id;?>">
<table width="100%"align="center" border="0">
		<!-- sec 2-->
	<tr>
		<td colspan="3" id="c_blue" align="center"><b>Sector 0</b><td>
	</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Type</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_type_b[0]",$pms["antenna_type_b"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_type_a[0]",$pms["antenna_type_a"][0],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Height</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_height_b[0]",$pms["antenna_height_b"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_height_a[0]",$pms["antenna_height_a"][0],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Azimuth</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("azimuth_b[0]",$pms["azimuth_b"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("azimuth_a[0]",$pms["azimuth_a"][0],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Mech. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("mech_b[0]",$pms["mech_b"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("mech_a[0]",$pms["mech_a"][0],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Elect. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("elect_b[0]",$pms["elect_b"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 1800</td><td colspan="2">: <?=$f->input("elect_a18[0]",$pms["elect_a18"][0],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 2100</td><td colspan="2">: <?=$f->input("elect_a21[0]",$pms["elect_a21"][0],"","classinput");?></td>
		</tr>
		
		<!-- sec 1-->
	<tr>
		<td colspan="3" id="c_blue" align="center"><b>Sector 1</b><td>
	</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Type</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_type_b[1]",$pms["antenna_type_b"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_type_a[1]",$pms["antenna_type_a"][1],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Height</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_height_b[1]",$pms["antenna_height_b"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_height_a[1]",$pms["antenna_height_a"][1],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Azimuth</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("azimuth_b[1]",$pms["azimuth_b"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("azimuth_a[1]",$pms["azimuth_a"][1],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Mech. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("mech_b[1]",$pms["mech_b"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("mech_a[1]",$pms["mech_a"][1],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Elect. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("elect_b[1]",$pms["elect_b"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 1800</td><td colspan="2">: <?=$f->input("elect_a18[1]",$pms["elect_a18"][1],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 2100</td><td colspan="2">: <?=$f->input("elect_a21[1]",$pms["elect_a21"][1],"","classinput");?></td>
		</tr>
		
		<!-- sec 2-->
	<tr>
		<td colspan="3" id="c_blue" align="center"><b>Sector 2</b><td>
	</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Type</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_type_b[2]",$pms["antenna_type_b"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_type_a[2]",$pms["antenna_type_a"][2],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Antenna Height</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("antenna_height_b[2]",$pms["antenna_height_b"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("antenna_height_a[2]",$pms["antenna_height_a"][2],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Azimuth</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("azimuth_b[2]",$pms["azimuth_b"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("azimuth_a[2]",$pms["azimuth_a"][2],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Mech. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("mech_b[2]",$pms["mech_b"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After </td><td colspan="2">: <?=$f->input("mech_a[2]",$pms["mech_a"][2],"","classinput");?></td>
		</tr>
	<tr>
		<td colspan="3" align="Left"><b>&emsp;Elect. Tilt</b><td>
	</tr>
		<tr>
			<td >Before</td><td colspan="2">: <?=$f->input("elect_b[2]",$pms["elect_b"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 1800</td><td colspan="2">: <?=$f->input("elect_a18[2]",$pms["elect_a18"][2],"","classinput");?></td>
		</tr>
		<tr>
			<td >After 2100</td><td colspan="2">: <?=$f->input("elect_a21[2]",$pms["elect_a21"][2],"","classinput");?></td>
		</tr>
	<tr>	
		<td colspan="3" style="padding-top:15;">	
			<?=$f->input("back","Back","type='button' onclick='window.location=\"pms_nokia_photo.php?token=".$token."&pms_id=".$pms_id."&page=03\";'","btn btn-warning");?>
			<?php if(!$pms[0]["id"]) { ?>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<?=$f->input("save","Save","type='submit'","btn btn-primary");?>
			<?php } else {?>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<?=$f->input("save","Update","type='submit'","btn btn-primary");?>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<?=$f->input("nest","Next","type='button' onclick='window.location=\"pms_nokia_photo.php?token=".$token."&pms_id=".$pms_id."&page=04\";'","btn btn-info");?>
			<?php } ?>
		</td>
	</tr>
</table>
</form>	
<script> $("#site_id").focus(); </script>
<?php include_once "footer.php";?>