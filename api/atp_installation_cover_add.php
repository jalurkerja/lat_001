<?php 
	include_once "header.php";
	if(isset($_POST["save"])){
		$worktype_ids = "|".$_POST["worktype_id"]."|";
		$site_name = $db->fetch_single_data("indottech_sites","concat(name,' [',site_code,']')",["id" => $_POST["site_id"]]);
		
		$db->addtable("indottech_atd_cover");
		$db->addfield("doctype");			$db->addvalue($_GET["doctype"]);
		$db->addfield("worktype_ids");		$db->addvalue($worktype_ids);
		$db->addfield("vendor");			$db->addvalue($_POST["vendor"]);
		$db->addfield("project_name");		$db->addvalue($_POST["project_name"]);
		$db->addfield("customer");			$db->addvalue($_POST["customer"]);
		$db->addfield("site_id");			$db->addvalue($_POST["site_id"]);
		$db->addfield("site_name");			$db->addvalue($site_name);
		$db->addfield("acceptance_at");		$db->addvalue($_POST["acceptance_at"]);
		$db->addfield("acceptance_status");	$db->addvalue($_POST["acceptance_status"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("window.location=\"atp_installation_menu.php?token=".$token."&atd_id=".$inserting["insert_id"]."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	
	if($_GET["doctype"] == "rectifier"){ $checked[3] = "checked"; 	}
	$sites = $db->fetch_select_data("indottech_sites","id","concat(name,' [',site_code,']')",["project_id" => "13"],["name"],"",true);
?>
	<center><h4><b>ACCEPTANCE TEST DOCUMENT</b></h4></center>
	<center><?=$_errormessage;?></center>
	<form method="POST" action="?token=<?=$token;?>&doctype=<?=$_GET["doctype"];?>">
		<table width="100%" cellpadding="0" cellspacing="0"><tr><td align="center">
			<table>
				<tr><td><?=$f->input("worktype_id","1","style='height:13px;' type='radio' required ".$checked[1]);?> - CIVIL WORK & INSTALLATION</td></tr>
				<tr><td><?=$f->input("worktype_id","2","style='height:13px;' type='radio' required ".$checked[2]);?> - RADIO BASE STATION</td></tr>
				<tr><td><?=$f->input("worktype_id","3","style='height:13px;' type='radio' required ".$checked[3]);?> - RECTIFIER</td></tr>
			</table>
		</td></tr></table>
		<br>
		<table>
			<tr><td>VENDOR</td><td>:</td><td><?=$f->input("vendor","PT ALITA","required","classinput");?></td></tr>
			<tr><td nowrap>PROJECT NAME</td><td>:</td><td><?=$f->input("project_name","","required","classinput");?></td></tr>
			<tr><td>CUSTOMER</td><td>:</td><td><?=$f->input("customer","","","classinput");?></td></tr>
			<tr><td>SITE</td><td>:</td><td><?=$f->select("site_id",$sites,"","required","classinput");?></td></tr>
			<tr><td>ACCEPTANCE</td><td>:</td><td><?=$f->input("acceptance_at",date("Y-m-d"),"type='date'");?></td></tr>
			<tr><td>STATUS</td><td>:</td><td><?=$f->select("acceptance_status",[""=>"","1" => "PASS, NO PENDING ITEMS","2" => "PASS WITH PENDING ITEMS","3" => "REJECTED BY XL AXIATA",],"","","classinput");?></td></tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"atp_installation.php?token=".$token."\";'");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'");?></td>
		</tr></table>
	</form>
<?php include_once "footer.php";?>