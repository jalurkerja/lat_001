<?php
	include_once "win_head.php";
	$from_wh = $_SESSION["atf_from_wh"];
?>

<h3><b><?=$_title;?></b></h3>

<br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("material_id",$_POST["material_id"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>

<?=$t->start("","data_content");?>
<?=$t->header(array("No","Name","Part Number","Sub Cat 1","Sub Cat 2","Sub Cat 3","Brand","Stock"));?>
<?php
	//material ditampilkan berdasarkan material pada atf in dan sisa > 0
	$no = 1;
	if($_POST["material_id"] != ""){
		$materials = $db->fetch_all_data("materials",[],"name LIKE '%".$_POST["material_id"]."%'","name");
	} else {
		$materials = $db->fetch_all_data("materials",[],"id > 0","name");
	}
		foreach($materials as $material){
			$mat_ids .=$material["id"].",";
		}
		$mat_ids = substr($mat_ids,0,-1);
		$indottech_atf_histories_materials = $db->fetch_all_data("indottech_atf_histories",[],"to_warehouse_id = '".$from_wh."' AND material_id IN (".$mat_ids.") group by material_id","material_id");
		
		foreach($indottech_atf_histories_materials as $mat_no => $material_id){
			$indottech_atf_histories_qtys = $db->fetch_all_data("indottech_atf_histories",[],"to_warehouse_id = '".$from_wh."' AND material_id = '".$material_id["material_id"]."' AND sisa > 0");
			$_mat_qty_in = "";
			foreach($indottech_atf_histories_qtys as $in_no => $mat_qty_in){
				$_mat_qty_in +=$mat_qty_in["sisa"];
			}
			
			$material_stock 	= $_mat_qty_in;
			$material_details 	= $db->fetch_all_data("materials",[],"id = '".$material_id["material_id"]."'")[0];
			$material_unit		= $db->fetch_single_data("material_units","name",["id" => $material_details["unit_id"]]);
			$arr_sub_mode_1		= array("" => "", "1" => "Equipment","2" => "Consumable");
			$arr_sub_mode_2		= array("" => "", "1" => "BTS","2" => "Power", "3" => "Transmission");
			$brand	 			= $db->fetch_single_data("brands","name",["id" => $material_details["brand_id"]]);
			$actions = "style=\"cursor:pointer;\" onclick=\"parent_load('".$_name."','".$material_details["id"]."','".$material_details["name"]."');\"";
			if ($_mat_qty_in > 0){
				echo $t->row([$no++,
							$material_details["name"],
							$material_details["partno"],
							$arr_sub_mode_1[$material_details["sub_mode_1"]],
							$arr_sub_mode_2[$material_details["sub_mode_2"]],
							$db->fetch_single_data("material_sub_category","name",["id" => $material_details["sub_mode_3"]]),
							$brand,
							$material_stock." ".$material_unit,
						],[	"align='right' valign='top' width='3%'".$actions,
							$actions,
							$actions,
							$actions,
							$actions,
							$actions,
							"width='10%'".$actions,
							$actions]);
			}
		}
?>
<?=$t->end();?>