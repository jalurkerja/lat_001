<?php
	include_once "../common.php"; 
	if(isset($_GET["mode"])){ $_mode = $_GET["mode"]; } else { $_mode = ""; }

	if($_mode == "sel_dashboards"){
		$arr_dashboards_name	= $db->fetch_select_data("tickets_v_dashboards","id","description",array(),array(),"",true);
		echo $f->select("sel_dashboards",$arr_dashboards_name,$_POST["sel_dashboards"]," style='width:100%; height:25px;' required");
	}
	
?>