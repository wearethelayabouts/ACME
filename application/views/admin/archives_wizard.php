<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Create an Archive (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2>Create an Archive</h1>
		<div class="mainbox" style="text-align: center;">
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>
				Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
			</p>
			<form action="<?php echo $baseurl; ?>toolbox/archives/run/<?php echo $category['id']; ?>" method="post" name="form" id="form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="act" value="create" />
				<table class="maintable" style="text-align: left;">
					<tr class="tr">
						<td style="width: 150px;">
							<p>Name</p>
							<p class="description">Name of the category the archive will be generated for.</p>
						</td>
						<td class="td">
							<?php echo $category['name']; ?>
						</td>
					</tr>
					<tr class="tr">
						<td style="width: 150px;">
							<p>Archive Type (<span style="color: #f00;">*</span>)</p>
							<p class="description">How should we compress this?</p>
						</td>
						<td class="td">
							<select name="type">
								<?php foreach ($formats as $ext => $name) { ?>
								<option value="<?php echo $ext; ?>"><?php echo $name; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
				</table>
				<input type="submit" />
				(be patient after clicking this, it might take a while!)
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>