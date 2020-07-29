<?php
	include_once "../common.php"; 
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }
	
	if($_mode == "show_select"){
		$parent_id	= $_GET["parent_id"];
		if($parent_id > 0){
			echo $f->select("category_id",$db->fetch_select_data("activities","id","name",["parent_id" => $parent_id],array(),"",true),$_POST["category_id"],"required","dropdown-product selectpicker");
		} else {
			echo "";
		}
	}
	if($_mode == "show_select_edit"){
		$parent_id	= $_GET["parent_id"];
		if($parent_id > 0){
			echo $f->select("category_id",$db->fetch_select_data("activities","id","name",["parent_id" => $parent_id],array(),"",true),$_POST["category_id"],"required","dropdown-product selectpicker");
		} else {
			echo "";
		}
	}
?>