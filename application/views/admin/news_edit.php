<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Edit News Post (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/includes/ext/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript" >
		tinyMCE.init({
		        mode : "exact",
		        theme : "advanced",
		        skin : "o2k7",
		        skin_variant : "silver",
		        theme_advanced_toolbar_location : "top",
		        theme_advanced_toolbar_align : "left",
		        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,hr,removeformat,visualaid,|,sub,sup",
		        theme_advanced_buttons2 : "charmap,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		        theme_advanced_buttons3 : "",
		        elements : "content, shortcontent",
		        theme_advanced_statusbar_location : "bottom",
		        theme_advanced_resizing : true,
		        valid_elements : "*[*]"
		});
		</script>
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'news'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<table class="UILegend">
						<tr>
							<td class="UILegendTitle"><?php if ($editexisting) echo "Edit"; else echo "Add"; ?> News</td>
							<td class="UILegendActions"><?php if ($editexisting) { ?><a href="<?php echo $baseurl; ?>toolbox/delete/news/<?php echo $news['entry']['id']; ?>/confirm">Delete</a><?php } ?></td>
						</tr>
					</table>
					<div class="content nopadding">
						<?php foreach ($errors as $error) { ?>
						<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p>
						<?php } ?>
						<p>
							Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
						</p>
						<form action="<?php echo $thispageurl; ?>" method="post" name="form" id="form">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
							<input type="hidden" name="commit" value="true" />
							<input type="hidden" name="id" value="<?php echo $news['entry']['id']; ?>" />
							<table class="UITable" style="text-align: left;">
								<tr>
									<td style="width: 350px;">
										<p>Name (<span style="color: #f00;">*</span>)</p>
										<p class="description">Name of the news item.</p>
									</td>
									<td>
											<input type="text" name="name" style="width: 300px;" value="<?php echo $news['entry']['title']; ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<p>Published (<span style="color: #f00;">*</span>)</p>
										<p class="description">Should this be displayed to the users</p>
									</td>
									<td>
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
									<td>
										<input type="text" name="year" maxlength="4" style="width: 50px;" value="<?php if ($news['entry']['date'] > 0) echo date("Y", $news['entry']['date']); ?>" /> <input type="text" name="month" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("m", $news['entry']['date']); ?>" /> <input type="text" name="day" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("d", $news['entry']['date']); ?>" /> at <input type="text" name="hour" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("H", $news['entry']['date']); ?>" />:<input type="text" name="minute" maxlength="2" style="width: 30px;" value="<?php if ($news['entry']['date'] > 0) echo date("i", $news['entry']['date']); ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<p>Short Content</p>
										<p class="description">Shorter version of the article, displayed on the front page.</p>
									</td>
									<td>
										<textarea name="shortcontent" rows="8" cols="60"><?php echo $news['entry']['shortcontent']; ?></textarea>
									</td>
								</tr>
								<tr>
									<td>
										<p>Content (<span style="color: #f00;">*</span>)</p>
										<p class="description">Article itself.</p>
									</td>
									<td>
										<textarea name="content" rows="8" cols="60"><?php echo $news['entry']['content']; ?></textarea>
									</td>
								</tr>
								<tr>
									<td>
										<p>Poster (<span style="color: #f00;">*</span>)</p>
										<p class="description">User ID of the person that the post should be attributed to</p>
									</td>
									<td>
										<input type="text" name="author_id_1" id="author_id_1" style="width: 120px;" value="<?php echo $news['poster']['id']; ?>" /> &nbsp; &nbsp; &nbsp; <a href="javascript:void();" onclick="window.open('/toolbox/popup/users/select/1','new_win','width=350,height=650');">Browse Users...</a>
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