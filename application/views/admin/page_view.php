<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Plays (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'pages'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<legend>
						<table class="UILegend">
							<tr>
								<td class="UILegendTitle">Pages</td>
								<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/pages/add">Add</a></td>
							</tr>
						</table>
					</legend>
					<div class="content nopadding">
						<table class="UITable">
							<tr>
								<td width="1px">ID</td>
								<td>Name</td>
							</tr>
							<?php foreach ($pages as $piece) { ?>
							<tr>
								<td><strong><?php echo $piece['id']; ?></strong></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/pages/edit/<?php echo $piece['id']; ?>"><?php if (strlen($piece['slug']) > 0) echo $piece['slug']; else echo "(no name -- edit this page)";  ?></a></td>
							</tr>
							<?php } ?>
						</table>
						<?php echo $paginationhtml; ?>
					</div>
				</fieldset>
			</div>
		</div>
		<div id="UIFooter">
			&nbsp;
			<div id="alignright">
				<a href="/auth/logout">Logout</a>
			</div>
		</div>
	</body>
</html>