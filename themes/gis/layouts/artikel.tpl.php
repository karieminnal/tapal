<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view($folder_themes . '/layouts/header_artikel.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="container-artikel">
				<?php
				$this->load->view(Web_Controller::fallback_default($this->theme, '/partials/artikel.php'));
				?>
			</div>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>

</div>
</div>

</body>

</html>