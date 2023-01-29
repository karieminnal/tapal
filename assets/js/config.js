var config = (function () {
  return {
    urlTileDrone: '/assets/tiles/',
    apiDusun: window.location.origin + '/api_custom/dusun',
    apiLokasi: window.location.origin + '/api_custom/plan_lokasi',
    apiLokasiKategori:
      window.location.origin + '/api_custom/plan_lokasi_kategori',
    apiPersil: window.location.origin + '/api_custom/plan_persil',
    apiLahan: window.location.origin + '/api_custom/plan_tutupan_lahan',
    apiLahanJenis:
      window.location.origin + '/api_custom/plan_tutupan_lahan_jenis',
    apiStat: window.location.origin + '/api_custom/statistik_penduduk',
    apiStatSub: window.location.origin + '/api_custom/statistik_sub',
    pathImageLokasi: window.location.origin + '/desa/upload/gis/lokasi/',
  };
})();
var configColor = (function () {
  return {
    primary: '#41577c',
    secondary: '#ae8a32',
    hightlight: '#f8db21',
    desa: '#81e9e6',
    dusun: '#68BBE3',
    rw: '#0E86D4',
    rt: '#055C9D',
    white: '#ffffff',
    satu: '#ffa822',
    dua: '#ff6150',
    tiga: '#1ac0c6',
    empat: '#722699',
    lima: '#83d257',
    enam: '#de779d',
    tujuh: '#999999',
    delapan: '#42b649',
    persil: '#ae8a32',
    border: '#fee096',
  };
})();

var configDusun = (function () {
  return {
    dusun1: 'Karajan 1',
    dusun2: 'Kecemek 2',
    dusun3: 'Kecemek 3',
    dusun4: 'Kecemek 4',
    dusun5: 'Dusun 5',
    dusun6: 'Dusun 6',
    dusun7: 'Dusun 7',
    dusun8: 'Dusun 8',
  };
})();

function randomColor() {
  var randomColor = Math.floor(Math.random() * 16777215).toString(16);
  return '#' + randomColor;
}

function getColor(d) {
  return d > 1000
    ? '#ed1e28'
    : d > 500
    ? '#f15f23'
    : d > 200
    ? '#f7921e'
    : d > 100
    ? '#feb914'
    : d > 50
    ? '#fbde08'
    : d > 20
    ? '#dce23a'
    : d > 10
    ? '#b6d434'
    : d > 0
    ? '#79c143'
    : '#42b649';
}

function isGanjil(num) {
  var hasil = num % 2;
  if (hasil) {
    var total = parseInt(num) + 1;
  } else {
    var total = num;
  }
  return total;
}

function getTotalPendudukPlus(elemTotal) {
  var jml = $(elemTotal).attr('value');
  var cekGanjil = isGanjil(jml);
  if (cekGanjil < 200) {
    return 200 / 2;
  } else {
    return cekGanjil / 2;
  }
}

function getStepColor(val) {
  var hasil = val;
}

function randNumber(min, max) {
  var randomnumber = Math.floor(Math.random() * (max + 1) + min);
  return randomnumber;
}

function randColor() {
  var colors = ['#990000', '#cc3333', '#ff6666'];
  var rand = Math.floor(Math.random() * colors.length);

  return randColor;
}

function lightenColor(color, percent) {
  var num = parseInt(color.replace('#', ''), 16),
    amt = Math.floor(2.55 * percent),
    R = (num >> 16) + amt,
    B = ((num >> 8) & 0x00ff) + amt,
    G = (num & 0x0000ff) + amt;
  return (
    '#' +
    (
      0x1000000 +
      (R < 255 ? (R < 1 ? 0 : R) : 255) * 0x10000 +
      (B < 255 ? (B < 1 ? 0 : B) : 255) * 0x100 +
      (G < 255 ? (G < 1 ? 0 : G) : 255)
    )
      .toString(16)
      .slice(1)
  );
}

function convertRibuan(angka) {
  return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

$(document).ready(function () {});
