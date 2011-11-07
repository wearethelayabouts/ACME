<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Content (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> File</h1>
		<div class="mainbox" style="text-align: center;">
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>
				<a href="<?php echo $baseurl; ?>toolbox/delete/files/<?php echo $file['id']; ?>/confirm">- Delete...</a>
				<br /><br />
				Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
			</p>
			<form action="<?php echo $thispageurl; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $file['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr class="tralt">
						<td>
							<p>Internal Description</p>
							<p class="description">Description of the file, for your own reference. Not required, but recommended.</p>
						</td>
						<td class="tdalt">
							<textarea name="internal_description" rows="8" cols="60"><?php echo $file['internal_description']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td style="width: 150px;">
							<p>File Type (<span style="color: #f00;">*</span>)</p>
							<p class="description">File extension of the file (e.g. png, jpg, mp3...).</p>
						</td>
						<td class="tdalt">
							<input type="text" name="type" style="width: 300px;" value="<?php echo $file['type']; ?>" />
						</td>
					</tr>
					<tr class="tralt">
						<td style="width: 150px;">
							<p>Filename</p>
							<p class="description">Self-explanatory. Only required if the file is Downloadable (see below).</p>
						</td>
						<td class="tdalt">
							<input type="text" name="name" style="width: 300px;" value="<?php echo $file['name']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Is Downloadable? (<span style="color: #f00;">*</span>)</p>
							<p class="description">If unchecked, a Download link cannot appear on content pages (for things like images).</p>
						</td>
						<td class="tdalt">
							<input type="checkbox" name="is_downloadable"<?php if ($file['is_downloadable']) echo "checked=\"checked\""; ?>" />
						</td>
					</tr>	
					<tr class="tralt">
						<td style="width: 150px;">
							<p>File (<span style="color: #f00;">*</span>)</p>
							<p class="description"><?php if ($editexisting) { ?>This will OVERWRITE the file you're editing! Be careful!!<?php } else { ?>Self-explanatory.<?php } ?></p>
						</td>
						<td class="tdalt">
							<input type="file" name="userfile" enctype="multipart/form-data" style="width: 300px;" />
						</td>
					</tr>			
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>