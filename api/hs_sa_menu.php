<?php 
	include_once "header.php";
	$site_id	= $_GET["site_id"];
?>
<style>
	table{
		font-size:12pt !important;
		width:95%;
	}
	body{
		font-size:12pt !important;
	}
</style>
<?php if(!$site_id){?>
	<div style="width:95%;">
		Site : 
		<?=$f->start("filter","GET");?>
		<?=$f->input("token",$_GET["token"],"type='hidden'");?>
		<?=$f->input("site_id",$_POST["site_id"],"type='hidden'");?>
		<?=$f->input("txt_site",$_POST["txt_site"],"required step='any' autocomplete='off' onkeyup='loadSelectRef(this.value,event.keyCode);'","classinput");?>
		<div style=\"position:absolute;display:none;z-index:99;\" id="div_select_ref">
			<table style=\"border:grey solid 1px; background-color:#EFEFEF;\"> 
				<tr><td id="select_ref" style="font-size:12px;"></td></tr>
			</table>
		</div>
		<br><br><?=$f->input("do_filter","Submit","type='submit'","btn btn-primary");?>
		<?=$f->end();?>
		<script>
			$("#txt_site").focus();
		</script>
	</div>
<?php } else {?>
<?php
	$data_details = $db->fetch_all_data("indottech_sites",[],"id='".$site_id."'")[0];
?>
	<table Width="100%">
		<tr>
			<td width="20%">Kode Site</td>
			<td>: <?=$data_details["kode"];?></td>
		</tr>
		<tr>
			<td width="20%">Nama Site</td>
			<td>: <?=$data_details["name"];?></td>
		</tr>
		<tr>
			<td width="20%">Kordinat</td>
			<td>: <?=$data_details["latitude"];?> , <?=$data_details["longitude"];?></td>
		</tr>
	</table>
	<?=$f->input("reset","Ganti Site","type='button' onclick='window.location=\"?token=".$token."\";'","btn btn-info");?>
	<br>
	<br>
	<table>
		<tr>
			<td width="50%" align="center"><?=$f->input("sa","SA","style='width:50px; height:50px !important;' type='button' onclick='window.location=\"sa_add.php?token=".$token."&id=".$id."&site_id=".$site_id."&mode=sa&user_id=".$__user_id."\";'","btn btn-success");?></td>
			<td width="50%" align="center"><?=$f->input("hs","HS","style='width:50px; height:50px !important;' type='button' onclick='window.location=\"hs_add.php?token=".$token."&id=".$id."&site_id=".$site_id."&mode=hs&user_id=".$__user_id."\";'","btn btn-warning");?></td>
		</tr>
	</table>
<?php }?>
<?php
	include_once "hs_sa_js.php";
	include_once "footer.php";
?>