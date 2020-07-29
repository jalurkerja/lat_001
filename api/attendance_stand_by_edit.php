<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "user_info.php";
	
	$attendance_activity = $db->fetch_all_data("attendance_activity",[],"id ='".$_GET["activity_id"]."'")[0];
	$description 	= $f->textarea("description",substr($attendance_activity["description"],18),"style='width:80%;height:80px;'","classinput");
	if(isset($_POST["save"])){
		$_errormessage="";
		if(!$_POST["description"]) $_errormessage = "<p style='color:red'>Saving data failed, Please fill description!</p>";
		if(!preg_match("#^[a-zA-Z0-9 \.,\?_/'!£\$%&*()+=\r\n-]+$#",$_POST["description"])) $_errormessage = "<p style='color:red'>Saving data failed, makesure your input!</p>";
		if ($_errormessage == ""){
			if ($__group_id == 12 || $__group_id == 14){
				$cordinator_mail = $db->fetch_single_data("users","email",["id" => $_POST["cordinator_id"]]);
			} else {
				$cordinator_mail = $_SESSION["username"];
			}
			$db->addtable("attendance_activity");	$db->where("id",$_GET["activity_id"]);
			$db->addfield("attendance_status"); 	$db->addvalue("7");
			$db->addfield("description"); 			$db->addvalue("<b>Stand By - </b>".$_POST["description"]);
			$db->addfield("approved_by"); 			$db->addvalue($cordinator_mail);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				$_SESSION["sow_activity"] = "";
				javascript("alert('Data Saved');");
				javascript("window.location='my_activities.php?token=".$_GET["token"]."';");
			} else {
				javascript("alert('Data failed to save!');");
			}
		}
	}
	if(isset($_POST["save"])){
		$description 	= $f->textarea("description",$_POST["description"],"style='width:80%;height:80px;'","classinput");
		$cordinator		= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
		$cordinator_id 	= $f->select("cordinator_id",$cordinator,$_POST["cordinator_id"],"required style='width:80%'");
	} else {
		$description 	= $f->textarea("description",$attendance_activity["description"],"style='width:80%;height:80px;'","classinput");
		$my_cordinator	= $db->fetch_single_data("users","id",["email" => $attendance_activity["approved_by"].":LIKE"]);
		$cordinator		= $db->fetch_select_data("users","id","concat(name,' - ',email)",["group_id" => "11:IN", "hidden" => "0"],["name"],"",true);
		$cordinator_id 	= $f->select("cordinator_id",$cordinator,$my_cordinator,"required style='width:80%'");
	}
?>

	<center><h4><b>EDIT KEHADIRAN - STAND BY</b></h4></center>
	<center><?=$_errormessage;?></center>
	<br>
	<form method="POST" action="?token=<?=$token;?>&activity_id=<?=$_GET["activity_id"]?>">
		<table id="data_content" width="100%">
			<tr>
				<td style="width:20%">Tanggal</td>
				<td><?=format_tanggal($attendance_activity["created_at"],"d-M-Y");?></td>
			</tr>
			<?php
				if ($__group_id == 12 || $__group_id == 14){
					?>
						<tr>
							<td>Kordinator**</td><td width="50px"><?=$cordinator_id;?></td>
						</tr>
					<?php
				}
			?>
			<tr>
				<td>Deskripsi</td><td><?=$description;?></td>
			</tr>
		</table>
		<br>
		<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"my_activities.php?token=".$token."\";'","btn btn-warning");?></td>
			<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
		</tr></table>
		<p style='font-size:5px'>&emsp;** Kordinator yang menyetujui (Tahap 1)</p>
<?php include_once "footer.php";?>