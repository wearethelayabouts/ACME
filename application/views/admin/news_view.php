<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All News Posts (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>View News</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/categories/add">+ Add New News Item...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td>ID</td>
					<td>Poster</td>
					<td>Name</td>
					
					<td>Short Content</td>
					
					<!--<td><?php // if ($sortby == 'rating') echo "<strong>"; ?><a href="<?php echo $baseurl; ?>toolbox/content/1/rating/<?php // if ($changetoasc == 'rating') echo 'a'; else echo 'd'; ?>">User Rating<?php // if ($sortby == 'rating') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>-->
					
					<td class="tdalt">Published?</td>
				</tr>
				<?php $altrow = false;				
				foreach ($news as $piece) { ?>
				<tr<?php if (!$altrow) $altrow = true;
				else { echo " class=\"tralt\"";
				$altrow = false;
				}?>>
					<td><strong><?php echo $piece['entry']['id']; ?></strong></td>
					<td><? echo $piece['poster']['full_name']; ?></td>
					<td class="tdalt"><a href="<?php echo $baseurl; ?>toolbox/news/edit/<?php echo $piece['entry']['id']; ?>"><?php echo $piece['entry']['title']; ?></a></td>
					<td class="smallish"><?php echo $piece['entry']['shortcontent']; ?> </td>
					<td class="tdalt"><?php if ($piece['entry']['published'] != 0) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>