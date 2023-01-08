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
    success: function(data) {
      var filterJenis = data.filter(function(v) {
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
        // console.log(thisNama + ', ');
        pushListSub(thisNama);
      }
    },
  });
  var layerLokasi = {
    ['<b style="text-transform:uppercase;">' +
    thisNamaJenis +
    '</b>']: labelControlMarkerAll,
  };

  checkListData();

  return layerLokasi;
}

function saranaLayer(marker, thisSimbol, thisNamaJenis, thisKategori) {
  var markersList = [];
  var saranaLayer = L.geoJSON(marker, {
    coordsToLatLng: function(coords) {
      return new L.LatLng(coords[0], coords[1]);
    },

    pointToLayer: function(feature, latlng) {
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
    filter: function(feature, layer) {
      return feature.properties.ref_point === thisKategori;
    },
    onEachFeature: function(feature, layer) {
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
    // 'Tampilkan Jumlah': layer_lokasi,
  };
  var saranaLayer = L.geoJSON(marker, {
    coordsToLatLng: function(coords) {
      return new L.LatLng(coords[0], coords[1]);
    },

    pointToLayer: function(feature, latlng) {
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
    filter: function(feature, layer) {
      if (kategori === 'true') {
        return feature.properties.kategori === jenis;
      } else {
        return feature.properties.jenis === jenis;
      }
    },
    // onEachFeature: onEachFeature
    onEachFeature: function(feature, layer) {
      var content_lokasi =
        '<div id="content">' +
        '<h4 id="firstHeading" class="firstHeading">' +
        feature.properties.nama +
        '</h4>' +
        '<div id="bodyContent">' +
        // feature.properties.foto +
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
  //   map.fitBounds(saranaLayer.getBounds());

  map.on('layeradd layerremove', function() {
    var bounds = new L.LatLngBounds();
    map.eachLayer(function(layer) {
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
