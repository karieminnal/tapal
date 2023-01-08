function setLayerSebaran(paths, idJenis, namaJenis, map) {
  $('.button-data').removeClass('show');
  var thisJenis = namaJenis;

  var labelControlStat = {};
  $.ajax({
    async: false,
    url: config.apiStatSub + '/' + idJenis + '?logApp=true',
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
        // console.log(thisNama);
        pushListSubRadio(thisNama, 'sebaranRadio');
        $('.button-data').addClass('show');
      }
    },
  });

  var layerLokasi = {
    ['<b style="text-transform:uppercase;">' + namaJenis + '</b>']:
      labelControlStat,
  };

  checkListData();
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
        // getFile +
        '</p>' +
        '</div>';
      layer.bindPopup(content_pop);
      layer.bindTooltip(getJml + '', {
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
