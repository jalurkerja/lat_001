<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	$whereclause = "id IN (
						SELECT distinct(candidate_id) FROM all_data_update WHERE 
						(	project_ids LIKE '%|1|%' OR
							project_ids LIKE '%|2|%' OR
							project_ids LIKE '%|3|%' OR
							project_ids LIKE '%|4|%' OR
							project_ids LIKE '%|5|%' OR
							project_ids LIKE '%|6|%' OR
							project_ids LIKE '%|7|%' OR
							project_ids LIKE '%|10|%' OR
							project_ids LIKE '%|20|%' OR
							project_ids LIKE '%|22|%')
					)";
	if($_POST["keyword"] != "") 
		$whereclause .= " AND (".$_id_field." = '".$_POST["keyword"]."' 
			OR ".$_caption_field." LIKE '%".$_POST["keyword"]."%' 
			OR ktp LIKE '%".$_POST["keyword"]."%' 
			OR phone LIKE '%".$_POST["keyword"]."%' 
			OR code LIKE '%".$_POST["keyword"]."%' 
			OR sex LIKE '%".$_POST["keyword"]."%')";
	
	$db->awhere($whereclause);
	$db->limit(1000);
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
<?=$t->header(array("No","Code","Candidate Name","KTP","Sex"));?>
<?php 
	foreach($_data as $no => $data){
		$actions = "onclick=\"parent_load('".$_name."','".$data[$_id_field]."','".$data["code"]."');parent.load_detail_candidate('".$data[$_id_field]."');\"";
		echo $t->row(array($no+1,$data["code"],$data[$_caption_field],$data["ktp"],$data["sex"]),array("align='right' valign='top' ".$actions,"align='right' valign='top' ".$actions,$actions,$actions,$actions));
	} 
?>
<?=$t->end();?>