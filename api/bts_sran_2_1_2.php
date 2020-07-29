<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_1_2 = $db->fetch_all_data("indottech_bts_sran_2_1_2",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_1_2");
		if($bts_sran_2_1_2["id"] > 0) 				$db->where("id",$bts_sran_2_1_2["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("v1_1");						$db->addvalue($_POST["v1_1"]);
		$db->addfield("v1_2");						$db->addvalue($_POST["v1_2"]);
		$db->addfield("v1_3");						$db->addvalue($_POST["v1_3"]);
		$db->addfield("v1_4");						$db->addvalue($_POST["v1_4"]);
		$db->addfield("v1_5");						$db->addvalue($_POST["v1_5"]);
		$db->addfield("v2_1");						$db->addvalue($_POST["v2_1"]);
		$db->addfield("v2_2");						$db->addvalue($_POST["v2_2"]);
		$db->addfield("v2_3");						$db->addvalue($_POST["v2_3"]);
		$db->addfield("v2_4");						$db->addvalue($_POST["v2_4"]);
		$db->addfield("v2_5");						$db->addvalue($_POST["v2_5"]);
		$db->addfield("v2_6");						$db->addvalue($_POST["v2_6"]);
		if($bts_sran_2_1_2["id"] > 0) $inserting = $db->update();
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
<center>2.1.2 Antenna Line Information</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>ITEM</b></td>
					<td><b>DESCRIPTION</b></td>
					<td><b>OK/NOK</b></td>
				</tr>
				<tr>
					<td><b>1</b></td>
					<td><b>PREPARATION</b></td>
					<td></td>
				</tr>
				<tr>
					<td>1.1</td>
					<td>Delivery checked,<br>any shortcomings are recorded</td>
					<td><?=$f->select("v1_1",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v1_1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.2</td>
					<td>Any damages are recorded</td>
					<td><?=$f->select("v1_2",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v1_2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.3</td>
					<td>Equipment layout checked,<br>differences to the drawings recorded</td>
					<td><?=$f->select("v1_3",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v1_3"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.4</td>
					<td>Cabling routes checked,<br>cable trays & ladders installed</td>
					<td><?=$f->select("v1_4",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v1_4"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.5</td>
					<td>Antenna tower/pole grounding checked</td>
					<td><?=$f->select("v1_5",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v1_5"], "Xrequired");?></td>
				</tr>
				<tr align="center">
					<td><b>2</b></td>
					<td><b>ANTENNA INSTALLATION</b></td>
					<td></td>
				</tr>
				<tr>
					<td>2.1</td>
					<td>Antenna mounted according<br>to Site Specific Documents</td>
					<td><?=$f->select("v2_1",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.2</td>
					<td>Mounting height checked according<br>to Final Site Configuration</td>
					<td><?=$f->select("v2_2",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.3</td>
					<td>Antenna direction checked according<br>to Final Site Configuration</td>
					<td><?=$f->select("v2_3",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_3"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.4</td>
					<td>Mechanical tilting angle checked<br>according to Final Site Configuration</td>
					<td><?=$f->select("v2_4",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_4"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.5</td>
					<td>Electrical tilting angle checked<br>according to Final Site Configuration</td>
					<td><?=$f->select("v2_5",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_5"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.6</td>
					<td>Antenna mounting clamps checked,<br>all screws tightened</td>
					<td><?=$f->select("v2_6",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_2["v2_6"], "Xrequired");?></td>
				</tr>
			</table>
				<br>
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