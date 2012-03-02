<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Categories (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'categories'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle">Category</td>
							<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/categories/add">Add</a></td>
						</tr>
					</table>
					<div class="content nopadding">	
						<table class="UITable">
							<tr>
								<td>ID</td>
								<td>Name</td>
								<td>Parent Category</td>
								<td>Published?</td>
								<td>Date</td>
							</tr>
							<?php foreach ($categories as $piece) { ?>
							<tr>
								<td><strong><?php echo $piece['id']; ?></strong></td>
								<td><a href="<?php echo $baseurl; ?>toolbox/categories/edit/<?php echo $piece['id']; ?>"><?php if (strlen($piece['name']) > 0) echo $piece['name']; else echo "(no description -- edit this category)"; ?></a></td>
								<td class="smallish"><?php if ($piece['parent_id'] != 0) echo $categories[$piece['parent_id']]['name'];
								else echo "None"; ?> </td>
								<td><?php if ($piece['published'] != 0) echo "<span class=\"yes\">Yes</span>";
								else echo "<span class=\"no\">No</span>";?></td>
								<td><?php if ($piece['date'] > 0) { echo date('D, M j, Y @ g:i A',$piece['date']); } ?></td>
							</tr>
							<?php } ?>
						</table>
						<?php echo $paginationhtml; ?>
					</div>
				</div>
			</fieldset>
		</div>
	</body>
</html>