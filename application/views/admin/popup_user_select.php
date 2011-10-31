<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Select User</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h2>Select User</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/users/add">+ Add New User...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td>ID</td>
					<td>Name</td>
				</tr>
				<?php $altrow = false;				
				foreach ($users as $id => $piece) { ?>
				<tr>
					<td><strong><?php echo $id; ?></strong></td>
					<td class="tdalt"><a href="javascript:void();" onclick="window.opener.document.forms['form'].author_id_<?php echo $fieldnum; ?>.value = '<?php echo $id; ?>'; window.close();"><?php echo $piece['full_name']; ?></a></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>