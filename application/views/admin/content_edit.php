<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?=$sitename?> &bull; View All Content (Admin)</title>
		<link href="<?=$baseurl?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?=$baseurl?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?=$sitename?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> Content</h1>
		<div class="mainbox" style="text-align: center;">
			<p>Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.</p>
			<form action="<?=$thispageurl?>" method="post">
				<input type="hidden" name="commit" value="true" />
				<table class="maintable" style="text-align: left;">
					<tr class="tralt">
						<td style="width: 150px;">
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Name of the piece of content.</p>
						</td>
						<td class="tdalt">
							<input type="text" name="name" style="width: 300px;" value="<?php echo $content['name']; ?>" />
							<?php if ($errors['name']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['name']?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Category (<span style="color: #f00;">*</span>)</p>
							<p class="description">Category that the piece goes in (lowest level).</p>
						</td>
						<td class="tdalt">
							<select name="category_id">
								<?php foreach ($allcategories as $id => $name) {
									if ($id == $content['category_id']) echo '<option selected="yes" value="';
									else echo '<option value="';
									echo $id;
									echo '">';
									echo $name;
									echo '</option>';
								} ?>
							</select>
						</td>
					</tr>
					<tr class="tralt">
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/content/kimocpirts/<strong>achkei</strong></em><br /><em>www.othersite.com/content/blootoons/<strong>23</strong></em>)</p>
						</td>
						<td class="tdalt">
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $content['slug']; ?>" />
							<?php if ($errors['slug']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['slug']?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Date/Time</p>
							<p class="description">Format: YYYY-MM-DD at hh:mm (24-hour time!)</p>
							<p class="description">If left blank, will use current date/time. If set to a time later than now, content will remain unpublished until then.</p>
						</td>
						<td class="tdalt">
							<input type="text" name="year" maxlength="4" style="width: 50px;" value="<?php if ($content['date'] > 0) echo date("Y", $content['date']); ?>" /> <input type="text" name="month" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("m", $content['date']); ?>" /> <input type="text" name="day" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("d", $content['date']); ?>" /> at <input type="text" name="hour" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("H", $content['date']); ?>" />:<input type="text" name="minute" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("i", $content['date']); ?>" />
							<?php if ($errors['year']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['year']?></p><?php } ?>
							<?php if ($errors['month']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['month']?></p><?php } ?>
							<?php if ($errors['day']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['day']?></p><?php } ?>
							<?php if ($errors['hour']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['hour']?></p><?php } ?>
							<?php if ($errors['minute']) { ?><p class="message-error"><strong>ERROR:</strong> <?=$errors['minute']?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Description</p>
							<p class="description">Descriptive text to be displayed alongside the content.</p>
						</td>
						<td class="tdalt">
							<textarea name="body" rows="8" cols="60"><?=$content['body']?></textarea>
						</td>
					</tr>
					<tr class="tralt">
						<td>
							<p>Rating</p>
							<p class="description">Content advisory rating and descriptors, if so desired.</p>	
							<p class="description">If the category has a rating and you leave these fields blank, the content will inherit the caregory's rating.</p>
							<p class="description">Setting the rating code but not the description will result in a description of "Suitable For All Audiences" (or whatever you have set to your default).</p>
						</td>
						<td class="tdalt">
							Rating Code: <input type="text" name="rating" style="width: 50px;" value="<?php echo $content['rating']; ?>" /><br />
							Rating Descriptors:<br /><textarea name="rating_description" rows="4" cols="35"><?php echo $content['rating_description']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Custom Embed</p>
							<p class="description">Any HTML in this field will be inserted into the page in the content area. This is useful for, say, embedding an external player like one from YouTube or SoundCloud, or a Flash movie.</p>
						</td>
						<td class="tdalt">
							<textarea name="customembed" rows="8" cols="60"><?php echo $content['customEmbed']; ?></textarea>
						</td>
					</tr>					
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>