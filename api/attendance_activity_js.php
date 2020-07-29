<script>	
	function attach_yes(){
		document.getElementById("attachment").value="1";
		document.getElementById('save').click();
	}
	
	function show_select(){
		var parent_id = document.getElementById("category").value;
		$.get( "../ajax/attendance_activity_ajax.php?mode=show_select&parent_id="+parent_id, function(data) {
			$("#category_id").html(data);
		});
	}
	function show_select_edit(){
		var parent_id = document.getElementById("category").value;
		$.get( "../ajax/attendance_activity_ajax.php?mode=show_select_edit&parent_id="+parent_id, function(data) {
			$("#category_id").html(data);
		});
	}

	function loadSelectRef_1(elm,keycode){
		var keyword = elm.value;
		if(keycode==27){
			document.getElementById("category_desc").style.color="black";
			document.getElementById("div_select_ref_1").style.display="none";
		}else{
		  if(keyword != ""){
			var parent_id = "";
			try{ var parent_id = document.getElementById("category").value; } catch (e){}
			try{ document.getElementById("category_id").value=""; } catch (e){}
			get_ajax("../ajax/attendance_activity_ajax.php?mode=loadSelectRef_1&keyword="+keyword+"&parent_id="+parent_id,"SelectRefList_1","loadingRef_1();",false);
		  }else{
			document.getElementById("category_desc").style.color="black";
			document.getElementById("div_select_ref_1").style.display="none";
		  }
		}
	}
	
	function loadingRef_1(){
		var returnvalue = global_respon['SelectRefList_1'];
		if(returnvalue != ""){
		  document.getElementById("div_select_ref_1").style.display="block";
		  document.getElementById("select_ref_1").innerHTML=returnvalue;
		} else {
		  document.getElementById("div_select_ref_1").style.display="none";
		  document.getElementById("category_desc").style.color="black";
		}
	}
	
	function pickSelectRefList_1(id,description){
		try{ document.getElementById("category_id").value = id; } catch (e){}
		try{ document.getElementById("category_desc").value = description; } catch (e){}
		// document.getElementById("category_desc").style.color="green";
		document.getElementById("div_select_ref_1").style.display="none";
	}
</script>	
