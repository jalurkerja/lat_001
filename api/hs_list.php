<?php include_once "header.php";?>

<style>
	body{
		font-size:2vw !important;
	}
</style>

<table width="100%">
	<tr>
		<td align="left" style="font-weight:bolder;">Health &amp; Safety Site Inspection Self Assessment Form</td>
	</tr>
	<tr>
		<td align="left" style="font-style:italic;"><?php if($_GET["is_project"]){
				echo "Project ".$db->fetch_single_data("indottech_projects","name",["id" => $_GET["is_project"]]);
			};?></td>
	</tr>
</table>

<?php
	$sel_project = false;
	if($_GET["is_project"]){$is_project = $_GET["is_project"];} else {
		$sel_project = true;
	}
	if($sel_project){
		echo $f->start("filter","GET");
		echo "Project : ".$f->select("is_project",["" => "", "17" => "Indosat"],@$_GET["is_project"],"style='height:25px; width:100%'");
		echo $f->input("token",@$_GET["token"],"type='hidden'");
		echo "<br>".$f->input("do_filter","Select","type='submit' style='margin-top:5px; width:100px;'", "btn btn-primary");
		echo $f->end();
	} else {
?>
	<form method="GET">
		<input type="hidden" name="token" value="<?=$_GET["token"];?>">
		<input type="hidden" name="is_project" value="<?=$_GET["is_project"];?>">
		<table style="margin-top:5;">
			<tr><td id="filter"><u><span>Filter </span><span id="icon">+</span></u></td></tr>
		</table>
		
		<table id="filter_table" style="display:none;">
			<?=$t->row(["Site Name",$f->input("site_name",$_GET["site_name"])]);?>
			<?=$t->row(["Site Code",$f->input("site_code",$_GET["site_code"])]);?>
			<?=$t->row(["WP ID",$f->input("wp_id",$_GET["wp_id"])]);?>
			<?=$t->row(["Inspection Date",$f->input("inspection_date_1",$_GET["inspection_date_1"],"type='date'")." - ".$f->input("inspection_date_2",$_GET["inspection_date_2"],"type='date'")]);?>
			<tr><td colspan="2">
				<?=$f->input("search","Search","type='submit'","btn btn-info");?>&nbsp;
				<?=$f->input("","Reset","type='button' onclick='window.location=\"?token=".$_GET["token"]."&is_project=".$is_project."\";'","btn btn-warning");?>
			</td></tr>
		</table>
	</form>	
	
	<?php
		$start_date	= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-31,date("Y")));
		$end_date	= date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
		$whereclause = "";
		$whereclause .= "project_id = '".$is_project."' AND created_by = '".$__username."' AND ";
		if($_GET["site_name"] != "") {
			$whereclause .= "(site_name LIKE '%".$_GET["site_name"]."%') AND ";
		}
		if($_GET["site_code"] != "") {
			$whereclause .= "(site_code LIKE '%".$_GET["site_code"]."%') AND ";
		}
		if($_GET["wp_id"] != "") {
			$whereclause .= "(wp_id LIKE '%".$_GET["wp_id"]."%') AND ";
		}
		if($_GET["inspection_date_1"] != "" && $_GET["inspection_date_2"] != "") {
			$whereclause .= "(inspection_date BETWEEN '".date("Y-m-d 00:00:00",strtotime($_GET["inspection_date_1"]))."' AND '".date("Y-m-d 23:59:59",strtotime($_GET["inspection_date_2"]))."') AND ";
		} else {
			$whereclause .= "(created_at BETWEEN '".$start_date."' AND '".$end_date."') AND ";
		}
			
		$db->addtable("indottech_hs_01");
		$db->awhere(substr($whereclause,0,-4));
		$db->order("created_at DESC");
		$indottech_hs_01 = $db->fetch_data(true);
		if($__group_id == 0) echo $f->input("Reload","Reload","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-success");
	?>

	<?=$f->input("","Add","type='button' onclick='window.location=\"".str_replace("_list","_add",$_SERVER["PHP_SELF"])."?token=".$_GET["token"]."&is_project=".$_GET["is_project"]."\";'","btn btn-primary");?>&ensp;
	<br>
	<div style="overflow-x:auto;">
		<table width="100%" align="center" id="data_content">
			<tr>
				<th nowrap width="3%">No</th>
				<th nowrap>Inspection Date</th>
				<th nowrap>Site Name</th>
				<th nowrap>Site Code</th>
				<th nowrap>WP ID</th>
				<th nowrap>Created At</th>
			</tr>
			<?php
				$no = 1;
				foreach($indottech_hs_01 as $data){
					$onclick = "onclick=\"window.location='".str_replace("_list","_add",$_SERVER["PHP_SELF"])."?token=".$token."&is_project=".$is_project."&id=".$data["id"]."';\"";
					?>
					<tr <?=$onclick;?>>
						<td nowrap align="right"><?=$no++;?></td>	
						<td nowrap><?=format_tanggal($data["inspection_date"],"Y M d");?></td>
						<td nowrap><?=$data["site_name"];?></td>
						<td nowrap><?=$data["site_code"];?></td>
						<td nowrap><?=$data["wp_id"];?></td>
						<td nowrap align="right"><?=format_tanggal($data["created_at"],"Y M d");?></td>
					</tr>
					<?php
				}
			?>
		</table>
	</div>
	
	<script>
		$(document).ready(function(){
		  $("#filter").click(function(){
			$("#filter_table").toggle();
			var icon = document.getElementById("icon").innerHTML;
			if(icon == "-"){
				document.getElementById("icon").innerHTML = "+";
			} else {
				document.getElementById("icon").innerHTML = "-";
			}
		  });
		});
	</script>

<?php 
	}
	
	include_once "footer.php";
?>