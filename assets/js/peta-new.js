$(document).ready(function () {
  var labelSebaran = $('toggle-sebaran-penduduk').closest('label'),
    checkLabelSebaran = $(labelSebaran).find('input');
  triggerMenu(map);
  resizeWindow(map);

  $('#pilihProvinsi').select2({
    placeholder: 'Pilih Provinsi',
    language: 'id',
    width: '100%',
  });
  $('#pilihKota').select2({
    placeholder: 'Pilih Kota/Kabupaten',
    language: 'id',
    width: '100%',
  });
  $('#pilihKecamatan').select2({
    placeholder: 'Pilih Kecamatan',
    language: 'id',
    width: '100%',
  });
  $('#pilihKelurahan').select2({
    placeholder: 'Pilih Kelurahan',
    language: 'id',
    width: '100%',
  });
  $(
    '#pilihProvinsi, #pilihKota, #pilihKecamatan, #pilihKelurahan, #pilihDesa',
  ).on('select2:open', function (e) {
    $('body').addClass('select-open');
  });
  $(
    '#pilihProvinsi, #pilihKota, #pilihKecamatan, #pilihKelurahan, #pilihDesa',
  ).on('select2:close', function (e) {
    $('body').removeClass('select-open');
  });
  $('#pilihProvinsi').change(function () {
    $('img#load1').show();
    var id_provinces = $(this).val();
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kota',
      data: 'id_provinces=' + id_provinces,
      success: function (msg) {
        $('select#pilihKota').html(msg);
        $('img#load1').hide();
        $('.row-kota').addClass('show');
        getAjaxKota();
      },
    });
  });

  $('#pilihKota').change(getAjaxKota);
  function getAjaxKota() {
    $('img#load2').show();
    var id_regencies = $('#pilihKota').val();
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kecamatan',
      data: 'id_regencies=' + id_regencies,
      success: function (msg) {
        $('select#pilihKecamatan').html(msg);
        $('img#load2').hide();
        $('.row-kecamatan').addClass('show');
        getAjaxKecamatan();
      },
    });
  }

  $('#pilihKecamatan').change(getAjaxKecamatan);
  function getAjaxKecamatan() {
    $('img#load3').show();
    var id_district = $('#pilihKecamatan').val();
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/getProvinsi?jenis=kelurahan',
      data: 'id_district=' + id_district,
      success: function (msg) {
        $('select#pilihKelurahan').html(msg);
        $('img#load3').hide();
        $('.row-desa').addClass('show');
        $('.btn-filter-submit').removeAttr('disabled');
      },
    });
  }

  $('.toggle-ubah-sandi').click(function () {
    var thisToggle = $(this);
    $('.password-container').slideToggle(function () {
      if ($('.password-container').is(':hidden')) {
        resetToggleSandi();
      } else {
        $(thisToggle).html('Batal');
      }
    });
  });
  $('.show-pass').click(function () {
    var thisTog = $(this);
    var thisInput = $(this).closest('.input-group').find('input');
    if (thisInput.attr('type') === 'password') {
      thisInput.attr('type', 'text');
      thisTog.addClass('active');
    } else {
      thisInput.attr('type', 'password');
      thisTog.removeClass('active');
    }
  });

  $('#pass_lama').keyup(function () {
    var passLama = $(this).val();
    if (passLama != '') {
      $('.check-sandi').show();
    } else {
      $('.check-sandi').hide();
    }
  });

  $('#modalAkun').on('show.bs.modal', function (e) {
    var modal = $(this);
    resetModalAkun();
    resetToggleSandi();
  });
  if ($('#pass_baru1').length) {
    setTimeout(function () {
      $('#pass_baru1').rules('add', {
        equalTo: '#pass_baru',
      });
    }, 500);
  }
});

$(window).on('load', function () {});

function changeSesi(val) {
  $('input#sesiDesa').val(val);
  $('.main-nav ul li a:not(.has-child)').attr('data-desaid', val);
}

function triggerPilihDesa(map, lat, lng) {
  $('#pilihDesa').select2({
    placeholder: 'Pilih Desa',
    language: 'id',
    width: '100%',
  });
  $('#pilihDesa').change(function () {
    var id = $(this).val();
    var getId = $(this).select2('val');
    if (getId != 0) {
      var latDesa = $(this).find(':selected').data('lat');
      var lngDesa = $(this).find(':selected').data('lng');
      var pathDesa = $(this).find(':selected').data('path');
      var toDesa = new L.LatLngBounds(
        new L.LatLng(latDesa, lngDesa),
        new L.LatLng(latDesa, lngDesa),
      );
      if (pathDesa != '') {
        map.flyTo([latDesa, lngDesa], 14, {
          animate: true,
          duration: 3,
        });
      }
      clearExlude(getId);
    } else {
      $(
        '.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil',
      ).removeClass('fade-poly');
      map.flyTo([lat, lng], 9, {
        animate: true,
        duration: 1.5,
      });
    }
    $.ajax({
      type: 'POST',
      dataType: 'html',
      url: '/first/filterIdDesa?',
      data: 'filterIdDesa=' + getId,
      success: function (msg) {
        bersihkan(map);
        if ((getId = 0)) {
          $(
            '.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil',
          ).removeClass('fade-poly');
        }
      },
    });
    changeSesi(getId);
  });
}

function clearControl(map) {
  bersihkan(map);
  loadingAset.addTo(map);
}

function bersihkan(map) {
  $(
    '.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)',
  ).remove();
  markerGroup.clearLayers();

  var thisCheck = $(
    '.leaflet-top.leaflet-left .leaflet-control-layers:not(.lahan-check-container) input[type="checkbox"]',
  );
  $(thisCheck).each(function (index, value) {
    if ($(this).is(':checked')) {
      $(this).trigger('click');
      $(this).removeAttr('checked');
    }
  });

  $('.info-sebaran').remove();

  map.removeControl(lahanControl);
  map.removeControl(lahanControlUkuran);
  map.removeControl(sebaranControl);
  map.removeControl(markerSarana);
  map.closePopup();
  $('.list_kategori').find('li').removeClass('current-menu');
}

function clearExlude(id) {
  $(
    '.leaflet-interactive:not(.not-clear):not(.poly-desa), .leaflet-tooltip:not(.not-clear)',
  ).remove();
  $(
    '.leaflet-interactive.poly-desa, .leaflet-interactive.poly-wil',
  ).removeClass('fade-poly');
  $('.leaflet-interactive.poly-desa:not(.desa-' + id + ')').addClass(
    'fade-poly',
  );
}

function menuActive(el) {
  $('.list_kategori').find('li').removeClass('current-menu');
  $(el).parent('li').addClass('current-menu');
}

function filterFormDesa(idForm, action, target = '') {
  csrf_semua_form();
  if (target != '') {
    $('#' + idForm).attr('target', target);
  }
  $('#' + idForm).attr('action', action);
  $('#' + idForm).submit();
}

function resetModalAkun() {
  $('.modal-body .erm').html('');
  $('input[type="password"]').val('');
  $('.form-group').removeClass('has-error');
  $('label.error').remove();
  $('.password-container').slideUp('fast');
  $('.toggle-ubah-sandi').html('Ubah sandi?');
  $('.show-pass').removeClass('active');
}

function checkSandi(userSes) {
  $('.check-sandi').click(function () {
    var thisA = $(this);
    var thisP = $('#pass_lama');
    var passLama = $(thisP).val();
    var thisParent = $(thisP).closest('.form-group');
    if (passLama != '') {
      $.ajax({
        url: 'user_setting/check_pass_lama/' + userSes,
        type: 'post',
        data: {
          pass_lama: passLama,
        },
        success: function (response) {
          if (response == 1) {
            $('.input-sandi-baru').fadeIn();
            $(thisParent).removeClass('has-error');
            $(thisParent).addClass('has-valid');
            $('.error.pass-lama').remove();
            $(thisA).html('<i class="fa fa-check" aria-hidden="true"></i>');
            $(thisP).attr('disabled', 'disabled');
          } else {
            $('.input-sandi-baru').fadeOut();
            $(thisParent).removeClass('has-valid');
            $(thisParent).addClass('has-error');
            var elError =
              '<label class="error pass-lama">' + response + '</label>';
            $(elError).appendTo(thisParent);
            $(thisA).html(
              '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            );
            $(thisP).removeAttr('disabled');
          }
        },
      });
    }
  });
}

function submitSetting(userSes) {
  $('#btnSubmit').click(function () {
    var modalAkun = $('#modalAkun');
    var elError = $(modalAkun).find('.erm');
    var namaLengkap = $('#namaLengkap').val();
    var passLama = $('#pass_lama').val();
    var passBaru = $('#pass_baru').val();
    var passBaru1 = $('#pass_baru1').val();
    var urlPost = 'user_setting/update_password/' + userSes;
    if (passLama != '') {
      if (!$('#modalAkun').find('.has-error').length) {
        $.ajax({
          url: urlPost,
          type: 'post',
          data: {
            pass_lama: passLama,
            pass_baru: passBaru,
            pass_baru1: passBaru1,
            nama: namaLengkap,
          },
          success: function (response) {
            $(elError).fadeOut().html('');
            $(response).appendTo(elError);
            $(elError).fadeIn();
            if (
              response ==
              '<div class="alert alert-success">Data berhasil tersimpan!</div>'
            )
              location.reload();
          },
        });
      }
    } else {
      $.ajax({
        url: urlPost,
        type: 'post',
        data: {
          nama: namaLengkap,
        },
        success: function (response) {
          $(elError).fadeOut().html('');
          $(response).appendTo(elError);
          $(elError).fadeIn();
          if (
            response ==
            '<div class="alert alert-success">Data berhasil tersimpan!</div>'
          )
            location.reload();
        },
      });
    }
  });
}

function resetToggleSandi() {
  $('input[type="password"]').val('');
  $('.toggle-ubah-sandi').html('Ubah sandi?');
  $('.input-sandi-baru').fadeOut();
  $('.form-group').removeClass('has-valid has-error');
  $('.pass-lama').remove();
  $('.check-sandi')
    .html('<i class="fa fa-chevron-right" aria-hidden="true"></i>')
    .hide();
  $('#pass_lama').removeAttr('disabled');
}

var elemTotal = '#totalPenduduk';
getTotalPendudukPlus(elemTotal);

function resizeWindow(map) {
  $(window).resize(function () {
    $('#map').removeAttr('style');
    $('body').removeClass('hide-menu');
    map.invalidateSize();
    triggerMenu(map);
  });
}

function triggerMenu(map) {
  var deviceWidth = $(window).width();
  if (deviceWidth < 768) {
    var bodyClass = $('body').hasClass('hide-menu');
    if (!bodyClass) {
      $('.toggle-menu.mobile a').trigger('click');
    }
  }
}

function toggleMenu(map) {
  $('.toggle-menu a').on('click', function () {
    $('body').toggleClass('hide-menu');
    var bodyClass = $('body').hasClass('hide-menu');
    var deviceWidth = $(window).width();

    if (deviceWidth > 767) {
      var winWid = deviceWidth - 66;
    } else {
      var winWid = deviceWidth;
    }
    if (bodyClass) {
      $('#map').width(winWid);
      map.invalidateSize();
    } else {
      $('#map').removeAttr('style');
      setTimeout(function () {
        map.invalidateSize();
      }, 500);
    }
  });
}

function loadingControl(loadingAset, map) {
  loadingAset.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'leaflet-bar');
    this._div.innerHTML = '<a class="leaflet-control-loading"></a>';
    $('.main-nav').addClass('loading-active');
    return this._div;
  };

  return loadingAset;
}

function toggleExport(map) {
  var toggleExport = L.control({ position: 'topright' });

  toggleExport.onAdd = function (map) {
    this._div = L.DomUtil.create('div');
    this._div.classList.add('leaflet-bar', 'leaflet-control');
    this._div.setAttribute('onclick', 'manualPrint()');
    this._div.innerHTML = '<a class="trigger-export"></a>';
    return this._div;
  };
  toggleExport.addTo(map);
}

function toggleClear(map) {
  var toggleClear = L.control({ position: 'topright' });

  toggleClear.onAdd = function (map) {
    this._div = L.DomUtil.create('div');
    this._div.classList.add('leaflet-bar', 'leaflet-control');
    this._div.setAttribute('onclick', 'bersihkan(map)');
    this._div.innerHTML =
      '<a class="trigger-clear" title="Bersihkan Peta"></a>';
    return this._div;
  };
  toggleClear.addTo(map);
}

function checkUkuran() {
  var thiCheck = $('.lahan-check-container input[type="checkbox"]');

  if (thiCheck.is(':checked')) {
    $('.tooltip-lahan').show();
  } else {
    $('.tooltip-lahan').hide();
  }
}

var styleProv = {
  color: configColor.border,
  opacity: 1,
  weight: 1,
  fillColor: configColor.desa,
  fillOpacity: 0.1,
  fill: false,
  className: 'not-clear',
};
function petaProv(map) {
  $.getJSON('/assets/geojson.geojson', function (data) {
    var layerProv = L.geoJson(data, {
      style: styleProv,
      onEachFeature: function (feature, layer) {
        layer.layerID = 'layerProv';
      },
    });
    layerProv.addTo(map);
  });
}

function setLayerSebaran(paths, idJenis, namaJenis, map) {
  var thisJenis = namaJenis;

  var labelControlStat = {};
  $.ajax({
    async: false,
    url: config.apiStatSub + '/' + idJenis,
    dataType: 'json',
    success: function (data) {
      for (var key in data) {
        var thisNama = key;
        var totalSebaran = data[key];
        var thisNamaStyle =
          '<span class="toggle-sebaran-penduduk">' + key + '</span>';
        labelControlStat[thisNamaStyle] = poligonAreaSebaran(
          paths,
          thisNama,
          idJenis,
          namaJenis,
          totalSebaran,
        );
      }
    },
  });

  var layerLokasi = {
    ['<b style="text-transform:uppercase;">' + namaJenis + '</b>']:
      labelControlStat,
  };

  return layerLokasi;
}

function poligonAreaSebaran(paths, thisNama, idJenis, namaJenis, totalSebaran) {
  var style_polygon = {
    weight: 1,
    color: '#555555',
    opacity: 1,
    fillOpacity: 0.85,
    dashArray: '2',
  };

  info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info-sebaran');
    this.update();
    return this._div;
  };

  info.update = function (props, thisNama, getJml) {
    this._div.innerHTML =
      'Sebaran ' +
      (props
        ? '<b>' +
          thisNama +
          '</b><br>di RT ' +
          props.rt +
          ' RW ' +
          props.rw +
          '<br>Dusun ' +
          props.dusun +
          '<br>Jumlah : <b>' +
          getJml +
          ' orang</b>'
        : '');
  };

  info.addTo(map);

  var layerLahan = L.geoJSON(paths, {
    coordsToLatLng: function (coords) {
      return new L.LatLng(coords[0], coords[1]);
    },
    style: style_polygon,
    onEachFeature: function (feature, layer) {
      var getKey = feature.properties[thisNama];
      if (typeof getKey !== 'undefined') {
        var getJml = feature.properties[thisNama].jumlah;

        if (getJml > 0) {
          var getFile =
            '<div class="btn-unduh-popup"><a href="' +
            feature.properties[thisNama].file +
            '" class="btn btn-block btn-outline-secondary btn-sm">Unduh Data</a></div>';
        } else {
          var getFile = '';
        }
      } else {
        var getJml = 0;
        var getFile = '';
      }
      layer.setStyle({
        fillColor: getColor(getJml),
      });
      layer.on('load', function () {
        this.setStyle({
          fillColor: getColor(getJml),
        });
      });
      layer.on('mouseover', function () {
        this.setStyle({
          fillColor: lightenColor(getColor(getJml), 15),
          color: '#aaaaaa',
        });
        info.update(layer.feature.properties, thisNama, getJml);
      });
      layer.on('mouseout', function () {
        this.setStyle({
          fillColor: getColor(getJml),
          color: '#555555',
        });
        info.update();
      });

      var content_pop =
        '<div class="popup-sebaran">' +
        '<h5> RT ' +
        feature.properties.rt +
        ' RW ' +
        feature.properties.rw +
        ' Dusun ' +
        feature.properties.dusun +
        '</h5>' +
        '<p>' +
        namaJenis +
        ' : ' +
        thisNama +
        '<br> Jumlah : ' +
        '<span class="jml-orang"><b>' +
        getJml +
        '</b></span> orang' +
        '</p>' +
        '</div>';
      layer.bindPopup(content_pop);
      layer.bindTooltip(getJml, {
        sticky: true,
        direction: 'center',
        permanent: true,
      });
    },
  });

  legend.onAdd = function (map) {
    var totalPenduduk = getTotalPendudukPlus(elemTotal);
    var div = L.DomUtil.create('div', 'info-sebaran legend'),
      grades = [0, 10, 20, 50, 100, 200, 500, 1000],
      labels = [],
      from,
      to;

    for (var i = 0; i < grades.length; i++) {
      from = grades[i];
      to = grades[i + 1];

      labels.push(
        '<i style="background:' +
          getColor(from + 1) +
          '"></i> ' +
          parseInt(from + 1) +
          (to ? ' &ndash; ' + to : '+'),
      );
    }

    div.innerHTML = labels.join('<br>');
    return div;
  };

  legend.addTo(map);
  return layerLahan;
}

function setLayerCustomSaranaAll(
  marker,
  pathSimbol,
  idJenis,
  jenis,
  kategori,
  map,
) {
  var thisSimbol = pathSimbol;
  var thisJenis = idJenis;
  var thisMarker = marker;
  var thisNamaJenis = jenis;

  var labelControlMarkerAll = {};
  $.ajax({
    async: false,
    url: config.apiLokasiKategori,
    dataType: 'json',
    success: function (data) {
      var filterJenis = data.filter(function (v) {
        return v.parrent == thisJenis;
      });
      var jml = filterJenis.length;
      for (var x = 0; x < jml; x++) {
        var thisNama = filterJenis[x].nama;
        var thisLabel = thisNama + '-' + filterJenis[x].id;
        var thisKategori = filterJenis[x].id;
        labelControlMarkerAll[thisNama] = saranaLayer(
          thisMarker,
          thisSimbol,
          thisNamaJenis,
          thisKategori,
        );
      }
    },
  });
  var layerLokasi = {
    ['<b style="text-transform:uppercase;">' + thisNamaJenis + '</b>']:
      labelControlMarkerAll,
  };

  return layerLokasi;
}

function saranaLayer(marker, thisSimbol, thisNamaJenis, thisKategori) {
  var markersList = [];
  var saranaLayer = L.geoJSON(marker, {
    coordsToLatLng: function (coords) {
      return new L.LatLng(coords[0], coords[1]);
    },

    pointToLayer: function (feature, latlng) {
      var iconLokasi = L.icon({
        iconUrl: thisSimbol + feature.properties.simbol,
        iconSize: [32, 37],
        iconAnchor: [16, 37],
        popupAnchor: [0, -28],
      });
      return L.marker(latlng, {
        icon: iconLokasi,
      });
    },
    filter: function (feature, layer) {
      return feature.properties.ref_point === thisKategori;
    },
    onEachFeature: function (feature, layer) {
      if (
        feature.properties.nama_jalan !== '' ||
        feature.properties.nama_jalan !== '-'
      ) {
        var jalan = '<p>' + feature.properties.nama_jalan + '</p>';
      } else {
        var jalan = '';
      }
      if (feature.properties.desk !== '' || feature.properties.desk !== '-') {
        var desk = '<p>' + feature.properties.desk + '</p>';
      } else {
        var desk = '';
      }
      if (feature.properties.foto) {
        var fotoLokasi =
          '<a href="javascript:;" data-img="' +
          config.pathImageLokasi +
          feature.properties.foto +
          '" data-title="' +
          feature.properties.nama +
          '" data-remote="false" data-toggle="modal" data-target="#modalFoto">' +
          '<img src="' +
          config.pathImageLokasi +
          feature.properties.foto +
          '" alt="' +
          feature.properties.nama +
          '" style="max-width: 100%;"></a>';
      } else {
        var fotoLokasi = '';
      }
      var content_lokasi =
        '<div id="content">' +
        '<h4 id="firstHeading" class="firstHeading">' +
        feature.properties.nama +
        '</h4>' +
        '<div id="bodyContent">' +
        fotoLokasi +
        jalan +
        desk +
        '</div>' +
        '</div>';
      layer.bindPopup(content_lokasi);
      layer.bindTooltip(feature.properties.nama, {
        sticky: true,
        direction: 'bottom',
        permanent: true,
      });
    },
  });

  markersList.push(saranaLayer);
  return saranaLayer;
}

function setLayerCustomSarana(marker, pathSimbol, jenis, kategori, map) {
  var marker_lokasi = [];
  var markers = new L.MarkerClusterGroup();
  var markersList = [];

  var layer_lokasi = L.featureGroup();

  var layerLokasi = {
    'Tampilkan Pin': layer_lokasi,
  };
  var saranaLayer = L.geoJSON(marker, {
    coordsToLatLng: function (coords) {
      return new L.LatLng(coords[0], coords[1]);
    },

    pointToLayer: function (feature, latlng) {
      var iconLokasi = L.icon({
        iconUrl: pathSimbol + feature.properties.simbol,
        iconSize: [32, 37],
        iconAnchor: [16, 37],
        popupAnchor: [0, -28],
      });
      return L.marker(latlng, {
        icon: iconLokasi,
      });
    },
    filter: function (feature, layer) {
      if (kategori === 'true') {
        return feature.properties.kategori === jenis;
      } else {
        return feature.properties.jenis === jenis;
      }
    },

    onEachFeature: function (feature, layer) {
      var content_lokasi =
        '<div id="content">' +
        '<h4 id="firstHeading" class="firstHeading">' +
        feature.properties.nama +
        '</h4>' +
        '<div id="bodyContent">' +
        '<p>' +
        feature.properties.nama_jalan +
        '</p>' +
        '<p>' +
        feature.properties.desk +
        '</p>' +
        '</div>' +
        '</div>';
      layer.bindPopup(content_lokasi);
      layer.bindTooltip(feature.properties.nama);
    },
  });

  markersList.push(saranaLayer);
  markers.addLayer(saranaLayer);

  map.on('layeradd layerremove', function () {
    var bounds = new L.LatLngBounds();
    map.eachLayer(function (layer) {
      if (map.hasLayer(layer_lokasi)) {
        map.addLayer(markers);
      } else {
        map.removeLayer(markers);
        map._layersMaxZoom = 21;
      }
      if (layer instanceof L.FeatureGroup) {
        bounds.extend(layer.getBounds());
      }
    });
  });

  return layerLokasi;
}

function setLayerCustomPersil(marker, map, color) {
  var style_polygon = {
    weight: 0.5,
    color: configColor.border,
    opacity: 1,
    fillColor: configColor.primary,
    fillOpacity: 0.85,
  };
  var layerPersil = L.geoJSON(marker, {
    coordsToLatLng: function (coords) {
      return new L.LatLng(coords[0], coords[1]);
    },
    style: style_polygon,
    onEachFeature: function (feature, layer) {
      layer.on('mouseover', function () {
        this.setStyle({
          fillColor: lightenColor(configColor.primary, 15),
        });
      });
      layer.on('mouseout', function () {
        this.setStyle({
          fillColor: configColor.primary,
        });
      });
      if (
        feature.properties.deskripsi === '' ||
        feature.properties.deskripsi === null
      ) {
      } else {
        var perNamaPemilik =
            feature.properties.Nama_Pemil !== ''
              ? '<tr><td>Pemilik</td><td>: ' +
                feature.properties.Nama_Pemil +
                '</td></tr>'
              : '',
          perNik =
            feature.properties.NIK !== '0'
              ? '<tr><td>NIK</td><td>: ' + feature.properties.NIK + '</td></tr>'
              : '',
          perNoSurat =
            feature.properties.No_Surat_P !== ''
              ? '<tr><td>No.Surat</td><td>: ' +
                feature.properties.No_Surat_P +
                '</td></tr>'
              : '',
          perSppt =
            feature.properties.Nomor_SPPT !== ''
              ? '<tr><td>No.SPPT</td><td>: ' +
                feature.properties.Nomor_SPPT +
                '</td></tr>'
              : '',
          perNib =
            feature.properties.NIB !== ''
              ? '<tr><td>NIB</td><td>: ' + feature.properties.NIB + '</td></tr>'
              : '',
          perJenis =
            feature.properties.Jenis_Pers !== ''
              ? '<tr><td>Jenis</td><td>: ' +
                feature.properties.Jenis_Pers +
                '</td></tr>'
              : '',
          perLuasPtsl =
            feature.properties.Luas_PTSL !== '0'
              ? '<tr><td>Luas PTSL</td><td>: ' +
                convertRibuan(feature.properties.Luas_PTSL) +
                ' m<span class="superscript">2</span></td></tr>'
              : '',
          perKelasTanah =
            feature.properties.Kelas_Tana !== ''
              ? '<tr><td>Kelas Tanah</td><td>: ' +
                feature.properties.Kelas_Tana +
                '</td></tr>'
              : '',
          perLuasSppt =
            feature.properties.Luas__SPPT !== '0'
              ? '<tr><td>Luas SPPT</td><td>: ' +
                convertRibuan(feature.properties.Luas__SPPT) +
                ' m<span class="superscript">2</span></td></tr>'
              : '',
          perPeruntukan =
            feature.properties.Peruntukan !== ''
              ? '<tr><td>Peruntukkan</td><td>: ' +
                feature.properties.Peruntukan +
                '</td></tr>'
              : '',
          perNamaJalan =
            feature.properties.Nama_Jalan !== ''
              ? '<li>' + feature.properties.Nama_Jalan + '</li>'
              : '',
          perAlamat =
            feature.properties.Alamat !== ''
              ? '<li>' + feature.properties.Alamat + '</li>'
              : '',
          perBlok =
            feature.properties.Blok !== '0'
              ? 'Blok ' + feature.properties.Blok + ' '
              : '',
          perRT =
            feature.properties.RT !== '0'
              ? 'RT ' + feature.properties.RT + ' '
              : '',
          perRW =
            feature.properties.RW !== '0'
              ? 'RW ' + feature.properties.RW + ' '
              : '',
          perDusun =
            feature.properties.Dusun !== ''
              ? 'Dusun ' + feature.properties.Dusun + ' '
              : '',
          perKet =
            feature.properties.Keterangan !== ''
              ? '<tr><td>Keterangan</td><td>: ' +
                feature.properties.Keterangan +
                '</td></tr>'
              : '';
        var mergeAlamat =
          '<tr><td>Alamat</td><td>: <ul>' +
          perAlamat +
          '<li>' +
          perBlok +
          perRT +
          perRW +
          perDusun +
          '</li>' +
          '</ul></td></tr>';
        var mergeDataPersil =
          '<table class="table-data-persil">' +
          perNamaPemilik +
          perNik +
          perNoSurat +
          perSppt +
          perNib +
          perJenis +
          perLuasPtsl +
          perKelasTanah +
          perLuasSppt +
          perPeruntukan +
          mergeAlamat +
          perKet +
          '</table>';
        var contentPersil = mergeDataPersil;
        layer.bindPopup(contentPersil);
        layer.bindTooltip('Lihat detil');
      }
    },
  });
  map.fitBounds(layerPersil.getBounds());
  return layerPersil;
}

function overlayWilPersil(wilayah, deskripsi, map) {
  var daerah_wilayah = wilayah;
  daerah_wilayah[0].push(daerah_wilayah[0][0]);

  var style_polygon = {
    weight: 1,
    color: '#FFFFFF',
    opacity: 1,
    fillColor: '#FC4E2A',
    fillOpacity: 0.85,
    dashArray: '3',
  };

  if (deskripsi === '') {
    var poligonPersil = L.polygon(wilayah, style_polygon).bindTooltip(
      'Data belum tersedia',
    );
  } else {
    var poligonPersil = L.polygon(wilayah, style_polygon, {
      popup: deskripsi,
    }).bindTooltip('Lihat detil');

    var onPolyClick = function (event) {
      popup = new L.Popup();
      var popupContent = deskripsi;
      var bounds = poligonPersil.getBounds();
      popup.setLatLng(bounds.getCenter());
      popup.setContent(popupContent);
      map.openPopup(popup);

      map.fitBounds(poligonPersil.getBounds());
    };

    poligonPersil.on('click', onPolyClick);
  }

  return poligonPersil;
}

function setLayerCustomLahan(paths, map, color) {
  var labelControlLahanAll = {};
  $.ajax({
    async: false,
    url: config.apiLahanJenis,
    dataType: 'json',
    success: function (data) {
      var jml = data.length;
      for (var x = 0; x < jml; x++) {
        var thisNama = data[x].nama;
        var thisWarna = data[x].warna;
        var labelList =
          '<span class="warna-label" style="background-color:' +
          thisWarna +
          ';"></span>' +
          thisNama;
        var controlList = poligonArea(paths, thisNama);
        labelControlLahanAll[labelList] = controlList;
      }

      $('.loaderAll').hide();
    },
  });

  var overlayLayers = { '<b>TUTUPAN LAHAN</b>': labelControlLahanAll };
  return overlayLayers;
}

function poligonArea(paths, jenis) {
  var style_polygon = {
    weight: 0.5,
    color: '#FFFFFF',
    opacity: 1,
    fillOpacity: 0.85,
  };
  var layerLahan = L.geoJSON(paths, {
    coordsToLatLng: function (coords) {
      return new L.LatLng(coords[0], coords[1]);
    },
    filter: function (feature, layer) {
      return feature.properties.jenis === jenis;
    },
    style: style_polygon,
    onEachFeature: function (feature, layer) {
      if (
        feature.properties.jenis === 'Jalan' ||
        feature.properties.jenis === 'Saluran & Sungai'
      ) {
        layer.setStyle({
          fillColor: feature.properties.warna,
          weight: 0,
        });
      } else {
        layer.setStyle({
          fillColor: feature.properties.warna,
          weight: 0.5,
          color: lightenColor(feature.properties.warna, 15),
        });
      }
      layer.on('load', function () {
        this.setStyle({
          fillColor: feature.properties.warna,
        });
        checkUkuran();
      });
      layer.on('mouseover', function () {
        this.setStyle({
          fillColor: lightenColor(feature.properties.warna, 15),
        });
      });
      layer.on('mouseout', function () {
        this.setStyle({
          fillColor: feature.properties.warna,
        });
      });

      layer.bindTooltip('Lihat detil');
      var thisLuas = parseFloat(feature.properties.luas);
      var luasDec = Number(thisLuas).toFixed(2);
      if (feature.properties.jenis === 'Sawah') {
        var perNamaPemilik =
            feature.properties.pemilik !== ''
              ? '<tr><td>Pemilik</td><td>: ' +
                feature.properties.pemilik +
                '</td></tr>'
              : '',
          perLuas =
            feature.properties.luas !== ''
              ? '<tr><td>Luas</td><td>: ' + luasDec + ' Ha</td></tr>'
              : '',
          perKelasTanah =
            feature.properties.kelas !== null
              ? '<tr><td>Kelas Tanah</td><td>: ' +
                feature.properties.kelas +
                '</td></tr>'
              : '';
        perAlamatTanah =
          feature.properties.alamat !== null
            ? '<tr><td>Alamat</td><td>: ' +
              feature.properties.alamat +
              '</td></tr>'
            : '';
        var mergeDataSawah =
          '<table class="table-data-persil">' +
          perNamaPemilik +
          perLuas +
          perKelasTanah +
          '</table>';
        var contentSawah = mergeDataSawah;
        layer.bindPopup(contentSawah);
      } else {
        layer.bindPopup('Luas : ' + luasDec + ' Ha');
      }
      if (
        feature.properties.deskripsi === '' ||
        feature.properties.deskripsi === null
      ) {
      } else {
      }
    },
  });

  return layerLahan;
}

function getJenisLahan(jenis) {
  var result = null;
  $.ajax({
    async: false,
    url: config.apiLahanJenis,
    dataType: 'json',
    success: function (data) {
      var filterJenis = data.filter(function (v) {
        return v.nama == jenis;
      });
      $.each(filterJenis, function (index) {
        result =
          '<span class="warna-label" style="background-color:' +
          filterJenis[index].warna +
          ';"></span>' +
          filterJenis[index].nama;
      });
    },
  });
  return result;
}

function poligonWilNew(marker) {
  var poligonWil = L.geoJSON(turf.featureCollection(marker), {
    pmIgnore: true,
    onEachFeature: function (feature, layer) {
      if (feature.properties.name == 'kantor_desa') {
        layer.bindPopup(feature.properties.content, {
          className: 'kantor_desa',
        });
        layer.bindTooltip(feature.properties.judulkantor, {
          sticky: true,
          direction: 'center',
          permanent: true,
          className: 'not-clear',
        });
      } else if (feature.properties.name == 'leuit_desa') {
        layer.bindPopup(feature.properties.content, {
          className: 'leuit_desa',
        });
        layer.bindTooltip(feature.properties.judul, {
          sticky: true,
          direction: 'center',
          permanent: true,
          className: 'not-clear',
        });
      } else if (feature.properties.tipe == 'dusun') {
        layer.setStyle({
          color: '#42b649',
        });
        layer.bindTooltip(feature.properties.content, {
          sticky: true,
          direction: 'center',
          permanent: true,
        });
      } else {
        if (feature.properties.name !== 'Wilayah Desa') {
          layer.bindTooltip(feature.properties.content, {
            sticky: true,
            direction: 'center',
            className: 'tooltip-wilayah',
            offset: [0, 10],
          });
        } else {
          layer.bindTooltip(feature.properties.desa, {
            sticky: true,
            direction: 'center',
            permanent: true,
            className: 'not-clear',
          });
        }
        layer.bindPopup(feature.properties.content);
      }
      if (feature.properties.name !== 'kantor_desa') {
        if (feature.properties.name == 'RT') {
          layer.setStyle({
            color: '#999999',
          });
        }
        if (feature.properties.name == 'RW') {
          layer.setStyle({
            color: '#0E86D4',
          });
        }

        layer.on('load', function () {
          this.setStyle({
            fillColor: feature.properties.color,
          });
        });
        layer.on('mouseover', function () {
          this.setStyle({
            fillColor: lightenColor(feature.properties.color, 15),
          });
        });
        layer.on('mouseout', function () {
          this.setStyle({
            fillColor: feature.properties.color,
          });
        });
      }
    },
    style: function (feature) {
      if (feature.properties.style) {
        return feature.properties.style;
      }
    },
    pointToLayer: function (feature, latlng) {
      if (feature.properties.style) {
        return L.marker(latlng, { icon: feature.properties.style });
      } else return L.marker(latlng);
    },
  });
  return poligonWil;
}

function overlayWilNew(marker_desa, marker_dusun, marker_rw, marker_rt) {
  var poligon_wil_desa = poligonWilNew(marker_desa);
  var poligon_wil_dusun = poligonWilNew(marker_dusun);
  var poligon_wil_rw = poligonWilNew(marker_rw);
  var poligon_wil_rt = poligonWilNew(marker_rt);

  var overlayLayers = {
    '<b style="text-transform:uppercase;">Batas Wilayah</b>': {
      ' Dusun': poligon_wil_dusun,
      ' RW': poligon_wil_rw,
      ' RT': poligon_wil_rt,
    },
  };
  return overlayLayers;
}

function overlayWilDesa(marker_desa) {
  var poligon_wil_desa = poligonWilNew(marker_desa);
  return poligon_wil_desa;
}

function setPolygonDesa(
  marker_desa,
  desa,
  judul,
  favico_desa,
  contents,
  desaid,
) {
  var daerah_desa = JSON.parse(desa['path']);
  var jml = daerah_desa[0].length;
  daerah_desa[0].push(daerah_desa[0][0]);
  for (var x = 0; x < jml; x++) {
    daerah_desa[0][x].reverse();
  }

  content = $(contents).html();
  thisDesa = $(content).find('.firstHeading').html();
  marker_desa.push(
    turf.polygon(daerah_desa, {
      name: 'Wilayah Desa',
      content: content,
      desa: thisDesa,
      style: {
        color: configColor.border,
        opacity: 1,
        weight: 2.5,
        fillColor: configColor.desa,
        fillOpacity: 0.2,
        className: 'poly-desa desa-' + desaid,
      },
      color: configColor.desa,
    }),
  );
}

function setPolygonContent(
  marker,
  daftar_path,
  warna,
  judul,
  nama_wil,
  contents,
  desaid,
) {
  var marker_style = {
    stroke: true,
    color: '#f8db21',
    opacity: 1,
    weight: 1,
    fillOpacity: 0.5,
  };
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var jml_path;
  for (var x = 0; x < jml; x++) {
    if (daftar[x].path) {
      daftar[x].path = JSON.parse(daftar[x].path);
      jml_path = daftar[x].path[0].length;
      for (var y = 0; y < jml_path; y++) {
        daftar[x].path[0][y].reverse();
      }

      content = $(contents + x).html();
      thisDusun = $(content).find('.nama-dusun').html();
      var randColor = randomColor();

      daftar[x].path[0].push(daftar[x].path[0][0]);
      marker.push(
        turf.multiPolygon([daftar[x].path], {
          name: judul,
          dusun: thisDusun,
          tipe: nama_wil,
          content: content,
          style: {
            stroke: true,
            color: lightenColor(configColor.dusun, 15),
            opacity: 1,
            weight: 2,
            fillColor: configColor.dusun,
            fillOpacity: 0.05,
            className:
              'poly-wil wil-sub-' +
              nama_wil +
              ' class-dusun-' +
              thisDusun +
              ' desa-' +
              daftar[x].id_desa,
          },
          color: configColor.dusun,
        }),
      );
    }
  }
}

function setPointLeuit(map, nama, lat, lng, contents, id) {
  content = $(contents).html();

  var leuit_style = stylePointLeuit('/assets/images/leuit.png');
  var customIcon = L.icon(leuit_style);
  var markerOptions = {
    title: nama,
    clickable: true,
    icon: customIcon,
  };
  var marker = L.marker([lat, lng], markerOptions);
  var popupLeuit =
    '<div id="content">' +
    '<h4 id="firstHeading" class="firstHeading">' +
    nama +
    '</h4>' +
    '<div id="bodyContent">' +
    '<p>' +
    '</p>' +
    '</div>' +
    '</div>';
  marker.bindPopup(content);
  marker.addTo(map);
  var getLink = $('#isi_popup_leuit_' + id).find('a');
}

function stylePointLeuit(url) {
  var style = {
    iconSize: [28, 28],
    iconAnchor: [16, 28],
    popupAnchor: [0, -16],
    iconUrl: url,
    className: 'not-clear',
  };
  return style;
}

function leuitOnClick(contents) {}
