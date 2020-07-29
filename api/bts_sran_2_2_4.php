<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_2_4 = $db->fetch_all_data("indottech_bts_sran_2_2_4",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_2_4");
		if($bts_sran_2_2_4["id"] > 0) 					$db->where("id",$bts_sran_2_2_4["id"]);
		$db->addfield("atd_id");						$db->addvalue($atd_id);
		$db->addfield("v1");							$db->addvalue($_POST["v1"]);
		$db->addfield("v2");							$db->addvalue($_POST["v2"]);
		$db->addfield("v3");							$db->addvalue($_POST["v3"]);
		$db->addfield("v4");							$db->addvalue($_POST["v4"]);
		$db->addfield("v5");							$db->addvalue($_POST["v5"]);
		$db->addfield("v6");							$db->addvalue($_POST["v6"]);
		$db->addfield("v7");							$db->addvalue($_POST["v7"]);
		$db->addfield("v8");							$db->addvalue($_POST["v8"]);
		$db->addfield("v9");							$db->addvalue($_POST["v9"]);
		$db->addfield("v10");							$db->addvalue($_POST["v10"]);
		$db->addfield("v11");							$db->addvalue($_POST["v11"]);
		$db->addfield("v12");							$db->addvalue($_POST["v12"]);
		$db->addfield("v13");							$db->addvalue($_POST["v13"]);
		$db->addfield("v14");							$db->addvalue($_POST["v14"]);
		$db->addfield("v15");							$db->addvalue($_POST["v15"]);
		if($bts_sran_2_2_4["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
?>
<center>2.2.4 External Alarm Test</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>NO</b></td>
					<td><b>ENVA</b></td>
					<td><b>NA/OK/NOK</b></td>
				</tr>
				<tr>
					<td>1</td>
					<td>L1 FAILURE</td>
					<td><?=$f->select("v1",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2</td>
					<td>L2 FAILURE</td>
					<td><?=$f->select("v2",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>3</td>
					<td>L3 FAILURE</td>
					<td><?=$f->select("v3",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v3"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>4</td>
					<td>DOOR OPEN</td>
					<td><?=$f->select("v4",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v4"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>5</td>
					<td>AC REMOVED<br>(not applicable for outdoor site)</td>
					<td><?=$f->select("v5",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v5"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>6</td>
					<td>FENCE BREAK<br>(not applicable for outdoor site)</td>
					<td><?=$f->select("v6",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v6"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>7</td>
					<td>GENSET RUNNING<br>(only applicable for site with Genset)</td>
					<td><?=$f->select("v7",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v7"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>8</td>
					<td>GENSET FAILURE<br>(only applicable for site with Genset)</td>
					<td><?=$f->select("v8",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v8"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>9</td>
					<td>GENSET LOW FUEL<br>(only applicable for site with Genset)</td>
					<td><?=$f->select("v9",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v9"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>10</td>
					<td>RECTIFIER MAIN FAILURE</td>
					<td><?=$f->select("v10",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v10"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>11</td>
					<td>MEDIUM SURGE PROTECTION<br>FAILURE</td>
					<td><?=$f->select("v11",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v11"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>12</td>
					<td>DC HIGH VOLTAGE</td>
					<td><?=$f->select("v12",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v12"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>13</td>
					<td>DC LOW VOLTAGE</td>
					<td><?=$f->select("v13",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v13"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>14</td>
					<td>GROUNDING CABLE CUT</td>
					<td><?=$f->select("v14",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v14"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>15</td>
					<td>INDOOR TEMPARATURE TOO HIGH<br>(only applicable for indoor site)</td>
					<td><?=$f->select("v15",["0"=>"NA","1" => "OK","2" => "NOK"],$bts_sran_2_2_4["v15"], "Xrequired");?></td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
					<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>