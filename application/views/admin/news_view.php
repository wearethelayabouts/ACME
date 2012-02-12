<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All News Posts (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'news'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle">News</td>
							<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/news/add">Add</a></td>
						</tr>
					</table>
					<div class="content nopadding">
						<table class="UITable">
							<tr>
								<td>ID</td>
								<td width="100px">Poster</td>
								<td width="200px">Name</td>
								<td>Short Content</td>
								<td>Published?</td>
							</tr>
							<?php foreach ($news as $piece) { ?>
							<tr>
								<td><strong><?php echo $piece['entry']['id']; ?></strong></td>
								<td><? echo $piece['poster']['full_name']; ?></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/news/edit/<?php echo $piece['entry']['id']; ?>"><?php if (strlen($piece['entry']['title']) > 0) echo $piece['entry']['title']; else echo "(no name -- edit this piece of news)";  ?></a></td>
								<td class="smallish"><?php echo $piece['entry']['shortcontent']; ?> </td>
								<td><?php if ($piece['entry']['published'] != 0) echo "<span class=\"yes\">Yes</span>";
								else echo "<span class=\"no\">No</span>";?></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</fieldset>
			</div>
			<?php echo $paginationhtml; ?>
		</div>
		<div id="UIFooter">
			&nbsp;
			<div id="alignright">
				<a href="/auth/logout">Logout</a>
			</div>
		</div>
	</body>
</html>