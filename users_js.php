<script>
	function load_detail_candidate(candidate_id){
		$.get( "ajax/candidates.php?mode=load_detail&candidate_id="+candidate_id, function(data) {
			var valReturn = data.split("|||");
			$("#name").val(valReturn[0]);
			$("#job_title").val(valReturn[1]);
		});
	}
</script>