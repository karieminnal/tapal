<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="footer">
	<div class="container">
		<?php if (!is_null($transparansi)) $this->load->view($folder_themes. '/partials/apbdesa-tema.php', $transparansi);?>

		<div class="row">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">

			</div>
			<div class="col-md-4">

				<div class="footer-right">
					<ul id="global-nav-right" class="top">
					<li><a href="<?php echo $sosmed[nested_array_search('Facebook',$sosmed)]['link']?>" target="_blank"><span style="color:#fff" ><i class="fa fa-facebook-square fa-2x"></i></span></a></li>
					<li><a href="<?php echo $sosmed[nested_array_search('Twitter',$sosmed)]['link']?>" target="_blank"><span style="color:#fff"><i class="fa fa-twitter-square fa-2x"></i></span></a></li>
					<li><a href="<?php echo $sosmed[nested_array_search('YouTube',$sosmed)]['link']?>" target="_blank"><span style="color:#fff"><i class="fa fa-youtube-square fa-2x"></i></span></a></li>
					<li><a href="<?php echo $sosmed[nested_array_search('Google Plus',$sosmed)]['link']?>" target="_blank"><span style="color:#fff"><i class="fa fa-google-plus-square fa-2x"></i></span></a></li>
					<li><a href="<?php echo $sosmed[nested_array_search('Instagram',$sosmed)]['link']?>" target="_blank"><span style="color:#fff"><i class="fa fa-instagram fa-2x"></i></span></a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="copyright">
			Copyright &copy; <?php echo date("Y");?>. 
			Dikelola oleh Pemerintah <?php echo ucwords($this->setting->sebutan_desa)?> <?php echo $desa['nama_desa']?>
		</div>
	</div>
</div>

