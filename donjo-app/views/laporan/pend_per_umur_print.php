<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Cetak Laporan Bulanan</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link href="<?= base_url() ?>assets/css/report.css" rel="stylesheet" type="text/css">
  <!-- Untuk ubahan style desa -->
  <?php if (is_file("desa/css/siteman.css")) : ?>
    <link type='text/css' href="<?= base_url() ?>desa/css/siteman.css" rel='Stylesheet' />
  <?php endif; ?>
</head>
<style type="text/css">
  .underline {
    text-decoration: underline;
  }

  td.judul {
    font-size: 14pt;
    font-weight: bold;
  }

  td.judul2 {
    font-size: 12pt;
    font-weight: bold;
  }

  td.text-bold {
    font-weight: bold;
  }

  table.tftable td.no-border {
    border: 0px;
    border-style: hidden;
  }

  table.tftable td.no-border-kecuali-kiri {
    border-top-style: hidden;
    border-bottom-style: hidden;
    border-right-style: hidden;
  }

  table.tftable td.no-border-kecuali-atas {
    border-left-style: hidden;
    border-bottom-style: hidden;
    border-right-style: hidden;
  }

  table.tftable td.no-border-kecuali-bawah {
    border-left-style: hidden;
    border-top-style: hidden;
    border-right-style: hidden;
  }

  table.tftable {
    margin-top: 5px;
    font-size: 12px;
    color: <?= (isset($warna_font) ? $warna_font : ""); ?>;
    width: 100%;
    border-width: 1px;
    border-style: solid;
    border-color: <?= (isset($warna_border) ? $warna_border : ""); ?>;
    border-collapse: collapse;
  }

  table.tftable.lap-bulanan {
    border-width: 3px;
  }

  table.tftable tr.thick {
    border-width: 3px;
    border-style: solid;
  }

  table.tftable th.thick {
    border-width: 3px;
  }

  table.tftable th.thick-kiri {
    border-left: 3px solid <?= (isset($warna_border) ? $warna_border : ""); ?>;
  }

  table.tftable td.thick-kanan {
    border-right: 3px solid <?= (isset($warna_border) ? $warna_border : ""); ?>;
  }

  table.tftable td.angka {
    text-align: right;
  }

  table.tftable th {
    background-color: <?= (isset($warna_background) ? $warna_background : ""); ?>;
    padding: 3px;
    border: 1px solid <?= (isset($warna_border) ? $warna_border : ""); ?>;
    text-align: center;
  }

  /*table.tftable tr {background-color:#ffffff;}*/
  table.tftable td {
    padding: 8px;
    border: 1px solid <?= (isset($warna_border) ? $warna_border : ""); ?>;
  }
</style>

<body>
  <div id="container">
    <!-- Print Body -->
    <div id="body">
      <table>
        <tr><td colspan="12" class="no-border" style="font-size: 14pt; text-align: center; font-weight: bold">LAPORAN MUTASI PENDUDUK DIPERINCI MENURUT UMUR</td></tr>
        <tr><td colspan="12" class="no-border" style="font-size: 14pt; text-align: center; font-weight: bold">DESA <?= strtoupper($config['nama_desa']) ?></td></tr>
        <tr><td colspan="12" class="no-border" style="font-size: 14pt; text-align: center; font-weight: bold">KECAMATAN <?= strtoupper($config['nama_kecamatan']) ?></td></tr>
        <tr><td colspan="12" class="no-border" style="font-size: 14pt; text-align: center; font-weight: bold">BULAN <?= strtoupper($bln) ?> <?= $tahun ?></td></tr>
      </table>
      <br>
      <?php include("donjo-app/views/laporan/tabel_pend_per_umur.php"); ?>
      <table class="tftable">
        <tr>
        </tr>
        <tr>
          <?php if ($pamong_ttd['pamong_id'] == $ttd['pamong_id']) { ?>
            <td colspan="8" class="no-border"></td>
          <?php } else { ?>
            <td colspan="4" class="no-border">
              Mengetahui<br>
              <?= str_ireplace($this->setting->sebutan_desa, '', $ttd['jabatan']) . ' ' . ucwords($this->setting->sebutan_desa) . ' ' . $config['nama_desa'] ?>
            </td>
            <td colspan="4" class="no-border"></td>
          <?php } ?>
          <td colspan="4" class="no-border" style="vertical-align: top;">
            <?= ucwords($this->setting->sebutan_desa) ?> <?= $config['nama_desa'] ?>, <?= tgl_indo(date("Y m d")) ?><br>
            <?= str_ireplace($this->setting->sebutan_desa, '', $pamong_ttd['jabatan']) . ' ' . ucwords($this->setting->sebutan_desa) . ' ' . $config['nama_desa'] ?>
          </td>
        </tr><tr>
        </tr><tr>
        </tr><tr>
          <?php if ($pamong_ttd['pamong_id'] == $ttd['pamong_id']) { ?>
            <td colspan="8" class="no-border"></td>
          <?php } else { ?>
            <td colspan="4" class="no-border">
              <?= $ttd['pamong_nama'] ?><br>
            </td>
            <td colspan="4" class="no-border"></td>
          <?php } ?>
          <td colspan="4" class="no-border" style="vertical-align: top;">
            <?= $pamong_ttd['pamong_nama'] ?><br>
            <!-- NIP/NIAP <?= $pamong_ttd['pamong_niap_nip'] ?> -->
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>