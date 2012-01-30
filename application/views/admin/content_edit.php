<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Edit Content (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/admin.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="/includes/ext/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" >
		tinyMCE.init({
		        mode : "exact",
		        theme : "advanced",
		        skin : "o2k7",
		        skin_variant : "silver",
		        theme_advanced_toolbar_location : "top",
		        theme_advanced_toolbar_align : "left",
		        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,hr,removeformat,visualaid,|,sub,sup,|,charmap,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		        theme_advanced_buttons2 : "",
		        theme_advanced_buttons3 : "",
		        elements : "desc, custom_embed",
		        theme_advanced_statusbar_location : "bottom",
		        theme_advanced_resizing : true,
		        valid_elements : "*[*]"
		});
		</script>
		<script type="text/javascript">
			function addAuthorFields() {
				nextauthor = parseInt($("#author_amt").attr("value")) + 1;
				$("#author_amt").attr("value", nextauthor);
				content = "<input type=\"hidden\" name=\"author_dbid_"+nextauthor+"\" style=\"width: 80px;\" value=\"nopechucktesta\" />Author ID: <input type=\"text\" name=\"author_id_"+nextauthor+"\" style=\"width: 80px;\" value=\"\" /> &nbsp; &nbsp; &nbsp; <a href=\"javascript:void();\" onclick=\"window.open('/toolbox/popup/users/select/"+nextauthor+"','new_win','width=350,height=650');\">Browse Users...</a> &nbsp; &nbsp; &nbsp; Role: <input type=\"text\" name=\"author_role_"+nextauthor+"\" style=\"width: 160px;\" value=\"\" /><br />";
				
				$("#authorsbox").append(content);
			}
		</script>
	</head>
	<body>
		<img src="<?php echo $baseurl; ?>includes/acme/logo.png" alt="ACME: Awesome Creative Media Engine" title="ACME: Awesome Creative Media Engine" />
		<h1><?php echo $sitename; ?> Admin Toolbox</h1>
		<h2><?php if ($editexisting) echo "Edit"; else echo "Add New"; ?> Content</h1>
		<div class="mainbox" style="text-align: center;">
			<?php foreach ($errors as $error) { ?>
			<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
			<?php } ?>
			<p>
				<?php if ($editexisting) { ?><a href="<?php echo $baseurl; ?>toolbox/delete/content/<?php echo $content['id']; ?>/confirm">- Delete...</a>
				<br /><br /><?php } ?>
				Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
			</p>
			<form action="<?php echo $thispageurl; ?>" method="post" id="form" name="form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
				<input type="hidden" name="commit" value="true" />
				<input type="hidden" name="id" value="<?php echo $content['id']; ?>" />
				<table class="maintable" style="text-align: left;">
					<tr>
						<td style="width: 150px;">
							<p>Name (<span style="color: #f00;">*</span>)</p>
							<p class="description">Name of the piece of content.</p>
						</td>
						<td>
							<input type="text" name="name" style="width: 300px;" value="<?php echo $content['name']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Category (<span style="color: #f00;">*</span>)</p>
							<p class="description">Category that the piece goes in (lowest level).</p>
						</td>
						<td>
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
					<tr>
						<td>
							<p>Slug (<span style="color: #f00;">*</span>)</p>
							<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/content/kimocpirts/<strong>achkei</strong></em><br /><em>www.othersite.com/content/blootoons/<strong>23</strong></em>)</p>
						</td>
						<td>
							<input type="text" name="slug" style="width: 120px;" value="<?php echo $content['slug']; ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Published (<span style="color: #f00;">*</span>)</p>
							<p class="description">Should this be displayed to the users</p>
						</td>
						<td>
							<select name="published">
							<option value="1"<?php if($content['published'] == 1) echo ' selected="yes"';?>>Yes</option>
							<option value="0"<?php if($content['published'] == 0) echo ' selected="yes"';?>>No</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<p>Date/Time</p>
							<p class="description">Format: YYYY-MM-DD at hh:mm (24-hour time!)</p>
							<p class="description">If left blank, will use current date/time. If set to a time later than now, content will remain unpublished until then.</p>
						</td>
						<td>
							<input type="text" name="year" maxlength="4" style="width: 50px;" value="<?php if ($content['date'] > 0) echo date("Y", $content['date']); ?>" /> <input type="text" name="month" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("m", $content['date']); ?>" /> <input type="text" name="day" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("d", $content['date']); ?>" /> at <input type="text" name="hour" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("H", $content['date']); ?>" />:<input type="text" name="minute" maxlength="2" style="width: 30px;" value="<?php if ($content['date'] > 0) echo date("i", $content['date']); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<p>Description</p>
							<p class="description">Descriptive text to be displayed alongside the content.</p>
						</td>
						<td>
							<textarea id="desc" name="desc" rows="8" cols="100"><?php echo $content['body']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Rating</p>
							<p class="description">Content advisory rating and descriptors, if so desired.</p>	
							<p class="description">If the category has a rating and you leave these fields blank, the content will inherit the caregory's rating.</p>
							<p class="description">Setting the rating code but not the description will result in a description of "Suitable For All Audiences" (or whatever you have set to your default).</p>
						</td>
						<td>
							Rating Code: <input type="text" name="rating" style="width: 50px;" value="<?php echo $content['rating']; ?>" /><br />
							Rating Descriptors:<br /><textarea name="rating_description" rows="4" cols="35"><?php echo $content['rating_description']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Main File Attachment</p>
							<p class="description">The main file attachment for this content (e.g. an image file for a comic, an mp3 for a song...). Not required.</p>
						</td>
						<td>
							File ID: <input type="text" id="main_attachment_id" name="main_attachment" style="width: 80px;" value="<?php if ($content['main_attachment'] > 0) echo $content['main_attachment']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/main_attachment_id','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/main_attachment_id','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Image File Attachment</p>
							<p class="description">If your main attachment is something non-visual and you wish to have an image accompaniment (e.g. screenshots for a downloadable game), you can provide one here.</p>
						</td>
						<td>
							File ID: <input type="text" name="image_attachment" style="width: 80px;" value="<?php if ($content['image_attachment'] > 0) echo $content['image_attachment']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/image_attachment','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/image_attachment','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>
					<tr>
						<td>
							<p>Download File Attachment</p>
							<p class="description">If you wish to have a downloadable attachment differing from the previous two attachments, you can provide one here.</p>
						</td>
						<td>
							File ID: <input type="text" name="download_attachment" style="width: 80px;" value="<?php if ($content['download_attachment'] > 0) echo $content['download_attachment']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/download_attachment','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/download_attachment','new_win','width=650,height=850');">Browse Files...</a>
					</tr>
					<tr>
						<td>
							<p>Content Thumbnail</p>
							<p class="description">If your site uses content thumbnails, you can provide one here.</p>
						</td>
						<td>
							File ID: <input type="text" name="content_thumbnail" style="width: 80px;" value="<?php if ($content['content_thumbnail'] > 0) echo $content['content_thumbnail']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/files/add/popup/content_thumbnail','new_win','width=650,height=850');">Add File...</a>
							&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/files/select/1/content_thumbnail','new_win','width=650,height=850');">Browse Files...</a>
						</td>
					</tr>	
					<tr>
						<td>
							<p>Custom Embed</p>
							<p class="description">Any HTML in this field will be inserted into the page in the content area. This is useful for, say, embedding an external player like one from YouTube or SoundCloud, or a Flash movie.</p>
						</td>
						<td>
							<textarea id="custom_embed" name="custom_embed" rows="8" cols="60"><?php echo $content['custom_embed']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>Authors</p>
							<p class="description">Add authors to your content here, if you so choose. The "role" is their position on the project, e.g. Artist, Editor, Lead Animator, Programming, Host... etc. If both fields are empty, the author will be removed.</p>
						</td>
						<td>
							<div id="authorsbox">
								<?php $i = 0; foreach ($content['authors'] as $author) { $i++; ?>
								<input type="hidden" name="author_dbid_<?=$i?>" style="width: 80px;" value="<?=$author['db_id']?>" />
								Author ID: <input type="text" name="author_id_<?=$i?>" style="width: 80px;" value="<?=$author['user']['id']?>" />
								&nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/users/select/<?=$i?>','new_win','width=350,height=650');">Browse Users...</a> &nbsp; &nbsp; &nbsp; Role: <input type="text" name="author_role_<?=$i?>" style="width: 160px;" value="<?=$author['role']?>" /><br />
								<?php } ?>
							</div><br />
							<center><a href="javascript:void();" onclick="addAuthorFields();">Add Author...</a></center>
							<input type="hidden" name="author_amt" id="author_amt" value="<?=($i)?>" />
						</td>
					</tr>				
				</table>
				<?php if (!$editexisting) { ?><input type="checkbox" name="updatetimestamp" value="yes"> Update parent category's timestamp with current time<br /><?php } ?>
				<input type="submit" />
			</form>
		</div>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>