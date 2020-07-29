<?php
	if(isset($_POST["saving_new"])){
		$errormessage = "";
		$cek_pn = $db->fetch_single_data("materials","id",["partno" => $_POST["partno"]]);
		if($cek_pn > 0) $errormessage = "Penyimpanan Gagal, Part number sudah terdaftar";
		if($errormessage == ""){
			$db->addtable("materials");
			$db->addfield("name");							$db->addvalue($_POST["name"]);
			$db->addfield("mode");							$db->addvalue($_POST["mode"]);
			$db->addfield("sub_mode_1");					$db->addvalue($_POST["sub_mode_1"]);
			$db->addfield("sub_mode_2");					$db->addvalue($_POST["sub_mode_2"]);
			$db->addfield("sub_mode_3");					$db->addvalue($_POST["sub_mode_3"]);
			$db->addfield("unit_id");						$db->addvalue($_POST["unit_id"]);
			$db->addfield("brand_id");						$db->addvalue($_POST["brand_id"]);
			$db->addfield("partno");						$db->addvalue($_POST["partno"]);
			$db->addfield("sn");							$db->addvalue($_POST["sn"]);
			$db->addfield("description");					$db->addvalue($_POST["description"]);;
			$inserting = $db->insert();
			if($inserting["affected_rows"] >= 0){
				?> <script> parent_load('<?=$_name;?>','<?=$inserting["insert_id"];?>','<?=$_POST["name"];?>'); </script> <?php
			} else {
				?> <script> window.location='?<?=str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]);?>'; </script> <?php
			}
		} else {
				?> <script> alert('<?=$errormessage;?>'); </script><?php
		}
	}
	$sn 			= $f->select("sn",["0" => "No","1" => "Yes"],$_POST["sn"],"style='height: 25px; width:52%'");
	$mode 			= $f->select("mode",[""=>"","1" => "Project Material","2" => "Tools"],$_POST["mode"],"style='height: 25px; width:52%' required");
	$sub_mode_1		= $f->select("sub_mode_1",[""=>"","1" => "Equipment","2" => "Consumable"],$_POST["sub_mode_1"],"style='height: 25px; width:52%'");
	$sub_mode_2		= $f->select("sub_mode_2",[""=>"","1" => "BTS","2" => "Power", "3" => "Transmission"],$_POST["sub_mode_2"],"style='height: 25px; width:52%'");
	$_sub_mode_3	= $db->fetch_select_data("material_sub_category","id","name",["id" => "0:!="],["name"],"",true);
	$sub_mode_3		= $f->select("sub_mode_3",$_sub_mode_3,@$_POST["sub_mode_3"],"style='height:25px; width:100%'");
	$name 			= $f->input("name",$_POST["name"],"required");
	$units			= $db->fetch_select_data("material_units","id","concat(name,' - ',description)","",["name"],"",true);
	$unit_id 		= $f->select("unit_id",$units,$_POST["unit_id"],"style='width: 52%; height: 25px' required");
	$brands			= $db->fetch_select_data("brands","id","name","",["name"],"",true);
	$brand_id 		= $f->select("brand_id",$brands,$_POST["brand_id"],"style='width: 52%; height: 25px'");
	$partno 		= $f->input("partno",$_POST["partno"], "");
	$description 	= $f->textarea("description",$_POST["description"]);
?>
<?=$f->start("","POST","?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]));?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["Category",$mode]);?>
		<?=$t->row(["Sub Category 1",$sub_mode_1]);?>
		<?=$t->row(["Sub Category 2",$sub_mode_2]);?>
		<?=$t->row(["Sub Category 3",$sub_mode_3]);?>
		<?=$t->row(["Name",$name]);?>
		<?=$t->row(["Part Number",$partno]);?>
		<?=$t->row(["Unit",$unit_id]);?>
		<?=$t->row(["Brand",$brand_id]);?>
		<?=$t->row(["Have SN",$sn]);?>
		<?=$t->row(["Description",$description]);?>
        <?=$t->row(array("&nbsp;"));?>
	<?=$t->end();?>
	<br>
	
	<?=$f->input("saving_new","Save","type='submit'");?> <?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"])."';\"");?>
	<p style="font-size:11px">Material ATF Berkategori "Project Material" <br> Equipment / Perkakas Berkategori "Tools"</p>
<?=$f->end();?>