<?php
	include_once "../ajax/custom_js.php"; 
?>
<script>
	function loadSelectRef(keyword,keycode){
		if(keycode==27){
		  div_select_ref.style.display="none";
		}else{
		  if(keyword != ""){
			try{ document.getElementById("customer_code").value=""; } catch (e){}
			get_ajax("../ajax/hs_sa_ajax.php?mode=loadSelectRef&keyword="+keyword,"SelectRefList","loadingRef();",false);
		  }else{
			div_select_ref.style.display="none";
		  }
		}
	}
	
	function loadingRef(){
		var returnvalue = global_respon['SelectRefList'];
		if(returnvalue != ""){
		  document.getElementById("div_select_ref").style.display="block";
		  document.getElementById("select_ref").innerHTML=returnvalue;
		} else {
		  document.getElementById("div_select_ref").style.display="none";
		}
	}
	
	function pickSelectRefList(id,kode,name){
		try{ document.getElementById("site_id").value = id; } catch (e){}
		try{ document.getElementById("txt_site").value = kode+" - "+name; } catch (e){}
		document.getElementById("div_select_ref").style.display="none";
	}
	
</script>