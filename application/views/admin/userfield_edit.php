<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Edit Page (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> Page</h1>
		<div class="mainbox" style="text-align: center;">
			<p>Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.</p>
			<?php if ($field['crucial'] == 0) { ?>
			<form action="<?php echo $thispageurl; ?>" method="post">
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $field['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr>
						<td>
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short human readable name for the field</p>
						</td>
						<td>
							<input type="text" name="name" style="width: 120px;" value="<?php echo $field['name']; ?>" />
							<?php if (isset($errors['name'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['name']; ?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short machine readable name for the field</p>
						</td>
						<td>
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $field['slug']; ?>" />
							<?php if (isset($errors['slug'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['name']; ?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Description (<span style="color: #f00;">*</span>)</p>
							<p class="description">Human readable description for the field</p>
						</td>
						<td>
							<input type="text" name="desc" style="width: 120px;" value="<?php echo $field['description']; ?>" />
							<?php if (isset($errors['description'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['description']; ?></p><?php } ?>
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
			<?php } else { ?>
			This is a crucial field and cannot be edited!
			<?php } ?>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>