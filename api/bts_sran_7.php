<?php 
	include_once "header.php";
	$atd_id = $_GET["atd_id"];
		
	if(isset($_POST["save"])){
		$db->addtable("indottech_bts_sran_7");
		$db->addfield("atd_id");				$db->addvalue($atd_id);
		$db->addfield("seqno");					$db->addvalue($_POST["seqno"]);
		$db->addfield("description");			$db->addvalue($_POST["description"]);
		$db->addfield("pic");					$db->addvalue($_POST["pic"]);
		$db->addfield("close_at");				$db->addvalue($_POST["close_at"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_errormessage = "<font color='blue'>Data Tersimpan!</font>";
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	if(isset($_POST["edit"])){
		$db->addtable("indottech_bts_sran_7");
		$db->where("id",$_POST["id"]);
		$db->addfield("description");			$db->addvalue($_POST["description"]);
		$db->addfield("pic");					$db->addvalue($_POST["pic"]);
		$db->addfield("close_at");				$db->addvalue($_POST["close_at"]);
		$inserting = $db->update();
		if($inserting["affected_rows"] > 0){
			$_errormessage = "<font color='blue'>Data Tersimpan!</font>";
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	if(isset($_POST["delete"])){
		$db->addtable("indottech_bts_sran_7");
		$db->where("id",$_POST["id"]);
		$db->delete_();
		$bts_sran_7s = $db->fetch_all_data("indottech_bts_sran_7",[],"atd_id='".$atd_id."' AND seqno > '".$_POST["seqno"]."'");
		foreach($bts_sran_7s as $bts_sran_7){
			$db->addtable("indottech_bts_sran_7");	$db->where("id",$bts_sran_7["id"]);
			$db->addfield("seqno");	$db->addvalue($bts_sran_7["seqno"] - 1);
			$updating = $db->update();
		}
	}
	$bts_sran_7s = $db->fetch_all_data("indottech_bts_sran_7",[],"atd_id='".$atd_id."'");
?>
<center><b>7. REMARK</b></center>
<center><?=$_errormessage;?></center>
<table width="320"align="center">
	<tr>
		<td>
			<table border="1">
				<?=$t->row(["<b>No</b>", "<b>Description</b>", "<b>PIC [Company]</b>", "<b>Taret Close</b>",""]);?>
				<?php 
					$no = -1;
					foreach($bts_sran_7s as $no => $bts_sran_7){
						echo "<form method='POST'>";
							echo $f->input("id",$bts_sran_7["id"],"type='hidden'");
							echo $f->input("seqno",$no,"type='hidden'");
							echo $t->row([
								$no+1,
								$f->input("description",$bts_sran_7["description"],"placeholder='Description'","classinput"),
								$f->input("pic",$bts_sran_7["pic"],"placeholder='PIC [Company]'","classinput"),
								$f->input("close_at",$bts_sran_7["close_at"],"type='date'","classinput"),
								$f->input("edit","Save","type='submit'")." ".$f->input("delete","Delete","type='submit'")
							]);
						echo "</form>";
					}
					echo "<form method='POST' action=\"?token=".$token."&atd_id=".$atd_id."\">";
						echo $f->input("seqno",$no+1,"type='hidden'");
						echo $t->row([
							$no+2,
							$f->input("description","","placeholder='Description'","classinput"),
							$f->input("pic","","placeholder='PIC [Company]'","classinput"),
							$f->input("close_at",substr($__now,0,10),"type='date'","classinput"),
							$f->input("save","Save","type='submit'")
						]);
					echo "</form>";
				?>
			</table>
		</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$atd_id."\";'");?></td>
	</tr>
</table>
<script> $("#nbw_no").focus(); </script>
<?php include_once "footer.php";?>