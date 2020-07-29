<?php
	include_once "win_head.php";
	
	if(@$_POST["add"] && @$_POST["newvalue"] != ""){
		$db->addtable($_tablename);
		$db->addfield($_caption_field);$db->addvalue($_POST["newvalue"]);
		$db->addfield("created_at");$db->addvalue(date("Y-m-d H:i:S"));
		$db->addfield("created_by");$db->addvalue($__username);
		$db->addfield("created_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");$db->addvalue(date("Y-m-d H:i:S"));
		$db->addfield("updated_by");$db->addvalue($__username);
		$db->addfield("updated_ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			?> <script> parent_load('<?=$_name;?>','<?=$inserting["insert_id"];?>','<?=$_POST["newvalue"];?>'); </script> <?php
		}
	}
	
	$db->addtable($_tablename);
	$db->addfield($_id_field);
	$db->addfield($_caption_field);
	$db->addfield("email");
	$db->addfield("region_id");
	$db->addfield("job_title");
	$whereclause = "forbidden_chr_dashboards = '6' AND hidden = '0'";
	if(@$_POST["keyword"] != "")
		$whereclause .= " AND (".$_id_field." = '".@$_POST["keyword"]."' OR ".$_caption_field." LIKE '%".@$_POST["keyword"]."%' OR email LIKE '%".@$_POST["keyword"]."%')";
	$db->awhere($whereclause);
	$db->limit(1000);
	$db->order($_caption_field);
	$_data = $db->fetch_data(true);
	
?>
<h3><b><?=$_title;?></b></h3>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",@$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<table id="data_content">
	<tr>
		<th width="5%">No</th>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Position</th>
		<th>Region</th>
	</tr>
	<?php 
		foreach($_data as $no => $data){
			$actions = "onclick=\"parent_load('".$_name."','".$data[$_id_field]."','".$data[$_caption_field]."');\"";
			?>
			<tr <?=$actions;?>>
				<td><?=$no+1;?></td>
				<td><?=$data["id"];?></td>
				<td><?=$data["name"];?></td>
				<td><?=$data["email"];?></td>
				<td><?=$data["job_title"];?></td>
				<td><?=$db->fetch_single_data("indottech_regions","name",["id" => $data["region_id"]]);?></td>
			<?php
			?>
			</tr>
			<?php		
		} 
	?>
</table>
