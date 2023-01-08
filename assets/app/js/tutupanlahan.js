function setLayerCustomLahan(paths, map, color) {
  var labelControlLahanAll = {};
  $.ajax({
    async: false,
    url: config.apiLahanJenis,
    dataType: 'json',
    success: function(data) {
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
        pushListSub(labelList);
      }
    },
  });

  var overlayLayers = { '<b>TUTUPAN LAHAN</b>': labelControlLahanAll };
  checkListData();
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
    // showMeasurements: true,
    coordsToLatLng: function(coords) {
      return new L.LatLng(coords[0], coords[1]);
    },
    filter: function(feature, layer) {
      return feature.properties.jenis === jenis;
    },
    style: style_polygon,
    onEachFeature: function(feature, layer) {
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
        });
        // layer.showMeasurements({ imperial: true, showSegmentLength: false });
      }
      layer.on('load', function() {
        // $('.show-ukuran-lahan').show();
        this.setStyle({
          fillColor: feature.properties.warna,
        });
        // checkUkuran();
      });
      layer.on('mouseover', function() {
        this.setStyle({
          fillColor: lightenColor(feature.properties.warna, 15),
        });
      });
      layer.on('mouseout', function() {
        this.setStyle({
          fillColor: feature.properties.warna,
        });
      });
      //   layer.bindTooltip(feature.properties.luas, {
      //     sticky: true,
      //     direction: 'center',
      //     permanent: true,
      //     className: 'tooltip-lahan',
      //   });
      layer.bindPopup(
        'Luas : ' +
          convertRibuan(feature.properties.luas) +
          ' m<span class="superscript">2</span>',
      );
      if (
        feature.properties.deskripsi === '' ||
        feature.properties.deskripsi === null
      ) {
        // layer.bindTooltip('Data belum tersedia');
      } else {
        // layer.bindPopup(feature.properties.deskripsi);
        // layer.bindTooltip('Lihat detil');
      }
    },
  });

  //   map.fitBounds(layerLahan.getBounds());
  return layerLahan;
}
