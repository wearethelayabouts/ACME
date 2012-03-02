<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Create an Archive (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'categories'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<legend>Generate Archive</legend>
					<div class="content nopadding">	
						<?php foreach ($errors as $error) { ?>
						<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
						<?php } ?>
						<div class="padding">
							Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
						</div>
						<form action="<?php echo $baseurl; ?>toolbox/archives/run/<?php echo $category['id']; ?>" method="post" name="form" id="form">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
							<input type="hidden" name="act" value="create" />
							<table class="UITable">
								<tr>
									<td style="width: 150px;">
										<p>Name</p>
										<p class="description">Name of the category the archive will be generated for.</p>
									</td>
									<td>
										<?php echo $category['name']; ?>
									</td>
								</tr>
								<tr>
									<td style="width: 150px;">
										<p>Archive Type (<span style="color: #f00;">*</span>)</p>
										<p class="description">How should we compress this?</p>
									</td>
									<td>
										<select name="type">
											<?php foreach ($formats as $ext => $name) { ?>
											<option value="<?php echo $ext; ?>"><?php echo $name; ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
							<center>
								<input type="submit" /><br />
								(be patient after clicking this, it might take a while!)
							</center>
						</form>
					</div>
				</fieldset>
			</div>
		</div>
	</body>
</html>