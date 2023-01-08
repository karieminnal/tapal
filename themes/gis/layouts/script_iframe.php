<script id="scriptJquery" type="text/javascript" src="<?= base_url() ?>assets/front/js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/vendors.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/select2/js/i18n/id.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/bootstrap/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/bootstrap/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
	var loadJS = function(url, scriptOnLoad, location) {
		var scriptTag = document.createElement('script');
		scriptTag.src = url;
		scriptTag.onload = scriptOnLoad;
		scriptTag.onreadystatechange = scriptOnLoad;
		$(scriptTag).insertAfter('#scriptJquery');
	};
	var scriptOnLoad = function() {

	}
</script>