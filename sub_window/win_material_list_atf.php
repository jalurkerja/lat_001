<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") {$db->awhere("mode = 1 AND ("
								.$_caption_field." LIKE '%".$_POST["keyword"]."%' 
								OR partno LIKE '%".$_POST["keyword"]."%')
								");
	} else {$db->awhere("mode= 1");}
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
?>
<h3><b><?=$_title;?></b></h3>
<?php
	if($_GET["addnew"]==1 || isset($_POST["saving_new"])){
		include_once "win_material_add.php";
	} else {
		echo $f->input("addnew","Add New Material","type='button' onclick=\"window.location='?addnew=1&".$_SERVER["QUERY_STRING"]."';\"");
	}
	
	
?>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","Name","Part Number","Sub Cat 1","Sub Cat 2","Sub Cat 3","Unit","Brand"));?>
<?php 
	foreach($_data as $no => $data){
		$actions = "style=\"cursor:pointer;\" onclick=\"parent_load('".$_name."','".$data[$_id_field]."','".$data[$_caption_field]."');\"";
		$brand	 = $db->fetch_single_data("brands","name",["id" => $data["brand_id"]]);
		$arr_sub_mode_1		= array("" => "", "1" => "Equipment","2" => "Consumable");
		$arr_sub_mode_2		= array("" => "", "1" => "BTS","2" => "Power", "3" => "Transmission");
		?>
		<tr <?=$actions;?>>
			<td nowrap><?=$no+1;?></td>
			<td nowrap><?=$data[$_caption_field];?></td>
			<td nowrap><?=$data["partno"];?></td>
			<td nowrap><?=$arr_sub_mode_1[$data["sub_mode_1"]];?></td>
			<td nowrap><?=$arr_sub_mode_2[$data["sub_mode_2"]];?></td>
			<td nowrap><?=$db->fetch_single_data("material_sub_category","name",["id" => $data["sub_mode_3"]]);?></td>
			<td nowrap><?=$db->fetch_single_data("material_units","name",["id" => $data["unit_id"]]);?></td>
			<td nowrap><?=$brand;?></td>
		</tr>
		<?php
	} 
?>
<?=$t->end();?>