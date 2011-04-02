<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "gttp://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?=$sitename?> &bull; ACME admin panel</title>
		<style type="text/css">
			/*<![CDATA[*/
				body { text-align: center; }
				.main-listbox {
					width: 200px;
					background-color: #ddd;
					margin: 0 auto;
					padding: 8px;
					text-align: left;
				}
				ul { list-style-position: inside; }
			/*]]>*/
		</style>
	</head>
	<body>
		<?php if (!
		<h1><?=$sitename?></h1>
		<h2>ACME admin panel</h2>
		<ul class="main-listbox">
			<li><a href="<?=$config['base_url']?>/admin/content/">Content</a></li>
			<li><a href="<?=$config['base_url']?>/admin/files/">Files</a></li>
			<li><a href="<?=$config['base_url']?>/admin/categories/">Categories</a></li>
			<li><a href="<?=$config['base_url']?>/admin/users/">Users</a></li>
			<li><a href="<?=$config['base_url']?>/admin/user_fields/">User Fields</a></li>
			<li><a href="<?=$config['base_url']?>/admin/author_roles/">Author Roles</a></li>
			<li><a href="<?=$config['base_url']?>/admin/news/">News</a></li>
			<li><a href="<?=$config['base_url']?>/admin/pages/">Pages</a></li>
		</ul>
		<p class="footer">Powered by <a href="http://acme.wearethelayabouts.com/">ACME</a> alpha 2 "Bucket" prerelease.</p>
	</body>
</html>