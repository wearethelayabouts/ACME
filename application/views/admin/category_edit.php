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
			<form action="<?php echo $thispageurl; ?>" method="post">
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
                    		<p>desc_bg</p>
                    		<p class="description"></p>
                    	</td>
                    	<td class="td">
                    		File ID: <input type="text" name="desc_bg" style="width: 80px;" value="<?php if ($category['desc_bg'] > 0) echo $category['desc_bg']; ?>" />
                    		 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
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
							<p>category_thumbnail</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" id="category_thumbnail" name="category_thumbnail" style="width: 80px;" value="<?php if ($category['category_thumbnail'] > 0) echo $category['category_thumbnail']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>default_content_thumbnail</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="default_content_thumbnail" style="width: 80px;" value="<?php if ($category['default_content_thumbnail'] > 0) echo $category['default_content_thumbnail']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>comicnav_first</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_first" style="width: 80px;" value="<?php if ($category['comicnav_first'] > 0) echo $category['comicnav_first']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>comicnav_back</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_back" style="width: 80px;" value="<?php if ($category['comicnav_back'] > 0) echo $category['comicnav_back']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>comicnav_next</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_back" style="width: 80px;" value="<?php if ($category['comicnav_next'] > 0) echo $category['comicnav_next']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>comicnav_last</p>
							<p class="description"></p>
						</td>
						<td class="td">
							File ID: <input type="text" name="comicnav_last" style="width: 80px;" value="<?php if ($category['comicnav_last'] > 0) echo $category['comicnav_last']; ?>" />
							 &nbsp; &nbsp; &nbsp; <a href="#">+ Add New File...</a> &nbsp; &nbsp; &nbsp; <a href="#">Browse Files...</a>
						</td>
					</tr>
					<tr class="tr">
						<td>
							<p>addon_domain</p>
							<p class="description"></p>
						</td>
						<td class="td">
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $category['addon_domain']; ?>" />
						</td>
					</tr>
				</table>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>