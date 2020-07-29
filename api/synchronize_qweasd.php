<?php
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "sites"){
		$sites = $db->fetch_all_data("indottech_sites",["id","kode","name","longitude","latitude"]);
		foreach($sites as $site){
			echo $site["id"]."|||".$site["kode"]."|||".$site["name"]."|||".$site["longitude"]."|||".$site["latitude"]."]]]";
		}
	}
	if($mode == "projects"){
		$projects = $db->fetch_all_data("indottech_projects",["id","name"]);
		foreach($projects as $project){
			echo $project["id"]."|||".$project["name"]."]]]";
		}
	}
	if($mode == "photo_items"){
		$photo_items = $db->fetch_all_data("indottech_photo_items",["id","parent_id","is_childest","project_id","doctype","seqno","name","com"]);
		foreach($photo_items as $photo_item){
			echo $photo_item["id"]."|||".$photo_item["parent_id"]."|||".$photo_item["is_childest"]."|||".$photo_item["project_id"]."|||".$photo_item["doctype"]."|||".$photo_item["seqno"]."|||".$photo_item["name"]."|||".$photo_item["com"]."]]]";
		}
	}
	
	if($mode == "full"){
		$sql .= "DROP TABLE IF EXISTS user;\n";
		$sql .= "DROP TABLE IF EXISTS sites;\n";
		$sql .= "DROP TABLE IF EXISTS projects;\n";
		$sql .= "DROP TABLE IF EXISTS photo_items;\n";
		$sql .= "DROP TABLE IF EXISTS atd_covers;\n";
		$sql .= "DROP TABLE IF EXISTS tag_photos;\n";
		$sql .= "DROP TABLE IF EXISTS tag_photo_projects;\n";
		$sql .= "CREATE TABLE user ( user varchar(255) NOT NULL );\n";
		$sql .= "CREATE TABLE sites ( id int NOT NULL, kode varchar(50) NOT NULL, name varchar(255) NOT NULL, longitude varchar(50) NOT NULL, latitude varchar(50) NOT NULL );\n";
		$sql .= "CREATE TABLE projects ( id int NOT NULL, name varchar(150) NOT NULL );\n";
		$sql .= "CREATE TABLE photo_items ( id int NOT NULL, parent_id int NOT NULL, is_childest smallint NOT NULL, project_id int NOT NULL, doctype varchar(50) NOT NULL, seqno int NOT NULL, name varchar(255) NOT NULL, com varchar(5) NOT NULL );\n";
		$sql .= "CREATE TABLE atd_covers ( chk_work_type int NOT NULL, vendor varchar(100) NOT NULL, project_name varchar(100) NOT NULL, customer varchar(100) NOT NULL, site_code varchar(100) NOT NULL, status smallint NOT NULL, created_at datetime NOT NULL );\n";
		$sql .= "CREATE TABLE tag_photos ( atd_id int NOT NULL, photo_items_id int NOT NULL, latitude varchar(50) NOT NULL, longitude varchar(50) NOT NULL, filename varchar(255) NOT NULL, status smallint NOT NULL, created_at datetime NOT NULL );\n";
		$sql .= "CREATE TABLE tag_photo_projects ( project_id int NOT NULL, site_id int NOT NULL, site_code varchar(50) NOT NULL, site_name varchar(255) NOT NULL, latitude varchar(50) NOT NULL, longitude varchar(50) NOT NULL, status smallint NOT NULL, created_at datetime NOT NULL );\n";
		$sql .= "CREATE TABLE IF NOT EXISTS sync_log ( sync_at date NOT NULL );\n";
		$sql .= "CREATE TABLE IF NOT EXISTS tag_photo_project_mode ( atd_id int NOT NULL, doctype varchar(50) NOT NULL);\n";
	}
	
	if($mode == "all" || $mode == "full"){
		$sql .= "DELETE FROM projects;\n";
		$projects = $db->fetch_all_data("indottech_projects",["id","name"]);
		foreach($projects as $project){
			$sql .= "INSERT INTO projects (id,name) VALUES ('".$project["id"]."','".$project["name"]."');\n";
		}
		
		$sql .= "DELETE FROM sites;\n";
		$sites = $db->fetch_all_data("indottech_sites",["id","kode","name","longitude","latitude"]);
		foreach($sites as $site){
			$sql .= "INSERT INTO sites (id,kode,name,longitude,latitude) VALUES ('".$site["id"]."','".$site["kode"]."','".$site["name"]."','".$site["longitude"]."','".$site["latitude"]."');\n";
		}
		
		$sql .= "DELETE FROM photo_items;\n";
		$photo_items = $db->fetch_all_data("indottech_photo_items",["id","parent_id","is_childest","project_id","doctype","seqno","name","com"]);
		foreach($photo_items as $key => $photo_item){
			$sql .= "INSERT INTO photo_items (id,parent_id,is_childest,project_id,doctype,seqno,name,com) VALUES ";
			$sql .= "('".$photo_item["id"]."','".$photo_item["parent_id"]."','".$photo_item["is_childest"]."','".$photo_item["project_id"]."','".$photo_item["doctype"]."','".$photo_item["seqno"]."','".$photo_item["name"]."','".$photo_item["com"]."');\n";
		}
		echo $sql;
	}
	
	if($mode == "new"){
		$data = "sync_log|||CREATE TABLE IF NOT EXISTS sync_log ( sync_at date NOT NULL );]]]";
		$data .= "sync_log|||CREATE TABLE IF NOT EXISTS tag_photo_project_mode ( atd_id int NOT NULL, doctype varchar(50) NOT NULL);]]]";
		if(!$_GET["sync_at"]) $_GET["sync_at"] = "2018-10-01";
		$sync_at = $_GET["sync_at"]." 00:00:00";
		
		$projects = $db->fetch_all_data("indottech_projects",["id","name"],"xtimestamp >= '$sync_at'");
		foreach($projects as $project){
			$data .= "projects|||".$project["id"]."|||".$project["name"]."]]]";
		}
		
		$sites = $db->fetch_all_data("indottech_sites",["id","kode","name","longitude","latitude"],"xtimestamp >= '$sync_at'");
		foreach($sites as $site){
			$data .= "sites|||".$site["id"]."|||".$site["kode"]."|||".$site["name"]."|||".($site["longitude"]*1)."|||".($site["latitude"]*1)."]]]";
		}
		
		$photo_items = $db->fetch_all_data("indottech_photo_items",["id","parent_id","is_childest","project_id","doctype","seqno","name","com"],"xtimestamp >= '$sync_at'");
		foreach($photo_items as $key => $photo_item){
			$data .= "photo_items|||".$photo_item["id"]."|||".$photo_item["parent_id"]."|||".$photo_item["is_childest"]."|||".$photo_item["project_id"]."|||".$photo_item["doctype"]."|||".$photo_item["seqno"]."|||".$photo_item["name"]."|||".$photo_item["com"]."]]]";
		}
		echo $data;
	}
?>

