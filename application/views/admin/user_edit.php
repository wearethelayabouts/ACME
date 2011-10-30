<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; <?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> User (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> User</h1>
		<div class="mainbox" style="text-align: center;">
			<p>Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.</p>
			<form action="<?php echo $thispageurl; ?>" method="post">
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
				<table class="maintable" style="text-align: left;">
				    <?php foreach ($user['fields'] as $field) { ?>
					<tr>
						<td>
							<p><?php echo $field['metadata']['name']; ?> <?php if ($field['metadata']['crucial'] == 1) { ?>(<span style="color: #f00;">*</span>)<?php } ?></p>
							<p class="description"><?php echo $field['metadata']['description']; ?></p>
						</td>
						<td class="tdalt">
							<input type="text" name="<?php echo $field['metadata']['slug']; ?>" style="width: 120px;" value="<?php echo $field['data']; ?>" />
							<?php if (isset($errors['name'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['name']; ?></p><?php } ?>
						</td>
					</tr>
                    <?php } ?>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>