<?php
	include_once "../common.php"; 
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	if(isset($_GET["candidate_id"])){ $candidate_id = $_GET["candidate_id"]; } else { $candidate_id = ""; }
	if($_mode == "load_detail"){
		$name = $db->fetch_single_data("candidates","name",["id" => $candidate_id]);
		$position_ids = pipetoarray($db->fetch_single_data("all_data_update","position_ids",["candidate_id" => $candidate_id],["id DESC"]));
		$position_id = $position_ids[count($position_ids)-1];
		$position = $db->fetch_single_data("positions","name",["id" => $position_id]);
		echo $name."|||".$position;
	}
?>