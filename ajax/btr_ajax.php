<?php
	include_once "../common.php"; 
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	if(isset($_GET["project"])){ $project = $_GET["project"]; } else { $project = ""; }
	if(isset($_GET["id_all_data"])){ $id_all_data = $_GET["id_all_data"]; } else { $id_all_data = ""; }
	if(isset($_GET["key_id"])){ $key_id = $_GET["key_id"]; } else { $key_id = ""; }
	if(isset($_GET["airline"])){ $airline = $_GET["airline"]; } else { $airline = ""; }
	
	if($_mode == "get_select_employee" && $project > 0){
		$candidate_ids_in	= $db->fetch_all_data("all_data_update",[],"project_ids LIKE '%|".$project."|%' group by candidate_id");
		$where = "";
		foreach($candidate_ids_in as $in_ids){
			$where .= $in_ids["candidate_id"].",";
		}
		$where = substr($where,0,-1);
		$master_employee	= $db->fetch_select_data("candidates","id","concat(code,' - ',name)",["id" => $where.":IN"],["code"],"");
		
		$candidate_id = "";
		if($key_id > 0){
			$candidate_id = $db->fetch_single_data("business_trip","candidate_id",["id" => $key_id]);
		}
		echo $f->select("candidate_id",$master_employee,$candidate_id,"style='width:100%; height:25px'");
	}

	if($_mode == "get_airline" && $airline == 8){
		$airline_oth = $db->fetch_single_data("business_trip","airline_oth",["id" => $key_id]);
		echo  $f->input("airline_oth",@$airline_oth,"placeholder='Nama Maskapai Lain?' style='width:100%'");
	}
	
?>