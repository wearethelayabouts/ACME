<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; <?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> Category (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> Category</h1>
		<div class="mainbox" style="text-align: center;">
			<p>Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.</p>
			<form action="<?php echo $baseurl; ?>toolbox/categories/commit/<?php echo $thingid; ?>" method="post" name="form" id="form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr class="tr">
						<td style="width: 150px;">
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Name of the category.</p>
						</td>
						<td class="td">
							<input type="text" name="name" style="width: 300px;" value="<?php echo $category['name']; ?>" />
							<?php if (isset($errors['name'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['name']?></p><?php } ?>
						</td>
					</tr>
					<tr>
						<td>
							<p>Description</p>
							<p class="description">Descriptive text to be displayed alongside the content.</p>
						</td>
						<td class="td">
							<textarea name="body" rows="8" cols="60"><?php echo $category['desc']; ?></textarea>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Description background</p>
							<p class="description">Background displayed under the descriptive text.</p>
						</td>
						<td class="td">
							File ID: <input type="text" name="desc_bg" style="width: 80px;" value="<?php if ($category['desc_bg'] > 0) echo $category['desc_bg']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/desc_bg','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>	
					<tr>
						<td>
							<p>Parent Category (<span style="color: #f00;">*</span>)</p>
							<p class="description">Category above the category.</p>
						</td>
						<td class="td">
							<select name="parent_id">
								<?php foreach ($allcategories as $id => $name) {
									if ($id == $category['parent_id']) echo '<option selected="yes" value="';
									else echo '<option value="';
									echo $id;
									echo '">';
									echo $name;
									echo '</option>';
								} ?>
							</select>
							<?php if (isset($errors['parent_id'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['parent_id']?></p><?php } ?>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/content/<strong>kimocpirts</strong></em><br /><em>www.othersite.com/content/<strong>blootoons</strong></em>)</p>
						</td>
						<td class="td">
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $category['slug']; ?>" />
							<?php if (isset($errors['slug'])) { ?><p class="message-error"><strong>ERROR:</strong> <?php echo $errors['slug']; ?></p><?php } ?>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Rating</p>
							<p class="description">Content advisory rating and descriptors, if so desired.</p>	
							<p class="description">If the category has a rating and you leave these fields blank, the content will inherit the category's rating.</p>
							<p class="description">Setting the rating code but not the description will result in a description of "Suitable For All Audiences" (or whatever you have set to your default).</p>
						</td>
						<td class="td">
							Rating Code: <input type="text" name="rating" style="width: 50px;" value="<?php echo $category['rating']; ?>" /><br />
							Rating Descriptors:<br /><textarea name="rating_description" rows="4" cols="35"><?php echo $category['rating_description']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Category Thumbnail</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" id="category_thumbnail" name="category_thumbnail" style="width: 80px;" value="<?php if ($category['category_thumbnail'] > 0) echo $category['category_thumbnail']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/category_thumbnail','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Default Content Thumbnail</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="default_content_thumbnail" style="width: 80px;" value="<?php if ($category['default_content_thumbnail'] > 0) echo $category['default_content_thumbnail']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/default_content_thumbnail','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Comic Navigation: First</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_first" style="width: 80px;" value="<?php if ($category['comicnav_first'] > 0) echo $category['comicnav_first']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_first','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Comic Navigation: Back</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_back" style="width: 80px;" value="<?php if ($category['comicnav_back'] > 0) echo $category['comicnav_back']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_back','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Comic Navigation: Next</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_next" style="width: 80px;" value="<?php if ($category['comicnav_next'] > 0) echo $category['comicnav_next']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_next','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Comic Navigation: Last</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_last" style="width: 80px;" value="<?php if ($category['comicnav_last'] > 0) echo $category['comicnav_last']; ?>" />
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_last','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>Addon Domain</p>
							<p class="description"></p>
						</td>
						<td class="td">
							<input type="text" name="addon_domain" style="width: 120px;" value="<?php echo $category['addon_domain']; ?>" />
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>