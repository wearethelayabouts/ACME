<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$sortdesc = !$sortasc;
	if ($sortdesc) $changetoasc = $sortby;
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?=$sitename?> &bull; View All Content (Admin)</title>
		<link href="<?=$baseurl?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?=$baseurl?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?=$sitename?> Admin Toolbox</h1>
		<h2>View Content</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?=$baseurl?>toolbox/content/add">+ Add New Content...</a></p>
			<table class="maintable">
				<tr class="tralt">
					<td><?php if ($sortby == 'id') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/content/1/id/<?php if ($changetoasc == 'id') echo 'a'; else echo 'd'; ?>">ID<?php if ($sortby == 'id') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					<td class="tdalt"><?php if ($sortby == 'name') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/content/1/name/<?php if ($changetoasc == 'name') echo 'a'; else echo 'd'; ?>">Name<?php if ($sortby == 'name') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					
					<td><?php if ($sortby == 'cat') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/content/1/cat/<?php if ($changetoasc == 'cat') echo 'a'; else echo 'd'; ?>">Hub<?php if ($sortby == 'cat') { if ($sortdesc) echo "</strong> <em>(Subcategory)</em> &#9660;"; else echo "</strong> <em>(Subcategory)</em> &#9650;"; } else echo " <em>(Subcategory)</em>"; ?></td>
					
					<td class="tdalt"><?php if ($sortby == 'date') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/content/1/date/<?php if ($changetoasc == 'date') echo 'a'; else echo 'd'; ?>">Date<?php if ($sortby == 'date') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>
					
					<!--<td><?php // if ($sortby == 'rating') echo "<strong>"; ?><a href="<?=$baseurl?>toolbox/content/1/rating/<?php // if ($changetoasc == 'rating') echo 'a'; else echo 'd'; ?>">User Rating<?php // if ($sortby == 'rating') if ($sortdesc) echo "&#9660;</strong>"; else echo "&#9650;</strong>"; ?></td>-->
					
					<td>User Rating</td>
					
					<td class="tdalt">Published?</td>
				</tr>
				<?php $altrow = false;				
				foreach ($content as $piece) {
				if ($piece['date'] < 1) break; ?>
				<tr<?php if (!$altrow) $altrow = true;
				else { echo " class=\"tralt\"";
				$altrow = false;
				}?>>
					<td><strong><?=$piece['id']?></strong></td>
					<td class="tdalt"><a href="<?=$baseurl?>toolbox/content/edit/<?=$piece['id']?>"><?=$piece['name']?></a></td>
					<td class="smallish"><?=$piece['hub']['name']?><?php if ($categorynames[$piece['id']] != $piece['hub']['name']) echo " <em class=\"smallish\">(", $categorynames[$piece['id']], ")</em>"; ?> </td>
					<td class="tdalt smallish"><?php echo date('D, M j, Y @ g:i A',$piece['date']) ?></td>
					<td>&nbsp;</td>
					<td class="tdalt"><?php if ($piece['date'] >= time()) echo "<span class=\"notyet\">Not Yet!</span>";
					else if ($piece['published'] != 0) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?=$paginationhtml?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>