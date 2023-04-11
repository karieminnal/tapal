function set_marker(e,t,o,n,a){for(var r,i={stroke:!0,color:"#FF0000",opacity:1,weight:2,fillColor:o,fillOpacity:.2},l=JSON.parse(t),s=l.length,d=0;d<s;d++)if(l[d].path){l[d].path=JSON.parse(l[d].path),r=l[d].path[0].length;for(var c=0;c<r;c++)l[d].path[0][c].reverse();l[d].path[0].push(l[d].path[0][0]),e.push(turf.multiPolygon([l[d].path],{content:n+" "+l[d][a],style:i}))}}function set_marker_dusun(e,t,o,n,a){for(var r,i=JSON.parse(t),l=i.length,s=0;s<l;s++)if(i[s].path){var d=i[s].id;i[s].path=JSON.parse(i[s].path),r=i[s].path[0].length;for(var c=0;c<r;c++)i[s].path[0][c].reverse();i[s].path[0].push(i[s].path[0][0]),e.push(turf.polygon(i[s].path,{content:n+" "+i[s][a],idDusun:d,style:{color:"#ffffff",opacity:1,weight:1,fillColor:configColor.delapan,fillOpacity:.8,className:"poly-dusun dusun-"+d}}))}}function overlayWilDusun(e,t){return poligonWilDusun(e,t)}function poligonWilDusun(e,t){L.geoJSON(turf.featureCollection(e),{pmIgnore:!0,showMeasurements:!0,measurementOptions:{showSegmentLength:!1},onEachFeature:function(e,t){"kantor_desa"==e.properties.name?t.bindPopup(e.properties.content,{className:"kantor_desa"}):(t.bindTooltip(e.properties.content,{sticky:!0,direction:"top",permanent:!0,className:"tooltip-tranparan tooltip-dusun dusun-"+e.properties.idDusun}),t.on("click",(function(){layerDusunClick(e.properties.idDusun)})),t.on("mouseover",(function(){this.setStyle({fillColor:configColor.hightlight,fillOpacity:.8})})),t.on("mouseout",(function(){this.setStyle({fillColor:configColor.delapan,fillOpacity:.8})})))},style:function(e){if(e.properties.style)return e.properties.style},pointToLayer:function(e,t){return e.properties.style?L.marker(t,{icon:e.properties.style}):L.marker(t)}}).addTo(t)}function set_marker_desa(e,t,o,n){var a=JSON.parse(t.path),r=a[0].length;a[0].push(a[0][0]);for(var i=0;i<r;i++)a[0][i].reverse();var l=stylePointLogo(n);e.push(turf.polygon(a,{content:o,style:stylePolygonDesa(),style:L.icon(l)})),e.push(turf.point([t.lng,t.lat],{content:"Kantor Desa",style:L.icon(l)}))}function set_marker_desa_content(e,t,o,n,a){var r=JSON.parse(t.path),i=r[0].length;r[0].push(r[0][0]);for(var l=0;l<i;l++)r[0][l].reverse();content=$(a).html();var s=stylePointLogo(n);e.push(turf.point([t.lng,t.lat],{name:"kantor_desa",content:"Kantor Desa",style:L.icon(s)})),e.push(turf.polygon(r,{content:content,style:stylePolygonDesa(),style:L.icon(s)}))}function set_marker_content(e,t,o,n,a,r){for(var i,l={stroke:!0,color:"#f8db21",opacity:1,weight:1,fillColor:o,fillOpacity:.5},s=JSON.parse(t),d=s.length,c=0;c<d;c++)if(s[c].path){s[c].path=JSON.parse(s[c].path),i=s[c].path[0].length;for(var u=0;u<i;u++)s[c].path[0][u].reverse();content=$(r+c).html(),s[c].path[0].push(s[c].path[0][0]),e.push(turf.polygon(s[c].path,{content:content,style:l}))}}function getBaseLayers(e,t){return{Satelite:L.tileLayer("//server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.png",{attribution:'<a href="javascript:;" title="Basemap satelite by Arcgis">Arcgis</a>'}).addTo(e)}}function getImageDrone(e){return L.tileLayer(config.urlTileDrone+"{z}/{x}/{y}.png",{minZoom:14,maxZoom:21,opacity:1,tms:!1})}function poligonWil(e){return L.geoJSON(turf.featureCollection(e),{pmIgnore:!0,showMeasurements:!0,measurementOptions:{showSegmentLength:!1},onEachFeature:function(e,t){"kantor_desa"==e.properties.name?t.bindPopup(e.properties.content,{className:"kantor_desa"}):t.bindPopup(e.properties.content),t.bindTooltip(e.properties.content,{sticky:!0,direction:"top"})},style:function(e){if(e.properties.style)return e.properties.style},pointToLayer:function(e,t){return e.properties.style?L.marker(t,{icon:e.properties.style}):L.marker(t)}})}function overlayWil(e,t,o,n){return{"Peta Wilayah Desa":poligonWil(e),"Peta Wilayah Dusun":poligonWil(t),"Peta Wilayah RW":poligonWil(o),"Peta Wilayah RT":poligonWil(n)}}function getLatLong(e,t){return("Rectangle"==e||"Line"==e||"Poly"==e?JSON.stringify(t._latlngs):JSON.stringify(t._latlng)).replace(/\}/g,"]").replace(/(\{)/g,"[").replace(/(\"lat\"\:|\"lng\"\:)/g,"").replace(/(\"alt\"\:)/g,"").replace(/(\"ele\"\:)/g,"")}function stylePolygonDesa(){return{color:configColor.desa,opacity:1,weight:1,fillColor:configColor.desa,fillOpacity:.5}}function stylePointLogo(e){return{iconSize:[16,16],iconAnchor:[8,16],popupAnchor:[0,-16],iconUrl:e,className:"not-clear"}}function editToolbarPoly(){return{position:"topright",drawMarker:!1,drawCircleMarker:!1,drawPolyline:!1,drawRectangle:!1,drawPolygon:!1,drawCircle:!1,cutPolygon:!1,editMode:!1,removalMode:!0}}function editToolbarLine(){return{position:"topright",drawMarker:!1,drawCircleMarker:!1,drawPolyline:!1,drawRectangle:!1,drawPolygon:!1,drawCircle:!1,cutPolygon:!1,editMode:!1,removalMode:!0}}function styleGpx(){return{color:"red",opacity:1,fillOpacity:1,weight:2,clickable:!0}}function eximGpxPoly(e){return controlGpxPoly=L.Control.fileLayerLoad({addToMap:!0,formats:[".gpx",".kml"],fitBounds:!0,layerOptions:{pointToLayer:function(e,t){return L.marker(t)}}}),controlGpxPoly.addTo(e),controlGpxPoly.loader.on("data:loaded",(function(t){t.layerType;for(var o=t.layer,n=[],a=turf.flip(o.toGeoJSON()),r=JSON.stringify(a),i=(L.geoJson(JSON.parse(r),{pointToLayer:function(e,t){return L.marker(t)},onEachFeature:function(e,t){n.push(e.geometry.coordinates)}}).addTo(e),n[0].length),l=0;l<i;l++)n[0][l].length>2&&n[0][l].pop();document.getElementById("path").value=JSON.stringify(n).replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("[[[[","[[[").replace("]]]]","]]]").replace("],null]","]")})),controlGpxPoly}function eximGpxPoint(e){return controlGpxPoint=L.Control.fileLayerLoad({addToMap:!1,formats:[".gpx",".kml"],fitBounds:!0,layerOptions:{pointToLayer:function(e,t){return L.marker(t)}}}),controlGpxPoint.addTo(e),controlGpxPoint.loader.on("data:loaded",(function(t){t.layerType;var o=t.layer,n=[],a=o.toGeoJSON(),r=JSON.stringify(a);L.geoJson(JSON.parse(r),{pointToLayer:function(e,t){return L.marker(t)},onEachFeature:function(e,t){n.push(e.geometry.coordinates)}}).addTo(e);document.getElementById("lat").value=n[0][1],document.getElementById("lng").value=n[0][0]})),controlGpxPoint}function eximShp(e,t){return L.Control.Shapefile=L.Control.extend({onAdd:function(t){var o=L.DomUtil.create("div","leaflet-control-command"),n=L.DomUtil.create("div","leaflet-control-command-interior",o),a=L.DomUtil.create("form","leaflet-control-command-form",n);a.action="",a.method="post",a.enctype="multipart/form-data";var r=L.DomUtil.create("input","leaflet-control-command-form-input",a);return r.id="file",r.type="file",r.name="uploadFile",r.style.display="none",L.DomEvent.addListener(a,"click",(function(){document.getElementById("file").click()})).addListener(r,"change",(function(){var o=document.getElementById("file");o.files[0]?(file=o.files[0],fr=new FileReader,fr.onload=function(){geojson=fr.result;var o=new L.Shapefile(geojson).addTo(t);o.once("data:loaded",(function(t){t.layerType,t.layer;var n=[],a=turf.flip(o.toGeoJSON()),r=JSON.stringify(a);L.geoJson(JSON.parse(r),{pointToLayer:function(e,t){return L.circleMarker(t,{style:style})},onEachFeature:function(e,t){n.push(e.geometry.coordinates)}});document.getElementById("path").value=normalize_coords(n),e.fitBounds(o.getBounds())}))},fr.readAsArrayBuffer(file)):alert("Pilih file shapefile dalam format .zip")})),n.title="Impor Shapefile (.Zip)",o}}),L.control.shapefile=function(e){return new L.Control.Shapefile(e)},L.control.shapefile({position:"topleft"}).addTo(e),eximShp}function eximShpPersil(e,t){return L.Control.Shapefile=L.Control.extend({onAdd:function(o){var n=L.DomUtil.create("div","leaflet-control-command"),a=L.DomUtil.create("div","leaflet-control-command-interior",n),r=L.DomUtil.create("form","leaflet-control-command-form",a);r.action="",r.method="post",r.enctype="multipart/form-data";var i=L.DomUtil.create("input","leaflet-control-command-form-input",r);return i.id="file",i.type="file",i.name="uploadFile",i.style.display="none",L.DomEvent.addListener(r,"click",(function(){document.getElementById("file").click()})).addListener(i,"change",(function(){var n=document.getElementById("file");n.files[0]?(file=n.files[0],fr=new FileReader,fr.onload=function(){geojson=fr.result;var n=new L.Shapefile(geojson).addTo(o);n.once("data:loaded",(function(o){o.layerType,o.layer;var a=[],r=[],i=turf.flip(n.toGeoJSON()),l=JSON.stringify(i);L.geoJson(JSON.parse(l),{pointToLayer:function(e,t){return L.circleMarker(t,{style:style})},onEachFeature:function(e,t){var o={path:normalize_coords(e.geometry.coordinates),props:e.properties};r.push(o)}});switch(t){case"tutupan_lahan":document.getElementById("jenis").value=i.features[0].properties.id_jenis,document.getElementById("pemilik").value=JSON.stringify(r),document.getElementById("alamat").value=JSON.stringify(r),document.getElementById("luas").value=JSON.stringify(r);break;case"leuit_sawah":document.getElementById("jenis").value=i.features[0].properties.id_jenis,document.getElementById("pemilik").value=JSON.stringify(r),document.getElementById("kelas").value=JSON.stringify(r),document.getElementById("luas").value=JSON.stringify(r)}document.getElementById("more_info").value=JSON.stringify(r),document.getElementById("path").value=normalize_coords(a),e.fitBounds(n.getBounds())}))},fr.readAsArrayBuffer(file)):alert("Pilih file shapefile dalam format .zip")})),a.title="Impor Shapefile (.Zip)",n}}),L.control.shapefile=function(e){return new L.Control.Shapefile(e)},L.control.shapefile({position:"topleft"}).addTo(e),eximShpPersil}function eximShpLokasi(e){return L.Control.Shapefile=L.Control.extend({onAdd:function(t){var o=L.DomUtil.create("div","leaflet-control-command"),n=L.DomUtil.create("div","leaflet-control-command-interior",o),a=L.DomUtil.create("form","leaflet-control-command-form",n);a.action="",a.method="post",a.enctype="multipart/form-data";var r=L.DomUtil.create("input","leaflet-control-command-form-input",a);return r.id="file",r.type="file",r.name="uploadFile",r.style.display="none",L.DomEvent.addListener(a,"click",(function(){document.getElementById("file").click()})).addListener(r,"change",(function(){var o=document.getElementById("file");o.files[0]?(file=o.files[0],fr=new FileReader,fr.onload=function(){geojson=fr.result;var o=new L.Shapefile(geojson).addTo(t);o.once("data:loaded",(function(t){t.layerType,t.layer;var n=[],a=turf.flip(o.toGeoJSON()),r=JSON.stringify(a);L.geoJson(JSON.parse(r),{pointToLayer:function(e,t){return L.circleMarker(t,{style:style})},onEachFeature:function(e,t){var o="<p> <b>"+e.properties.nama_lokas+"</b></br>"+e.properties.keterangan+"</p>";t.bindPopup(o);var a={props:e.properties};n.push(a)},pointToLayer:function(e,t){return L.circleMarker(t,{radius:6,opacity:.5,color:"#000",fillColor:"red",fillOpacity:.8})}});document.getElementById("extract_data").value=JSON.stringify(n),e.fitBounds(o.getBounds())}))},fr.readAsArrayBuffer(file)):alert("Pilih file shapefile dalam format .zip")})),n.title="Impor Shapefile (.Zip)",o}}),L.control.shapefile=function(e){return new L.Control.Shapefile(e)},L.control.shapefile({position:"topleft"}).addTo(e),eximShpPersil}function shpProv(e){return L.Control.Shapefile=L.Control.extend({onAdd:function(t){var o=L.DomUtil.create("div","leaflet-control-command"),n=L.DomUtil.create("div","leaflet-control-command-interior",o),a=L.DomUtil.create("form","leaflet-control-command-form",n);a.action="",a.method="post",a.enctype="multipart/form-data";var r=L.DomUtil.create("input","leaflet-control-command-form-input",a);return r.id="file",r.type="file",r.name="uploadFile",r.style.display="none",L.DomEvent.addListener(a,"click",(function(){document.getElementById("file").click()})).addListener(r,"change",(function(){var o=document.getElementById("file");o.files[0]?(file=o.files[0],fr=new FileReader,fr.onload=function(){geojson=fr.result;var o=new L.Shapefile(geojson).addTo(t);o.once("data:loaded",(function(t){t.layerType,t.layer;for(var n=[],a=turf.flip(o.toGeoJSON()),r=JSON.stringify(a),i=(L.geoJson(JSON.parse(r),{pointToLayer:function(e,t){return L.circleMarker(t,{style:style})},onEachFeature:function(e,t){n.push(e.geometry.coordinates)}}),n[0].length),l=0;l<i;l++)if(n[0][l].length>2){var s=n[0][l].pop();alert(JSON.stringify(s))}document.getElementById("path").value=JSON.stringify(n).replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]],[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("]]],[[[","],[").replace("[[[[","[[[").replace("]]]]","]]]").replace("],null]","]"),e.fitBounds(o.getBounds())}))},fr.readAsArrayBuffer(file)):alert("Pilih file shapefile dalam format .zip")})),n.title="Impor Shapefile (.Zip)",o}}),L.control.shapefile=function(e){return new L.Control.Shapefile(e)},L.control.shapefile({position:"topleft"}).addTo(e),shpProv}function normalize_coords(e){return JSON.stringify(e).replace("]],[[","],[").replace("]]],[[[","],[").replace("[[[[","[[[").replace("]]]]","]]]").replace("],null]","]")}function geoLocation(e){var t=L.control.locate({drawCircle:!1,icon:"fa fa-map-marker",locateOptions:{enableHighAccuracy:!0},strings:{title:"Lokasi Saya",popup:"Anda berada di sekitar {distance} {unit} dari titik ini"}}).addTo(e);return e.on("locationfound",(function(t){e.setView(t.latlng)})),e.on("startfollowing",(function(){e.on("dragstart",t._stopFollowing,t)})).on("stopfollowing",(function(){e.off("dragstart",t._stopFollowing,t)})),t}function hapusPeta(e){return e.on("pm:globalremovalmodetoggled",(function(e){document.getElementById("path").value=""})),hapusPeta}function updateZoom(e){return e.on("zoomend",(function(t){document.getElementById("zoom").value=e.getZoom()})),updateZoom}function addPetaPoly(e){return e.on("pm:create",(function(t){var o=t.layerType,n=t.layer,a="circle"===o?n.getLatLng():n.getLatLngs(),r=L.polygon(a,{color:"#A9AAAA",weight:4,opacity:1,showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(e);r.on("pm:edit",(function(t){document.getElementById("path").value=getLatLong("Poly",t.target).toString(),document.getElementById("zoom").value=e.getZoom()})),e.fitBounds(r.getBounds()),document.getElementById("path").value=getLatLong("Poly",n).toString(),document.getElementById("zoom").value=e.getZoom()})),addPetaPoly}function addPetaLine(e){return e.on("pm:create",(function(t){var o=t.layerType,n=t.layer,a="circle"===o?n.getLatLng():n.getLatLngs(),r=L.polyline(a,{color:"#A9AAAA",weight:4,opacity:1,showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(e);r.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Line",e.target).toString()})),e.fitBounds(r.getBounds()),document.getElementById("path").value=getLatLong("Line",n).toString()})),addPetaLine}function showCurrentMultiPolygon(e,t){var o=e;o[0].push(o[0][0]);var n=L.polygon(e,{showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(t);n.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Poly",e.target).toString(),document.getElementById("zoom").value=t.getZoom()}));var a=n,r=a.toGeoJSON(),i=JSON.stringify(r),l=togpx(JSON.parse(i));return $("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(l),$(this).attr({href:data,target:"_blank"})})),t.fitBounds(n.getBounds()),document.getElementById("path").value=getLatLong("MultiPolygon",a).toString(),document.getElementById("zoom").value=t.getZoom(),showCurrentMultiPolygon}function showCurrentPolygon(e,t){var o=e;o[0].push(o[0][0]);var n=L.polygon(e,{showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(t);n.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Poly",e.target).toString(),document.getElementById("zoom").value=t.getZoom()}));var a=n,r=a.toGeoJSON(),i=JSON.stringify(r),l=togpx(JSON.parse(i));return $("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(l),$(this).attr({href:data,target:"_blank"})})),t.fitBounds(n.getBounds()),document.getElementById("path").value=getLatLong("Poly",a).toString(),document.getElementById("zoom").value=t.getZoom(),showCurrentPolygon}function showCurrentPolygonProv(e,t){var o=L.polygon(e,{showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(t);o.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Poly",e.target).toString(),document.getElementById("zoom").value=t.getZoom()}));var n=o,a=n.toGeoJSON(),r=JSON.stringify(a),i=togpx(JSON.parse(r));return $("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(i),$(this).attr({href:data,target:"_blank"})})),t.fitBounds(o.getBounds()),document.getElementById("path").value=getLatLong("Poly",n).toString(),document.getElementById("zoom").value=t.getZoom(),showCurrentPolygonProv}function showCurrentPoint(e,t){var o=L.marker(e,{draggable:!0}).addTo(t);o.on("dragend",(function(e){$("#lat").val(e.target._latlng.lat),$("#lng").val(e.target._latlng.lng),$("#map_tipe").val("HYBRID"),$("#zoom").val(t.getZoom())})),t.on("zoomstart zoomend",(function(e){$("#zoom").val(t.getZoom())})),$("#lat").on("input",(function(e){if(!$("#validasi1").valid())return void $("#simpan_kantor").attr("disabled",!0);$("#simpan_kantor").attr("disabled",!1);let n=$("#lat").val(),a=$("#lng").val(),r=L.latLng({lat:n,lng:a});o.setLatLng(r),t.setView(r,zoom)})),$("#lng").on("input",(function(e){if(!$("#validasi1").valid())return void $("#simpan_kantor").attr("disabled",!0);$("#simpan_kantor").attr("disabled",!1);let n=$("#lat").val(),a=$("#lng").val(),r=L.latLng({lat:n,lng:a});o.setLatLng(r),t.setView(r,zoom)}));var n=o.toGeoJSON(),a=JSON.stringify(n),r=togpx(JSON.parse(a));$("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(r),$(this).attr({href:data,target:"_blank"})}));var i=L.control.locate({drawCircle:!1,icon:"fa fa-map-marker",strings:{title:"Lokasi Saya",locateOptions:{enableHighAccuracy:!0},popup:"Anda berada disekitar {distance} {unit} dari titik ini"}}).addTo(t);return t.on("locationfound",(function(e){$("#lat").val(e.latlng.lat),$("#lng").val(e.latlng.lng),o.setLatLng(e.latlng),t.setView(e.latlng)})),t.on("startfollowing",(function(){t.on("dragstart",i._stopFollowing,i)})).on("stopfollowing",(function(){t.off("dragstart",i._stopFollowing,i)})),showCurrentPoint}function showCurrentLine(e,t){var o=L.polyline(e,{showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(t);o.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Line",e.target).toString()}));var n=o,a=n.toGeoJSON(),r=JSON.stringify(a),i=togpx(JSON.parse(r));return $("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(i),$(this).attr({href:data,target:"_blank"})})),t.fitBounds(o.getBounds()),document.getElementById("path").value=getLatLong("Line",n).toString(),showCurrentLine}function showCurrentArea(e,t){var o=e;o[0].push(o[0][0]);var n=L.polygon(e,{showMeasurements:!0,measurementOptions:{showSegmentLength:!1}}).addTo(t);n.on("pm:edit",(function(e){document.getElementById("path").value=getLatLong("Poly",e.target).toString()}));var a=n,r=a.toGeoJSON(),i=JSON.stringify(r),l=togpx(JSON.parse(i));return $("#exportGPX").on("click",(function(e){data="data:text/xml;charset=utf-8,"+encodeURIComponent(l),$(this).attr({href:data,target:"_blank"})})),t.fitBounds(n.getBounds()),document.getElementById("path").value=getLatLong("Poly",a).toString(),showCurrentArea}function setMarkerCustom(e,t){if(0!=e.length){var o=L.geoJSON(turf.featureCollection(e),{pmIgnore:!0,showMeasurements:!0,measurementOptions:{showSegmentLength:!1},onEachFeature:function(e,t){t.bindPopup(e.properties.content),t.bindTooltip(e.properties.content)},style:function(e){if(e.properties.style)return e.properties.style},pointToLayer:function(e,t){return e.properties.style?L.marker(t,{icon:e.properties.style}):L.marker(t)}});t.addLayer(o)}return setMarkerCustom}function setMarkerCluster(e,t,o){if(0!=e.length){var n=L.geoJSON(turf.featureCollection(e),{pmIgnore:!0,showMeasurements:!0,measurementOptions:{showSegmentLength:!1},onEachFeature:function(e,t){t.bindPopup(e.properties.content),t.bindTooltip(e.properties.content)},style:function(e){if(e.properties.style)return e.properties.style},pointToLayer:function(e,t){return e.properties.style?L.marker(t,{icon:e.properties.style}):L.marker(t)}});t.push(n),o.addLayer(n)}return setMarkerCluster}function set_marker_area(e,t,o){for(var n,a,r,i=JSON.parse(t),l=i.length,s=o,d=0;d<l;d++)if(i[d].path){i[d].path=JSON.parse(i[d].path),n=i[d].path[0].length;for(var c=0;c<n;c++)i[d].path[0][c].reverse();a=i[d].foto?'<img src="'+s+"sedang_"+i[d].foto+'" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>':"";var u={stroke:!0,opacity:1,weight:2,fillColor:i[d].color,fillOpacity:.5};r='<div id="content"><div id="siteNotice"></div><h4 id="firstHeading" class="firstHeading">'+i[d].nama+'</h4><div id="bodyContent">'+a+"<p>"+i[d].desk+"</p></div></div>",i[d].path[0].push(i[d].path[0][0]),e.push(turf.polygon(i[d].path,{content:r,style:u}))}}function set_marker_garis(e,t,o){for(var n,a,r,l,s=JSON.parse(t),d=s.length,c=o,u=0;u<d;u++)if(s[u].path){for(s[u].path=JSON.parse(s[u].path),a=(n=s[u].path).length,i=0;i<a;i++)holdLon=n[i][0],n[i][0]=n[i][1],n[i][1]=holdLon;r=s[u].foto?'<img src="'+c+"sedang_"+s[u].foto+'" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>':"",l='<div id="content"><div id="siteNotice"></div><h4 id="firstHeading" class="firstHeading">'+s[u].nama+'</h4><div id="bodyContent">'+r+"<p>"+s[u].desk+"</p></div></div>";var p={stroke:!0,opacity:1,weight:3,color:s[u].color};e.push(turf.lineString(n,{content:l,style:p}))}}function set_marker_lokasi(e,t,o,n){for(var a,r,i=JSON.parse(t),l=i.length,s=n,d=o,c={iconSize:[32,32],iconAnchor:[16,32],popupAnchor:[0,-28]},u=0;u<l;u++)i[u].lat&&(c.iconUrl=d+i[u].simbol,a=i[u].foto?'<img src="'+s+"sedang_"+i[u].foto+'" style=" width:200px;height:140px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;border:2px solid #555555;"/>':"",r='<div id="content"><div id="siteNotice"></div><h4 id="firstHeading" class="firstHeading">'+i[u].nama+'</h4><div id="bodyContent">'+a+"<p>"+i[u].desk+"</p></div></div>",e.push(turf.point([i[u].lng,i[u].lat],{content:r,style:L.icon(c)})))}function tampilkan_layer_lokasi(e,t,o,n){var a=[],r=new L.MarkerClusterGroup,i=L.featureGroup(),l={"Wilayah Administrasi":i};return t&&set_marker_lokasi(a,t,o,n),setMarkerCluster(a,[],r),e.on("layeradd layerremove",(function(){var t=new L.LatLngBounds;e.eachLayer((function(o){e.hasLayer(i)?e.addLayer(r):(e.removeLayer(r),e._layersMaxZoom=19),o instanceof L.FeatureGroup&&t.extend(o.getBounds())}))})),l}function tampilkan_layer_area_garis_lokasi(e,t,o,n,a,r,i,l){var s=[],d=[],c=[],u=new L.MarkerClusterGroup,p=L.featureGroup(),f=L.featureGroup(),m=L.featureGroup(),g={"Infrastruktur Desa":{"Infrastruktur (Area)":p,"Infrastruktur (Garis)":f,"Infrastruktur (Lokasi)":m}};return t&&set_marker_area(s,t,r),o&&set_marker_garis(d,o,i),n&&set_marker_lokasi(c,n,a,l),setMarkerCustom(s,p),setMarkerCustom(d,f),setMarkerCluster(c,[],u),e.on("layeradd layerremove",(function(){var t=new L.LatLngBounds;e.eachLayer((function(o){e.hasLayer(m)?e.addLayer(u):(e.removeLayer(u),e._layersMaxZoom=19),o instanceof L.FeatureGroup&&t.extend(o.getBounds())}))})),g}$(document).ready((function(){$("#resetme").click((function(){window.location.reload(!1)}));var e=[","],t=["."];$('input[name="lat"], input[name="lng"]').bind("propertychange change click keyup keypress input paste blur",(function(){for(var o=$(this).val(),n=0;n<e.length;n++)o=o.replace(e[n],t[n]);$(this).val(o)}))})),$(document).ready((function(){$("#modalKecil").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),$("#modalSedang").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),$("#modalBesar").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),$("#modalLeuit").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),$("#modalLeuit360").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),$("#modalFoto").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("img"),n=t.data("title");$(this).find(".modal-title").text(n),$(this).find(".fetched-data").html('<img src="'+o+'" alt="'+n+'" style="width:100%;">')})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")}));var e=$(".slider-profil-lembaga");return $("#modalProfil").on("show.bs.modal",(function(t){$(".slider-profil-lembaga").length&&$(e).not(".slick-initialized").slick({dots:!1,arrows:!0,autoplay:!0,fade:!0,infinite:!0,speed:600,autoplaySpeed:4e3,slidesToShow:1})})).on("hidden.bs.modal",(function(t){$(".slider-profil-lembaga").length&&$(e).slick("unslick")})),$("#modalAparatur").on("show.bs.modal",(function(e){var t=$(e.relatedTarget),o=t.data("title");$(this).find(".modal-title").text(o),$(this).find(".fetched-data").load(t.attr("href"))})).on("hidden.bs.modal",(function(e){$(this).find(".fetched-data").html("")})),!1}));const regions={indonesia:{id:1,attributes:{wilayah:"name",positif:"jumlahKasus",meninggal:"meninggal",sembuh:"sembuh"}},provinsi:{id:2,attributes:{wilayah:"provinsi",positif:"kasusPosi",meninggal:"kasusMeni",sembuh:"kasusSemb"}}};function numberFormat(e){return new Intl.NumberFormat("id-ID").format(e)}function parseToNum(e){return parseFloat(e.toString().replace(/,/g,""))}function showCovidData(e,t){const o=t.id===regions.indonesia.id?"#covid-nasional":"#covid-provinsi";Object.keys(t.attributes).forEach((function(n){let a=e[t.attributes[n]],r="wilayah"===n?a.toUpperCase():numberFormat(parseToNum(a));$(o).find(`[data-name=${n}]`).html(`${r}`)})),$(o).find(".shimmer").removeClass("shimmer")}function showError(e=""){$(`${e} .shimmer`).html('<span class="small"><i class="fa fa-exclamation-triangle"></i> Gagal memuat...</span>'),$(`${e} .shimmer`).removeClass("shimmer")}$(document).ready((function(){if($("#covid-nasional").length){const e="https://indonesia-covid-19.mathdro.id/api/",t="provinsi/";try{$.ajax({async:!0,cache:!0,url:e,success:function(e){const t=e;t.name="Indonesia",showCovidData(t,regions.indonesia)},error:function(e){showError("#covid-nasional")}})}catch(e){showError("#covid-nasional")}if(KODE_PROVINSI)try{$.ajax({async:!0,cache:!0,url:e+t,success:function(e){const t=e.data.filter((e=>e.kodeProvi==KODE_PROVINSI));t.length?showCovidData(t[0],regions.provinsi):showError("#covid-provinsi")},error:function(e){showError("#covid-provinsi")}})}catch(e){showError("#covid-provinsi")}}}));