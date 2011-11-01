<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Pages (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>View Pages</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/pages/add">+ Add New Page...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td>ID</td>
					<td>Name</td>
				</tr>
				<?php $altrow = false;				
				foreach ($pages as $piece) { ?>
				<tr<?php if (!$altrow) $altrow = true;
				else { echo " class=\"tralt\"";
				$altrow = false;
				}?>>
					<td><strong><?php echo $piece['id']; ?></strong></td>
					<td class="tdalt"><a href="<?php echo $baseurl; ?>toolbox/pages/edit/<?php echo $piece['id']; ?>"><?php echo $piece['slug']; ?></a></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>