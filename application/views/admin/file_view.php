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
		<title><?php echo $sitename; ?> &bull; View All Files (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'files'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle">Files</td>
							<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/files/add">Add</a></td>
						</tr>
					</table>
					<div class="content nopadding">
						<table class="UITable">
							<tr>
								<td><a href="<?php echo $baseurl; ?>toolbox/files/1/id/<?php if ($changetoasc == 'id') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'id') echo "<strong>"; ?>ID<?php if ($sortby == 'id') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/files/1/dscr/<?php if ($changetoasc == 'dscr') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'dscr') echo "<strong>"; ?>Internal Description<?php if ($sortby == 'dscr') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/files/1/type/<?php if ($changetoasc == 'type') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'type') echo "<strong>"; ?>File Type<?php if ($sortby == 'type') { if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; } else echo ""; ?></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/files/1/fname/<?php if ($changetoasc == 'fname') echo 'a'; else echo 'd'; ?>"><?php if ($sortby == 'fname') echo "<strong>"; ?>Filename<?php if ($sortby == 'fname') if ($sortdesc) echo "&#9660;</a></strong>"; else echo "&#9650;</a></strong>"; ?></td>
								<td>Is Downloadable</td>
							</tr>
							<?php foreach ($files as $file) {
							if ($file['id'] < 1) break; ?>
							<tr>
								<td><strong><?php echo $file['id']; ?></strong></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/files/edit/<?php echo $file['id']; ?>"><?php if (strlen($file['internal_description']) > 0) echo $file['internal_description']; else echo "(no description -- edit this file)"; ?></a></td>
								<td><?php echo $file['type']; ?></td>
								<td class="tdalt smallish"><?php if (strlen($file['name']) > 0) echo $file['name']; else echo "(no filename)"; ?></td>
								<td><?php if ($file['is_downloadable'] == 1) echo "<span class=\"yes\">Yes</span>";
								else echo "<span class=\"no\">No</span>";?></td>
							</tr>
							<?php } ?>
						</table>
						<center><?php echo $paginationhtml; ?></center>
					</div>
				</div>
			</fieldset>
		</div>
		<div id="UIFooter">
			&nbsp;
			<div id="alignright">
				<a href="/auth/logout">Logout</a>
			</div>
		</div>
	</body>
</html>