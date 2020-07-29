<script>
	var global_respon = new Array();
	function get_ajax(x_url,target_elm,done_function){
		$( document ).ready(function() {
			$.ajax({url: x_url, success: function(result){
				try{ $("#"+target_elm).html(result); } catch(e){}
				try{ $("#"+target_elm).val(result); } catch(e){}
				try{ global_respon[target_elm] = result; } catch(e){}
				try{ eval(done_function || ""); } catch(e){}
			}});
		});
	}
</script>