<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") $db->awhere(
										"kode LIKE '%".$_POST["keyword"]."%'
										OR name LIKE '%".$_POST["keyword"]."%'"
									);
	$db->limit($_max_counting);
	$db->order("kode");
	$_data = $db->fetch_data(true);
?>
<script>
	function parent_load(site_id,site_name){
		parent.document.getElementById("<?=$_GET["name"];?>").value = site_id;
		parent.document.getElementById("sw_caption_<?=$_GET["name"];?>").innerHTML = site_name;		
		parent.$.fancybox.close();
	}
</script>
<h3><b><?=$_title;?></b></h3>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>&nbsp;<?=$f->input("reset","Remove Selected Site","type='Reset' onclick=\"parent_load('".$data["id"]."','','');\"");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","Site ID","Site Code","Name","Region"));?>
<?php 
	foreach($_data as $no => $data){
		$region_name = $db->fetch_single_data("indottech_regions","name",["id" => $data["region_id"]]);
		$actions = "onclick=\"parent_load('".$data["id"]."','[".$data["kode"]."] ".$data["name"]."');\"";
		echo $t->row(array($no+1,$data["id"],$data["kode"],$data["name"],$region_name),array("align='right' valign='top' ".$actions,"valign='top' ".$actions,"valign='top' ".$actions,"valign='top' nowrap ".$actions));
	} 
?>
<?=$t->end();?>