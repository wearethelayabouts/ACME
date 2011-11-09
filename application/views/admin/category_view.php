<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Categories (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>View Categories</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/categories/add">+ Add New Category...</a></p>
			<table class="maintable">
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Parent Category</td>
					<td>Published?</td>
				</tr>
				<?php foreach ($categories as $piece) { ?>
				<tr>
					<td><strong><?php echo $piece['id']; ?></strong></td>
					<td><a href="<?php echo $baseurl; ?>toolbox/categories/edit/<?php echo $piece['id']; ?>"><?php if (strlen($piece['name']) > 0) echo $piece['name']; else echo "(no description -- edit this category)"; ?></a></td>
					<td class="smallish"><?php if ($piece['parent_id'] != 0) echo $categories[$piece['parent_id']]['name'];
					else echo "None"; ?> </td>
					<td><?php if ($piece['published'] != 0) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>