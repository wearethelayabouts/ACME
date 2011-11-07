<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>
				<a href="<?php echo $baseurl; ?>toolbox/delete/pages/<?php echo $page['id']; ?>/confirm">- Delete...</a>
				<br /><br />
				Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
			</p>
			<form action="<?php echo $thispageurl; ?>" method="post">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $page['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr class="tralt">
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/page/<strong>achkei</strong></em><br /><em>www.othersite.com/page/<strong>23</strong></em>)</p>
						</td>
						<td class="tdalt">
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $page['slug']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Custom CSS</p>
							<p class="description">Shorter version of the article, displayed on the front page.</p>
						</td>
						<td class="td">
							<textarea name="custom_css" rows="8" cols="60"><?php echo $page['custom_css']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Content (<span style="color: #f00;">*</span>)</p>
							<p class="description">Page itself.</p>
						</td>
						<td class="td">
							<textarea name="content" rows="8" cols="60"><?php echo $page['content']; ?></textarea>
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>