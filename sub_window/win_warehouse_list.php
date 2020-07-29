<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") $db->awhere(
								$_id_field." = '".$_POST["keyword"]."' 
								OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%' 
								OR ".address." LIKE '%".$_POST["keyword"]."%' 
						");
	$db->limit(1000);
	$db->order($_id_field);
	$_data = $db->fetch_data(true);
?>
<h3><b><?=$_title;?></b></h3>
<?php
	if($_GET["addnew"]==1 || isset($_POST["saving_new"])){
		include_once "win_warehouse_add.php";
	} else {
		echo $f->input("addnew","Add New Warehouse","type='button' onclick=\"window.location='?addnew=1&".$_SERVER["QUERY_STRING"]."';\"");
		echo "&nbsp;";
		echo $f->input("reset","Remove Selected WH","type='Reset' onclick=\"parent_load('".$_name."','','');\"");
	}
?>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","Name","Address","Region"));?>
<?php 
	foreach($_data as $no => $data){
		$region_name = $db->fetch_single_data("indottech_regions","name",["id" => $data["region_id"]]);
		$actions = "style=\"cursor:pointer;\" onclick=\"parent_load('".$_name."','".$data[$_id_field]."','".$data[$_caption_field]."');\"";
		echo $t->row([$no+1,
						$data[$_caption_field],
						$data["address"],
						$region_name,
						// $data["area"],
						// $data["subarea"],
						// $data["longitude"],
						// $data["latitude"],
					],[	"align='right' valign='top' ".$actions,
						$actions,
						// $actions,
						// $actions,
						// $actions,
						$actions]);
	} 
?>
<?=$t->end();?>