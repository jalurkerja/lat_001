<?php
	include_once "../common.php"; 
	
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	///start loadSelectRef///
	$master_data = "";
	if($_mode == "loadSelectRef"){
		$keyword = "%".str_replace(" ","%",$_GET["keyword"])."%";
		$keyword = str_replace(" ","",$keyword);

		$whereclause = "project_id = '29' AND ";
		
		$master_data = $db->fetch_all_data("indottech_sites",[],$whereclause." (kode LIKE '$keyword' OR name LIKE '$keyword') order by name limit 10");
		if($master_data){
			foreach($master_data as $key => $data){ 
				$result .= "<div style=\"cursor:pointer; padding:5 0 5 3;\" onclick=\"pickSelectRefList('".$data["id"]."','".$data["kode"]."','".$data["name"]."');\">".$data["kode"]." - ".$data["name"]."</div>";
			}
			echo $result;
		}
	}
	///end loadSelectRef///
?>