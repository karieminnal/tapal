$(document).ready(function () {
  $('#modalKecil')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('#modalSedang')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('#modalBesar')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('#modalLeuit')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('#modalLeuit360')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('#modalFoto')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var foto = link.data('img');
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this)
        .find('.fetched-data')
        .html(
          '<img src="' + foto + '" alt="' + title + '" style="width:100%;">',
        );
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });
  $('#modalAparatur')
    .on('show.bs.modal', function (e) {
      var link = $(e.relatedTarget);
      var title = link.data('title');
      var modal = $(this);
      modal.find('.modal-title').text(title);
      $(this).find('.fetched-data').load(link.attr('href'));
    })
    .on('hidden.bs.modal', function (e) {
      $(this).find('.fetched-data').html('');
    });

  $('.button-batas .control-custom').each(function (i, element) {
    var thisCheck = $(element).find('input');

    $(thisCheck).change(function (index, value) {
      handleTriggerApp(0, i);
    });
  });

  return false;
});

var elemTotal = '#totalPenduduk';
getTotalPendudukPlus(elemTotal);

function checkListData() {
  $('.button-data .control-custom').each(function (i, element) {
    var thisCheck = $(element).find('input');

    $(thisCheck).change(function (index, value) {
      handleTriggerApp(1, i);
    });
  });
}

function handleTriggerApp(indexGroup, indexCheck) {
  var controlLeft = $('.leaflet-top.leaflet-left');

  var batasWilayah = $(controlLeft).find('.leaflet-control').eq(indexGroup);
  var layerG = $(batasWilayah).find('.leaflet-control-layers-group');

  var thisLabel = $(layerG)
    .find('label')
    .eq(indexCheck + 1);

  $(thisLabel).trigger('click');
}

function pushListSub(thisNama) {
  var elButtonData = $('.button-data');
  var listCheck =
    '<div class="control-custom">' +
    '<label class="control control--checkbox">' +
    '<input type="checkbox" />' +
    '<span>' +
    thisNama +
    '</span>' +
    '<div class="control__indicator"></div>' +
    '</label>' +
    '</div>';
  $(listCheck).appendTo(elButtonData);
}

function pushListSubRadio(thisNama, tagName) {
  var elButtonData = $('.button-data');
  var listCheck =
    '<div class="control-custom ' +
    tagName +
    '">' +
    '<label class="control control--checkbox">' +
    '<input type="radio" name="' +
    tagName +
    '" />' +
    '<span>' +
    thisNama +
    '</span>' +
    '<div class="control__indicator"></div>' +
    '</label>' +
    '</div>';
  $(listCheck).appendTo(elButtonData);
}

function toggleClear(map) {
  var toggleClear = L.control({ position: 'topright' });

  toggleClear.onAdd = function (map) {
    this._div = L.DomUtil.create('div');
    this._div.classList.add('leaflet-bar', 'leaflet-control');
    this._div.setAttribute('onclick', 'bersihkan()');
    this._div.innerHTML =
      '<a class="trigger-clear" title="Bersihkan Peta"></a>';
    return this._div;
  };
  toggleClear.addTo(map);
}

function stylePointLogo(url) {
  var style = {
    iconSize: [16, 16],
    iconAnchor: [8, 16],
    popupAnchor: [0, -28],
    iconUrl: url,
  };
  return style;
}

function getBaseLayers(peta, access_token) {
  var defaultLayer = L.tileLayer(
    '//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.png',
    {
      attribution:
        '<a href="javascript:;" title="Basemap satelite by Arcgis">Arcgis</a>',
    },
  ).addTo(peta);

  var baseLayers = {
    Satelite: defaultLayer,
  };

  return baseLayers;
}

function numberFormat(num) {
  return new Intl.NumberFormat('id-ID').format(num);
}

function parseToNum(data) {
  return parseFloat(data.toString().replace(/,/g, ''));
}

function poligonWilNew(marker) {
  //   console.log(marker);
  var poligonWil = L.geoJSON(turf.featureCollection(marker), {
    pmIgnore: true,
    // showMeasurements: true,
    // measurementOptions: { showOnHover: true },
    onEachFeature: function (feature, layer) {
      if (feature.properties.name == 'kantor_desa') {
        // Beri classname berbeda, supaya bisa gunakan css berbeda
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
          // fillOpacity: 0.6,
        });
      } else {
        if (feature.properties.name !== 'Wilayah Desa') {
          layer.bindTooltip(feature.properties.content, {
            sticky: true,
            direction: 'center',
            // permanent: true,
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
            // fillOpacity: 0.6,
          });
        }
        if (feature.properties.name == 'RW') {
          layer.setStyle({
            color: '#0E86D4',
            // fillOpacity: 0.6,
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
      //   ' Desa': poligon_wil_desa,
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

  //   var point_style = stylePointLogo(favico_desa);
  //   marker_desa.push(
  //     turf.point([desa['lng'], desa['lat']], {
  //       name: 'kantor_desa',
  //       //   content: 'Kantor ' + judul,
  //       content: content,
  //       judulkantor: judul,
  //       style: L.icon(point_style),
  //       color: configColor.desa,
  //     }),
  //   );
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
    // fillColor: warna,
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
        turf.polygon(daftar[x].path, {
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
            className: 'poly-wil desa-' + daftar[x].id_desa,
          },
          color: configColor.dusun,
        }),
      );
      //   console.log(marker);
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
  //   contentUrl = $('/first/loadModalLeuit360/' + id).html();
  var marker = L.marker([lat, lng], markerOptions);
  var popupLeuit =
    '<div id="content">' +
    '<h4 id="firstHeading" class="firstHeading">' +
    nama +
    '</h4>' +
    '<div id="bodyContent">' +
    '<p>' +
    // feature.properties.nama_jalan +
    '</p>' +
    '</div>' +
    '</div>';
  //   marker.bindPopup(content);
  var getLink = $('#isi_popup_leuit_' + id).find('a');
  marker.addTo(map).on('click', function (e) {
    $(getLink).trigger('click');
  });
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

var styleProv = {
  color: configColor.border,
  opacity: 1,
  weight: 1,
  fillColor: configColor.desa,
  fillOpacity: 0,
  fill: false,
  className: 'not-clear',
};
function petaProv(map) {
  $.getJSON('/assets/geojson.geojson', function (data) {
    var layerProv = L.geoJson(data, {
      style: styleProv,
      onEachFeature: function (feature, layer) {
        layer.layerID = 'layerProv';
        // layer.options.zIndex = -1;
      },
    });
    layerProv.addTo(map);
  });
}
