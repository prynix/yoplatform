<?php
	if($item->status == 1 ){
		$status = "fa-check-circle";
		$title = "unactive";
	}else{
		$status = "fa-circle-o";
		$title = "active";
	}
?>
<a class="" href="javascript:;" onclick="changeStatus('{{$item->id}}', '{{$item->status}}')" title="Click to {{$title}} this conversion" data-toggle="tooltip" data-placement="top">
	<i class="fa {{$status}} fs20"></i>
</a>
<script type="text/javascript">
$(function () {
	  $('[data-toggle="tooltip"]').tooltip();
});
</script>