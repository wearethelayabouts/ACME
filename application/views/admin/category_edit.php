<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>
				<?php if ($editexisting) { ?><?php if ($category['allow_zip']) { ?><a href="<?php echo $baseurl; ?>toolbox/archives/wizard/<?php echo $category['id'] ?>">+ Generate Archive...</a><?php } ?>
				<a href="<?php echo $baseurl; ?>toolbox/delete/category/<?php echo $category['id']; ?>/confirm">- Delete...</a>
				<br /><br /><?php } ?>
				Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
			</p>
			<form action="<?php echo $thispageurl; ?>" method="post" name="form" id="form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $category['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr>
						<td style="width: 150px;">
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Name of the category.</p>
						</td>
						<td>
							<input type="text" name="name" style="width: 300px;" value="<?php echo $category['name']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Description</p>
							<p class="description">Descriptive text to be displayed alongside the content.</p>
						</td>
						<td>
							<textarea name="body" rows="8" cols="60"><?php echo $category['desc']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Description background</p>
							<p class="description">Background displayed under the descriptive text.</p>
						</td>
						<td>
							File ID: <input type="text" name="desc_bg" style="width: 80px;" value="<?php if ($category['desc_bg'] > 0) echo $category['desc_bg']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/desc_bg','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/desc_bg','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>	
					<tr>
						<td>
							<p>Parent Category (<span style="color: #f00;">*</span>)</p>
							<p class="description">Category above the category.</p>
						</td>
						<td>
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
						</td>
					</tr>
					<tr>
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/content/<strong>kimocpirts</strong></em><br /><em>www.othersite.com/content/<strong>blootoons</strong></em>)</p>
						</td>
						<td>
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $category['slug']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Published (<span style="color: #f00;">*</span>)</p>
							<p class="description">Should this be displayed to the users</p>
						</td>
						<td>
							<select name="published">
							<option value="1"<?php if($category['published'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($category['published'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Hub? (<span style="color: #f00;">*</span>)</p>
							<p class="description">Indicates if the category is a hub or not. The slug of this category is used when calculating the content's URL.</p>
						</td>
						<td>
							<select name="is_hub">
							<option value="1"<?php if($category['is_hub'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($category['is_hub'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Return All Content? (<span style="color: #f00;">*</span>)</p>
							<p class="description">Indicates if when viewing the category, content under this category's subcategories should be included as well.</p>
						</td>
						<td>
							<select name="return_all_content">
							<option value="1"<?php if($category['return_all_content'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($category['return_all_content'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Allow archive downloads? (<span style="color: #f00;">*</span>)</p>
							<p class="description">Indicates if a option should be displayed to the user for downloading an archive file of the category's contents.</p>
							<p class="description"><b>Note:</b> After enabling this you must return to this page and generate an archive file.</p>
						</td>
						<td>
							<select name="allow_zip">
							<option value="1"<?php if($category['allow_zip'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($category['allow_zip'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Sorting Order (<span style="color: #f00;">*</span>)</p>
							<p class="description">How should ACME sort the category's content.</p>
						</td>
						<td>
							<select name="oldest_first">
							<option value="0"<?php if($category['oldest_first'] == 0) echo ' selected="yes"';?>>Newest first</option>
							<option value="1"<?php if($category['oldest_first'] == 1) echo ' selected="yes"';?>>Oldest first</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Allow play all? (<span style="color: #f00;">*</span>)</p>
							<p class="description">Indicates if a option should be displayed to the user for playing all of the songs inside of the category.</p>
						</td>
						<td>
							<select name="allow_play_all">
							<option value="1"<?php if($category['allow_play_all'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($category['allow_play_all'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="width: 150px;">
							<p>List Priority (<span style="color: #f00;">*</span>)</p>
							<p class="description">In what order should this category appear when viewed in it's parent category? Higher numbers come first.</p>
						</td>
						<td>
							<input type="text" name="list_priority" style="width: 300px;" value="<?php echo $category['list_priority']; ?>" />
						</td>
					</tr>
					<tr>
						<td style="width: 150px;">
							<p>Category Template</p>
							<p class="description">Template used to display the category. Falls back to site default if blank.</p>
						</td>
						<td>
							<input type="text" name="category_template" style="width: 300px;" value="<?php echo $category['category_template']; ?>" />
						</td>
					</tr>
					<tr>
						<td style="width: 150px;">
							<p>Content Template</p>
							<p class="description">Template used to display content inside the category. Falls back to site default if blank.</p>
						</td>
						<td>
							<input type="text" name="content_template" style="width: 300px;" value="<?php echo $category['content_template']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Rating</p>
							<p class="description">Content advisory rating and descriptors, if so desired.</p>	
							<p class="description">If the category has a rating and you leave these fields blank, the content will inherit the category's rating.</p>
							<p class="description">Setting the rating code but not the description will result in a description of "Suitable For All Audiences" (or whatever you have set to your default).</p>
						</td>
						<td>
							Rating Code: <input type="text" name="rating" style="width: 50px;" value="<?php echo $category['rating']; ?>" /><br />
							Rating Descriptors:<br /><textarea name="rating_description" rows="4" cols="35"><?php echo $category['rating_description']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Category Thumbnail</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" id="category_thumbnail" name="category_thumbnail" style="width: 80px;" value="<?php if ($category['category_thumbnail'] > 0) echo $category['category_thumbnail']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/category_thumbnail','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/category_thumbnail','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Default Content Thumbnail</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" name="default_content_thumbnail" style="width: 80px;" value="<?php if ($category['default_content_thumbnail'] > 0) echo $category['default_content_thumbnail']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/default_content_thumbnail','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/default_content_thumbnail','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Comic Navigation: First</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" name="comicnav_first" style="width: 80px;" value="<?php if ($category['comicnav_first'] > 0) echo $category['comicnav_first']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/comicnav_first','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_first','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Comic Navigation: Back</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" name="comicnav_back" style="width: 80px;" value="<?php if ($category['comicnav_back'] > 0) echo $category['comicnav_back']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/comicnav_back','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_back','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Comic Navigation: Next</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" name="comicnav_next" style="width: 80px;" value="<?php if ($category['comicnav_next'] > 0) echo $category['comicnav_next']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/comicnav_next','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_next','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Comic Navigation: Last</p>
							<p class="description"></p>
						</td>
						<td>
							File ID: <input type="text" name="comicnav_last" style="width: 80px;" value="<?php if ($category['comicnav_last'] > 0) echo $category['comicnav_last']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/comicnav_last','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/comicnav_last','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Addon Domain</p>
							<p class="description"></p>
						</td>
						<td>
							<input type="text" name="addon_domain" style="width: 120px;" value="<?php echo $category['addon_domain']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Subcategory name</p>
							<p class="description">What should this category's subcategories be labeled as?</p>
						</td>
						<td>
							<input type="text" name="subcategory_name" style="width: 120px;" value="<?php echo $category['subcategory_name']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Show subcontent prefixes? (<span style="color: #f00;">*</span>)</p>
							<p class="description">If disabled, users browsing this category will not see the hub name listed before content pieces with a hub deeper than this category.</p>
						</td>
						<td>
							<select name="no_subcontent_prefixes">
							<option value="0"<?php if($category['no_subcontent_prefixes'] == 0) echo ' selected="yes"';?>>Yes</option>
							<option value="1"<?php if($category['no_subcontent_prefixes'] == 1) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Show content prefixes? (<span style="color: #f00;">*</span>)</p>
							<p class="description">If disabled, users seeing a piece of content in this hub in a higher category will not see the hub name listed before the content piece.</p>
						</td>
						<td>
							<select name="no_content_prefixes">
							<option value="0"<?php if($category['no_content_prefixes'] == 0) echo ' selected="yes"';?>>Yes</option>
							<option value="1"<?php if($category['no_content_prefixes'] == 1) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>