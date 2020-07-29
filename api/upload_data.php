<?php include_once "header.php";?>
<h4><b>Upload Data Offline</b></h4>
<?php if($_GET["upload"] != "now" && $_GET["uploaddone"] != "1"){ ?>
<p>Pastikan koneksi internet Anda dalam kondisi yang sangat Baik</p>
<?php } ?>
<?php
	if($_GET["upload"] == "now"){ echo "<h4 style='color:red;font-weight:bolder;'>Harap Tunggu, Upload sedang berlangsung!</h4>"; }
	if($_GET["uploaddone"] == "1"){ echo "<h4 style='color:blue;font-weight:bolder;'>Upload Selesai!</h4>"; }
	if($_GET["upload"] != "now" && $_GET["uploaddone"] != "1"){ ?> <button onclick="window.location='?token=<?=$token;?>&upload=now';">Upload Sekarang</button> <?php } ?>
<?php include_once "footer.php";?>