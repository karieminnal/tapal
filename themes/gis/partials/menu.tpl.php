<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script>
	jQuery(function($) {
		$('.main-nav ul li').hover(function() {
			var thisLi = $(this);
				thisLink = $(thisLi).find('.has-child').length;
			if(thisLink > 0) {
				if (!$('.sub-kategori').is(':visible')) {
					$(thisLi).find('.sub-kategori').toggleClass('open', true);
				}
			}
		}, function() {
		    if ($('.sub-kategori').is(':visible')) {
		        $(this).find('.sub-kategori').toggleClass('open', false);
		    }
		});
		$('.main-nav ul li a.has-child').click(function(){
		    if (!$('.sub-kategori').is(':visible') && $(this).attr('href') != '#') {
		        $(this).parent().find('.sub-kategori').toggleClass('open', false);
		        window.location = $(this).attr('href')
		    } else if ($(this).parent().find('.sub-kategori').hasClass('open') && $(this).attr('href') != '#') {
		        window.location = $(this).attr('href')
		    }
		});
	});
</script>
<link type='text/css' href="<?= base_url()?>assets/front/css/default.css" rel='Stylesheet' />
<link type='text/css' href="<?= base_url().$this->theme_folder.'/'.$this->theme.'/css/default.css'?>" rel='Stylesheet' />
<?php if (is_file("desa/css/".$this->theme."/desa-default.css")):?>
  <link type='text/css' href="<?= base_url()?>desa/css/<?php echo $this->theme ?>/desa-default.css" rel='Stylesheet' />
<?php endif; ?>

<div class="main-nav">
	<ul>
		<li><a href="<?= site_url()."first"?>">Beranda</a></li>
		<?php foreach ($menu_atas as $data): ?>
			<li>
				<a href="<?= $data['link']?>" class="<?php (count($data['submenu']) > 0) and print("has-child") ?>">
					<?= $data['nama'] ?>
				</a>
				<?php if (count($data['submenu']) > 0): ?>
					<div class="sub-kategori">
						<ul>
							<?php foreach ($data['submenu'] as $submenu): ?>
								<li><a href="<?= $submenu['link']?>"><?= $submenu['nama']?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
<ul class="float-right button-login-admin d-none">
	<a href="<?= site_url('siteman') ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-lock fa-lg"></i> Login Admin</button></a>
</ul>