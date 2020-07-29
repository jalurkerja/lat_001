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
	$back 			=$f->input("","Back","type='button' onclick='window.location=\"sa_add.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-warning");
	$next			= "";
	if(isset($_POST["save"])){
		if(!$id) {
			$db->addtable("indottech_sa");
			$db->addfield("site_id");				$db->addvalue($site_id);
			$inserting = $db->insert();
			$id = $inserting["insert_id"];
		}
		if($inserting["affected_rows"] >= 0){
			$seqno = $db->fetch_single_data("indottech_sa_01","seqno",["sa_id"=>$id],["seqno desc"]);
			foreach($_POST["description"] as $key => $post){
				$db->addtable("indottech_sa_01");
				$db->addfield("sa_id");				$db->addvalue($id);
				$db->addfield("seqno");				$db->addvalue($seqno+1);
				$db->addfield("checklist_id");		$db->addvalue($key);
				$db->addfield("insp_result");		$db->addvalue($_POST["insp_result"][$key]);
				$db->addfield("responsible");		$db->addvalue($_POST["responsible"][$key]);
				$db->addfield("defect_status");		$db->addvalue($_POST["defect"][$key]);
				$db->addfield("description");		$db->addvalue($_POST["description"][$key]);
				$db->insert();
			}
			javascript("window.location=\"?token=".$token."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";");
		}
	}
	
	if($id){
		$next			=$f->input("","Next","type='button' onclick='window.location=\"sa_add_02.php?token=".$_GET["token"]."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-primary");
		$data_sa_01s	=$db->fetch_all_data("indottech_sa_01",[],"sa_id = '".$id."'");
		foreach($data_sa_01s as $data_sa_01){
			$checked_1[$data_sa_01["checklist_id"]] = "";
			$checked_2[$data_sa_01["checklist_id"]] = "";
			if($data_sa_01["insp_result"] == 1){
				$checked_1[$data_sa_01["checklist_id"]] = "checked";
			}
			if($data_sa_01["insp_result"] == 2){
				$checked_2[$data_sa_01["checklist_id"]] = "checked";
			}
			
			$_POST["responsible[".$data_sa_01["checklist_id"]."]"] 	= ""; 		$_POST["responsible[".$data_sa_01["checklist_id"]."]"] 	= $data_sa_01["responsible"];	
			$_POST["defect[".$data_sa_01["checklist_id"]."]"] 		= ""; 		$_POST["defect[".$data_sa_01["checklist_id"]."]"] 		= $data_sa_01["defect_status"];	
			$_POST["description[".$data_sa_01["checklist_id"]."]"] 	= ""; 		$_POST["description[".$data_sa_01["checklist_id"]."]"] 	= $data_sa_01["description"];	
		}
	} else {
		foreach($_POST["insp_result"] as $key => $post){
			$checked_1[$key] = "";
			$checked_2[$key] = "";
			if($post == 1){
				$checked_1[$key] = "checked";
			}
			if($post == 2){
				$checked_2[$key] = "checked";
			}
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
		<tr style="background-color:#adad85;">
			<td style="font-weight:bolder;" align="center">Item<br>number</td>
			<td style="font-weight:bolder;" align="center">Sev.<br>Lv.</td>
			<td style="font-weight:bolder;" align="center">Checklist name</td>
		</tr>
		<?php
			$checklist = $db->fetch_all_data("indottech_checklist",[],"project_id = '29' AND doc_type = 'SA' AND parent_id = '0'");
			$arr_responsible =[""=>"","Subkon"=>"Subkon","Nokia"=>"Nokia","Costumer"=>"Costumer"];
			$arr_defect =[""=>"","Open"=>"Open"];
			foreach($checklist as $list){
				echo "<tr style='background-color:#ccccb3;'><td colspan='3' style='font-weight:bolder;'>".$list["name"]."</td></tr>";
				$list_2 = $db->fetch_all_data("indottech_checklist",[],"parent_id = '".$list["id"]."'");
				$i=0;
				foreach($list_2 as $_list_2){
					$i++;
					echo "<tr style='background-color:#ccccb3;'><td colspan='3'>".$i.". ".$_list_2["name"]."</td></tr>";
					$list_3 = $db->fetch_all_data("indottech_checklist",[],"parent_id = '".$_list_2["id"]."'");
					foreach($list_3 as $_list_3){
						echo "<tr>";
						echo "<td align='center'>".$_list_3["item_number"]."</td>";
						echo "<td align='center'>".$_list_3["sev_lv"]."</td>";
						echo "<td style='font-size:12px; white-space: normal;'>".$_list_3["name"]."</td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td>&nbsp;</td>";
						echo "<td colspan='2'>
								<table width='100%' border='0'>
									<tr>
										<td width='20%'>".
											$f->input("insp_result[".$_list_3["id"]."]","1","style='height:20px;' type='radio' ".$checked_1[$_list_3["id"]])." OK".
											$f->input("insp_result[".$_list_3["id"]."]","2","style='height:20px;' type='radio' ".$checked_2[$_list_3["id"]])." NOK
										</td>
										<td width='35%'>Responsible : ".$f->select("responsible[".$_list_3["id"]."]",$arr_responsible,@$_POST["responsible[".$_list_3["id"]."]"],"style='height:20px;'")."</td>
										<td >Defect : ".$f->select("defect[".$_list_3["id"]."]",$arr_defect,@$_POST["defect[".$_list_3["id"]."]"],"style='height:20px;'")."</td>
									</tr>
									<tr>
										<td colspan='3'>".$f->input("description[".$_list_3["id"]."]",$_POST["description[".$_list_3["id"]."]"],"placeholder='Description' style='height:20px; width:100%;'","classinput")."</td>
									</tr>
								</table>
							</td>";
						echo "</tr>";
					}
				}
				echo "<tr><td colspan='8' style='font-weight:bolder;'>&nbsp;</td></tr>";
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
			document.getElementById("defect[<?=$key;?>]").value = "<?=$_POST["defect"][$key];?>";
			document.getElementById("description[<?=$key;?>]").value = "<?=$_POST["description"][$key];?>";
		</script><?php
	}
?>
<?php include_once "footer.php";?>