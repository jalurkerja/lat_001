<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	// $whereclause = ("id IN (1,2,3,4,5,13,14,15,16,17,18,19,20)");
	$not_ids = [11,12];
	$non = "";
	foreach($not_ids as $not_id){
		$non .= "id != '".$not_id."' AND ";
	}
	$non=substr($non,0,-4);
	
	$whereclause = "(".$non.") AND hidden = 0";
	if(@$_POST["keyword"] != "") $whereclause .=(" AND (name LIKE '%".$_POST["keyword"]."%' OR initial LIKE '%".$_POST["keyword"]."%')");
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order("initial ASC");
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
Search : <?=$f->input("keyword",@$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","Initial","Name"));?>
<?php 
	foreach($_data as $no => $data){
		$actions = "onclick=\"parent_load('".$data["id"]."','".$data["name"]."');\"";
		echo $t->row(array($no+1,$data["initial"],$data["name"]),array("align='right' valign='top' ".$actions,"valign='top' ".$actions,"valign='top' ".$actions));
	} 
?>
<?=$t->end();?> 