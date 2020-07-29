<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$bts_sran_2_1_1 = $db->fetch_all_data("indottech_bts_sran_2_1_1",[],"atd_id='".$atd_id."'")[0];
	
	if(isset($_POST["save"])){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		
		$db->addtable("indottech_bts_sran_2_1_1");
		if($bts_sran_2_1_1["id"] > 0) 				$db->where("id",$bts_sran_2_1_1["id"]);
		$db->addfield("atd_id");					$db->addvalue($atd_id);
		$db->addfield("v1_1");						$db->addvalue($_POST["v1_1"]);
		$db->addfield("v1_2");						$db->addvalue($_POST["v1_2"]);
		$db->addfield("v1_3");						$db->addvalue($_POST["v1_3"]);
		$db->addfield("v1_4");						$db->addvalue($_POST["v1_4"]);
		$db->addfield("v1_5");						$db->addvalue($_POST["v1_5"]);
		$db->addfield("v2_1");						$db->addvalue($_POST["v2_1"]);
		$db->addfield("v2_2");						$db->addvalue($_POST["v2_2"]);
		$db->addfield("v2_3");						$db->addvalue($_POST["v2_3"]);
		$db->addfield("v3_1");						$db->addvalue($_POST["v3_1"]);
		$db->addfield("v3_2");						$db->addvalue($_POST["v3_2"]);
		$db->addfield("v3_3");						$db->addvalue($_POST["v3_3"]);
		$db->addfield("v3_4");						$db->addvalue($_POST["v3_4"]);
		if($bts_sran_2_1_1["id"] > 0) $inserting = $db->update();
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
<center><h4><b>2. EQUIPMENT INSTALLATION & COMMISSIONING RECORD</b></h4></center>
<center><h5><b>2.1 BTS Installation Record</b></h5></center>
<center>2.1.1 BTS Information</center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
<table width="320"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr align="center">
					<td><b>ITEM</b></td>
					<td><b>DESCRIPTION</b></td>
					<td><b>OK/NOK</b></td>
				</tr>
				<tr align="center">
					<td><b>1</b></td>
					<td colspan="2"><b>PREPARATION</b></td>
				</tr>
				<tr>
					<td>1.1</td>
					<td>Delivery checked,<br>any shortcomings are recorded</td>
					<td><?=$f->select("v1_1",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v1_1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.2</td>
					<td>Any damages are recorded</td>
					<td><?=$f->select("v1_2",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v1_2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.3</td>
					<td>Equipment layout checked,<br>as planned</td>
					<td><?=$f->select("v1_3",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v1_3"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.4</td>
					<td>Cabling routes checked</td>
					<td><?=$f->select("v1_4",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v1_4"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>1.5</td>
					<td>Installation of main grounding<br>busbar (connection to building earth) checked</td>
					<td><?=$f->select("v1_5",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v1_5"], "Xrequired");?></td>
				</tr>
				<tr align="center">
					<td><b>2</b></td>
					<td colspan="2"><b>BTS INSTALLATION</b></td>
				</tr>
				<tr>
					<td>2.1</td>
					<td>BTS System module installed<br>and fixed to base frame as plan</td>
					<td><?=$f->select("v2_1",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v2_1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.2</td>
					<td>BTS RF module installed and<br>fixed to bracket at tower leg</td>
					<td><?=$f->select("v2_2",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v2_2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>2.3</td>
					<td>BTS system module and RF<br>module are grounded properly</td>
					<td><?=$f->select("v2_3",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v2_3"], "Xrequired");?></td>
				</tr>
				<tr align="center">
					<td><b>3</b></td>
					<td colspan="2"><b>BTS CABLING</b></td>
				</tr>
				<tr>
					<td>3.1</td>
					<td>Power cables are installed and tidy</td>
					<td><?=$f->select("v3_1",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v3_1"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>3.2</td>
					<td>Optic cables are installed and tidy</td>
					<td><?=$f->select("v3_2",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v3_2"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>3.3</td>
					<td>Alarm cables are installed and tidy</td>
					<td><?=$f->select("v3_3",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v3_3"], "Xrequired");?></td>
				</tr>
				<tr>
					<td>3.4</td>
					<td>All cables are labelling preperly</td>
					<td><?=$f->select("v3_4",[""=>"","1" => "OK","2" => "NOK"],$bts_sran_2_1_1["v3_4"], "Xrequired");?></td>
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