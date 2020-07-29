<?php
	if(isset($_POST["saving_new"])){
		$db->addtable("warehouses");
			$db->addfield("name");							$db->addvalue($_POST["name"]);
			$db->addfield("address");              			$db->addvalue($_POST["address"]);
			$db->addfield("region_id");						$db->addvalue($_POST["region_id"]);
			$inserting = $db->insert();
			
			
		if($inserting["affected_rows"] >= 0){
			?> <script> parent_load('<?=$_name;?>','<?=$inserting["insert_id"];?>','<?=$_POST["name"];?>'); </script> <?php
		} else {
			?> <script> window.location='?<?=str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]);?>'; </script> <?php
		}
	}
	
	$name = $f->input("name",@$_POST["name"],"required");
	$address = $f->input("address",@$_POST["address"]);
	$area = $f->input("area",@$_POST["area"]);
	$subarea = $f->input("subarea",@$_POST["subarea"]);
	$longitude = $f->input("longitude",@$_POST["longitude"]);
	$latitude = $f->input("latitude",@$_POST["latitude"]);
	$region_id = $f->select("region_id",$db->fetch_select_data("indottech_regions","id","name",["id" => "1,2,3,4,5,13,14,15,16,17,18,19,20,21:IN"],[],"",true),$_GET["region_id"],"style='height:20px;'");
	
?>
<?=$f->start("","POST","?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]));?>
	<?=$t->start("","editor_content");?>
	    <?=$t->row(["Name",$name]);?>
	    <?=$t->row(["Address",$address]);?>
	    <?=$t->row(["Regional",$region_id]);?>
	    <!--<?=$t->row(["Area",$area]);?>
	    <?=$t->row(["Sub Area",$subarea]);?>
	    <?=$t->row(["Longitude",$longitude]);?>
	    <?=$t->row(["Latitute",$latitude]);?>-->
        <?=$t->row(array("&nbsp;"));?>
	<?=$t->end();?>
	<br>
	<?=$f->input("saving_new","Save","type='submit'");?> <?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"])."';\"");?>
<?=$f->end();?>