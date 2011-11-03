<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Edit News Post (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> News Post</h1>
		<div class="mainbox" style="text-align: center;">
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.</p>
			<form action="<?php echo $thispageurl; ?>" method="post" name="form" id="form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $news['entry']['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr class="tr">
						<td style="width: 150px;">
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Name of the news item.</p>
						</td>
						<td class="td">
								<input type="text" name="name" style="width: 300px;" value="<?php echo $news['entry']['title']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Published (<span style="color: #f00;">*</span>)</p>
							<p class="description">Should this be displayed to the users</p>
						</td>
						<td class="td">
							<select name="published">
							<option value="1"<?php if($news['entry']['published'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($news['entry']['published'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Date/Time</p>
							<p class="description">Format: YYYY-MM-DD at hh:mm (24-hour time!)</p>
							<p class="description">If left blank, will use current date/time. If set to a time later than now, content will remain unpublished until then.</p>
						</td>
						<td class="tdalt">
							<input type="text" name="year" maxlength="4" style="width: 50px;" value="<?php if ($news['entry']['date'] > 0) echo date("Y", $news['entry']['date']); ?>" /> <input type="text" name="month" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("m", $news['entry']['date']); ?>" /> <input type="text" name="day" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("d", $news['entry']['date']); ?>" /> at <input type="text" name="hour" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("H", $news['entry']['date']); ?>" />:<input type="text" name="minute" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("i", $news['entry']['date']); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Short Content</p>
							<p class="description">Shorter version of the article, displayed on the front page.</p>
						</td>
						<td class="td">
							<textarea name="shortcontent" rows="8" cols="60"><?php echo $news['entry']['shortcontent']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Content (<span style="color: #f00;">*</span>)</p>
							<p class="description">Article itself.</p>
						</td>
						<td class="td">
							<textarea name="content" rows="8" cols="60"><?php echo $news['entry']['content']; ?></textarea>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Poster (<span style="color: #f00;">*</span>)</p>
							<p class="description">User ID of the person that the post should be attributed to</p>
						</td>
						<td class="td">
							<input type="text" name="author_id_1" id="author_id_1" style="width: 120px;" value="<?php echo $news['poster']['uid']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/users/select/1','new_win','width=350,height=650');">Browse Users...</a>
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>