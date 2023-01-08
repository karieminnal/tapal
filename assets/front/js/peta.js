
$(document).ready(function()
{
	$('#resetme').click(function(){
		window.location.reload(false);
	});
});

function getBounds() {
    var bounds = new L.LatLngBounds(
        new L.LatLng(-6.823879, 108.462215),
        new L.LatLng(-6.805149, 108.476327));
    // setMap(map);

    return bounds;
}

function setMap(map) {
    var bounds = getBounds();
    var thisMap = L.map('map',{
        zoomControl: false,
    }).fitBounds(bounds);
    L.control.zoom({
        position: 'topright'
    }).addTo(map);

    return thisMap;
}

function set_marker(marker, daftar_path, warna, judul, nama_wil)
{
  var marker_style = {
    stroke: true,
    color: '#FF0000',
    opacity: 1,
    weight: 2,
    fillColor: warna,
    fillOpacity: 0.5
  }
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var jml_path;
  for (var x = 0; x < jml;x++)
  {
    if (daftar[x].path)
    {
      daftar[x].path = JSON.parse(daftar[x].path)
      jml_path = daftar[x].path[0].length;
      for (var y = 0; y < jml_path; y++)
      {
        daftar[x].path[0][y].reverse()
      }
      daftar[x].path[0].push(daftar[x].path[0][0])
      marker.push(turf.polygon(daftar[x].path, {content: judul + ' ' + daftar[x][nama_wil], style: marker_style}));
    }
  }
}

function set_marker_desa(marker_desa, desa, judul, favico_desa)
{
	var daerah_desa = JSON.parse(desa['path']);
  var jml = daerah_desa[0].length;
  daerah_desa[0].push(daerah_desa[0][0]);
  for (var x = 0; x < jml; x++)
  {
    daerah_desa[0][x].reverse();
  }

  var point_style = stylePointLogo(favico_desa);
  marker_desa.push(turf.polygon(daerah_desa, {content: judul, style: stylePolygonDesa(), style: L.icon(point_style)}))
  marker_desa.push(turf.point([desa['lng'], desa['lat']], {content: "Kantor Desa",style: L.icon(point_style)}));
}

function set_marker_desa_content(marker_desa, desa, judul, favico_desa, contents)
{
	var daerah_desa = JSON.parse(desa['path']);
  var jml = daerah_desa[0].length;
  daerah_desa[0].push(daerah_desa[0][0]);
  for (var x = 0; x < jml; x++)
  {
    daerah_desa[0][x].reverse();
  }

	content = $(contents).html();

  var point_style = stylePointLogo(favico_desa);
  marker_desa.push(turf.polygon(daerah_desa, {content: content, style: stylePolygonDesa(), style: L.icon(point_style)}))
  marker_desa.push(turf.point([desa['lng'], desa['lat']], {content: "Kantor Desa",style: L.icon(point_style)}));
}

function set_marker_content(marker, daftar_path, warna, judul, nama_wil, contents)
{
  var marker_style = {
    stroke: true,
    color: '#FF0000',
    opacity: 1,
    weight: 2,
    fillColor: warna,
    fillOpacity: 0.5
  }
  var daftar = JSON.parse(daftar_path);
  var jml = daftar.length;
  var jml_path;
  for (var x = 0; x < jml;x++)
  {
    if (daftar[x].path)
    {
      daftar[x].path = JSON.parse(daftar[x].path)
      jml_path = daftar[x].path[0].length;
      for (var y = 0; y < jml_path; y++)
      {
        daftar[x].path[0][y].reverse()
      }

			content = $(contents + x).html();

      daftar[x].path[0].push(daftar[x].path[0][0])
      marker.push(turf.polygon(daftar[x].path, {content: content, style: marker_style}));
    }
  }
}

function getBaseLayers(peta, access_token)
{
	//Menampilkan BaseLayers Peta
	// var defaultLayer = L.tileLayer.provider('OpenStreetMap.Mapnik').addTo(peta);
	var defaultLayer = L.tileLayer('//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.png').addTo(peta);

	var baseLayers = {
		// 'OpenStreetMap': defaultLayer,
		'Satelite': defaultLayer,
		'OpenStreetMap H.O.T.': L.tileLayer.provider('OpenStreetMap.HOT'),
		'Mapbox Streets' : L.tileLayer('https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}@2x.png?access_token='+access_token, {attribution: '<a href="https://www.mapbox.com/about/maps">© Mapbox</a> <a href="https://openstreetmap.org/copyright">© OpenStreetMap</a> | <a href="https://mapbox.com/map-feedback/">Improve this map</a>'}),
		'Mapbox Outdoors' : L.tileLayer('https://api.mapbox.com/v4/mapbox.outdoors/{z}/{x}/{y}@2x.png?access_token='+access_token, {attribution: '<a href="https://www.mapbox.com/about/maps">© Mapbox</a> <a href="https://openstreetmap.org/copyright">© OpenStreetMap</a> | <a href="https://mapbox.com/map-feedback/">Improve this map</a>'}),
		'Mapbox Streets Satellite' : L.tileLayer('https://api.mapbox.com/v4/mapbox.streets-satellite/{z}/{x}/{y}@2x.png?access_token='+access_token, {attribution: '<a href="https://www.mapbox.com/about/maps">© Mapbox</a> <a href="https://openstreetmap.org/copyright">© OpenStreetMap</a> | <a href="https://mapbox.com/map-feedback/">Improve this map</a>'}),
	};
	return baseLayers;
}

function getImageDrone(map) {
	var options = {
		minZoom: 14,
		maxZoom: 21,
		opacity: 1.0,
		tms: false,
	};
	var layerDesa = L.tileLayer('http://kjskbyugi.co.id/tile-mandirancan/{z}/{x}/{y}.png', options).addTo(map);

	return layerDesa;
}

function getDusun(map) {
	var styleDusun = {
		weight: 1,
		color: "#f8db21",
		opacity: 0.5,
		fillColor: "#B0DE5C",
		fillOpacity: 0
	};

	var geojsonDusun = new L.GeoJSON.AJAX("/geojson/dusun.geojson",{
		style: styleDusun,
		onEachFeature:onEachFeature,
		coordsToLatLng: function (coords) {
			return new L.LatLng(coords[0], coords[1], coords[2]);
		}
	});
	// var addBatasDusun = geojsonDusun.addTo(map);

	addPolyDusun(map, geojsonDusun);

	function onEachFeature(feature, map) {
		// var popupContent = "<p>popup test " +feature.geometry.type + "</p>";
		var popupContent = "";

		map.bindTooltip(feature.properties.namaDusun, {
			permanent: true, 
			direction: 'top',
			offset: [0, 10],
			'className': 'tooltip-dusun'
		});

		if (feature.properties && feature.properties.popupContent) {
			popupContent += feature.properties.popupContent;
		}

		map.on('mouseover', function () {
			this.setStyle({
				fillOpacity: 0.3
			});
			map.bindPopup(popupContent);
		});

		map.on('mouseout', function () {
			this.setStyle({
				fillOpacity: 0
			});
		});
		
		map.on('click', function () {

			//layer.bindPopup(popupContent);
		});
	}

	return geojsonDusun;
}

function addPolyDusun(map, geojsonDusun) {
	var addBatasDusun = geojsonDusun.addTo(map);
	return addBatasDusun;
}

function loadControlLayer2(map, baseTree, optionsTree, addBatasDusun) {

    
    var checkAllLayer = $('.show-all-layer-check');
    var iconMarker = styleMarker('/assets/img/point/default.png');
    var iconPemerintahan = styleMarker('/assets/img/point/justice.png');
    var iconSaranaPemerintahan = styleMarker('/assets/img/point/villa.png');
    var iconSekolah = styleMarker('/assets/img/point/university.png');
    var iconMasjid = styleMarker('/assets/img/point/mosque.png');
    var iconGereja = styleMarker('/assets/img/point/chapel.png');

    //////////////////
    var markerGroupWilayahAdministrasi = L.layerGroup();
    var markerWilayahAdministrasi = [
        [
            108.469143209037, 
            -6.81136375961883, 
            "Kantor Desa",
            "<h5><b>Kantor Desa</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469080541705, 
            -6.81030042485179, 
            "Kepala Desa",
            "<h5><b>Kepala Desa</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469196451839, 
            -6.8134370949976, 
            "Sekertaris Desa",
            "<h5><b>Sekertaris Desa</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469080541705, 
            -6.81030042485179, 
            "Kaur Keuangan",
            "<h5><b>Kaur Keuangan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469196451839, 
            -6.8134370949976, 
            "Kaur Tata Usaha dan Umum",
            "<h5><b>Kaur Tata Usaha dan Umum</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469264143775, 
            -6.81180143669573, 
            "Kaur Perencanaan",
            "<h5><b>Kaur Perencanaan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469991781503, 
            -6.8120820331026, 
            "Kasi Pemerintahan",
            "<h5><b>Kasi Pemerintahan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.470098526572, 
            -6.8116172615137, 
            "Kasi Pelayanan",
            "<h5><b>Kasi Pelayanan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.467064706661, 
            -6.81048357577257, 
            "Kasi Kesejahteraan",
            "<h5><b>Kasi Kesejahteraan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.463323320789, 
            -6.81284815516662, 
            "Kadus Manis",
            "<h5><b>Kadus Manis</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469524823292, 
            -6.81288044172794, 
            "Kadus Pahing",
            "<h5><b>Kadus Pahing</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469873654574, 
            -6.80929169927578, 
            "Kadus PON",
            "<h5><b>Kadus PON</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.467282771172, 
            -6.81127556308663, 
            "Kadus Wage",
            "<h5><b>Kadus Wage</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.4694606788, 
            -6.81247392577241, 
            "Kadus Kliwon",
            "<h5><b>Kadus Kliwon</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerWilayahAdministrasi.length; i++) {
        var thisMarkers = new L.marker([markerWilayahAdministrasi[i][1],markerWilayahAdministrasi[i][0]], {icon: iconPemerintahan})
            .bindPopup(markerWilayahAdministrasi[i][3])
            .bindTooltip(markerWilayahAdministrasi[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupWilayahAdministrasi);
    }
    
    var overlaysAdminsitrasi = [
        {
            label: 'Wilayah Administrasi',
            selectAllCheckbox: 'Un/select all',
            children: [
                {label: 'Dusun', layer: addBatasDusun},
                {label: 'Administratif', layer: markerGroupWilayahAdministrasi},
            ]
        },
    ];
    var markerAdministrasi = L.control.layers.tree(baseTree, overlaysAdminsitrasi, optionsTree);

    //////////////////

    var markerGroupSaranaPemerintahan = L.layerGroup();
    var markerSaranaPemerintahan = [
        [
            108.46853870893, 
            -6.80937198712405, 
            "Kantor Kecamatan Mandirancan",
            "<h5><b>Tentang Kantor Kecamatan Mandirancan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.468695299589, 
            -6.80957705552808, 
            "Pendopo Kec. Mandirancan",
            "<h5><b>Tentang Pendopo Kec. Mandirancan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.468903399039, 
            -6.809462115508, 
            "Gedung Dakwah",
            "<h5><b>Tentang Gedung Dakwah</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.468744425522, 
            -6.80932262812242, 
            "Dinas Pendidikan Kec. Mandirancan",
            "<h5><b>Dinas Pendidikan Kec. Mandirancan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerSaranaPemerintahan.length; i++) {
        var thisMarkers = new L.marker([markerSaranaPemerintahan[i][1],markerSaranaPemerintahan[i][0]], {icon: iconSaranaPemerintahan})
            .bindPopup(markerSaranaPemerintahan[i][3])
            .bindTooltip(markerSaranaPemerintahan[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupSaranaPemerintahan);
    }

    var overlaysSaranaPemerintahan = [
        {
            label: 'Sarana Pemerintahan',
            selectAllCheckbox: 'Un/select all',
            children: [
                {label: 'Sarana Pemerintahan', layer: markerGroupSaranaPemerintahan},
            ]
        },
    ];
    var markerSaranaPemerintahan = L.control.layers.tree(baseTree, overlaysSaranaPemerintahan, optionsTree);
    
    //////////////////

    var markerGroupMasjid = L.layerGroup();
    var markerMasjid = [
        [
            108.468826235206, 
            -6.81121175513542, 
            "Masjid Al-Barokah",
            "<h5><b>Tentang Masjid Al-Barokah</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.468005579522, 
            -6.80874795021464, 
            "Masjid Jami As-salam",
            "<h5><b>Tentang Masjid Jami As-salam</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.471189202373, 
            -6.80795176838128, 
            "Masjid An-Nur",
            "<h5><b>Tentang Masjid An-Nur</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerMasjid.length; i++) {
        var thisMarkers = new L.marker([markerMasjid[i][1],markerMasjid[i][0]], {icon: iconMasjid})
            .bindPopup(markerMasjid[i][3])
            .bindTooltip(markerMasjid[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupMasjid);
    }

    var markerGroupMusholla = L.layerGroup();
    var markerMusholla = [
        [
            108.466770496692, 
            -6.8116131893671, 
            "Musholla Miftahul Jannah",
            "<h5><b>Tentang Musholla Miftahul Jannah</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469641382464, 
            -6.81180681764145, 
            "Musholla Rodhatul Falah",
            "<h5><b>Tentang Musholla Rodhatul Falah</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.469597648392, 
            -6.81263797018079, 
            "Musholla Baitul Rahman",
            "<h5><b>Tentang Musholla Baitul Rahman</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerMusholla.length; i++) {
        var thisMarkers = new L.marker([markerMusholla[i][1],markerMusholla[i][0]], {icon: iconMasjid})
            .bindPopup(markerMusholla[i][3])
            .bindTooltip(markerMusholla[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupMusholla);
    }

    var overlaysIbadah = [
        {
            label: 'Ibadah',
            selectAllCheckbox: 'Un/select all',
            children: [
                {label: 'Masjid', layer: markerGroupMasjid},
                {label: 'Musholla', layer: markerGroupMusholla},
            ]
        },
    ];
    var markerIbadah= L.control.layers.tree(baseTree, overlaysIbadah, optionsTree);
    
    //////////////////

    var markerGroupPendidikanSDN = L.layerGroup();
    var markerPendidikanSDN = [
        [
            108.469190166024, 
            -6.80975758824108, 
            "SDN Mandirancan",
            "<h5><b>Tentang SDN Mandirancan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerPendidikanSDN.length; i++) {
        var thisMarkers = new L.marker([markerPendidikanSDN[i][1],markerPendidikanSDN[i][0]], {icon: iconSekolah})
            .bindPopup(markerPendidikanSDN[i][3])
            .bindTooltip(markerPendidikanSDN[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupPendidikanSDN);
    }

    var markerGroupPendidikanPAUD = L.layerGroup();
    var markerPendidikanPAUD = [
        [
            108.468543992196, 
            -6.81135290240952, 
            "PAUD Tunas Harapan",
            "<h5><b>Tentang PAUD Tunas Harapan</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerPendidikanPAUD.length; i++) {
        var thisMarkers = new L.marker([markerPendidikanPAUD[i][1],markerPendidikanPAUD[i][0]], {icon: iconSekolah})
            .bindPopup(markerPendidikanPAUD[i][3])
            .bindTooltip(markerPendidikanPAUD[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupPendidikanPAUD);
    }

    var markerGroupPendidikanMD = L.layerGroup();
    var markerPendidikanMD = [
        [
            108.466145257439, 
            -6.80959813764825, 
            "Madrasah Diniyah Albarokah",
            "<h5><b>Tentang Madrasah Diniyah Albarokah</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
        [
            108.465492448256, 
            -6.80890738732948, 
            "Madrasah Diniyah Arrasyad",
            "<h5><b>Tentang Madrasah Diniyah Arrasyad</b></h5> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>", 
        ],
    ];
    for (var i = 0; i < markerPendidikanMD.length; i++) {
        var thisMarkers = new L.marker([markerPendidikanMD[i][1],markerPendidikanMD[i][0]], {icon: iconSekolah})
            .bindPopup(markerPendidikanMD[i][3])
            .bindTooltip(markerPendidikanMD[i][2], {
                direction: 'top',
            });
            

        thisMarkers.on('click', function () {
            this.openPopup();
        });
        thisMarkers.on('mouseover', function () {
            // this.openPopup();
        });
        thisMarkers.on('mouseout', function () {
            // this.closePopup();
        });
        thisMarkers.addTo(markerGroupPendidikanMD);
    }

    var overlaysPendidikan = [
        {
            label: '<span class="show-data-pendidikan">Pendidikan<span>',
            selectAllCheckbox: 'Un/select all',
            children: [
                {label: '<div id="onlysel" style="display:none">-Show only selected-</div>'},
                {label: '<span class="show-data-paud">PAUD</span>', layer: markerGroupPendidikanPAUD},
                {label: '<span class="show-data-paud">Madrasah Diniyah</span>', layer: markerGroupPendidikanMD},
                {label: '<span class="show-data-sd">SD</span>', layer: markerGroupPendidikanSDN},
            ]
        },
    ];
    var markerPendidikan = L.control.layers.tree(baseTree, overlaysPendidikan, optionsTree);
    
    //////////////////

    // markerWilayah.addTo(map).collapseTree().expandSelected().collapseTree(true);
    // L.DomEvent.on(L.DomUtil.get('onlysel'), 'click', function() {
    //     markerWilayah.collapseTree(true).expandSelected(true);
    // });

    // var markerWilayah2 = L.control.layers(baseLayers, overlayMaps);
    // markerWilayah2.addTo(map);

    $('[data-trigger="showWilayahAdministrasi"]').click(function(e){
        clearControl();
        clearLayerl();

        if(checkAllLayer.is(':checked')) {
            checkAllLayer.trigger('click');
        }

        map.addLayer(markerGroupWilayahAdministrasi);
        markerAdministrasi.addTo(map);
    });

    $('[data-trigger="showSaranaPemerintahan"]').click(function(e){
        clearControl();
        clearLayerl();

        if(checkAllLayer.is(':checked')) {
            checkAllLayer.trigger('click');
        }

        map.addLayer(markerGroupSaranaPemerintahan);
        markerSaranaPemerintahan.addTo(map);
    });

    $('[data-trigger="showIbadah"]').click(function(e){
        clearControl();
        clearLayerl();

        if(checkAllLayer.is(':checked')) {
            checkAllLayer.trigger('click');
        }

        map.addLayer(markerGroupMasjid);
        map.addLayer(markerGroupMusholla);
        markerIbadah.addTo(map);
    });

    $('[data-trigger="showPendidikan"]').click(function(e){
        clearControl();
        clearLayerl();

        if(checkAllLayer.is(':checked')) {
            checkAllLayer.trigger('click');
        }

        map.addLayer(markerGroupPendidikanSDN);
        map.addLayer(markerGroupPendidikanPAUD);
        map.addLayer(markerGroupPendidikanMD);
        markerPendidikan.addTo(map);
    });

    $('[data-trigger="onProgress"]').click(function(e){
        window.alert('Dalam Pengembangan');
    });

    checkAllLayer.click(function(e){
        if($(this).is(':checked')) {
            showAllLayer();
        } else {
            clearControl();
            clearLayerl();
        }
        
    });
    
    function showAllLayer() {
        map.addLayer(markerGroupWilayahAdministrasi);
        map.addLayer(markerGroupSaranaPemerintahan);
        map.addLayer(markerGroupMasjid);
        map.addLayer(markerGroupMusholla);
        map.addLayer(markerGroupPendidikanSDN);
        map.addLayer(markerGroupPendidikanPAUD);
        map.addLayer(markerGroupPendidikanMD);

        markerAdministrasi.addTo(map);
        markerSaranaPemerintahan.addTo(map);
        markerIbadah.addTo(map);
        markerPendidikan.addTo(map);
    }

    function clearControl() {
        map.removeControl(markerAdministrasi);
        map.removeControl(markerSaranaPemerintahan);
        map.removeControl(markerIbadah);
        map.removeControl(markerPendidikan);
    }

    function clearLayerl() {
        map.removeLayer(markerGroupWilayahAdministrasi);
        map.removeLayer(markerGroupSaranaPemerintahan);
        map.removeLayer(markerGroupMasjid);
        map.removeLayer(markerGroupMusholla);
        map.removeLayer(markerGroupPendidikanSDN);
        map.removeLayer(markerGroupPendidikanPAUD);
        map.removeLayer(markerGroupPendidikanMD);
    }
}

function poligonWil(marker)
{
	var poligon_wil = L.geoJSON(turf.featureCollection(marker), {
    pmIgnore: true,
    onEachFeature: function (feature, layer) {
      layer.bindPopup(feature.properties.content);
      layer.bindTooltip(feature.properties.content);
    },
    style: function(feature)
    {
      if (feature.properties.style)
      {
        return feature.properties.style;
      }
    },
    pointToLayer: function (feature, latlng)
    {
      if (feature.properties.style)
      {
        return L.marker(latlng, {icon: feature.properties.style});
      }
      else
      return L.marker(latlng);
    }
  });

	return poligon_wil;
}

function overlayWil(marker_desa, marker_dusun, marker_rw, marker_rt)
{
  var poligon_wil_desa = poligonWil(marker_desa);
  var poligon_wil_dusun = poligonWil(marker_dusun);
  var poligon_wil_rw = poligonWil(marker_rw);
  var poligon_wil_rt = poligonWil(marker_rt);

  var overlayLayers = {
    'Peta Wilayah Desa': poligon_wil_desa,
    'Peta Wilayah Dusun': poligon_wil_dusun,
    'Peta Wilayah RW': poligon_wil_rw,
    'Peta Wilayah RT': poligon_wil_rt
  };
  return overlayLayers;
}

function getLatLong(x, y)
{
  var hasil;
  if (x == 'Rectangle' || x == 'Line' || x == 'Poly')
  {
    hasil = JSON.stringify(y._latlngs);
  }
  else
  {
    hasil = JSON.stringify(y._latlng);
  }
  hasil = hasil.replace(/\}/g, ']').replace(/(\{)/g, '[').replace(/(\"lat\"\:|\"lng\"\:)/g, '');
  return hasil;
}

function stylePolygonDesa()
{
	var style_polygon = {
		stroke: true,
		color: '#FF0000',
		opacity: 1,
		weight: 2,
		fillColor: '#8888dd',
		fillOpacity: 0.5
	};
	return style_polygon;
}

function stylePointLogo(url)
{
	var style = {
			iconSize: [32, 37],
			iconAnchor: [16, 37],
			popupAnchor: [0, -28],
			iconUrl: url
	};
	return style;
}

function styleMarker(url) {
	var style = L.icon({
		iconUrl: url,
		iconAnchor: [12, 0],
		// shadowUrl: '/assets/img/marker-shadow.png',
		// iconSize:     [38, 95], // size of the icon
		// shadowSize:   [50, 64], // size of the shadow
		// shadowAnchor: [4, 62],  // the same for the shadow
		// popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});
	return style;
}

function setMarkerArray(groupName, jsonFile, icon, kategori) {
    var thisGroup = groupName;

    $.getJSON(jsonFile, function(data){
        switch(kategori) {
            case 'masjid':
                kategorinya = data.masjid;
                break;
            case 'musholla':
                kategorinya = data.musholla;
                break;
            case 'sd':
                kategorinya = data.sd;
                break;
            case 'paud':
                kategorinya = data.paud;
                break;
            case 'md':
                kategorinya = data.md;
                break;
            default:
                ''
        }

        // if(kategori === 'masjid') {
        //     kategorinya = data.masjid;
        // } else {
        //     kategorinya = data.musholla;
        // }
        $.each(kategorinya, function(key, value){
            var thisMarkers = new L.marker([value.lat,value.long], {icon: icon})
                .bindPopup(value.deskripsi)
                .bindTooltip(value.nama, {
                    direction: 'top',
                });
            thisMarkers.on('click', function () {
                this.openPopup();
            });
            thisMarkers.on('mouseover', function () {
                // this.openPopup();
            });
            thisMarkers.on('mouseout', function () {
                // this.closePopup();
            });
            thisMarkers.addTo(thisGroup);
        });
    });

	return thisGroup;
}

function overlayTree(thisMarkerGroup, map) {
	var overlaysAdminsitrasi = [
		{
			label: 'Peta Wilayah Administrasi',
			selectAllCheckbox: 'Un/select all',
			idLayer: 'check-administratif',
			children: [
				// {label: 'Dusun', layer: addBatasDusun, idLayer: 'check-dusun'},
				{label: 'Administratif', layer: thisMarkerGroup, idLayer: 'check-administratif'},
			]
		},
	];

	setTreeControl(overlaysAdminsitrasi, map);
}

function setTreeControl(overlaysAdminsitrasi, map) {
	var optionsTree = {
		namedToggle: true,
		selectorBack: false,
		closedSymbol: '',
		openedSymbol: '',
		// closedSymbol: '&#8862; &#x1f5c0;',
		// openedSymbol: '&#8863; &#x1f5c1;',
		// collapseAll: 'Collapse all',
		// expandAll: 'Expand all',
		collapsed: false,
		// labelIsSelector: 'both',
	}

	var baseTree = [
		{
			label: 'OpenStreeMap',
			layer: map,
		},
	];

	// return baseTree;
	var markerAdministrasi = L.control.layers.tree(baseTree, overlaysAdminsitrasi, optionsTree);

	return markerAdministrasi;
}

function editToolbarPoly()
{
	var options =
	{
		position: 'topright', // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
		drawMarker: false, // adds button to draw markers
		drawCircleMarker: false, // adds button to draw markers
		drawPolyline: false, // adds button to draw a polyline
		drawRectangle: false, // adds button to draw a rectangle
		drawPolygon: true, // adds button to draw a polygon
		drawCircle: false, // adds button to draw a cricle
		cutPolygon: false, // adds button to cut a hole in a polygon
		editMode: true, // adds button to toggle edit mode for all layers
		removalMode: true, // adds a button to remove layers
	};
	return options;
}

function editToolbarLine()
{
	var options =
	{
		position: 'topright', // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
		drawMarker: false, // adds button to draw markers
		drawCircleMarker: false, // adds button to draw markers
		drawPolyline: true, // adds button to draw a polyline
		drawRectangle: false, // adds button to draw a rectangle
		drawPolygon: false, // adds button to draw a polygon
		drawCircle: false, // adds button to draw a cricle
		cutPolygon: false, // adds button to cut a hole in a polygon
		editMode: true, // adds button to toggle edit mode for all layers
		removalMode: true, // adds a button to remove layers
	};
	return options;
}

function styleGpx()
{
	var style = {
		color: 'red',
		opacity: 1.0,
		fillOpacity: 1.0,
		weight: 2,
		clickable: true
	};
	return style;
}

function eximGpx(layerpeta)
{
	var control = L.Control.fileLayerLoad({
		addToMap: false,
		formats: [
			'.gpx',
			'.geojson'
		],
		fitBounds: true,
		layerOptions: {
			style: styleGpx(),
			pointToLayer: function (data, latlng) {
				return L.circleMarker(
					latlng,
					{ style: styleGpx() }
				);
			},

		}
	});
	control.addTo(layerpeta);

	control.loader.on('data:loaded', function (e) {
		var type = e.layerType;
		var layer = e.layer;
		var coords=[];
		var geojson = layer.toGeoJSON();
		var options = {tolerance: 0.0001, highQuality: false};
		var simplified = turf.simplify(geojson, options);
		var shape_for_db = JSON.stringify(geojson);
		var gpxData = togpx(JSON.parse(shape_for_db));

		$("#exportGPX").on('click', function (event) {
			data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);

			$(this).attr({
				'href': data,
				'target': '_blank'
			});

		});

		var polygon =
		//L.geoJson(JSON.parse(shape_for_db), { //jika ingin koordinat tidak dipotong/simplified
		L.geoJson(simplified, {
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, { style: style });
			},
			onEachFeature: function (feature, layer) {
				coords.push(feature.geometry.coordinates);
			},

		}).addTo(layerpeta);

		var jml = coords[0].length;
		coords[0].push(coords[0][0]);
		for (var x = 0; x < jml; x++)
		{
			coords[0][x].reverse();
		}

		polygon.on('pm:edit', function(e)
		{
			document.getElementById('path').value = JSON.stringify(coords);
			document.getElementById('zoom').value = layerpeta.getZoom();
		});

		document.getElementById('path').value = JSON.stringify(coords);
		document.getElementById('zoom').value = layerpeta.getZoom();
		layerpeta.fitBounds(polygon.getBounds());
	});
	return control;
}

function geoLocation(layerpeta)
{
	var lc = L.control.locate({
		icon: 'fa fa-map-marker',
		locateOptions: {enableHighAccuracy: true},
		strings: {
				title: "Lokasi Saya",
				popup: "Anda berada di sekitar {distance} {unit} dari titik ini"
		}

	}).addTo(layerpeta);

	layerpeta.on('locationfound', function(e) {
			layerpeta.setView(e.latlng)
	});

	layerpeta.on('startfollowing', function() {
		layerpeta.on('dragstart', lc._stopFollowing, lc);
	}).on('stopfollowing', function() {
		layerpeta.off('dragstart', lc._stopFollowing, lc);
	});
	return lc;
}

function hapusPeta(layerpeta)
{
	layerpeta.on('pm:globalremovalmodetoggled', function(e)
	{
		document.getElementById('path').value = '';
	});
	return hapusPeta;
}

function updateZoom(layerpeta)
{
	layerpeta.on('zoomend', function(e){
	document.getElementById('zoom').value = layerpeta.getZoom();
	});
	return updateZoom;
}

function addPetaPoly(layerpeta) {
	layerpeta.on('pm:create', function(e) {
		var type = e.layerType;
		var layer = e.layer;
		var latLngs;

		if (type === 'circle') {
			latLngs = layer.getLatLng();
		} else {
			latLngs = layer.getLatLngs();
		}

		var p = latLngs;
		var polygon = L.polygon(p, { color: '#A9AAAA', weight: 4, opacity: 1 }).addTo(layerpeta);

		polygon.on('pm:edit', function(e)
		{
			document.getElementById('path').value = getLatLong('Poly', e.target).toString();
			document.getElementById('zoom').value = peta_wilayah.getZoom();
		});

		layerpeta.fitBounds(polygon.getBounds());

		// set value setelah create polygon
		document.getElementById('path').value = getLatLong('Poly', layer).toString();
		document.getElementById('zoom').value = layerpeta.getZoom();
		console.log(layer.toGeoJSON());
	});
	return addPetaPoly;
}

function drawPolygon(map) {
	//var coords =  [[48,-3],[50,5],[44,11],[48,-3]] ;          
	var coords = document.getElementById("coordPolygon").value;

	var a = JSON.parse(coords);

	var polygon = L.polygon(a, {color: 'red'});
	polygon.addTo(map);

	map.fitBounds(polygon.getBounds());
}

function addPetaLine(layerpeta)
{
	layerpeta.on('pm:create', function(e)
	{
		var type = e.layerType;
		var layer = e.layer;
		var latLngs;

		if (type === 'circle') {
			latLngs = layer.getLatLng();
		}
		else
		latLngs = layer.getLatLngs();

		var p = latLngs;
		var polygon = L.polyline(p, { color: '#A9AAAA', weight: 4, opacity: 1 }).addTo(layerpeta);

		polygon.on('pm:edit', function(e)
		{
			document.getElementById('path').value = getLatLong('Line', e.target).toString();
		});

		layerpeta.fitBounds(polygon.getBounds());

		// set value setelah create polygon
		document.getElementById('path').value = getLatLong('Line', layer).toString();
	});
	return addPetaLine;
}

function showCurrentPolygon(wilayah, layerpeta)
{
	var daerah_wilayah = wilayah;
	daerah_wilayah[0].push(daerah_wilayah[0][0]);
	var poligon_wilayah = L.polygon(wilayah).addTo(layerpeta);
	poligon_wilayah.on('pm:edit', function(e)
	{
		document.getElementById('path').value = getLatLong('Poly', e.target).toString();
		document.getElementById('zoom').value = layerpeta.getZoom();
	})

	var layer = poligon_wilayah;
	var geojson = layer.toGeoJSON();
	var shape_for_db = JSON.stringify(geojson);
	var gpxData = togpx(JSON.parse(shape_for_db));

	$("#exportGPX").on('click', function (event) {
		data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
		$(this).attr({
			'href': data,
			'target': '_blank'
		});
	});

	layerpeta.fitBounds(poligon_wilayah.getBounds());

	// set value setelah create polygon
	document.getElementById('path').value = getLatLong('Poly', layer).toString();
	document.getElementById('zoom').value = layerpeta.getZoom();

	return showCurrentPolygon;
}

function showCurrentPoint(posisi1, layerpeta)
{
	var lokasi_kantor = L.marker(posisi1, {draggable: true}).addTo(layerpeta);

	lokasi_kantor.on('dragend', function(e){
		$('#lat').val(e.target._latlng.lat);
		$('#lng').val(e.target._latlng.lng);
		$('#map_tipe').val("HYBRID");
		$('#zoom').val(layerpeta.getZoom());
	})

	layerpeta.on('zoomstart zoomend', function(e){
		$('#zoom').val(layerpeta.getZoom());
	})

	$('#lat').on("input",function(e) {
		if (!$('#validasi1').valid())
		{
			$("#simpan_kantor").attr('disabled', true);
			return;
		} else
		{
			$("#simpan_kantor").attr('disabled', false);
		}
		let lat = $('#lat').val();
		let lng = $('#lng').val();
		let latLng = L.latLng({
			lat: lat,
			lng: lng
		});

		lokasi_kantor.setLatLng(latLng);
		layerpeta.setView(latLng,zoom);
	})

	$('#lng').on("input",function(e) {
		if (!$('#validasi1').valid())
		{
			$("#simpan_kantor").attr('disabled', true);
			return;
		} else
		{
			$("#simpan_kantor").attr('disabled', false);
		}
		let lat = $('#lat').val();
		let lng = $('#lng').val();
		let latLng = L.latLng({
			lat: lat,
			lng: lng
		});

		lokasi_kantor.setLatLng(latLng);
		layerpeta.setView(latLng, zoom);
	});

	var geojson = lokasi_kantor.toGeoJSON();
	var shape_for_db = JSON.stringify(geojson);
	var gpxData = togpx(JSON.parse(shape_for_db));

	$("#exportGPX").on('click', function (event) {
		data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
		$(this).attr({
			'href': data,
			'target': '_blank'
		});
	});

	var lc = L.control.locate({
		icon: 'fa fa-map-marker',
		strings: {
				title: "Lokasi Saya",
				locateOptions: {enableHighAccuracy: true},
				popup: "Anda berada disekitar {distance} {unit} dari titik ini"
		}

	}).addTo(layerpeta);

	layerpeta.on('locationfound', function(e) {
			$('#lat').val(e.latlng.lat);
			$('#lng').val(e.latlng.lng);
			lokasi_kantor.setLatLng(e.latlng);
			layerpeta.setView(e.latlng)
	});

	layerpeta.on('startfollowing', function() {
		layerpeta.on('dragstart', lc._stopFollowing, lc);
	}).on('stopfollowing', function() {
		layerpeta.off('dragstart', lc._stopFollowing, lc);
	});

	control = L.Control.fileLayerLoad({
		addToMap: false,
		formats: [
			'.gpx',
			'.kml'
		],
		fitBounds: true,
		layerOptions: {
			pointToLayer: function (data, latlng) {
				return L.marker(latlng);
			},

		}
	});
	control.addTo(layerpeta);

	control.loader.on('data:loaded', function (e) {
		layerpeta.removeLayer(lokasi_kantor);
		var type = e.layerType;
		var layer = e.layer;
		var coords=[];
		var geojson = layer.toGeoJSON();
		var shape_for_db = JSON.stringify(geojson);

		var polygon =
		L.geoJson(JSON.parse(shape_for_db), {
			pointToLayer: function (feature, latlng) {
				return L.marker(latlng);
			},
			onEachFeature: function (feature, layer) {
				coords.push(feature.geometry.coordinates);
			}
		}).addTo(layerpeta)

		document.getElementById('lat').value = coords[0][1];
		document.getElementById('lng').value = coords[0][0];
	});
	return showCurrentPoint;
}

function showCurrentLine(wilayah, layerpeta)
{
	var poligon_wilayah = L.polyline(wilayah).addTo(layerpeta);
	poligon_wilayah.on('pm:edit', function(e)
	{
		document.getElementById('path').value = getLatLong('Line', e.target).toString();
	})

	var layer = poligon_wilayah;
	var geojson = layer.toGeoJSON();
	var shape_for_db = JSON.stringify(geojson);
	var gpxData = togpx(JSON.parse(shape_for_db));

	$("#exportGPX").on('click', function (event) {
		data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
		$(this).attr({
			'href': data,
			'target': '_blank'
		});
	});

	layerpeta.fitBounds(poligon_wilayah.getBounds());

	// set value setelah create polygon
	document.getElementById('path').value = getLatLong('Line', layer).toString();

	return showCurrentLine;
}

function showCurrentArea(wilayah, layerpeta)
{
	var daerah_wilayah = wilayah;
	daerah_wilayah[0].push(daerah_wilayah[0][0]);
	var poligon_wilayah = L.polygon(wilayah).addTo(layerpeta);
	poligon_wilayah.on('pm:edit', function(e)
	{
		document.getElementById('path').value = getLatLong('Poly', e.target).toString();
	})

	var layer = poligon_wilayah;
	var geojson = layer.toGeoJSON();
	var shape_for_db = JSON.stringify(geojson);
	var gpxData = togpx(JSON.parse(shape_for_db));

	$("#exportGPX").on('click', function (event) {
		data = 'data:text/xml;charset=utf-8,' + encodeURIComponent(gpxData);
		$(this).attr({
			'href': data,
			'target': '_blank'
		});
	});

	layerpeta.fitBounds(poligon_wilayah.getBounds());

	// set value setelah create polygon
	document.getElementById('path').value = getLatLong('Poly', layer).toString();

	return showCurrentArea;
}
