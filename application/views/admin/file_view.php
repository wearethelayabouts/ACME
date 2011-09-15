<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$sortdesc = !$sortasc;
	if ($sortdesc) $changetoasc = $sortby;
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?=$sitename?> &bull; View All Files (Admin)</title>
		<link href="<?=$baseurl?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?=$baseurl?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?=$sitename?> Admin Toolbox</h1>
		<h2>View Files</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?=$baseurl?>toolbox/files/add">+ Add New File...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td><?php if ($sortby == 'id') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/files/1/id/<?php if ($changetoasc == 'id') echo 'a'; else echo 'd'; ?>">ID<?php if ($sortby == 'id') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					
					<td class="tdalt"><?php if ($sortby == 'dscr') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/files/1/dscr/<?php if ($changetoasc == 'dscr') echo 'a'; else echo 'd'; ?>">Internal Description<?php if ($sortby == 'dscr') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					
					<td><?php if ($sortby == 'mime') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/files/1/mime/<?php if ($changetoasc == 'mime') echo 'a'; else echo 'd'; ?>">MIME Type<?php if ($sortby == 'mime') { if ($sortdesc) echo "</strong> &#9660;"; else echo "</strong> &#9650;"; } else echo ""; ?></td>
					
					<td class="tdalt"><?php if ($sortby == 'fname') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/files/1/fname/<?php if ($changetoasc == 'fname') echo 'a'; else echo 'd'; ?>">Filename<?php if ($sortby == 'fname') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					
					<td>Is Downloadable</td>
				</tr>
				<?php $altrow = false;				
				foreach ($files as $file) {
				if ($file['id'] < 1) break; ?>
				<tr<?php if (!$altrow) $altrow = true;
				else { echo " class=\"tralt\"";
				$altrow = false;
				}?>>
					<td><strong><?=$file['id']?></strong></td>
					<td class="tdalt"><a href="<?=$baseurl?>toolbox/files/edit/<?=$file['id']?>"><?php if (strlen($file['internalDescription']) > 0) echo $file['internalDescription']; else echo "(no description -- edit this file)"; ?></a></td>
					<td><?=$file['type']?></td>
					<td class="tdalt smallish"><?php if (strlen($file['name']) > 0) echo $file['name']; else echo "(no filename)"; ?></td>
					<td><?php if ($file['isDownloadable'] == 1) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?=$paginationhtml?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>