<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Select File</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h2>Select File</h1>
		<div class="mainbox">
			<table class="maintable">
				<tr>
					<td>ID</td>
					
					<td>Internal Description</td>
					
					<td>File Type</td>
					
					<td>Filename</td>
					
					<td>Is Downloadable</td>
				</tr>
				<?php			
				foreach ($files as $file) {
				if ($file['id'] < 1) break; ?>
				<tr>
					<td><strong><?php echo $file['id']; ?></strong></td>
					<td><a href="javascript:void();" onclick="window.opener.document.forms['form'].<?php echo $formid; ?>.value = '<?php echo $file['id']; ?>'; window.close();"><?php if (strlen($file['internal_description']) > 0) echo $file['internal_description']; else echo "(no description)"; ?></a></td>
					<td><?php echo $file['type']; ?></td>
					<td class="smallish"><?php if (strlen($file['name']) > 0) echo $file['name']; else echo "(no filename)"; ?></td>
					<td><?php if ($file['is_downloadable'] == 1) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>