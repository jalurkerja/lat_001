<?php
	include_once "win_head.php";
	
	$db->addtable($_tablename);
	if($_POST["keyword"] != "") $db->awhere("name LIKE '%".$_POST["keyword"]."%' OR email LIKE '%".$_POST["keyword"]."%' OR pkp_num LIKE '%".$_POST["keyword"]."%' OR pic LIKE '%".$_POST["keyword"]."%'");
	$db->order("name");
	$_data = $db->fetch_data(true);
?>
<script>
	function all_data_update_load(vendor_id,vendor_name,pkp_no,vendor_name){
		parent.document.getElementById("<?=$_GET["name"];?>").value = vendor_id;
		parent.document.getElementById("sw_caption_<?=$_GET["name"];?>").innerHTML = vendor_id;
		parent.document.getElementById("pkp_no").innerHTML = pkp_no;
		parent.document.getElementById("vendor_name").innerHTML = vendor_name
		parent.$.fancybox.close();
	}
</script>
<h3><b><?=$_title;?></b></h3>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
Search : <?=$f->input("keyword",$_POST["keyword"],"size='50'");?>&nbsp;<?=$f->input("search","Load","type='submit'");?>
<?=$f->end();?>
<br>
<?=$t->start("","data_content");?>
<?=$t->header(array("No","PKP Number","Supplier Name","Email","area","pekerjaan","Valid Until"));?>
<?php 
	foreach($_data as $no => $data){
		if($data["valid_until"] <= date("Y-m-d" )){
			$style = "style='font-weight:bold; color:red;'";
		} else {
			$style = "";
		}
		$actions = "onclick=\"all_data_update_load('".$data["id"]."'
													,'".$data["name"]."'
													,'".$data["pkp_num"]."'
													,'".$data["name"]."');\"";
		
		echo $t->row(array($no+1,
							$data["pkp_num"],
							$data["name"],
							$data["email"],
							$data["area"],
							$data["pekerjaan"],
							format_tanggal($data["valid_until"],"d-M-Y")),
					array("align='right' valign='top' ".$actions,
							$actions,
							$actions,
							$actions,
							$actions,
							$actions,
							$actions.$style));
	} 
?>
<?=$t->end();?>