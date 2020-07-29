<?php
// PR DISINI melanjutkan PO justifikasi lalu tercreate PO baru

	include_once "win_head.php";
	$old_po = $db->fetch_all_data("indottech_po_vendor",[],"id = '".$_GET["justification"]."'")[0];
	$indottech_po_vendor_details = $db->fetch_all_data("indottech_po_vendor_details",[],"po_id = '".$old_po["id"]."'");
	$indottech_po_vendor_payments = $db->fetch_all_data("indottech_po_vendor_payments",[],"po_id = '".$old_po["id"]."'");
	function generate_po_no($po_at){
		global $db;
		$temp_po_no = "IHR";
		$po_no = $db->fetch_single_data("indottech_po_vendor","po_no",["po_no" => $temp_po_no."%:LIKE","po_at" => substr($po_at,0,4)."%:LIKE"],["po_no DESC"]);
		if($po_no != "") $po_no = (str_replace($temp_po_no,"",$po_no) * 1) + 1;
		else $po_no = 1;
		if(substr($po_at,0,4) == "2018" && $po_no == 1) $po_no = 1001;
		return $temp_po_no.numberpad($po_no,4);
	}
	$po_no = generate_po_no(date("Y-m-d",strtotime($old_po["po_at"])));
	
	if($_POST["reason"]){
		$errormessage="";
		if($_POST["justification_id"] =="") $errormessage = "Please select the justification!";
		if($errormessage == ""){
			$db->addtable("indottech_po_vendor");	$db->where("id",$_GET["justification"]);
			$db->addfield("justification_id");		$db->addvalue($_POST["justification_id"]);
			$db->addfield("reject_at");				$db->addvalue($__now);
			$db->addfield("reject_by");				$db->addvalue($__username);
			$db->addfield("reject_ip");				$db->addvalue($__remoteaddr);
			$db->addfield("po_status");				$db->addvalue("4");
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				
				$db->addtable("indottech_po_vendor");
				$db->addfield("po_no");				$db->addvalue($po_no);
				$db->addfield("vendor_id");			$db->addvalue($old_po["vendor_id"]);
				$db->addfield("po_reference");		$db->addvalue($old_po["po_reference"]);
				$db->addfield("po_at");				$db->addvalue($old_po["po_at"]);
				$db->addfield("description");		$db->addvalue($old_po["description"]);
				$db->addfield("indottech_project_id");$db->addvalue($old_po["indottech_project_id"]);
				$db->addfield("scope_id");			$db->addvalue($old_po["scope_id"]);
				$db->addfield("cost_center_id");	$db->addvalue($old_po["cost_center_id"]);
				$db->addfield("payment_notes");		$db->addvalue($old_po["payment_notes"]);
				$db->addfield("payment_terms");		$db->addvalue($old_po["payment_terms"]);
				$db->addfield("with_tax");			$db->addvalue($old_po["with_tax"]);
				$db->addfield("tax");				$db->addvalue($old_po["tax"]);
				$db->addfield("pkp_no");			$db->addvalue($old_po["pkp_no"]);
				$db->addfield("nominal");			$db->addvalue($old_po["total"]);
				$db->addfield("total");				$db->addvalue($old_po["total"]);
				$db->addfield("po_status");			$db->addvalue("0");
				$db->addfield("lock_editing");		$db->addvalue("1");
				$db->addfield("created_by");		$db->addvalue($old_po["created_by"]);
				// $db->addfield("created_at");		$db->addvalue($old_po["created_at"]);
				$inserting = $db->insert();
				
				$po_id = $inserting["insert_id"];
				
				foreach($indottech_po_vendor_details as $key => $indottech_po_vendor_detail){
					$db->addtable("indottech_po_vendor_details");
					$db->addfield("po_id");		$db->addvalue($po_id);
					$db->addfield("seqno");		$db->addvalue($key);
					$db->addfield("site_code");	$db->addvalue($indottech_po_vendor_detail["site_code"]);
					$db->addfield("site_name");	$db->addvalue($indottech_po_vendor_detail["site_name"]);
					$db->addfield("sow_id");	$db->addvalue($indottech_po_vendor_detail["sow_id"]);
					$db->addfield("price");		$db->addvalue($indottech_po_vendor_detail["price"]);
					$db->addfield("qty");		$db->addvalue($indottech_po_vendor_detail["qty"]);
					$db->addfield("total");		$db->addvalue($indottech_po_vendor_detail["total"]);
					$inserting = $db->insert();
				}
				
				foreach($indottech_po_vendor_payments as $key => $indottech_po_vendor_payment){
					$db->addtable("indottech_po_vendor_payments");
					$db->addfield("po_id");			$db->addvalue($po_id);
					$db->addfield("seqno");			$db->addvalue($key);
					$db->addfield("description");	$db->addvalue($indottech_po_vendor_payment["description"]);
					$db->addfield("percentage");	$db->addvalue($indottech_po_vendor_payment["percentage"]);
					$db->addfield("amount");		$db->addvalue($indottech_po_vendor_payment["amount"]);
					$inserting = $db->insert();
				}
				
				$db->addtable("indottech_po_vendor");	$db->where("id",$old_po["id"]);
				$db->addfield("revision_no");			$db->addvalue($po_id);
				$update = $db->update();
				
			?>
				<body onload="setTimeout ('parent.location.reload(true)', 500,); ">
				<center><b>PO Already Justified and Revision No : <?=$po_no;?></b></center>
			<?php
			
			} else {
				?>
					<center><b>Justification Failed</b></center>
				<?php
			}
		}
	}
?>
<br><br>
<?=$f->start("","POST","?".$_SERVER["QUERY_STRING"]);?>
	<?=$t->start("","editor_content");?>
	<center><b><?=$errormessage;?></b></center>
	<?php
		$reason = $f->select("justification_id",["1" => "Site Take Over - Dikerjakan Internal", "2" => "Site Take Over - Dikerjakan Patner Lain", "3" => "Re-Negosiasi Harga Persite"],"style ='height:30px; width:75%;'");
		$action= $f->input("reason","Post","type='submit'");
	?>
	<?=$t->row(["<b>Justification</b>", $reason, $action],["height='35px;'"]);?> 
	<?=$t->end();?>
<?=$f->end();?>
