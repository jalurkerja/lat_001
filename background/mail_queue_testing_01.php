<?php
	set_time_limit(0);
	include_once "document_root_path.php";
	include_once "../func.sendingmail.php";
	include_once "common.php";
	$subject = "Mail Queue Result";
	$address = "it@corphr.com";
	$query_chr 	= $db->fetch_all_data("mail_queue",["status"],"status = '0'");
	$query_za	= $db->fetch_all_data("mail_queue_za",["status"],"status = '0'");
	$query2_chr = $db->fetch_all_data("mail_queue",["status"],"		status = '1' and created_at like '%".date("Y-m-d")."%'");
	$query2_za	= $db->fetch_all_data("mail_queue_za",["status"],"	status = '1' and created_at like '%".date("Y-m-d")."%'");
	$body = "mail queue ".date("d-M-Y")."<br>
				<table width='75%' align='center' border='1px solid black'>
					<tr>
						<td align='center' style='font-weight:bolder;'>CHR</td>
						<td align='center' style='font-weight:bolder;'>ZA</td>
					</tr>
					<tr>
						<td align='center'>".count($query_chr)." Antrian</td>
						<td align='center'>".count($query_za)." Antrian</td>
					</tr>
					<tr>
						<td align='center'>".count($query2_chr)." Terkirim Hari Ini</td>
						<td align='center'>".count($query2_za). " Terkirim Hari Ini</td>
					</tr>
				</table>
			";
	sendingmail($subject,$address,$body);
?>