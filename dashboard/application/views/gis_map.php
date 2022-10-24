<link rel="stylesheet" href="<?php echo base_url() ?>assets/map/css/leaflet.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/map/css/qgis2web.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/map/css/fontawesome-all.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/map/css/leaflet-measure.css">
<style>
    html, body, #map {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
    }

    #map {
        position: fixed !important;
    }
</style>

<div class="app-content  ">

    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">

        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Map</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php /*base_url() */ ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Map
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="column-selectors">
                <div id="map">
                    <div id="popup" class="ol-popup">
                        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                        <div id="popup-content"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/map/js/qgis2web_expressions.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/leaflet.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/leaflet.rotatedMarker.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/leaflet.pattern.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/leaflet-hash.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/Autolinker.min.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/rbush.min.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/labelgun.min.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/labels.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/leaflet-measure.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/proj4.js"></script>
<script src="<?php echo base_url() ?>assets/map/js/proj4leaflet.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictBoundary_0.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/TehsilBoundary_1.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictSanghar_2.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictRahimYarKhan_3.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictQamberShahdadkot_4.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictNasirabad_5.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictMuzaffargarh_6.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictLasbela_7.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictJafferabad_8.js"></script>
<script src="<?php echo base_url() ?>assets/map/data/DistrictBadin_9.js"></script>

<script src="<?php echo base_url() ?>assets/map/resources/ol.js"></script>
<script src="<?php echo base_url() ?>assets/map/resources/ol-layerswitcher.js"></script>
<script src="<?php echo base_url() ?>assets/map/layers/layers.js" type="text/javascript"></script>
<script>
    var highlightLayer;

    function highlightFeature(e) {
        highlightLayer = e.target;

        if (e.target.feature.geometry.type === 'LineString') {
            highlightLayer.setStyle({
                color: '#ffff00',
            });
        } else {
            highlightLayer.setStyle({
                fillColor: '#ffff00',
                fillOpacity: 1
            });
        }
    }

    var crs = new L.Proj.CRS('EPSG:32642', '+proj=utm +zone=42 +datum=WGS84 +units=m +no_defs', {
        resolutions: [2800, 1400, 700, 350, 175, 84, 42, 21, 11.2, 5.6, 2.8, 1.4, 0.7, 0.35, 0.14, 0.07],
    });
    var map = L.map('map', {
        crs: crs,
        continuousWorld: false,
        worldCopyJump: false,
        zoomControl: true, maxZoom: 28, minZoom: 1
    }).fitBounds([[24.011334240753765, 63.66427361785593], [30.95000425615681, 73.07929781285154]]);


    var hash = new L.Hash(map);
    map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
    var autolinker = new Autolinker({truncate: {length: 30, location: 'smart'}});
    var measureControl = new L.Control.Measure({
        position: 'topleft',
        primaryLengthUnit: 'feet',
        secondaryLengthUnit: 'miles',
        primaryAreaUnit: 'sqfeet',
        secondaryAreaUnit: 'sqmiles'
    });
    measureControl.addTo(map);
    document.getElementsByClassName('leaflet-control-measure-toggle')[0]
        .innerHTML = '';
    document.getElementsByClassName('leaflet-control-measure-toggle')[0]
        .className += ' fas fa-ruler';
    var bounds_group = new L.featureGroup([]);

    function setBounds() {
    }

    function pop_DistrictBoundary_0(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['UeN_ML'] !== null ? autolinker.link(feature.properties['UeN_ML'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictBoundary_0_0() {
        return {
            pane: 'pane_DistrictBoundary_0',
            opacity: 1,
            color: 'rgba(228,26,28,1.0)',
            dashArray: '',
            lineCap: 'square',
            lineJoin: 'bevel',
            weight: 4.0,
            fillOpacity: 0,
            interactive: false,
        }
    }

    map.createPane('pane_DistrictBoundary_0');
    map.getPane('pane_DistrictBoundary_0').style.zIndex = 400;
    map.getPane('pane_DistrictBoundary_0').style['mix-blend-mode'] = 'normal';
    var layer_DistrictBoundary_0 = new L.geoJson(json_DistrictBoundary_0, {
        attribution: '',
        interactive: false,
        dataVar: 'json_DistrictBoundary_0',
        layerName: 'layer_DistrictBoundary_0',
        pane: 'pane_DistrictBoundary_0',
        onEachFeature: pop_DistrictBoundary_0,
        style: style_DistrictBoundary_0_0,
    });
    bounds_group.addLayer(layer_DistrictBoundary_0);
    map.addLayer(layer_DistrictBoundary_0);

    function pop_TehsilBoundary_1(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['UEN_TEH_N'] !== null ? autolinker.link(feature.properties['UEN_TEH_N'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['UeN_ML'] !== null ? autolinker.link(feature.properties['UeN_ML'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['UeN_Teh_La'] !== null ? autolinker.link(feature.properties['UeN_Teh_La'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_TehsilBoundary_1_0() {
        return {
            pane: 'pane_TehsilBoundary_1',
            opacity: 1,
            color: 'rgba(227,26,28,1.0)',
            dashArray: '',
            lineCap: 'square',
            lineJoin: 'bevel',
            weight: 2.0,
            fillOpacity: 0,
            interactive: false,
        }
    }

    map.createPane('pane_TehsilBoundary_1');
    map.getPane('pane_TehsilBoundary_1').style.zIndex = 401;
    map.getPane('pane_TehsilBoundary_1').style['mix-blend-mode'] = 'normal';
    var layer_TehsilBoundary_1 = new L.geoJson(json_TehsilBoundary_1, {
        attribution: '',
        interactive: false,
        dataVar: 'json_TehsilBoundary_1',
        layerName: 'layer_TehsilBoundary_1',
        pane: 'pane_TehsilBoundary_1',
        onEachFeature: pop_TehsilBoundary_1,
        style: style_TehsilBoundary_1_0,
    });
    bounds_group.addLayer(layer_TehsilBoundary_1);
    map.addLayer(layer_TehsilBoundary_1);

    function pop_DistrictSanghar_2(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictSanghar_2_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Sanghar':
                return {
                    pane: 'pane_DistrictSanghar_2',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(105,203,187,1.0)',
                    interactive: true,
                }
                break;
            case 'Shahdadpur':
                return {
                    pane: 'pane_DistrictSanghar_2',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(214,66,182,1.0)',
                    interactive: true,
                }
                break;
            case 'Sinjhoro':
                return {
                    pane: 'pane_DistrictSanghar_2',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(28,21,239,1.0)',
                    interactive: true,
                }
                break;
            case 'Tando Adam':
                return {
                    pane: 'pane_DistrictSanghar_2',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(128,218,76,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictSanghar_2');
    map.getPane('pane_DistrictSanghar_2').style.zIndex = 402;
    map.getPane('pane_DistrictSanghar_2').style['mix-blend-mode'] = 'normal';
    var layer_DistrictSanghar_2 = new L.geoJson(json_DistrictSanghar_2, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictSanghar_2',
        layerName: 'layer_DistrictSanghar_2',
        pane: 'pane_DistrictSanghar_2',
        onEachFeature: pop_DistrictSanghar_2,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictSanghar_2_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictSanghar_2);
    map.addLayer(layer_DistrictSanghar_2);

    function pop_DistrictRahimYarKhan_3(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictRahimYarKhan_3_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Khanpur':
                return {
                    pane: 'pane_DistrictRahimYarKhan_3',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(136,164,238,1.0)',
                    interactive: true,
                }
                break;
            case 'Liaqatpur':
                return {
                    pane: 'pane_DistrictRahimYarKhan_3',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(182,230,92,1.0)',
                    interactive: true,
                }
                break;
            case 'Rahim Yar Khan':
                return {
                    pane: 'pane_DistrictRahimYarKhan_3',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(239,115,93,1.0)',
                    interactive: true,
                }
                break;
            case 'Sadiqabad':
                return {
                    pane: 'pane_DistrictRahimYarKhan_3',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(63,239,157,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictRahimYarKhan_3');
    map.getPane('pane_DistrictRahimYarKhan_3').style.zIndex = 403;
    map.getPane('pane_DistrictRahimYarKhan_3').style['mix-blend-mode'] = 'normal';
    var layer_DistrictRahimYarKhan_3 = new L.geoJson(json_DistrictRahimYarKhan_3, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictRahimYarKhan_3',
        layerName: 'layer_DistrictRahimYarKhan_3',
        pane: 'pane_DistrictRahimYarKhan_3',
        onEachFeature: pop_DistrictRahimYarKhan_3,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictRahimYarKhan_3_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictRahimYarKhan_3);
    map.addLayer(layer_DistrictRahimYarKhan_3);

    function pop_DistrictQamberShahdadkot_4(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictQamberShahdadkot_4_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Kamber':
                return {
                    pane: 'pane_DistrictQamberShahdadkot_4',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(122,31,233,1.0)',
                    interactive: true,
                }
                break;
            case 'Miro Khan':
                return {
                    pane: 'pane_DistrictQamberShahdadkot_4',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(234,106,151,1.0)',
                    interactive: true,
                }
                break;
            case 'Nasirabad':
                return {
                    pane: 'pane_DistrictQamberShahdadkot_4',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(215,203,126,1.0)',
                    interactive: true,
                }
                break;
            case 'Shahdadkot':
                return {
                    pane: 'pane_DistrictQamberShahdadkot_4',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(75,190,228,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictQamberShahdadkot_4');
    map.getPane('pane_DistrictQamberShahdadkot_4').style.zIndex = 404;
    map.getPane('pane_DistrictQamberShahdadkot_4').style['mix-blend-mode'] = 'normal';
    var layer_DistrictQamberShahdadkot_4 = new L.geoJson(json_DistrictQamberShahdadkot_4, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictQamberShahdadkot_4',
        layerName: 'layer_DistrictQamberShahdadkot_4',
        pane: 'pane_DistrictQamberShahdadkot_4',
        onEachFeature: pop_DistrictQamberShahdadkot_4,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictQamberShahdadkot_4_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictQamberShahdadkot_4);
    map.addLayer(layer_DistrictQamberShahdadkot_4);

    function pop_DistrictNasirabad_5(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictNasirabad_5_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Dera Murad Jamali':
                return {
                    pane: 'pane_DistrictNasirabad_5',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(157,134,230,1.0)',
                    interactive: true,
                }
                break;
            case 'Tamboo':
                return {
                    pane: 'pane_DistrictNasirabad_5',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(80,209,108,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictNasirabad_5');
    map.getPane('pane_DistrictNasirabad_5').style.zIndex = 405;
    map.getPane('pane_DistrictNasirabad_5').style['mix-blend-mode'] = 'normal';
    var layer_DistrictNasirabad_5 = new L.geoJson(json_DistrictNasirabad_5, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictNasirabad_5',
        layerName: 'layer_DistrictNasirabad_5',
        pane: 'pane_DistrictNasirabad_5',
        onEachFeature: pop_DistrictNasirabad_5,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictNasirabad_5_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictNasirabad_5);
    map.addLayer(layer_DistrictNasirabad_5);

    function pop_DistrictMuzaffargarh_6(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictMuzaffargarh_6_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Alipur':
                return {
                    pane: 'pane_DistrictMuzaffargarh_6',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(75,208,99,1.0)',
                    interactive: true,
                }
                break;
            case 'Jatoi':
                return {
                    pane: 'pane_DistrictMuzaffargarh_6',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(157,62,224,1.0)',
                    interactive: true,
                }
                break;
            case 'Kot Adu':
                return {
                    pane: 'pane_DistrictMuzaffargarh_6',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(76,168,224,1.0)',
                    interactive: true,
                }
                break;
            case 'Muzaffargarh':
                return {
                    pane: 'pane_DistrictMuzaffargarh_6',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(207,57,87,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictMuzaffargarh_6');
    map.getPane('pane_DistrictMuzaffargarh_6').style.zIndex = 406;
    map.getPane('pane_DistrictMuzaffargarh_6').style['mix-blend-mode'] = 'normal';
    var layer_DistrictMuzaffargarh_6 = new L.geoJson(json_DistrictMuzaffargarh_6, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictMuzaffargarh_6',
        layerName: 'layer_DistrictMuzaffargarh_6',
        pane: 'pane_DistrictMuzaffargarh_6',
        onEachFeature: pop_DistrictMuzaffargarh_6,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictMuzaffargarh_6_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictMuzaffargarh_6);
    map.addLayer(layer_DistrictMuzaffargarh_6);

    function pop_DistrictLasbela_7(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictLasbela_7_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Bela':
                return {
                    pane: 'pane_DistrictLasbela_7',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(174,239,134,1.0)',
                    interactive: true,
                }
                break;
            case 'Hub':
                return {
                    pane: 'pane_DistrictLasbela_7',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(73,67,239,1.0)',
                    interactive: true,
                }
                break;
            case 'Sonmiani':
                return {
                    pane: 'pane_DistrictLasbela_7',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(23,152,181,1.0)',
                    interactive: true,
                }
                break;
            case 'Uthal':
                return {
                    pane: 'pane_DistrictLasbela_7',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(133,150,59,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictLasbela_7');
    map.getPane('pane_DistrictLasbela_7').style.zIndex = 407;
    map.getPane('pane_DistrictLasbela_7').style['mix-blend-mode'] = 'normal';
    var layer_DistrictLasbela_7 = new L.geoJson(json_DistrictLasbela_7, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictLasbela_7',
        layerName: 'layer_DistrictLasbela_7',
        pane: 'pane_DistrictLasbela_7',
        onEachFeature: pop_DistrictLasbela_7,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictLasbela_7_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictLasbela_7);
    map.addLayer(layer_DistrictLasbela_7);

    function pop_DistrictJafferabad_8(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictJafferabad_8_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Gandakha':
                return {
                    pane: 'pane_DistrictJafferabad_8',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(239,117,123,1.0)',
                    interactive: true,
                }
                break;
            case 'jhat Pat':
                return {
                    pane: 'pane_DistrictJafferabad_8',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(190,213,59,1.0)',
                    interactive: true,
                }
                break;
            case 'Jhat Pat':
                return {
                    pane: 'pane_DistrictJafferabad_8',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(48,133,237,1.0)',
                    interactive: true,
                }
                break;
            case 'Usta Muhammad':
                return {
                    pane: 'pane_DistrictJafferabad_8',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(87,201,127,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictJafferabad_8');
    map.getPane('pane_DistrictJafferabad_8').style.zIndex = 408;
    map.getPane('pane_DistrictJafferabad_8').style['mix-blend-mode'] = 'normal';
    var layer_DistrictJafferabad_8 = new L.geoJson(json_DistrictJafferabad_8, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictJafferabad_8',
        layerName: 'layer_DistrictJafferabad_8',
        pane: 'pane_DistrictJafferabad_8',
        onEachFeature: pop_DistrictJafferabad_8,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictJafferabad_8_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictJafferabad_8);
    map.addLayer(layer_DistrictJafferabad_8);

    function pop_DistrictBadin_9(feature, layer) {
        layer.on({
            mouseout: function (e) {
                for (i in e.target._eventParents) {
                    e.target._eventParents[i].resetStyle(e.target);
                }
            },
            mouseover: highlightFeature,
        });
        var popupContent = '<table>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Source'] !== null ? autolinker.link(feature.properties['Source'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['District'] !== null ? autolinker.link(feature.properties['District'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Tehsil'] !== null ? autolinker.link(feature.properties['Tehsil'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Latitude'] !== null ? autolinker.link(feature.properties['Latitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <td colspan="2">' + (feature.properties['Longitude'] !== null ? autolinker.link(feature.properties['Longitude'].toLocaleString()) : '') + '</td>\
                    </tr>\
                    <tr>\
                        <th scope="row">Cluster</th>\
                        <td>' + (feature.properties['Cluster'] !== null ? autolinker.link(feature.properties['Cluster'].toLocaleString()) : '') + '</td>\
                    </tr>\
                </table>';
        layer.bindPopup(popupContent, {maxHeight: 400});
    }

    function style_DistrictBadin_9_0(feature) {
        switch (String(feature.properties['Tehsil'])) {
            case 'Badin':
                return {
                    pane: 'pane_DistrictBadin_9',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(161,214,92,1.0)',
                    interactive: true,
                }
                break;
            case 'Matli':
                return {
                    pane: 'pane_DistrictBadin_9',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(15,209,138,1.0)',
                    interactive: true,
                }
                break;
            case 'Talhar':
                return {
                    pane: 'pane_DistrictBadin_9',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(74,103,231,1.0)',
                    interactive: true,
                }
                break;
            case 'Tando Bago':
                return {
                    pane: 'pane_DistrictBadin_9',
                    radius: 4.0,
                    opacity: 1,
                    color: 'rgba(35,35,35,1.0)',
                    dashArray: '',
                    lineCap: 'butt',
                    lineJoin: 'miter',
                    weight: 1,
                    fill: true,
                    fillOpacity: 1,
                    fillColor: 'rgba(216,123,213,1.0)',
                    interactive: true,
                }
                break;
        }
    }

    map.createPane('pane_DistrictBadin_9');
    map.getPane('pane_DistrictBadin_9').style.zIndex = 409;
    map.getPane('pane_DistrictBadin_9').style['mix-blend-mode'] = 'normal';
    var layer_DistrictBadin_9 = new L.geoJson(json_DistrictBadin_9, {
        attribution: '',
        interactive: true,
        dataVar: 'json_DistrictBadin_9',
        layerName: 'layer_DistrictBadin_9',
        pane: 'pane_DistrictBadin_9',
        onEachFeature: pop_DistrictBadin_9,
        pointToLayer: function (feature, latlng) {
            var context = {
                feature: feature,
                variables: {}
            };
            return L.circleMarker(latlng, style_DistrictBadin_9_0(feature));
        },
    });
    bounds_group.addLayer(layer_DistrictBadin_9);
    map.addLayer(layer_DistrictBadin_9);
    var title = new L.Control();
    title.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };
    title.update = function () {
        this._div.innerHTML = '<h2>Map of UeN Midline Clusters</h2>';
    };
    title.addTo(map);
    var baseMaps = {};
    L.control.layers(baseMaps, {
        'District Badin<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictBadin_9_Badin0.png" /></td><td>Badin</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictBadin_9_Matli1.png" /></td><td>Matli</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictBadin_9_Talhar2.png" /></td><td>Talhar</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictBadin_9_TandoBago3.png" /></td><td>Tando Bago</td></tr></table>': layer_DistrictBadin_9,
        'District Jafferabad<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictJafferabad_8_Gandakha0.png" /></td><td>Gandakha</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictJafferabad_8_jhatPat1.png" /></td><td>jhat Pat</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictJafferabad_8_JhatPat2.png" /></td><td>Jhat Pat</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictJafferabad_8_UstaMuhammad3.png" /></td><td>Usta Muhammad</td></tr></table>': layer_DistrictJafferabad_8,
        'District Lasbela<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictLasbela_7_Bela0.png" /></td><td>Bela</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictLasbela_7_Hub1.png" /></td><td>Hub</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictLasbela_7_Sonmiani2.png" /></td><td>Sonmiani</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictLasbela_7_Uthal3.png" /></td><td>Uthal</td></tr></table>': layer_DistrictLasbela_7,
        'District Muzaffargarh<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictMuzaffargarh_6_Alipur0.png" /></td><td>Alipur</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictMuzaffargarh_6_Jatoi1.png" /></td><td>Jatoi</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictMuzaffargarh_6_KotAdu2.png" /></td><td>Kot Adu</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictMuzaffargarh_6_Muzaffargarh3.png" /></td><td>Muzaffargarh</td></tr></table>': layer_DistrictMuzaffargarh_6,
        'District Nasirabad<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictNasirabad_5_DeraMuradJamali0.png" /></td><td>Dera Murad Jamali</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictNasirabad_5_Tamboo1.png" /></td><td>Tamboo</td></tr></table>': layer_DistrictNasirabad_5,
        'District Qamber Shahdadkot<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictQamberShahdadkot_4_Kamber0.png" /></td><td>Kamber</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictQamberShahdadkot_4_MiroKhan1.png" /></td><td>Miro Khan</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictQamberShahdadkot_4_Nasirabad2.png" /></td><td>Nasirabad</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictQamberShahdadkot_4_Shahdadkot3.png" /></td><td>Shahdadkot</td></tr></table>': layer_DistrictQamberShahdadkot_4,
        'District Rahim Yar Khan<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictRahimYarKhan_3_Khanpur0.png" /></td><td>Khanpur</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictRahimYarKhan_3_Liaqatpur1.png" /></td><td>Liaqatpur</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictRahimYarKhan_3_RahimYarKhan2.png" /></td><td>Rahim Yar Khan</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictRahimYarKhan_3_Sadiqabad3.png" /></td><td>Sadiqabad</td></tr></table>': layer_DistrictRahimYarKhan_3,
        'District Sanghar<br /><table><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictSanghar_2_Sanghar0.png" /></td><td>Sanghar</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictSanghar_2_Shahdadpur1.png" /></td><td>Shahdadpur</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictSanghar_2_Sinjhoro2.png" /></td><td>Sinjhoro</td></tr><tr><td style="text-align: center;"><img src="<?php echo base_url() ?>assets/map/legend/DistrictSanghar_2_TandoAdam3.png" /></td><td>Tando Adam</td></tr></table>': layer_DistrictSanghar_2,
        '<img src="<?php echo base_url() ?>assets/map/legend/TehsilBoundary_1.png" /> Tehsil Boundary': layer_TehsilBoundary_1,
        '<img src="<?php echo base_url() ?>assets/map/legend/DistrictBoundary_0.png" /> District Boundary': layer_DistrictBoundary_0,
    }, {collapsed: false}).addTo(map);
    setBounds();
    var i = 0;
    layer_DistrictBoundary_0.eachLayer(function (layer) {
        var context = {
            feature: layer.feature,
            variables: {}
        };
        layer.bindTooltip((layer.feature.properties['MAP_LABEL'] !== null ? String('<div style="color: #000000; font-size: 10pt; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['MAP_LABEL']) + '</div>' : ''), {
            permanent: true,
            offset: [-0, -16],
            className: 'css_DistrictBoundary_0'
        });
        labels.push(layer);
        totalMarkers += 1;
        layer.added = true;
        addLabel(layer, i);
        i++;
    });
    var i = 0;
    layer_TehsilBoundary_1.eachLayer(function (layer) {
        var context = {
            feature: layer.feature,
            variables: {}
        };
        layer.bindTooltip((layer.feature.properties['UeN_Teh_La'] !== null ? String('<div style="color: #000000; font-size: 7pt; font-family: \'MS Shell Dlg 2\', sans-serif;">' + layer.feature.properties['UeN_Teh_La']) + '</div>' : ''), {
            permanent: true,
            offset: [-0, -16],
            className: 'css_TehsilBoundary_1'
        });
        labels.push(layer);
        totalMarkers += 1;
        layer.added = true;
        addLabel(layer, i);
        i++;
    });
    resetLabels([layer_DistrictBoundary_0, layer_TehsilBoundary_1]);
    map.on("zoomend", function () {
        resetLabels([layer_DistrictBoundary_0, layer_TehsilBoundary_1]);
    });
    map.on("layeradd", function () {
        resetLabels([layer_DistrictBoundary_0, layer_TehsilBoundary_1]);
    });
    map.on("layerremove", function () {
        resetLabels([layer_DistrictBoundary_0, layer_TehsilBoundary_1]);
    });
</script>
