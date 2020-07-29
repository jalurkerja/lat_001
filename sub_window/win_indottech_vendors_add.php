<?php
	if(isset($_POST["saving_new"])){
		$db->addtable("indottech_vendors");
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("email");				$db->addvalue($_POST["email"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("fax");				$db->addvalue($_POST["fax"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("zipcode");			$db->addvalue($_POST["zipcode"]);
		$db->addfield("description");		$db->addvalue($_POST["description"]);
		$db->addfield("tax_no");			$db->addvalue($_POST["tax_no"]);
		$db->addfield("tax_address");		$db->addvalue($_POST["tax_address"]);
		$db->addfield("tax_zipcode");		$db->addvalue($_POST["tax_zipcode"]);
		$db->addfield("pkp_num");			$db->addvalue($_POST["pkp_num"]);
		$db->addfield("bank_name");			$db->addvalue($_POST["bank_name"]);
		$db->addfield("bank_account_name");	$db->addvalue($_POST["bank_account_name"]);
		$db->addfield("bank_account_no");	$db->addvalue($_POST["bank_account_no"]);
		$db->addfield("bank_branch");		$db->addvalue($_POST["bank_branch"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			?> <script> parent_load('<?=$_name;?>','<?=$inserting["insert_id"];?>','<?=$_POST["name"];?>'); </script> <?php
		} else {
			?> <script> window.location='?<?=str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]);?>'; </script> <?php
		}
	}
	
	$pic = $f->input("pic",@$_POST["pic"],"required");
	$name = $f->input("name",@$_POST["name"],"required");
	$email = $f->input("email",@$_POST["email"],"type='email' required");
	$phone = $f->input("phone",@$_POST["phone"],"required");
	$fax = $f->input("fax",@$_POST["fax"]);
	$address = $f->textarea("address",@$_POST["address"],"required");
	$zipcode = $f->input("zipcode",@$_POST["zipcode"]);
	$description = $f->textarea("description",@$_POST["description"]);
	$tax_no = $f->input("tax_no",@$_POST["tax_no"]);
	$tax_address = $f->textarea("tax_address",@$_POST["tax_address"]);
	$tax_zipcode = $f->input("tax_zipcode",@$_POST["tax_zipcode"]);
	$pkp_num = $f->input("pkp_num",@$_POST["pkp_num"],"required");
	$bank_name = $f->input("bank_name",@$_POST["bank_name"],"required");
	$bank_account_name = $f->input("bank_account_name",@$_POST["bank_account_name"],"required");
	$bank_account_no = $f->input("bank_account_no",@$_POST["bank_account_no"],"required");
	$bank_branch = $f->input("bank_branch",@$_POST["bank_branch"]);
	
?>
<?=$f->start("","POST","?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"]));?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(["PIC",$pic]);?>
	    <?=$t->row(["Name",$name]);?>
	    <?=$t->row(["Email",$email]);?>
	    <?=$t->row(["Phone",$phone]);?>
	    <?=$t->row(["Fax",$fax]);?>
	    <?=$t->row(["Address",$address]);?>
	    <?=$t->row(["ZipCode",$zipcode]);?>
	    <?=$t->row(["Description",$description]);?>
	    <?=$t->row(["Tax No",$tax_no]);?>
	    <?=$t->row(["Tax Address",$tax_address]);?>
	    <?=$t->row(["Tax ZipCode",$tax_zipcode]);?>
	    <?=$t->row(["PKP Number",$pkp_num]);?>
	    <?=$t->row(["Bank Name",$bank_name]);?>
	    <?=$t->row(["Bank Account Name",$bank_account_name]);?>
	    <?=$t->row(["Bank Account No",$bank_account_no]);?>
	    <?=$t->row(["Bank Branch",$bank_branch]);?>
        <?=$t->row(array("&nbsp;"));?>
	<?=$t->end();?>
	<br>
	<?=$f->input("saving_new","Save","type='submit'");?> <?=$f->input("cancel","Cancel","type='button' onclick=\"window.location='?".str_replace("addnew=1&","",$_SERVER["QUERY_STRING"])."';\"");?>
<?=$f->end();?>