<?php 
	include_once "header.php";
	$tssr_id = $_GET["tssr_id"];
	$tssr = $db->fetch_all_data("indottech_tssr_05_los",[],"tssr_id='".$tssr_id."'")[0];
	
	if(isset($_POST["save"])){
		$db->addtable("indottech_tssr_05_los");
		if($tssr["id"] > 0) 					$db->where("tssr_id",$tssr_id);
		$db->addfield("tssr_id");				$db->addvalue($tssr_id);
		$db->addfield("link");					$db->addvalue($_POST["link"]);
		$db->addfield("link_name");				$db->addvalue($_POST["link_name"]);
		$db->addfield("los_req_date");			$db->addvalue($_POST["los_req_date"]);
		$db->addfield("los_date");				$db->addvalue($_POST["los_date"]);
		$db->addfield("los_req_by");			$db->addvalue($_POST["los_req_by"]);
		$db->addfield("link_lenght");			$db->addvalue($_POST["link_lenght"]);
		$db->addfield("los_result");			$db->addvalue($_POST["los_result"]);
		$db->addfield("a_site_id");				$db->addvalue($_POST["a_site_id"]);
		$db->addfield("a_latitude");			$db->addvalue($_POST["a_latitude"]);
		$db->addfield("a_longitude");			$db->addvalue($_POST["a_longitude"]);
		$db->addfield("a_elevation");			$db->addvalue($_POST["a_elevation"]);
		$db->addfield("a_structure_type");		$db->addvalue($_POST["a_structure_type"]);
		$db->addfield("a_structure_height");	$db->addvalue($_POST["a_structure_height"]);
		$db->addfield("a_to_b_azimuth");		$db->addvalue($_POST["a_to_b_azimuth"]);
		$db->addfield("a_height");				$db->addvalue($_POST["a_height"]);
		$db->addfield("a_address");				$db->addvalue($_POST["a_address"]);
		$db->addfield("a_minimum");				$db->addvalue($_POST["a_minimum"]);
		$db->addfield("a_comments");			$db->addvalue($_POST["a_comments"]);
		$db->addfield("a_to_b_comments");		$db->addvalue($_POST["a_to_b_comments"]);
		$db->addfield("b_site_id");				$db->addvalue($_POST["b_site_id"]);
		$db->addfield("b_latitude");			$db->addvalue($_POST["b_latitude"]);
		$db->addfield("b_longitude");			$db->addvalue($_POST["b_longitude"]);
		$db->addfield("b_elevation");			$db->addvalue($_POST["b_elevation"]);
		$db->addfield("b_structure_type");		$db->addvalue($_POST["b_structure_type"]);
		$db->addfield("b_structure_height");	$db->addvalue($_POST["b_structure_height"]);
		$db->addfield("b_to_a_azimuth");		$db->addvalue($_POST["b_to_a_azimuth"]);
		$db->addfield("b_height");				$db->addvalue($_POST["b_height"]);
		$db->addfield("b_address");				$db->addvalue($_POST["b_address"]);
		$db->addfield("b_minimum");				$db->addvalue($_POST["b_minimum"]);
		$db->addfield("b_comments");			$db->addvalue($_POST["b_comments"]);
		$db->addfield("b_to_a_comments");		$db->addvalue($_POST["b_to_a_comments"]);
		if($tssr["id"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("alert('Data berhasil disimpan lanjutkan pada form lainnya');");
			javascript("window.location=\"tssr_new_site_add_05.php?token=".$token."&tssr_id=".$tssr_id."\";");
			exit();
		} else {
			$_errormessage = "<font color='red'>Data gagal disimpan!</font>";
		}
	}
	if($tssr["los_result"] == "1") $los_result = "checked";
	if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-success");
?>

<center><h4><b>Technical Site Survey Report</b></h4></center>
<center><h5><u>Los Report</u></h5></center>
<center><?=$_errormessage;?></center>
<form method="POST" action="?token=<?=$token;?>&tssr_id=<?=$tssr_id;?>">
<table width="100%"align="center">
	<tr>
		<td>
			<br>
			<table align="center" border="1">
				<tr>
					<td>Link</td>
					<td><?=$f->input("link",$tssr["link"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Link Name</td>
					<td><?=$f->input("link_name",$tssr["link_name"],"","classinput");?></td>
				</tr>
				<tr>
					<td>LoS Req. Date</td>
					<td><?=$f->input("los_req_date",$tssr["los_req_date"],"type='date' step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>LoS Date</td>
					<td><?=$f->input("los_date",$tssr["los_date"],"type='date' step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>LoS Req. By</td>
					<td><?=$f->input("los_req_by",$tssr["los_req_by"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Link Length (m)</td>
					<td><?=$f->input("link_lenght",$tssr["link_lenght"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>LoS Result</td>
					<td><?=$f->input("los_result","1","style='height:13px;' type='radio' ".$los_result);?> Visible</td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:5 0 5 0"><b>SITE A</b></td>
				</tr>
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("a_site_id",$db->fetch_single_data("indottech_tssr_01","site_id",["id" => $tssr_id]),"readonly","classinput");?></td>
				</tr>
				<tr>
					<td>Latitude</td>
					<td><?=$f->input("a_latitude",$tssr["a_latitude"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Longitude</td>
					<td><?=$f->input("a_longitude",$tssr["a_longitude"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Elevation</td>
					<td><?=$f->input("a_elevation",$tssr["a_elevation"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Structure Type</td>
					<td><?=$f->input("a_structure_type",$tssr["a_structure_type"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Structure Height</td>
					<td><?=$f->input("a_structure_height",$tssr["a_structure_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth site <br>A toward site B</td>
					<td><?=$f->input("a_to_b_azimuth",$tssr["a_to_b_azimuth"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Building Height</td>
					<td><?=$f->input("a_height",$tssr["a_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><?=$f->textarea("a_address",$tssr["a_address"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Minimum LoS<br>height A</td>
					<td><?=$f->input("a_minimum",$tssr["a_minimum"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Comment</td>
					<td><?=$f->textarea("a_comments",$tssr["a_comments"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Comment on LoS</td>
					<td><?=$f->textarea("a_to_b_comments",$tssr["a_to_b_comments"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td colspan="2" Align="center"Style="padding:5 0 5 0"><b>SITE B</b></td>
				</tr>
				<tr>
					<td>Site ID</td>
					<td><?=$f->input("b_site_id",$tssr["b_site_id"],"","classinput");?></td>
				</tr>
				<tr>
					<td>Latitude</td>
					<td><?=$f->input("b_latitude",$tssr["b_latitude"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Longitude</td>
					<td><?=$f->input("b_longitude",$tssr["b_longitude"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Elevation</td>
					<td><?=$f->input("b_elevation",$tssr["b_elevation"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Structure Type</td>
					<td><?=$f->input("b_structure_type",$tssr["b_structure_type"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Structure Height</td>
					<td><?=$f->input("b_structure_height",$tssr["b_structure_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Azimuth site <br>B toward site A</td>
					<td><?=$f->input("b_to_b_azimuth",$tssr["b_to_b_azimuth"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Building Height</td>
					<td><?=$f->input("b_height",$tssr["b_height"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><?=$f->textarea("b_address",$tssr["b_address"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Minimum LoS<br>height B</td>
					<td><?=$f->input("b_minimum",$tssr["b_minimum"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Comment</td>
					<td><?=$f->textarea("b_comments",$tssr["b_comments"],"step='any'","classinput");?></td>
				</tr>
				<tr>
					<td>Comment on LoS</td>
					<td><?=$f->textarea("b_to_a_comments",$tssr["b_to_a_comments"],"step='any'","classinput");?></td>
				</tr>
			</table>
			<br>
			
			<table width="100%"><tr>
			<td><?=$f->input("back","Back","type='button' onclick='window.location=\"tssr_new_site_add_04.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-warning");?></td>
			<?php if(!$tssr["id"]) { ?>
				<td align="right"><?=$f->input("save","Save","type='submit'","btn btn-primary");?></td>
			<?php } else {?>
				<td><?=$f->input("photo","Photo","type='button' onclick='window.location=\"tssr_new_site_add_photo.php?token=".$token."&tssr_id=".$tssr_id."&page=05\";'","btn btn-success");?></td>
				<td align="center"><?=$f->input("save","Update","type='submit'","btn btn-primary");?></td>
				<td align="right"><?=$f->input("nest","Next","type='button' onclick='window.location=\"tssr_new_site_add_06.php?token=".$token."&tssr_id=".$tssr_id."\";'","btn btn-info");?></td>
			<?php } ?>
			</tr></table>
		</td>
	</tr>
</table>
</form>	
<script> $("#link").focus(); </script>
<?php include_once "footer.php";?>