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
	$back 			=$f->input("","Back","type='button' onclick='window.location=\"hs_add.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";'","btn btn-warning");
	$next			= "";
	
	if(isset($_POST["save"])){
		if(!$id) {
			$db->addtable("indottech_hs");
			$db->addfield("site_id");				$db->addvalue($site_id);
			$inserting = $db->insert();
			$id = $inserting["insert_id"];
		}
		if($inserting["affected_rows"] >= 0){
			$seqno = $db->fetch_single_data("indottech_hs_02","seqno",["hs_id"=>$id],["seqno desc"]);
			foreach($_POST["description"] as $key => $post){
				$db->addtable("indottech_hs_02");
				$db->addfield("hs_id");				$db->addvalue($id);
				$db->addfield("seqno");				$db->addvalue($seqno+1);
				$db->addfield("checklist_id");		$db->addvalue($key);
				$db->addfield("insp_result");		$db->addvalue($_POST["insp_result"][$key]);
				$db->addfield("responsible");		$db->addvalue($_POST["responsible"][$key]);
				$db->addfield("description");		$db->addvalue($_POST["description"][$key]);
				$db->insert();
			}
			javascript("window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";");
		}
	}
	
	if($id){
		$next			=$f->input("","Next","type='button' onclick='window.location=\"hs_add_02.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";'","btn btn-primary");
		$last_seqno		=$db->fetch_single_data("indottech_hs_02","seqno",["hs_id" => $id],["seqno DESC"]);
		$data_hs_02s	=$db->fetch_all_data("indottech_hs_02",[],"hs_id = '".$id."' AND seqno = '".$last_seqno."'");
		foreach($data_hs_02s as $data_hs_02){
			$checked_1[$data_hs_02["checklist_id"]] = "";
			$checked_2[$data_hs_02["checklist_id"]] = "";
			$checked_3[$data_hs_02["checklist_id"]] = "";
			if($data_hs_02["insp_result"] == 1){
				$checked_1[$data_hs_02["checklist_id"]] = "checked";
			}
			if($data_hs_02["insp_result"] == 2){
				$checked_2[$data_hs_02["checklist_id"]] = "checked";
			}
			if($data_hs_02["insp_result"] == 3){
				$checked_3[$data_hs_02["checklist_id"]] = "checked";
			}
			
			$_POST["responsible[".$data_hs_02["checklist_id"]."]"] 	= ""; 		$_POST["responsible[".$data_hs_02["checklist_id"]."]"] 	= $data_hs_02["responsible"];	
			$_POST["description[".$data_hs_02["checklist_id"]."]"] 	= ""; 		$_POST["description[".$data_hs_02["checklist_id"]."]"] 	= $data_hs_02["description"];	
		}
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
	<table width="100%" align="center" style="color:black;" border="1" rules="all" id="data_content">
		<tr>
			<td align="center" style="font-weight: bolder; background-color: #ccccb3;" class="tdbreak">Nmr IPM</td>
			<td align="center" style="font-weight: bolder; background-color: #ccccb3;" >Daftar Periksa</td>
			<td align="center" style="font-weight: bolder; background-color: #ccccb3;" valign="middle" class="tdbreak">Sev. Lv</td>
		</tr>
		<?php
			$hs_checklist = $db->fetch_all_data("indottech_checklist",[],"project_id = '29' and parent_id = '0' AND doc_type = 'HS'");
			foreach($hs_checklist as $key => $data){
				?>
				<tr>
					<td align="center" style="background-color: #ccccb3;"><?=$data["item_number"];?></td>
					<td style="background-color: #ccccb3; font-size:12px;" class="tdbreak"><?=$data["name"];?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
				$sub_checklist = $db->fetch_all_data("indottech_checklist",[],"project_id = '29' and parent_id = '".$data["id"]."'");
				$arr_responsible =[""=>"","NS"=>"NS","NSN"=>"NSN","Cust"=>"Cust"];
				foreach($sub_checklist as $_key => $_data){
					?>
					<tr>
						<td align="center" ><?=$_data["item_number"];?></td>
						<td class="tdbreak" style="font-size:12px;"><?=$_data["name"];?></td>
						<td align="center" ><?=$_data["sev_lv"];?></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">
							<table  width="100%" style="font-size:12px; color:black;">
								<tr>
									<td width="40%">
										<?=$f->input("insp_result[".$_data["id"]."]","1","style='height:20px;' type='radio' ".$checked_1[$_data["id"]])." OK";?>
										<?=$f->input("insp_result[".$_data["id"]."]","2","style='height:20px;' type='radio' ".$checked_2[$_data["id"]])." NOK";?>
										<?=$f->input("insp_result[".$_data["id"]."]","3","style='height:20px;' type='radio' ".$checked_3[$_data["id"]])." N/A";?>
									</td>
									<td>
										Responsible : <?=$f->select("responsible[".$_data["id"]."]",$arr_responsible,@$_POST["responsible[".$_data["id"]."]"],"style='height:20px; width:100px;'");?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<?=$f->input("description[".$_data["id"]."]",$_POST["description[".$_data["id"]."]"],"placeholder='Description' style='height:20px; width:100%;'","classinput");?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<?php
				}
			}
		?>
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
<?php include_once "footer.php";?>