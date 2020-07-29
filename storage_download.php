<?php 
	include_once "common.php";
	$id = $_GET["id"];
	$storage = $db->fetch_all_data("storage",[],"id = '".$id."' AND (allowed_user_ids LIKE '%|".$__user_id."|%' OR user_id = '".$__user_id."')")[0];
	$local_file = "storage_share/".$storage["physicalname"];
	$download_file = $storage["filename"];
	$download_rate = 10240;//10Mb/s
	if(file_exists($local_file) && is_file($local_file)){
		header('Cache-control: private');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($local_file));
		header('Content-Disposition: filename='.$download_file);
		flush();
		$file = fopen($local_file, "r");
		while(!feof($file)){
			print fread($file, round($download_rate * 1024));
			flush();
			sleep(1);
		}
		fclose($file);
	} else {
		?> <script> alert("Error: The file `<?=$local_file;?>` does not exist!"); </script> <?php
	}
?>
<script> window.close(); </script>