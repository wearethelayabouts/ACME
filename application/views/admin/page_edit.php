<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; Edit Page (Admin)</title>
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
			<?php $this->load->view('admin/sidebar', Array('current' => 'pages'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<legend>
						<table class="UILegend">
							<tr>
								<td class="UILegendTitle"><?php if ($editexisting) echo "Edit"; else echo "Add"; ?> Page</td>
								<td class="UILegendActions"><?php if ($editexisting) { ?><a href="<?php echo $baseurl; ?>toolbox/delete/pages/<?php echo $page['id']; ?>/confirm">Delete</a></td>
							</tr>
						</table>
					</legend>
					<div class="content nopadding">
						<?php foreach ($errors as $error) { ?>
						<p class="message-error"><strong>ERROR:</strong> <?php echo $error?></p><br /><br />
						<?php } ?>
						<div class="padding">
							<?php } ?>
							Fields marked with a (<span style="color: #f00;">*</span>) are <em>required</em>.
						</div>
						<form action="<?php echo $thispageurl; ?>" method="post">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" />
							<input type="hidden" name="commit" value="true" />
							<input type="hidden" name="id" value="<?php echo $page['id']; ?>" />
							<table class="UITable" style="text-align: left;">
								<tr>
									<td width="350px">
										<p>Slug (<span style="color: #f00;">*</span>)</p>
										<p class="description">Short content ID that goes in the URL (examples: <em>www.site.com/page/<strong>achkei</strong></em><br /><em>www.othersite.com/page/<strong>23</strong></em>)</p>
									</td>
									<td>
										<input type="text" name="slug" style="width: 120px;" value="<?php echo $page['slug']; ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<p>Custom CSS</p>
										<p class="description">CSS code used to additionally style the page's content.</p>
									</td>
									<td>
										<textarea name="custom_css" rows="8" cols="60"><?php echo $page['custom_css']; ?></textarea>
									</td>
								</tr>
								<tr>
									<td>
										<p>Content (<span style="color: #f00;">*</span>)</p>
										<p class="description">Page itself.</p>
									</td>
									<td>
										<textarea name="content" rows="20" cols="60"><?php echo $page['content']; ?></textarea>
									</td>
								</tr>
							</table>
							<input type="submit" />
						</form>
					</div>
				</fieldset>
			</div>
		</div>
		<div id="UIFooter">
			&nbsp;
			<div id="alignright">
				<a href="/auth/logout">Logout</a>
			</div>
		</div>
	</body>
</html>