<?php if ($type == "addfile") { ?>
<script type="text/javascript">
if (window.opener && !window.opener.closed) { 
	var target = window.opener.document.getElementById(<?php echo $object['attachment_type']; ?>); 
	target.value = <?php echo $object['upload_data']['raw_name'] ?>;
	window.close(); 
} 
</script>
<?php } ?>