<script>
	////////start part removed replaced////////
	function open_search() {
		document.getElementById("conteainer-search").style.display = "block";
	};
	function open_reject(reject_id) {
		document.getElementById("conteainer-reject").style.display = "block";
			document.getElementById("reject_id").value = reject_id;
	};
	function close_search() {
		document.getElementById("conteainer-search").style.display = "none";
		document.getElementById("conteainer-reject").style.display = "none";
	};
	// function pop_up_search(mode,pop_up_ke,key_word){
		// $.get( "../ajax/fser_ajax.php?mode=pencarian&item="+key_word+"&col="+pop_up_ke+"&form_mode="+mode, function(data) {
			// $("#pop_up").html(data);
		// });
	// };
	////////end part removed replaced////////
</script>