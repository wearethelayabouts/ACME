<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Select User</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h2>Select User</h1>
		<div class="mainbox">
			<table class="maintable">
				<tr>
					<td>ID</td>
					<td>Name</td>
				</tr>
				<?php foreach ($users as $id => $piece) { ?>
				<tr>
					<td><strong><?php echo $id; ?></strong></td>
					<td><a href="javascript:void();" onclick="window.opener.document.forms['form'].author_id_<?php echo $fieldnum; ?>.value = '<?php echo $id; ?>'; window.close();"><?php if (strlen($piece['full_name']) > 0) echo $piece['full_name']; else echo "(no name)"; ?></a></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
	</body>
</html>