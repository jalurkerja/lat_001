<?php
	include_once "head.php";
?>
<table width="100%"><tr><td align="center">
	<fieldset style="width:30%;height:100%; padding-top:10px; padding-bottom:30px;" class="frontRegisterArea container">
		<div class="col-lg-12">
			<h3><b>Login</b></h3>
			<hr>
			<?=$f->start();?>
				<div class="form-group">
					<label for="email">Username</label>
					<?=$f->input("username","","required autocomplete='off'","form-control");?>
				</div>
				<div class="form-group">
					<label for="email">Password</label>
					<?=$f->input("password","","required autocomplete='off' type='password'","form-control");?>
					<?=$f->input("forget","yes","style='zoom:1.5;' type='checkbox' onchange='pass_unrequired();'");?> <sup>*Lupa Password</sup><br>
				</div>
				<div class="g-recaptcha" data-sitekey="<?=$__data_sitekey;?>"></div>
				<?=$f->input("data_secretKey",$__data_secretKey,"type='hidden'","");?>
				<?=$f->input("login_action","Login","type='submit' style='width:90% !important;'","btn btn-primary");?>
			<?=$f->end();?>
		</div>
	</fieldset>
</td></tr></table>
<script>
	function pass_unrequired(){
		document.getElementById("password").required = false;
	}
</script>
<script>
	var width = $('.g-recaptcha').parent().width();
	if (width < 302) {
		 var scale = width / 302;
		 $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
		 $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
		 $('.g-recaptcha').css('transform-origin', '0 0');
		 $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
	} 
</script>
<table align="center" width="300" border="0">
	<tr><td>
	<marquee>Tandai <b><i>*Lupa password</i></b> jika anda lupa password login dan untuk mendapatkan Password terbaru</marquee>
	</td></tr>
</table>

<?php include_once "footer.php";?>