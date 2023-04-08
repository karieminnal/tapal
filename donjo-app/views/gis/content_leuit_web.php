<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>

	<div id="content">
		<h5 id="firstHeading" class="firstHeading">
			<?= set_ucwords($wilayah); ?>
		</h5>
		<div id="bodyContent" class="hide-on-tooltip">
			<p>
				<a href="<?= site_url("first/loadModalLeuit/$desa"); ?>" class="btn btn-sm btn-outline-primary btn-block" 
					data-title="Data <?= set_ucwords($wilayah) ?>" 
					data-remote="false" 
					data-toggle="modal" 
					data-target="#modalLeuit">
					<i class="fa fa-leaf"></i>
					Data <?= set_ucwords($wilayah) ?>
				</a>
			</p>
			<?php if($panorama != NULL) { ?>
				<p>
					<a href="<?= site_url("first/loadModalLeuit360/$desa"); ?>" class="btn btn-sm btn-outline-primary btn-block" 
						data-title="Panorama <?= set_ucwords($wilayah) ?>" 
						data-remote="false" 
						data-toggle="modal" 
						data-target="#modalLeuit360">
						<i class="fa fa-image"></i>
						View Panorama
					</a>
				</p>
			<?php } ?>
		</div>
	</div>