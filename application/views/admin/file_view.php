<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$sortdesc = !$sortasc;
	if ($sortdesc)
		$changetoasc = $sortby;
	else
		$changetoasc = "n/a";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Files (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>View Files</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/files/add">+ Add New File...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td><a href="<?php echo $baseurl; ?>toolbox/files/1/id/<?php if ($changetoasc == 'id') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'id') echo "<strong>"; ?>ID<?php if ($sortby == 'id') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					
					<td><a href="<?php echo $baseurl; ?>toolbox/files/1/dscr/<?php if ($changetoasc == 'dscr') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'dscr') echo "<strong>"; ?>Internal Description<?php if ($sortby == 'dscr') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					
					<td><a href="<?php echo $baseurl; ?>toolbox/files/1/type/<?php if ($changetoasc == 'type') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'type') echo "<strong>"; ?>File Type<?php if ($sortby == 'type') { if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; } else echo ""; ?></td>
					
					<td><a href="<?php echo $baseurl; ?>toolbox/files/1/fname/<?php if ($changetoasc == 'fname') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'fname') echo "<strong>"; ?>Filename<?php if ($sortby == 'fname') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					
					<td>Is Downloadable</td>
				</tr>
				<?php $altrow = false;				
				foreach ($files as $file) {
				if ($file['id'] < 1) break; ?>
				<tr<?php if (!$altrow) $altrow = true;
				else { echo " class=\"tralt\"";
				$altrow = false;
				}?>>
					<td><strong><?php echo $file['id']; ?></strong></td>
					<td class="tdalt"><a href="<?php echo $baseurl; ?>toolbox/files/edit/<?php echo $file['id']; ?>"><?php if (strlen($file['internal_description']) > 0) echo $file['internal_description']; else echo "(no description -- edit this file)"; ?></a></td>
					<td><?php echo $file['type']; ?></td>
					<td class="tdalt smallish"><?php if (strlen($file['name']) > 0) echo $file['name']; else echo "(no filename)"; ?></td>
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