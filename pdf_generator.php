<?php
	include_once "common.php";
	include_once "func.sendingmail.php";
	
	// $url = "http://localhost/indottech/".base64_decode($_GET["url"]);
	$url = "http://103.253.113.201/indottech/".base64_decode($_GET["url"]);
	$referer = basename($_SERVER["HTTP_REFERER"]);
	$pdffile = "email_attachments/".$_GET["pdffile"];
	$handle = popen("/usr/local/bin/wkhtmltopdf.sh $url $pdffile 2>&1", "r");
	while (!feof($handle)) 
	  fread($handle, 4096);
	pclose($handle);
	if($_GET["mode"] == "export"){
		if (file_exists($pdffile)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($pdffile).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($pdffile));
			readfile($pdffile);
			exit;
		}
	}
	if($_GET["mode"] == "sendmail") {
		// $po_no = $db->fetch_single_data("indottech_po_vendor", "po_no", ["id" => $_GET["id"]]);
		$po = $db->fetch_all_data("indottech_po_vendor", [], "id = '".$_GET["id"]."'")[0];
		$nama = $db->fetch_single_data("users","name",["email" => $po["approved_by"]]);
		$recipient = $_GET["recipient"];
		$body = "Dear Partner,<br><br>
				Terlampir PO Number <b>".$po["po_no"]."</b>.<br>
				Mohon reply all email ini sebagai konfirmasi PO sudah diterima dan harga sudah sesuai PKP.
				<br><br><br>
				Salam,<br><br>
				IndoHR
				";
		$replyto = $po["approved_by"]."|".$nama;
		$ccs = "|".$po["created_by"]."||".$po["checked_by"]."|";
		sendingmail("Indottech -- Purchase Order [".$po["po_no"]."]",$recipient,$body,$replyto,$pdffile,$ccs);
	}
?>
<script>
	window.location='<?=$referer;?>';
</script>