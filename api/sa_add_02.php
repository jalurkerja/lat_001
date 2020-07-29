<?php include_once "header.php";?>
<?php 
	if($_GET["id"]){
		$id = $_GET["id"];
		$indottech_sa 	= $db->fetch_all_data("indottech_sa",[],"id='".$id."'")[0];
		$site_id		= $indottech_sa["site_id"];
	} else {
		$site_id	= $_GET["site_id"];
		$id 		= $db->fetch_single_data("indottech_sa","id",["site_id"=>$site_id]);
	}
	$site_details 	= $db->fetch_all_data("indottech_sites",[],"id='".$site_id."'")[0];
	$site_kode_name = str_replace(" ","_",$site_details["kode"]."_".$site_details["name"]);
	$back 			=$f->input("","Back","type='button' onclick='window.location=\"sa_add_01.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-warning");
	$next			= "";
	if(isset($_POST["save"])){
		$seqno = $db->fetch_single_data("indottech_sa_02","seqno",["sa_id"=>$id],["seqno desc"]);
		foreach($_POST["ant_type_before"] as $key => $ant_type_before){
			$db->addtable("indottech_sa_02");
			$db->addfield("sa_id");				$db->addvalue($id);
			$db->addfield("seqno");				$db->addvalue($seqno+1);
			$db->addfield("sector");			$db->addvalue($key);
			$db->addfield("ant_type_before");	$db->addvalue($_POST["ant_type_before"][$key]);
			$db->addfield("ant_type_after");	$db->addvalue($_POST["ant_type_after"][$key]);
			$db->addfield("ant_height_before");	$db->addvalue($_POST["ant_height_before"][$key]);
			$db->addfield("ant_height_after");	$db->addvalue($_POST["ant_height_after"][$key]);
			$db->addfield("azimuth_before");	$db->addvalue($_POST["azimuth_before"][$key]);
			$db->addfield("azimuth_after");		$db->addvalue($_POST["azimuth_after"][$key]);
			$db->addfield("mech_before");		$db->addvalue($_POST["mech_before"][$key]);
			$db->addfield("mech_after");		$db->addvalue($_POST["mech_after"][$key]);
			$db->addfield("elect_before");		$db->addvalue($_POST["elect_before"][$key]);
			$db->addfield("elect_after18");		$db->addvalue($_POST["elect_after18"][$key]);
			$db->addfield("elect_after21");		$db->addvalue($_POST["elect_after21"][$key]);
			$inserting = $db->insert();
		}
		javascript("window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";");
	}
	
	if($id){
		$next			= $f->input("","Next","type='button' onclick='window.location=\"sa_add_03.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-primary");
		
		$seqno 			= $db->fetch_single_data("indottech_sa_02","seqno",["sa_id"=>$id],["seqno desc"]);
		$master			= $db->fetch_all_data("indottech_sa_02",[],"sa_id = '".$id."' AND seqno = '".$seqno."'");
		foreach($master as $key => $row_data){
			$data["ant_type_before"][$key] 		= "";	$data["ant_type_before"][$key] 		= $row_data["ant_type_before"]; 	
			$data["ant_type_after"][$key] 		= "";	$data["ant_type_after"][$key] 		= $row_data["ant_type_after"]; 	
			$data["ant_height_before"][$key] 	= "";	$data["ant_height_before"][$key] 	= $row_data["ant_height_before"]; 	
			$data["ant_height_after"][$key] 	= "";	$data["ant_height_after"][$key] 	= $row_data["ant_height_after"]; 	
			$data["azimuth_before"][$key] 		= "";	$data["azimuth_before"][$key] 		= $row_data["azimuth_before"]; 	
			$data["azimuth_after"][$key] 		= "";	$data["azimuth_after"][$key] 		= $row_data["azimuth_after"]; 	
			$data["mech_before"][$key] 			= "";	$data["mech_before"][$key] 			= $row_data["mech_before"]; 	
			$data["mech_after"][$key] 			= "";	$data["mech_after"][$key] 			= $row_data["mech_after"]; 	
			$data["elect_before"][$key] 		= "";	$data["elect_before"][$key] 		= $row_data["elect_before"]; 	
			$data["elect_after18"][$key] 		= "";	$data["elect_after18"][$key] 		= $row_data["elect_after18"]; 	
			$data["elect_after21"][$key] 		= "";	$data["elect_after21"][$key] 		= $row_data["elect_after21"]; 	
		}
	}
		$save		=$f->input("save","Save","type='submit'","btn btn-success");

?>
<table width="100%">
	<tr>
		<td width="50%" align="left"><?=$back;?></td>
		<td width="50%" align="right"><?=$next;?></td>
	</tr>
	<tr>
		<td colspan="2">Site : <?=$site_kode_name;?></td>
	</tr>
</table>

<form method="POST" action="?token=<?=$token;?>&site_id=<?=$site_id;?>&id=<?=$id;?>&mode=sa&user_id=<?=$__user_id;?>">
	<table width="100%" cellspacing="0" border="1" rules="all" id="data_content">
		<?php for($i=0; $i<=2; $i++){?>
			<tr>
				<td colspan="2" align="center" style="background-color:#1a75ff; color:white; font-size:12px;"><b>Sector <?=$i;?></b></td>
			</tr>
			<tr>
				<td colspan="2" align="Left"><b>&emsp;Antenna Type</b></td>
			</tr>
				<tr>
					<td >Before</td><td>: <?=$f->input("ant_type_before[".$i."]",$data["ant_type_before"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After </td><td>: <?=$f->input("ant_type_after[".$i."]",$data["ant_type_after"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
			<tr>
				<td colspan="2" align="Left"><b>&emsp;Antenna Height</b></td>
			</tr>
				<tr>
					<td >Before</td><td>: <?=$f->input("ant_height_before[".$i."]",$data["ant_height_before"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After </td><td>: <?=$f->input("ant_height_after[".$i."]",$data["ant_height_after"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
			<tr>
				<td colspan="2" align="Left"><b>&emsp;Azimuth</b></td>
			</tr>
				<tr>
					<td >Before</td><td>: <?=$f->input("azimuth_before[".$i."]",$data["azimuth_before"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After </td><td>: <?=$f->input("azimuth_after[".$i."]",$data["azimuth_after"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
			<tr>
				<td colspan="2" align="Left"><b>&emsp;Mech. Tilt</b></td>
			</tr>
				<tr>
					<td >Before</td><td>: <?=$f->input("mech_before[".$i."]",$data["mech_before"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After </td><td>: <?=$f->input("mech_after[".$i."]",$data["mech_after"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
			<tr>
				<td colspan="2" align="Left"><b>&emsp;Elect. Tilt</b></td>
			</tr>
				<tr>
					<td >Before</td><td>: <?=$f->input("elect_before[".$i."]",$data["elect_before"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After 1800</td><td>: <?=$f->input("elect_after18[".$i."]",$data["elect_after18"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
				<tr>
					<td >After 2100</td><td>: <?=$f->input("elect_after21[".$i."]",$data["elect_after21"][$i],"style='width:90%;'","classinput");?></td>
				</tr>
		<?php } ?>
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
	foreach($_POST["ant_type_before"] as $key => $ant_type_before){
		?><script>
			document.getElementById("ant_type_before[<?=$key;?>]").value = "<?=$ant_type_before;?>";
			document.getElementById("ant_type_after[<?=$key;?>]").value = "<?=$_POST["ant_type_after"][$key];?>";
			document.getElementById("ant_height_before[<?=$key;?>]").value = "<?=$_POST["ant_height_before"][$key];?>";
			document.getElementById("ant_height_after[<?=$key;?>]").value = "<?=$_POST["ant_height_after"][$key];?>";
			document.getElementById("azimuth_before[<?=$key;?>]").value = "<?=$_POST["azimuth_before"][$key];?>";
			document.getElementById("azimuth_after[<?=$key;?>]").value = "<?=$_POST["azimuth_after"][$key];?>";
			document.getElementById("mech_before[<?=$key;?>]").value = "<?=$_POST["mech_before"][$key];?>";
			document.getElementById("mech_after[<?=$key;?>]").value = "<?=$_POST["mech_after"][$key];?>";
			document.getElementById("elect_before[<?=$key;?>]").value = "<?=$_POST["elect_before"][$key];?>";
			document.getElementById("elect_after18[<?=$key;?>]").value = "<?=$_POST["elect_after18"][$key];?>";
			document.getElementById("elect_after21[<?=$key;?>]").value = "<?=$_POST["elect_after21"][$key];?>";
		</script><?php
	}
?>
<?php include_once "footer.php";?>