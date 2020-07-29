<?php
	include_once "../common.php";
	include_once "header.php";
	include_once "header_01.php";
	$pass_lama		= $f->input("pass_lama","","required minlength='6' type='password' autocomplete='off'","form-control");
	$pass_baru		= $f->input("pass_baru","","required minlength='6' type='password' autocomplete='off'","form-control");
	$ulangi_pass	= $f->input("ulangi_pass","","required minlength='6' type='password' autocomplete='off'","form-control");
	
	if(isset($_POST["save"])){
		$_errormessage 	= "";
		$_successmessage= "";
		$_oldpassword = base64_decode($db->fetch_single_data("users","password",["id"=>$user_id]));
		if($_oldpassword != $_POST["pass_lama"] || $_POST["pass_baru"] != $_POST["ulangi_pass"]){
			$_errormessage = "Password salah, silakan ulangi lagi!";			
		}
		
		if($_errormessage == ""){
			$db->addtable("users");					$db->where("id",$user_id);
			$db->addfield("password");				$db->addvalue(base64_encode($_POST["pass_baru"]));
			$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");			$db->addvalue($username);
			$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$updating = $db->update();
			if($updating["affected_rows"] >= 0){
				$_successmessage = "Password berhasil diperbaharui!";
			}
		}
	}
	
?>
    <!-- Content section Start --> 
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6 col-xs-12">
            <div class="page-login-form box">
              <h3>
                Ganti Password
              </h3>
				<?php
					if($_errormessage){
						echo "<br><font style='font-size:12px; color:red;' id='_errormessage'>".$_errormessage."</font>";
						?>
						<script>
							setTimeout(function(){ 
								$("#_errormessage").fadeOut("slow");
							}, 3000)
						</script>
						<?php
					}
					if($_successmessage){
						echo "<br><font style='font-size:12px; color:green;' id='_successmessage'>".$_successmessage."</font>";
						?>
						<script>
							setTimeout(function(){ 
								$("#_successmessage").fadeOut("slow");
							}, 3000)
						</script>
						<?php
					}
				?>
				<form class="form-ad" style="color: black;" enctype="multipart/form-data" method="POST" action="?token=<?=$token;?>&sisacuti=<?=$_GET["sisacuti"];?>">
					<div class="form-group">
						<label class="control-label">Password Lama</label>
						<?= $pass_lama;?>
					</div>  
					<div class="form-group">
						<label class="control-label">Password Baru</label>
						<?= $pass_baru;?>
					</div> 
					<div class="form-group">
						<label class="control-label">Ulangi Password</label>
						<?= $ulangi_pass;?>
					</div> 
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="myFunction();">
						<label class="form-check-label" for="exampleCheck1" style="padding-left:20px; font-weight:normal;">Tampilkan</label>
					</div>
					<br>
					<?=$f->input("save","Simpan","type='submit'","btn btn-common log-btn");?>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Content section End -->  
<script>
	function myFunction() {
	var x = document.getElementById("pass_lama");
	var y = document.getElementById("pass_baru");
	var z = document.getElementById("ulangi_pass");
		if (x.type === "password") {
			x.type = "text";
			y.type = "text";
			z.type = "text";
		} else {
			x.type = "password";
			y.type = "password";
			z.type = "password";
		}
	}
</script>
<?php include_once "footer.php"; ?>