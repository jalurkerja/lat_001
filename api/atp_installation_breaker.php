<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
	$breakers = $db->fetch_all_data("indottech_breakers",[],"atd_id='".$atd_id."'");
	
	$breaker_types[0] = "Priority Load";
	$breaker_types[1] = "Non Priority Load";
	$breaker_types[2] = "ACPDB Load (Indoor)";
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_breakers"); $db->where("atd_id",$atd_id); $db->delete_();
		$is_any_failed = 0;
		foreach($_POST["capacity"] as $seqno => $capacity){
			$db->addtable("indottech_breakers");
			$db->addfield("atd_id");		$db->addvalue($atd_id);
			$db->addfield("seqno");			$db->addvalue($seqno);
			$db->addfield("breaker_type");	$db->addvalue($breaker_types[$seqno]);
			$db->addfield("breaker_no");	$db->addvalue($seqno);
			$db->addfield("capacity");		$db->addvalue($capacity);
			$db->addfield("qty");			$db->addvalue($_POST["qty"][$seqno]);
			$db->addfield("name");			$db->addvalue($_POST["name"][$seqno]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] <= 0) $is_any_failed++;
		}
		
		if($is_any_failed == 0){
			javascript("alert('Data berhasil disimpan');");
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
?>
<center><h4><b>BREAKERS</b></h4></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&atd_id=<?=$atd_id;?>">
	<table id="data_content">
		<tr>
			<th>Breaker Number</th>
			<th>Kapasitas</th>
			<th>Qty</th>
			<th>Nama Equipment</th>
		</tr>
		<?php for($xx = 0;$xx < 3;$xx++){ ?>
			<tr>
				<td><?=$breaker_types[$xx];?></td>
				<td><?=$f->input("capacity[".$xx."]",$breakers[$xx]["capacity"],"","classinput");?></td>
				<td><?=$f->input("qty[".$xx."]",$breakers[$xx]["qty"],"","classinput");?></td>
				<td><?=$f->input("name[".$xx."]",$breakers[$xx]["name"],"","classinput");?></td>
			</tr>
			<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
		<?php } ?>
	<table>
	<br>
	<table width="100%"><tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
		<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
	</tr></table>
</form>	
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>