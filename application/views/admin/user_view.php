<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Users (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'users'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle">Users</td>
							<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/users/add">Add</a></td>
						</tr>
					</table>
					<div class="content nopadding">
						<table class="UITable">
							<tr>
								<td>ID</td>
								<td>Name</td>
							</tr>
							<?php foreach ($users as $id => $piece) { ?>
							<tr>
								<td><strong><?php echo $id; ?></strong></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/users/edit/<?php echo $id; ?>"><?php if (strlen($piece['full_name']) > 0) echo $piece['full_name']; else echo "(no name -- edit this user)"; ?></a></td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</fieldset>
			</div>
			<?php echo $paginationhtml; ?>
		</div>
	</body>
</html>