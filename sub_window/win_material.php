<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") {$db->awhere($_caption_field." LIKE '%".$_POST["keyword"]."%' 
								OR partno LIKE '%".$_POST["keyword"]."%'
								");
	}
	$db->limit($_max_counting);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>
<h3><b><?=$_title;?></b></h3>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","Name","[ID] Part Number","Category","Unit","Brand","Description"));?>
<?php 
	foreach($_data as $no => $data){
		$actions = "style=\"cursor:pointer;\" onclick=\"parent_load('".$_name."','".$data[$_id_field]."','".$data[$_caption_field]." ".$data["tipe"]."');\"";
		$brand	 = $db->fetch_single_data("brands","name",["id" => $data["brand_id"]]);
		$mode				= [""=>"","1" => "Project Material","2" => "Tools"];
		$arr_sub_mode_1		= array("" => "", "1" => "Equipment","2" => "Consumable");
		$arr_sub_mode_2		= array("" => "", "1" => "BTS","2" => "Power", "3" => "Transmission");
		echo $t->row([$no+1,
						$data[$_caption_field],
						"[".$data["id"]."] ".$data["partno"],
						$mode[$data["mode"]],
						// $arr_sub_mode_1[$data["sub_mode_1"]],
						// $arr_sub_mode_2[$data["sub_mode_2"]],
						// $db->fetch_single_data("material_sub_category","name",["id" => $data["sub_mode_3"]]),
						$db->fetch_single_data("material_units","name",["id" => $data["unit_id"]]),
						$brand,
						$data["description"],
					 ],[$actions,
					 $actions,
					 $actions,
					 $actions,
					 $actions,
					 $actions,
					 $actions]);
	} 
?>
<?=$t->end();?>