<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<link rel="stylesheet" type="text/css" href="../backoffice.css">
	</head>
	<body>
		<style>
			a{
				text-decoration:none;
				color:#43579C;
			}
			button{
				width:90px;
				height:90px;
				font-weight:bolder;
				font-size:14px;
			}
		</style>
<?php 
	include_once "../common.php";
	include_once "user_info.php";
	$message = "";
	
	$menus[]["pms_nokia_list"] = "SIR";
	$menus[]["logout"] = "Log Out";
	$menus[]["exit"] = "Keluar";
?>
		<table width="100%">
			<tr><td align="center">
				<table width="100%">
					<tr>
						<?php 
							$ii = -1;
							foreach($menus as $menu) {
								$ii++;
								?> <td width="31%" align="center"><button onclick="window.location='?token=<?=$_GET["token"];?>&btnMode=<?=key($menu);?>';"><?=$menu[key($menu)];?></button></td> <?php
								if($ii < 2){
									?> <td width="3%">&nbsp;</td> <?php
								} else {
									?> </tr><tr><td></td></tr><tr> <?php
									$ii = -1;
								}
							}
						?>
					</tr>
				</table>
			</td></tr>
		</table>
	</body>
</html>
