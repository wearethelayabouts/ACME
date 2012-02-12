<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All User Fields (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'user_fields'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<legend>
						<table class="UILegend">
							<tr>
								<td class="UILegendTitle">User Fields</td>
								<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/user_fields/add">Add</a></td>
							</tr>
						</table>
					</legend>
					<div class="content nopadding">
						<table class="UITable">
							<tr>
								<td>ID</td>
								<td>Name</td>
								<td>Slug</td>
								<td>Description</td>
								<td>Crucial</td>
							</tr>
							<?php foreach ($userFields as $piece) { ?>
							<tr>
								<td><strong><?php echo $piece['id']; ?></strong></td>
								<td><?php if ($piece['crucial'] == 0) { ?><a href="<?php echo $baseurl; ?>toolbox/user_fields/edit/<?php echo $piece['id']; ?>"><?php if (strlen($piece['name']) > 0) echo $piece['name']; else echo "(no description -- edit this userfield)"; ?></a><?php } else { if (strlen($piece['name']) > 0) echo $piece['name']; else echo "(no description)"; } ?></td>
								<td><?php echo $piece['slug']; ?></td>
								<td><?php echo $piece['description']; ?></td>
								<td><?php if ($piece['crucial'] == 0) echo "<span class=\"no\">No</span>";
								else if ($piece['crucial'] == 1) echo "<span class=\"yes\">Yes</span>";?></td>
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