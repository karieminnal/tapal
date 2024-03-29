$(document).ready(function () {
  $('#resetme').click(function () {
    window.location.reload(false);
  });

  var repIn = [','];
  var repOut = ['.'];

  $('input[name="lat"], input[name="lng"]').bind(
    'propertychange change click keyup keypress input paste blur',
    function () {
      var text = $(this).val();
      for (var i = 0; i < repIn.length; i++) {
        text = text.replace(repIn[i], repOut[i]);
      }
      $(this).val(text);
    },
  );
});

function set_marker(marker, daftar_path, warna, judul, nama_wil) {
  var marker_style = {
    stroke: true,
    color: '#FF0000',
    opacity: 1,
    weight: 2,
    fillColor: warna,
    fillOpacity: 0.2,
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
      daftar[x].path[0].push(daftar[x].path[0][0]);
      marker.push(
        turf.multiPolygon([daftar[x].path], {
          content: judul + ' ' + daftar[x][nama_wil],
          style: marker_style,
        }),
      );
    }
  }
}

function set_marker_dusun(marker, daftar_path, warna, judul, nama_wil) {
  var marker_style = {
    stroke: true,
    color: '#FF0000',
    opacity: 1,
    weight: 2,
    fillColor: warna,
    fillOpacity: 0.2,
  };
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var jml_path;
  for (var x = 0; x < jml; x++) {
    if (daftar[x].path) {
      //   console.log(daftar[x].id);
      var dusunId = daftar[x].id;
      daftar[x].path = JSON.parse(daftar[x].path);
      jml_path = daftar[x].path[0].length;
      for (var y = 0; y < jml_path; y++) {
        daftar[x].path[0][y].reverse();
      }
      daftar[x].path[0].push(daftar[x].path[0][0]);
      marker.push(
        turf.polygon(daftar[x].path, {
          content: judul + ' ' + daftar[x][nama_wil],
          idDusun: dusunId,
          style: {
            color: '#ffffff',
            opacity: 1,
            weight: 1,
            fillColor: configColor.delapan,
            fillOpacity: 0.8,
            className: 'poly-dusun dusun-' + dusunId,
          },
        }),
      );
    }
  }
}

function overlayWilDusun(marker_dusun, peta) {
  var poligon_wil_dusun = poligonWilDusun(marker_dusun, peta);
  return poligon_wil_dusun;
}

function poligonWilDusun(marker, peta) {
  var poligon_wil = L.geoJSON(turf.featureCollection(marker), {
    pmIgnore: true,
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
    onEachFeature: function (feature, layer) {
      if (feature.properties.name == 'kantor_desa') {
        // Beri classname berbeda, supaya bisa gunakan css berbeda
        layer.bindPopup(feature.properties.content, {
          className: 'kantor_desa',
        });
      } else {
        // layer.bindPopup(feature.properties.content);
        layer.bindTooltip(feature.properties.content, {
          sticky: true,
          direction: 'top',
          permanent: true,
          className:
            'tooltip-tranparan tooltip-dusun dusun-' +
            feature.properties.idDusun,
        });
        layer.on('click', function () {
          layerDusunClick(feature.properties.idDusun);
        });
        layer.on('mouseover', function () {
          this.setStyle({
            fillColor: configColor.hightlight,
            fillOpacity: 0.8,
          });
        });
        layer.on('mouseout', function () {
          this.setStyle({
            fillColor: configColor.delapan,
            fillOpacity: 0.8,
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
  poligon_wil.addTo(peta);
  //   return poligon_wil;
}

function set_marker_desa(marker_desa, desa, judul, favico_desa) {
  var daerah_desa = JSON.parse(desa['path']);
  var jml = daerah_desa[0].length;
  daerah_desa[0].push(daerah_desa[0][0]);
  for (var x = 0; x < jml; x++) {
    daerah_desa[0][x].reverse();
  }

  var point_style = stylePointLogo(favico_desa);
  marker_desa.push(
    turf.polygon(daerah_desa, {
      content: judul,
      style: stylePolygonDesa(),
      style: L.icon(point_style),
    }),
  );
  marker_desa.push(
    turf.point([desa['lng'], desa['lat']], {
      content: 'Kantor Desa',
      style: L.icon(point_style),
    }),
  );
}

function set_marker_desa_content(
  marker_desa,
  desa,
  judul,
  favico_desa,
  contents,
) {
  var daerah_desa = JSON.parse(desa['path']);
  var jml = daerah_desa[0].length;
  daerah_desa[0].push(daerah_desa[0][0]);
  for (var x = 0; x < jml; x++) {
    daerah_desa[0][x].reverse();
  }

  content = $(contents).html();

  var point_style = stylePointLogo(favico_desa);
  marker_desa.push(
    turf.point([desa['lng'], desa['lat']], {
      name: 'kantor_desa',
      content: 'Kantor Desa',
      style: L.icon(point_style),
    }),
  );
  marker_desa.push(
    turf.polygon(daerah_desa, {
      content: content,
      style: stylePolygonDesa(),
      style: L.icon(point_style),
    }),
  );
}

function set_marker_content(
  marker,
  daftar_path,
  warna,
  judul,
  nama_wil,
  contents,
) {
  var marker_style = {
    stroke: true,
    color: '#f8db21',
    opacity: 1,
    weight: 1,
    fillColor: warna,
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

      daftar[x].path[0].push(daftar[x].path[0][0]);
      marker.push(
        turf.polygon(daftar[x].path, { content: content, style: marker_style }),
      );
    }
  }
}

function getBaseLayers(peta, access_token) {
  //Menampilkan BaseLayers Peta
  //   var StreetView = L.tileLayer
  //     .provider('OpenStreetMap.Mapnik', {
  //       attribution:
  //         '<a href="https://openstreetmap.org/copyright">© OpenStreetMap</a>',
  //     })
  //     .addTo(peta);
  var defaultLayer = L.tileLayer(
    '//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.png',
    {
      //   attribution:
      //     '<a href="javascript:;" title="Basemap satelite by Arcgis">Arcgis</a> | <a href="https://kjskbyugi.co.id" target="_blank" title="Custom tiles by Yugi Limantara" style="padding:2px 0;display:inline-block;"><img src="/assets/img/yugi-logo.png" alt="Yugi Limantara" style="height:16px;width: auto;"></a>',
      attribution:
        '<a href="javascript:;" title="Basemap satelite by Arcgis">Arcgis</a>',
    },
  ).addTo(peta);

  var baseLayers = {
    Satelite: defaultLayer,
    // 'OpenStreetMap H.O.T.': StreetView,
    // 'Mapbox Streets' : mbGLstr,
    // 	'Mapbox Satellite' : mbGLsat,
    // 	'Mapbox Satellite-Street' : mbGLstrsat
  };
  //   getImageDrone(peta);
  return baseLayers;
}

function getImageDrone(peta) {
  var options = {
    minZoom: 14,
    maxZoom: 21,
    opacity: 1.0,
    tms: false,
  };
  var layerDesa = L.tileLayer(config.urlTileDrone + '{z}/{x}/{y}.png', options);

  return layerDesa;
}

function poligonWil(marker) {
  var poligon_wil = L.geoJSON(turf.featureCollection(marker), {
    pmIgnore: true,
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
    onEachFeature: function (feature, layer) {
      if (feature.properties.name == 'kantor_desa') {
        // Beri classname berbeda, supaya bisa gunakan css berbeda
        layer.bindPopup(feature.properties.content, {
          className: 'kantor_desa',
        });
      } else {
        layer.bindPopup(feature.properties.content);
      }
      layer.bindTooltip(feature.properties.content, {
        sticky: true,
        direction: 'top',
      });
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

  return poligon_wil;
}

function overlayWil(marker_desa, marker_dusun, marker_rw, marker_rt) {
  var poligon_wil_desa = poligonWil(marker_desa);
  var poligon_wil_dusun = poligonWil(marker_dusun);
  var poligon_wil_rw = poligonWil(marker_rw);
  var poligon_wil_rt = poligonWil(marker_rt);

  var overlayLayers = {
    'Peta Wilayah Desa': poligon_wil_desa,
    'Peta Wilayah Dusun': poligon_wil_dusun,
    'Peta Wilayah RW': poligon_wil_rw,
    'Peta Wilayah RT': poligon_wil_rt,
  };
  return overlayLayers;
}

function getLatLong(x, y) {
  var hasil;
  if (x == 'Rectangle' || x == 'Line' || x == 'Poly') {
    hasil = JSON.stringify(y._latlngs);
  } else {
    hasil = JSON.stringify(y._latlng);
  }
  //hasil = hasil.replace(/\}/g, ']').replace(/(\{)/g, '[').replace(/(\"lat\"\:|\"lng\"\:)/g, '');
  hasil = hasil
    .replace(/\}/g, ']')
    .replace(/(\{)/g, '[')
    .replace(/(\"lat\"\:|\"lng\"\:)/g, '')
    .replace(/(\"alt\"\:)/g, '')
    .replace(/(\"ele\"\:)/g, '');

  return hasil;
}

function stylePolygonDesa() {
  var style_polygon = {
    color: configColor.desa,
    opacity: 1,
    weight: 1,
    fillColor: configColor.desa,
    fillOpacity: 0.5,
  };
  return style_polygon;
}

function stylePointLogo(url) {
  var style = {
    iconSize: [16, 16],
    iconAnchor: [8, 16],
    popupAnchor: [0, -16],
    iconUrl: url,
    className: 'not-clear',
  };
  return style;
}

function editToolbarPoly() {
  var options = {
    position: 'topright', // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
    drawMarker: false, // adds button to draw markers
    drawCircleMarker: false, // adds button to draw markers
    drawPolyline: false, // adds button to draw a polyline
    drawRectangle: false, // adds button to draw a rectangle
    drawPolygon: false, // adds button to draw a polygon
    drawCircle: false, // adds button to draw a cricle
    cutPolygon: false, // adds button to cut a hole in a polygon
    editMode: false, // adds button to toggle edit mode for all layers
    removalMode: true, // adds a button to remove layers
  };
  return options;
}

function editToolbarLine() {
  var options = {
    position: 'topright', // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
    drawMarker: false, // adds button to draw markers
    drawCircleMarker: false, // adds button to draw markers
    drawPolyline: false, // adds button to draw a polyline
    drawRectangle: false, // adds button to draw a rectangle
    drawPolygon: false, // adds button to draw a polygon
    drawCircle: false, // adds button to draw a cricle
    cutPolygon: false, // adds button to cut a hole in a polygon
    editMode: false, // adds button to toggle edit mode for all layers
    removalMode: true, // adds a button to remove layers
  };
  return options;
}

function styleGpx() {
  var style = {
    color: 'red',
    opacity: 1.0,
    fillOpacity: 1.0,
    weight: 2,
    clickable: true,
  };
  return style;
}

function eximGpxPoly(layerpeta) {
  controlGpxPoly = L.Control.fileLayerLoad({
    addToMap: true,
    formats: ['.gpx', '.kml'],
    fitBounds: true,
    layerOptions: {
      pointToLayer: function (data, latlng) {
        return L.marker(latlng);
      },
    },
  });
  controlGpxPoly.addTo(layerpeta);

  controlGpxPoly.loader.on('data:loaded', function (e) {
    var type = e.layerType;
    var layer = e.layer;
    var coords = [];
    var geojson = turf.flip(layer.toGeoJSON());
    var shape_for_db = JSON.stringify(geojson);

    var polygon = L.geoJson(JSON.parse(shape_for_db), {
      pointToLayer: function (feature, latlng) {
        return L.marker(latlng);
      },
      onEachFeature: function (feature, layer) {
        coords.push(feature.geometry.coordinates);
      },
    }).addTo(layerpeta);

    var jml = coords[0].length;
    for (var x = 0; x < jml; x++) {
      if (coords[0][x].length > 2) {
        coords[0][x].pop();
      }
    }

    document.getElementById('path').value = JSON.stringify(coords)
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      .replace(']]],[[[', '],[')
      .replace(']]],[[[', '],[')
      .replace(']]],[[[', '],[')
      .replace(']]],[[[', '],[')
      .replace(']]],[[[', '],[')
      .replace('[[[[', '[[[')
      .replace(']]]]', ']]]')
      .replace('],null]', ']');
  });
  return controlGpxPoly;
}

function eximGpxPoint(layerpeta) {
  controlGpxPoint = L.Control.fileLayerLoad({
    addToMap: false,
    formats: ['.gpx', '.kml'],
    fitBounds: true,
    layerOptions: {
      pointToLayer: function (data, latlng) {
        return L.marker(latlng);
      },
    },
  });
  controlGpxPoint.addTo(layerpeta);

  controlGpxPoint.loader.on('data:loaded', function (e) {
    var type = e.layerType;
    var layer = e.layer;
    var coords = [];
    var geojson = layer.toGeoJSON();
    var shape_for_db = JSON.stringify(geojson);

    var polygon = L.geoJson(JSON.parse(shape_for_db), {
      pointToLayer: function (feature, latlng) {
        return L.marker(latlng);
      },
      onEachFeature: function (feature, layer) {
        coords.push(feature.geometry.coordinates);
      },
    }).addTo(layerpeta);

    document.getElementById('lat').value = coords[0][1];
    document.getElementById('lng').value = coords[0][0];
  });

  return controlGpxPoint;
}

function eximShp(layerpeta, page) {
  L.Control.Shapefile = L.Control.extend({
    onAdd: function (map) {
      var thisControl = this;

      var controlDiv = L.DomUtil.create('div', 'leaflet-control-command');

      // Create the leaflet control.
      var controlUI = L.DomUtil.create(
        'div',
        'leaflet-control-command-interior',
        controlDiv,
      );

      // Create the form inside of the leaflet control.
      var form = L.DomUtil.create(
        'form',
        'leaflet-control-command-form',
        controlUI,
      );
      form.action = '';
      form.method = 'post';
      form.enctype = 'multipart/form-data';

      // Create the input file element.
      var input = L.DomUtil.create(
        'input',
        'leaflet-control-command-form-input',
        form,
      );
      input.id = 'file';
      input.type = 'file';
      input.name = 'uploadFile';
      input.style.display = 'none';

      L.DomEvent.addListener(form, 'click', function () {
        document.getElementById('file').click();
      }).addListener(input, 'change', function () {
        var input = document.getElementById('file');
        if (!input.files[0]) {
          alert('Pilih file shapefile dalam format .zip');
        } else {
          file = input.files[0];

          fr = new FileReader();
          fr.onload = receiveBinary;
          fr.readAsArrayBuffer(file);
        }

        function receiveBinary() {
          geojson = fr.result;
          var shpfile = new L.Shapefile(geojson).addTo(map);

          shpfile.once('data:loaded', function (e) {
            var type = e.layerType;
            var layer = e.layer;
            var coords = [];
            // var arr_res = [];
            var geojson = turf.flip(shpfile.toGeoJSON());
            // console.log(shpfile.toGeoJSON());
            var shape_for_db = JSON.stringify(geojson);

            var polygon = L.geoJson(JSON.parse(shape_for_db), {
              pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, { style: style });
              },
              onEachFeature: function (feature, layer) {
                coords.push(feature.geometry.coordinates);
              },
            });
            // console.log(JSON.stringify(arr_res));

            // var jml = coords[0].length;
            // for (var x = 0; x < jml; x++) {
            //   if (coords[0][x].length > 2) {
            //     coords[0][x].pop();
            //   }
            // }
            // document.getElementById('more_info').value = JSON.stringify(
            //   arr_res,
            // );

            // document.getElementById('path').value = JSON.stringify(coords)
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']],[[', '],[')
            //   .replace(']]],[[[', '],[')
            //   .replace(']]],[[[', '],[')
            //   .replace(']]],[[[', '],[')
            //   .replace(']]],[[[', '],[')
            //   .replace(']]],[[[', '],[')
            //   .replace('[[[[', '[[[')
            //   .replace(']]]]', ']]]')
            //   .replace('],null]', ']');
            document.getElementById('path').value = normalize_coords(coords);
            layerpeta.fitBounds(shpfile.getBounds());
          });
        }
      });

      controlUI.title = 'Impor Shapefile (.Zip)';
      return controlDiv;
    },
  });

  L.control.shapefile = function (opts) {
    return new L.Control.Shapefile(opts);
  };

  L.control.shapefile({ position: 'topleft' }).addTo(layerpeta);

  return eximShp;
}

function eximShpPersil(layerpeta, page) {
  L.Control.Shapefile = L.Control.extend({
    onAdd: function (map) {
      var thisControl = this;

      var controlDiv = L.DomUtil.create('div', 'leaflet-control-command');

      // Create the leaflet control.
      var controlUI = L.DomUtil.create(
        'div',
        'leaflet-control-command-interior',
        controlDiv,
      );

      // Create the form inside of the leaflet control.
      var form = L.DomUtil.create(
        'form',
        'leaflet-control-command-form',
        controlUI,
      );
      form.action = '';
      form.method = 'post';
      form.enctype = 'multipart/form-data';

      // Create the input file element.
      var input = L.DomUtil.create(
        'input',
        'leaflet-control-command-form-input',
        form,
      );
      input.id = 'file';
      input.type = 'file';
      input.name = 'uploadFile';
      input.style.display = 'none';

      L.DomEvent.addListener(form, 'click', function () {
        document.getElementById('file').click();
      }).addListener(input, 'change', function () {
        var input = document.getElementById('file');
        if (!input.files[0]) {
          alert('Pilih file shapefile dalam format .zip');
        } else {
          file = input.files[0];

          fr = new FileReader();
          fr.onload = receiveBinary;
          fr.readAsArrayBuffer(file);
        }

        function receiveBinary() {
          geojson = fr.result;
          var shpfile = new L.Shapefile(geojson).addTo(map);

          shpfile.once('data:loaded', function (e) {
            var type = e.layerType;
            var layer = e.layer;
            var coords = [];
            var arr_res = [];
            var luas = [];
            var geojson = turf.flip(shpfile.toGeoJSON());
            // console.log(shpfile.toGeoJSON());
            var shape_for_db = JSON.stringify(geojson);

            var polygon = L.geoJson(JSON.parse(shape_for_db), {
              pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, { style: style });
              },
              onEachFeature: function (feature, layer) {
                // coords.push(feature.geometry.coordinates);
                // more_info.push(feature.properties.more_info);
                var gen = {
                  path: normalize_coords(feature.geometry.coordinates),
                  props: feature.properties,
                };
                arr_res.push(gen);
              },
            });
            switch (page) {
              case 'tutupan_lahan':
                document.getElementById('jenis').value =
                  geojson.features[0].properties.id_jenis;
                document.getElementById('pemilik').value =
                  JSON.stringify(arr_res);
                document.getElementById('alamat').value =
                  JSON.stringify(arr_res);
                document.getElementById('luas').value = JSON.stringify(arr_res);
                break;
              case 'leuit_sawah':
                document.getElementById('jenis').value =
                  geojson.features[0].properties.id_jenis;
                document.getElementById('pemilik').value =
                  JSON.stringify(arr_res);
                document.getElementById('kelas').value =
                  JSON.stringify(arr_res);
                //   geojson.features[0].properties.Pemilik;
                document.getElementById('luas').value = JSON.stringify(arr_res);
                break;
              default:
            }

            // var jml = coords[0].length;
            // for (var x = 0; x < jml; x++) {
            //   if (coords[0][x].length > 2) {
            //     coords[0][x].pop();
            //   }
            // }
            // alert(normalize_coords(coords));
            document.getElementById('more_info').value =
              JSON.stringify(arr_res);

            document.getElementById('path').value = normalize_coords(coords);
            layerpeta.fitBounds(shpfile.getBounds());
          });
        }
      });

      controlUI.title = 'Impor Shapefile (.Zip)';
      return controlDiv;
    },
  });

  L.control.shapefile = function (opts) {
    return new L.Control.Shapefile(opts);
  };

  L.control.shapefile({ position: 'topleft' }).addTo(layerpeta);

  return eximShpPersil;
}

function eximShpLokasi(layerpeta) {
  L.Control.Shapefile = L.Control.extend({
    onAdd: function (map) {
      var thisControl = this;

      var controlDiv = L.DomUtil.create('div', 'leaflet-control-command');

      // Create the leaflet control.
      var controlUI = L.DomUtil.create(
        'div',
        'leaflet-control-command-interior',
        controlDiv,
      );

      // Create the form inside of the leaflet control.
      var form = L.DomUtil.create(
        'form',
        'leaflet-control-command-form',
        controlUI,
      );
      form.action = '';
      form.method = 'post';
      form.enctype = 'multipart/form-data';

      // Create the input file element.
      var input = L.DomUtil.create(
        'input',
        'leaflet-control-command-form-input',
        form,
      );
      input.id = 'file';
      input.type = 'file';
      input.name = 'uploadFile';
      input.style.display = 'none';

      L.DomEvent.addListener(form, 'click', function () {
        document.getElementById('file').click();
      }).addListener(input, 'change', function () {
        var input = document.getElementById('file');
        if (!input.files[0]) {
          alert('Pilih file shapefile dalam format .zip');
        } else {
          file = input.files[0];

          fr = new FileReader();
          fr.onload = receiveBinary;
          fr.readAsArrayBuffer(file);
        }

        function receiveBinary() {
          geojson = fr.result;
          var shpfile = new L.Shapefile(geojson).addTo(map);

          shpfile.once('data:loaded', function (e) {
            var type = e.layerType;
            var layer = e.layer;
            var coords = [];
            var arr_res = [];
            var luas = [];
            var geojson = turf.flip(shpfile.toGeoJSON());
            var shape_for_db = JSON.stringify(geojson);

            var polygon = L.geoJson(JSON.parse(shape_for_db), {
              pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, { style: style });
              },
              onEachFeature: function (feature, layer) {
                var popupContent =
                  '<p> <b>' +
                  feature.properties.nama_lokas +
                  '</b></br>' +
                  feature.properties.keterangan +
                  '</p>';

                layer.bindPopup(popupContent);

                var gen = {
                  //   path: feature.geometry.coordinates,
                  props: feature.properties,
                };
                arr_res.push(gen);
              },
              pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, {
                  radius: 6,
                  opacity: 0.5,
                  color: '#000',
                  fillColor: 'red',
                  fillOpacity: 0.8,
                });
              },
            });
            document.getElementById('extract_data').value =
              JSON.stringify(arr_res);

            // document.getElementById('path').value = normalize_coords(coords);
            layerpeta.fitBounds(shpfile.getBounds());
          });
        }
      });

      controlUI.title = 'Impor Shapefile (.Zip)';
      return controlDiv;
    },
  });

  L.control.shapefile = function (opts) {
    return new L.Control.Shapefile(opts);
  };

  L.control.shapefile({ position: 'topleft' }).addTo(layerpeta);

  return eximShpPersil;
}

function shpProv(layerpeta) {
  L.Control.Shapefile = L.Control.extend({
    onAdd: function (map) {
      var thisControl = this;

      var controlDiv = L.DomUtil.create('div', 'leaflet-control-command');

      // Create the leaflet control.
      var controlUI = L.DomUtil.create(
        'div',
        'leaflet-control-command-interior',
        controlDiv,
      );

      // Create the form inside of the leaflet control.
      var form = L.DomUtil.create(
        'form',
        'leaflet-control-command-form',
        controlUI,
      );
      form.action = '';
      form.method = 'post';
      form.enctype = 'multipart/form-data';

      // Create the input file element.
      var input = L.DomUtil.create(
        'input',
        'leaflet-control-command-form-input',
        form,
      );
      input.id = 'file';
      input.type = 'file';
      input.name = 'uploadFile';
      input.style.display = 'none';

      L.DomEvent.addListener(form, 'click', function () {
        document.getElementById('file').click();
      }).addListener(input, 'change', function () {
        var input = document.getElementById('file');
        if (!input.files[0]) {
          alert('Pilih file shapefile dalam format .zip');
        } else {
          file = input.files[0];

          fr = new FileReader();
          fr.onload = receiveBinary;
          fr.readAsArrayBuffer(file);
        }

        function receiveBinary() {
          geojson = fr.result;
          var shpfile = new L.Shapefile(geojson).addTo(map);

          shpfile.once('data:loaded', function (e) {
            var type = e.layerType;
            var layer = e.layer;
            var coords = [];
            var arr_res = [];
            var luas = [];
            var geojson = turf.flip(shpfile.toGeoJSON());
            // console.log(shpfile.toGeoJSON());
            var shape_for_db = JSON.stringify(geojson);

            var polygon = L.geoJson(JSON.parse(shape_for_db), {
              pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, { style: style });
              },
              onEachFeature: function (feature, layer) {
                coords.push(feature.geometry.coordinates);
              },
            });

            var jml = coords[0].length;
            for (var x = 0; x < jml; x++) {
              if (coords[0][x].length > 2) {
                var newCoor = coords[0][x].pop();
                alert(JSON.stringify(newCoor));
              }
            }
            document.getElementById('path').value = JSON.stringify(coords)
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']],[[', '],[')
              .replace(']]],[[[', '],[')
              .replace(']]],[[[', '],[')
              .replace(']]],[[[', '],[')
              .replace(']]],[[[', '],[')
              .replace(']]],[[[', '],[')
              .replace('[[[[', '[[[')
              .replace(']]]]', ']]]')
              .replace('],null]', ']');
            layerpeta.fitBounds(shpfile.getBounds());
          });
        }
      });

      controlUI.title = 'Impor Shapefile (.Zip)';
      return controlDiv;
    },
  });

  L.control.shapefile = function (opts) {
    return new L.Control.Shapefile(opts);
  };

  L.control.shapefile({ position: 'topleft' }).addTo(layerpeta);

  return shpProv;
}

function normalize_coords(coords) {
  return (
    JSON.stringify(coords)
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      //   .replace(']],[[', '],[')
      .replace(']],[[', '],[')
      //   .replace(']]],[[[', '],[')
      //   .replace(']]],[[[', '],[')
      //   .replace(']]],[[[', '],[')
      //   .replace(']]],[[[', '],[')
      .replace(']]],[[[', '],[')
      .replace('[[[[', '[[[')
      .replace(']]]]', ']]]')
      .replace('],null]', ']')
  );
}

function geoLocation(layerpeta) {
  var lc = L.control
    .locate({
      drawCircle: false,
      icon: 'fa fa-map-marker',
      locateOptions: { enableHighAccuracy: true },
      strings: {
        title: 'Lokasi Saya',
        popup: 'Anda berada di sekitar {distance} {unit} dari titik ini',
      },
    })
    .addTo(layerpeta);

  layerpeta.on('locationfound', function (e) {
    layerpeta.setView(e.latlng);
  });

  layerpeta
    .on('startfollowing', function () {
      layerpeta.on('dragstart', lc._stopFollowing, lc);
    })
    .on('stopfollowing', function () {
      layerpeta.off('dragstart', lc._stopFollowing, lc);
    });
  return lc;
}

function hapusPeta(layerpeta) {
  layerpeta.on('pm:globalremovalmodetoggled', function (e) {
    document.getElementById('path').value = '';
  });
  return hapusPeta;
}

function updateZoom(layerpeta) {
  layerpeta.on('zoomend', function (e) {
    document.getElementById('zoom').value = layerpeta.getZoom();
  });
  return updateZoom;
}

function addPetaPoly(layerpeta) {
  layerpeta.on('pm:create', function (e) {
    var type = e.layerType;
    var layer = e.layer;
    var latLngs;

    if (type === 'circle') {
      latLngs = layer.getLatLng();
    } else latLngs = layer.getLatLngs();

    var p = latLngs;
    var polygon = L.polygon(p, {
      color: '#A9AAAA',
      weight: 4,
      opacity: 1,
      showMeasurements: true,
      measurementOptions: { showSegmentLength: false },
    }).addTo(layerpeta);

    polygon.on('pm:edit', function (e) {
      document.getElementById('path').value = getLatLong(
        'Poly',
        e.target,
      ).toString();
      document.getElementById('zoom').value = layerpeta.getZoom();
    });

    layerpeta.fitBounds(polygon.getBounds());

    // set value setelah create polygon
    document.getElementById('path').value = getLatLong(
      'Poly',
      layer,
    ).toString();
    document.getElementById('zoom').value = layerpeta.getZoom();
  });
  return addPetaPoly;
}

function addPetaLine(layerpeta) {
  layerpeta.on('pm:create', function (e) {
    var type = e.layerType;
    var layer = e.layer;
    var latLngs;

    if (type === 'circle') {
      latLngs = layer.getLatLng();
    } else latLngs = layer.getLatLngs();

    var p = latLngs;
    var polygon = L.polyline(p, {
      color: '#A9AAAA',
      weight: 4,
      opacity: 1,
      showMeasurements: true,
      measurementOptions: { showSegmentLength: false },
    }).addTo(layerpeta);

    polygon.on('pm:edit', function (e) {
      document.getElementById('path').value = getLatLong(
        'Line',
        e.target,
      ).toString();
    });

    layerpeta.fitBounds(polygon.getBounds());

    // set value setelah create polygon
    document.getElementById('path').value = getLatLong(
      'Line',
      layer,
    ).toString();
  });
  return addPetaLine;
}

function showCurrentMultiPolygon(wilayah, layerpeta) {
  var daerah_wilayah = wilayah;
  daerah_wilayah[0].push(daerah_wilayah[0][0]);
  var poligon_wilayah = L.polygon(wilayah, {
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
  }).addTo(layerpeta);

  poligon_wilayah.on('pm:edit', function (e) {
    document.getElementById('path').value = getLatLong(
      'Poly',
      e.target,
    ).toString();
    document.getElementById('zoom').value = layerpeta.getZoom();
  });

  var layer = poligon_wilayah;
  var geojson = layer.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  layerpeta.fitBounds(poligon_wilayah.getBounds());

  // set value setelah create polygon
  document.getElementById('path').value = getLatLong(
    'MultiPolygon',
    layer,
  ).toString();
  document.getElementById('zoom').value = layerpeta.getZoom();

  return showCurrentMultiPolygon;
}

function showCurrentPolygon(wilayah, layerpeta) {
  var daerah_wilayah = wilayah;
  daerah_wilayah[0].push(daerah_wilayah[0][0]);
  var poligon_wilayah = L.polygon(wilayah, {
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
  }).addTo(layerpeta);

  poligon_wilayah.on('pm:edit', function (e) {
    document.getElementById('path').value = getLatLong(
      'Poly',
      e.target,
    ).toString();
    document.getElementById('zoom').value = layerpeta.getZoom();
  });

  var layer = poligon_wilayah;
  var geojson = layer.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  layerpeta.fitBounds(poligon_wilayah.getBounds());

  // set value setelah create polygon
  document.getElementById('path').value = getLatLong('Poly', layer).toString();
  document.getElementById('zoom').value = layerpeta.getZoom();

  return showCurrentPolygon;
}

function showCurrentPolygonProv(wilayah, layerpeta) {
  var daerah_wilayah = wilayah;
  //   daerah_wilayah[0].push(daerah_wilayah[0][0][0]);
  var poligon_wilayah = L.polygon(wilayah, {
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
  }).addTo(layerpeta);

  poligon_wilayah.on('pm:edit', function (e) {
    document.getElementById('path').value = getLatLong(
      'Poly',
      e.target,
    ).toString();
    document.getElementById('zoom').value = layerpeta.getZoom();
  });

  var layer = poligon_wilayah;
  var geojson = layer.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  layerpeta.fitBounds(poligon_wilayah.getBounds());

  // set value setelah create polygon
  document.getElementById('path').value = getLatLong('Poly', layer).toString();
  document.getElementById('zoom').value = layerpeta.getZoom();

  return showCurrentPolygonProv;
}

function showCurrentPoint(posisi1, layerpeta) {
  var lokasi_kantor = L.marker(posisi1, { draggable: true }).addTo(layerpeta);

  lokasi_kantor.on('dragend', function (e) {
    $('#lat').val(e.target._latlng.lat);
    $('#lng').val(e.target._latlng.lng);
    $('#map_tipe').val('HYBRID');
    $('#zoom').val(layerpeta.getZoom());
  });

  layerpeta.on('zoomstart zoomend', function (e) {
    $('#zoom').val(layerpeta.getZoom());
  });

  $('#lat').on('input', function (e) {
    if (!$('#validasi1').valid()) {
      $('#simpan_kantor').attr('disabled', true);
      return;
    } else {
      $('#simpan_kantor').attr('disabled', false);
    }
    let lat = $('#lat').val();
    let lng = $('#lng').val();
    let latLng = L.latLng({
      lat: lat,
      lng: lng,
    });

    lokasi_kantor.setLatLng(latLng);
    layerpeta.setView(latLng, zoom);
  });

  $('#lng').on('input', function (e) {
    if (!$('#validasi1').valid()) {
      $('#simpan_kantor').attr('disabled', true);
      return;
    } else {
      $('#simpan_kantor').attr('disabled', false);
    }
    let lat = $('#lat').val();
    let lng = $('#lng').val();
    let latLng = L.latLng({
      lat: lat,
      lng: lng,
    });

    lokasi_kantor.setLatLng(latLng);
    layerpeta.setView(latLng, zoom);
  });

  var geojson = lokasi_kantor.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  var lc = L.control
    .locate({
      drawCircle: false,
      icon: 'fa fa-map-marker',
      strings: {
        title: 'Lokasi Saya',
        locateOptions: { enableHighAccuracy: true },
        popup: 'Anda berada disekitar {distance} {unit} dari titik ini',
      },
    })
    .addTo(layerpeta);

  layerpeta.on('locationfound', function (e) {
    $('#lat').val(e.latlng.lat);
    $('#lng').val(e.latlng.lng);
    lokasi_kantor.setLatLng(e.latlng);
    layerpeta.setView(e.latlng);
  });

  layerpeta
    .on('startfollowing', function () {
      layerpeta.on('dragstart', lc._stopFollowing, lc);
    })
    .on('stopfollowing', function () {
      layerpeta.off('dragstart', lc._stopFollowing, lc);
    });

  return showCurrentPoint;
}

function showCurrentLine(wilayah, layerpeta) {
  var poligon_wilayah = L.polyline(wilayah, {
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
  }).addTo(layerpeta);

  poligon_wilayah.on('pm:edit', function (e) {
    document.getElementById('path').value = getLatLong(
      'Line',
      e.target,
    ).toString();
  });

  var layer = poligon_wilayah;
  var geojson = layer.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  layerpeta.fitBounds(poligon_wilayah.getBounds());

  // set value setelah create polygon
  document.getElementById('path').value = getLatLong('Line', layer).toString();

  return showCurrentLine;
}

function showCurrentArea(wilayah, layerpeta) {
  var daerah_wilayah = wilayah;
  daerah_wilayah[0].push(daerah_wilayah[0][0]);
  var poligon_wilayah = L.polygon(wilayah, {
    showMeasurements: true,
    measurementOptions: { showSegmentLength: false },
  }).addTo(layerpeta);

  poligon_wilayah.on('pm:edit', function (e) {
    document.getElementById('path').value = getLatLong(
      'Poly',
      e.target,
    ).toString();
  });

  var layer = poligon_wilayah;
  var geojson = layer.toGeoJSON();
  var shape_for_db = JSON.stringify(geojson);
  var gpxData = togpx(JSON.parse(shape_for_db));

  $('#exportGPX').on('click', function (event) {
    data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
    $(this).attr({
      href: data,
      target: '_blank',
    });
  });

  layerpeta.fitBounds(poligon_wilayah.getBounds());

  // set value setelah create polygon
  document.getElementById('path').value = getLatLong('Poly', layer).toString();

  return showCurrentArea;
}

function setMarkerCustom(marker, layercustom) {
  if (marker.length != 0) {
    var geojson = L.geoJSON(turf.featureCollection(marker), {
      pmIgnore: true,
      showMeasurements: true,
      measurementOptions: { showSegmentLength: false },
      onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.content);
        layer.bindTooltip(feature.properties.content);
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

    layercustom.addLayer(geojson);
  }

  return setMarkerCustom;
}

function setMarkerCluster(marker, markersList, markers) {
  if (marker.length != 0) {
    var geojson = L.geoJSON(turf.featureCollection(marker), {
      pmIgnore: true,
      showMeasurements: true,
      measurementOptions: { showSegmentLength: false },
      onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.content);
        layer.bindTooltip(feature.properties.content);
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

    markersList.push(geojson);
    markers.addLayer(geojson);
  }

  return setMarkerCluster;
}

function set_marker_area(marker, daftar_path, foto_area) {
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var jml_path;
  var foto;
  var content_area;
  var lokasi_gambar = foto_area;

  for (var x = 0; x < jml; x++) {
    if (daftar[x].path) {
      daftar[x].path = JSON.parse(daftar[x].path);
      jml_path = daftar[x].path[0].length;
      for (var y = 0; y < jml_path; y++) {
        daftar[x].path[0][y].reverse();
      }

      if (daftar[x].foto) {
        foto =
          '<img src="' +
          lokasi_gambar +
          'sedang_' +
          daftar[x].foto +
          '" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>';
      } else foto = '';

      var area_style = {
        stroke: true,
        opacity: 1,
        weight: 2,
        fillColor: daftar[x].color,
        fillOpacity: 0.5,
      };

      content_area =
        '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h4 id="firstHeading" class="firstHeading">' +
        daftar[x].nama +
        '</h4>' +
        '<div id="bodyContent">' +
        foto +
        '<p>' +
        daftar[x].desk +
        '</p>' +
        '</div>' +
        '</div>';

      daftar[x].path[0].push(daftar[x].path[0][0]);
      marker.push(
        turf.polygon(daftar[x].path, {
          content: content_area,
          style: area_style,
        }),
      );
    }
  }
}

function set_marker_garis(marker, daftar_path, foto_garis) {
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var coords;
  var lengthOfCoords;
  var foto;
  var content_garis;
  var lokasi_gambar = foto_garis;

  for (var x = 0; x < jml; x++) {
    if (daftar[x].path) {
      daftar[x].path = JSON.parse(daftar[x].path);
      coords = daftar[x].path;
      lengthOfCoords = coords.length;
      for (i = 0; i < lengthOfCoords; i++) {
        holdLon = coords[i][0];
        coords[i][0] = coords[i][1];
        coords[i][1] = holdLon;
      }

      if (daftar[x].foto) {
        foto =
          '<img src="' +
          lokasi_gambar +
          'sedang_' +
          daftar[x].foto +
          '" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>';
      } else foto = '';

      content_garis =
        '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h4 id="firstHeading" class="firstHeading">' +
        daftar[x].nama +
        '</h4>' +
        '<div id="bodyContent">' +
        foto +
        '<p>' +
        daftar[x].desk +
        '</p>' +
        '</div>' +
        '</div>';

      var garis_style = {
        stroke: true,
        opacity: 1,
        weight: 3,
        color: daftar[x].color,
      };

      marker.push(
        turf.lineString(coords, { content: content_garis, style: garis_style }),
      );
    }
  }
}

function set_marker_lokasi(marker, daftar_path, path_icon, foto_lokasi) {
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var foto;
  var content_lokasi;
  var lokasi_gambar = foto_lokasi;
  var path_foto = path_icon;
  var point_style = {
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -28],
  };

  for (var x = 0; x < jml; x++) {
    if (daftar[x].lat) {
      point_style.iconUrl = path_foto + daftar[x].simbol;

      if (daftar[x].foto) {
        foto =
          '<img src="' +
          lokasi_gambar +
          'sedang_' +
          daftar[x].foto +
          '" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>';
      } else foto = '';

      content_lokasi =
        '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h4 id="firstHeading" class="firstHeading">' +
        daftar[x].nama +
        '</h4>' +
        '<div id="bodyContent">' +
        foto +
        '<p>' +
        daftar[x].desk +
        '</p>' +
        '</div>' +
        '</div>';

      marker.push(
        turf.point([daftar[x].lng, daftar[x].lat], {
          content: content_lokasi,
          style: L.icon(point_style),
        }),
      );
    }
  }
}

//Menampilkan lokasi
function tampilkan_layer_lokasi(peta, daftar_lokasi, path_icon, foto_lokasi) {
  var marker_lokasi = [];
  var markers = new L.MarkerClusterGroup();
  var markersList = [];

  var layer_lokasi = L.featureGroup();

  var layerLokasi = {
    'Wilayah Administrasi': layer_lokasi,
  };

  //OVERLAY LOKASI DAN PROPERTI
  if (daftar_lokasi) {
    set_marker_lokasi(marker_lokasi, daftar_lokasi, path_icon, foto_lokasi);
  }

  setMarkerCluster(marker_lokasi, markersList, markers);

  peta.on('layeradd layerremove', function () {
    var bounds = new L.LatLngBounds();
    peta.eachLayer(function (layer) {
      if (peta.hasLayer(layer_lokasi)) {
        peta.addLayer(markers);
      } else {
        peta.removeLayer(markers);
        peta._layersMaxZoom = 19;
      }
      if (layer instanceof L.FeatureGroup) {
        bounds.extend(layer.getBounds());
      }
    });
  });

  return layerLokasi;
}

//Menampilkan OverLayer Area, Garis, Lokasi
function tampilkan_layer_area_garis_lokasi(
  peta,
  daftar_path,
  daftar_garis,
  daftar_lokasi,
  path_icon,
  foto_area,
  foto_garis,
  foto_lokasi,
) {
  var marker_area = [];
  var marker_garis = [];
  var marker_lokasi = [];
  var markers = new L.MarkerClusterGroup();
  var markersList = [];

  var layer_area = L.featureGroup();
  var layer_garis = L.featureGroup();
  var layer_lokasi = L.featureGroup();

  var layerCustom = {
    'Infrastruktur Desa': {
      'Infrastruktur (Area)': layer_area,
      'Infrastruktur (Garis)': layer_garis,
      'Infrastruktur (Lokasi)': layer_lokasi,
    },
  };

  //OVERLAY AREA
  if (daftar_path) {
    set_marker_area(marker_area, daftar_path, foto_area);
  }

  //OVERLAY GARIS
  if (daftar_garis) {
    set_marker_garis(marker_garis, daftar_garis, foto_garis);
  }

  //OVERLAY LOKASI DAN PROPERTI
  if (daftar_lokasi) {
    set_marker_lokasi(marker_lokasi, daftar_lokasi, path_icon, foto_lokasi);
  }

  setMarkerCustom(marker_area, layer_area);
  setMarkerCustom(marker_garis, layer_garis);
  setMarkerCluster(marker_lokasi, markersList, markers);

  peta.on('layeradd layerremove', function () {
    var bounds = new L.LatLngBounds();
    peta.eachLayer(function (layer) {
      if (peta.hasLayer(layer_lokasi)) {
        peta.addLayer(markers);
      } else {
        peta.removeLayer(markers);
        peta._layersMaxZoom = 19;
      }
      if (layer instanceof L.FeatureGroup) {
        bounds.extend(layer.getBounds());
      }
    });
  });

  return layerCustom;
}

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

  var sliderElement = $('.slider-profil-lembaga');
  $('#modalProfil')
    .on('show.bs.modal', function (e) {
      if ($('.slider-profil-lembaga').length) {
        $(sliderElement).not('.slick-initialized').slick({
          dots: false,
          arrows: true,
          autoplay: true,
          fade: true,
          infinite: true,
          speed: 600,
          autoplaySpeed: 4000,
          slidesToShow: 1,
        });
      }
    })
    .on('hidden.bs.modal', function (e) {
      if ($('.slider-profil-lembaga').length) {
        $(sliderElement).slick('unslick');
      }
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
  return false;
});

const regions = {
  indonesia: {
    id: 1,
    attributes: {
      wilayah: 'name',
      positif: 'jumlahKasus',
      meninggal: 'meninggal',
      sembuh: 'sembuh',
    },
  },
  provinsi: {
    id: 2,
    attributes: {
      wilayah: 'provinsi',
      positif: 'kasusPosi',
      meninggal: 'kasusMeni',
      sembuh: 'kasusSemb',
    },
  },
};

function numberFormat(num) {
  return new Intl.NumberFormat('id-ID').format(num);
}

function parseToNum(data) {
  return parseFloat(data.toString().replace(/,/g, ''));
}

function showCovidData(data, region) {
  const elem =
    region.id === regions.indonesia.id ? '#covid-nasional' : '#covid-provinsi';
  Object.keys(region.attributes).forEach(function (prop) {
    let tempData = data[region.attributes[prop]];
    let finalData =
      prop === 'wilayah'
        ? tempData.toUpperCase()
        : numberFormat(parseToNum(tempData));
    $(elem).find(`[data-name=${prop}]`).html(`${finalData}`);
  });

  $(elem).find('.shimmer').removeClass('shimmer');
}

function showError(elem = '') {
  $(`${elem} .shimmer`).html(
    '<span class="small"><i class="fa fa-exclamation-triangle"></i> Gagal memuat...</span>',
  );
  $(`${elem} .shimmer`).removeClass('shimmer');
}

$(document).ready(function () {
  if ($('#covid-nasional').length) {
    const COVID_API_URL = 'https://indonesia-covid-19.mathdro.id/api/';
    const ENDPOINT_PROVINSI = 'provinsi/';

    try {
      $.ajax({
        async: true,
        cache: true,
        url: COVID_API_URL,
        success: function (response) {
          const data = response;
          data.name = 'Indonesia';
          showCovidData(data, regions.indonesia);
        },
        error: function (error) {
          showError('#covid-nasional');
        },
      });
    } catch (error) {
      showError('#covid-nasional');
    }

    if (KODE_PROVINSI) {
      try {
        $.ajax({
          async: true,
          cache: true,
          url: COVID_API_URL + ENDPOINT_PROVINSI,
          success: function (response) {
            const data = response.data.filter(
              (data) => data.kodeProvi == KODE_PROVINSI,
            );
            data.length
              ? showCovidData(data[0], regions.provinsi)
              : showError('#covid-provinsi');
          },
          error: function (error) {
            showError('#covid-provinsi');
          },
        });
      } catch (error) {
        showError('#covid-provinsi');
      }
    }
  }
});
