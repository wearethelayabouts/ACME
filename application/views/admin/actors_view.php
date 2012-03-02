<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?php echo $sitename; ?> &bull; View All Plays (Admin)</title>
		<link href="<?php echo $baseurl; ?>includes/acme/rocket.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="UISidebar">
			<?php $this->load->view('admin/sidebar', Array('current' => 'plays'));?>
		</div>
		<div id="UIContent">
			<div class="UIContentSection">
				<fieldset>
					<legend>
						<table class="UILegend">
							<tr>
								<td class="UILegendTitle">Plays</td>
								<td class="UILegendActions"><a href="<?php echo $baseurl; ?>toolbox/plays/scan">Rescan</a></td>
							</tr>
						</table>
					</legend>
					<div class="content nopadding">
						<?php if (isset($syncNeeded)) { ?>
						<div class="message-error"><b>Warning:</b> ACME has detected a different number of actors on the filesystem than on the database. Please rescan plays!</div>
						<?php } ?>
						
						<table width="100%">
							<?php foreach ($FSinfo as $piece) { ?>
							<tr class="play">
								<td>
									<strong><?=$piece->description?></strong><br />
									<?=$piece->author?>
								</td>
								<td>&nbsp;</td>
							</tr>
							<?php foreach ($piece->contents as $actor) { ?>
							<tr class="actor">
								<td>
									<strong><?=$actor->description?></strong><?php if ($this->config->item('auth_actor') == $actor->bundle) { ?> (in use)<?php } ?><br />
									<i><?=$actor->bundle?></i>
								</td>
								<td width="50px">
									<?=$DBactors[$actor->bundle]['type']?>
								</td>
								
							</tr>
							<?php } ?>
							<?php } ?>
						</table>
					</div>
				</fieldset>
			</div>
		</div>
	</body>
</html>