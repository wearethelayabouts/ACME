<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Content (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'files'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle"><?php if ($editexisting) echo "Edit"; else echo "Add"; ?> File</h1></td>
							<td class="UILegendActions"><?php if ($editexisting) { ?><a href="<?php echo $baseurl; ?>toolbox/delete/files/<?php echo $file['id']; ?>/confirm">Delete</a><?php } ?></td>
						</tr>
					</table>
					<div class="content nopadding">
						<?php foreach ($errors as $error) { ?>
						<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
						<?php } ?>
						<p>
							Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
						</p>
						<form action="<?php echo $thispageurl; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
							<input type="hidden" name="commit" value="true" />
							<input type="hidden" name="id" value="<?php echo $file['id']; ?>" />
							<table class="UITable">
								<tr>
									<td width="350px">
										<p>Internal Description</p>
										<p class="description">Description of the file, for your own reference. Not required, but recommended.</p>
									</td>
									<td>
										<textarea name="internal_description" rows="8" cols="60"><?php echo $file['internal_description']; ?></textarea>
									</td>
								</tr>
								<tr>
									<td style="width: 150px;">
										<p>File Type (<span style="color: #f00;">*</span>)</p>
										<p class="description">File extension of the file (e.g. png, jpg, mp3...).</p>
									</td>
									<td>
										<input type="text" name="type" style="width: 300px;" value="<?php echo $file['type']; ?>" />
									</td>
								</tr>
								<tr>
									<td style="width: 150px;">
										<p>Filename</p>
										<p class="description">Self-explanatory. Only required if the file is Downloadable (see below).</p>
									</td>
									<td>
										<input type="text" name="name" style="width: 300px;" value="<?php echo $file['name']; ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<p>Is Downloadable? (<span style="color: #f00;">*</span>)</p>
										<p class="description">If unchecked, a Download link cannot appear on content pages (for things like images).</p>
									</td>
									<td>
										<input type="checkbox" name="is_downloadable"<?php if ($file['is_downloadable']) echo "checked=\"checked\""; ?>" />
									</td>
								</tr>	
								<tr>
									<td style="width: 150px;">
										<p>File (<span style="color: #f00;">*</span>)</p>
										<p class="description"><?php if ($editexisting) { ?>This will OVERWRITE the file you're editing! Be careful!!<?php } else { ?>Self-explanatory.<?php } ?></p>
									</td>
									<td>
										<input type="file" name="userfile" enctype="multipart/form-data" style="width: 300px;" />
									</td>
								</tr>			
							</table>
							<input type="submit" />
						</form>
					</div>
				</fieldset>
			</div>
		</div>
	</body>
</html>