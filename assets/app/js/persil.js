function setLayerCustomPersil(marker, map, color) {
  var style_polygon = {
    weight: 0.5,
    color: configColor.border,
    opacity: 1,
    fillColor: configColor.primary,
    fillOpacity: 0.85,
  };
  var layerPersil = L.geoJSON(marker, {
    coordsToLatLng: function(coords) {
      return new L.LatLng(coords[0], coords[1]);
    },
    style: style_polygon,
    onEachFeature: function(feature, layer) {
      layer.on('mouseover', function() {
        this.setStyle({
          fillColor: lightenColor(configColor.primary, 15),
        });
      });
      layer.on('mouseout', function() {
        this.setStyle({
          fillColor: configColor.primary,
        });
      });
      if (
        feature.properties.deskripsi === '' ||
        feature.properties.deskripsi === null
      ) {
        // layer.bindTooltip('Data belum tersedia');
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
          perNamaJalan +
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

    var onPolyClick = function(event) {
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

$(document).ready(function() {});

function pushSearchPersil() {
  var elButtonData = $('.button-data');
  var listCheck = $('#search-check-container').html();
  $(listCheck).appendTo(elButtonData);
}
