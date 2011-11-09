<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	$sortdesc = !$sortasc;
	if ($sortdesc)
		$changetoasc = $sortby;
	else
		$changetoasc = "n/a";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Content (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>View Content</h1>
		<div class="mainbox">
			<p style="text-align: center;"><a href="<?php echo $baseurl; ?>toolbox/content/add">+ Add New Content...</a></p>
			<table class="maintable">
				<tr>
					<td><a href="<?php echo $baseurl; ?>toolbox/content/1/id/<?php if ($changetoasc == 'id') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'id') echo "<strong>"; ?>ID<?php if ($sortby == 'id') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					<td><a href="<?php echo $baseurl; ?>toolbox/content/1/name/<?php if ($changetoasc == 'name') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'name') echo "<strong>"; ?>Name<?php if ($sortby == 'name') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					<td><a href="<?php echo $baseurl; ?>toolbox/content/1/cat/<?php if ($changetoasc == 'cat') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'cat') echo "<strong>"; ?>Hub<?php if ($sortby == 'cat') { if ($sortdesc) echo "</strong> <em>(Subcategory)</em> &#9660;"; else echo "</strong> <em>(Subcategory)</em> &#9650;"; } else echo " <em>(Subcategory)</em>"; ?></a></td>
					<td><a href="<?php echo $baseurl; ?>toolbox/content/1/date/<?php if ($changetoasc == 'date') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'date') echo "<strong>"; ?>Date<?php if ($sortby == 'date') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
					<td>User Rating</td>
					<td>Published?</td>
				</tr>
				<?php foreach ($content as $piece) {
				if ($piece['date'] < 1) break; ?>
				<tr>
					<td><strong><?php echo $piece['id']; ?></strong></td>
					<td><a href="<?php echo $baseurl; ?>toolbox/content/edit/<?php echo $piece['id']; ?>"><?php if (strlen($piece['name']) > 0) echo $piece['name']; else echo "(no description -- edit this piece of content)"; ?></a></td>
					<td class="smallish"><?php echo $piece['hub']['name']; ?><?php if ($categorynames[$piece['id']] != $piece['hub']['name']) echo " <em class=\"smallish\">(", $categorynames[$piece['id']], ")</em>"; ?> </td>
					<td class="tdalt smallish"><?php echo date('D, M j, Y @ g:i A',$piece['date']); ?></td>
					<td>&nbsp;</td>
					<td><?php if ($piece['date'] >= time()) echo "<span class=\"notyet\">Not Yet!</span>";
					else if ($piece['published'] != 0) echo "<span class=\"yes\">Yes</span>";
					else echo "<span class=\"no\">No</span>";?></td>
				</tr>
				<?php } ?>
			</table>
			<?php echo $paginationhtml; ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>