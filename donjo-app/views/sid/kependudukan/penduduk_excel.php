<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Penduduk_" . $namafile . '_' . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

include("donjo-app/views/sid/kependudukan/penduduk_print.php");
