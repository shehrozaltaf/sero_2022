ol.proj.proj4.register(proj4);
ol.proj.get("EPSG:32642").setExtent([-10582.385655, 2664591.678257, 890055.397455, 3424063.664643]);
var wms_layers = [];


var lyr_GoogleSatellite_0 = new ol.layer.Tile({
    'title': 'Google Satellite',
    'type': 'base',
    'opacity': 1.000000,


    source: new ol.source.XYZ({
        attributions: ' ',
        url: 'http://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}'
    })
});
var format_DistrictBoundary_1 = new ol.format.GeoJSON();
var features_DistrictBoundary_1 = format_DistrictBoundary_1.readFeatures(json_DistrictBoundary_1,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictBoundary_1 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictBoundary_1.addFeatures(features_DistrictBoundary_1);
var lyr_DistrictBoundary_1 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictBoundary_1,
    style: style_DistrictBoundary_1,
    interactive: false,
    title: '<img src="styles/legend/DistrictBoundary_1.png" /> District Boundary'
});
var format_TehsilBoundary_2 = new ol.format.GeoJSON();
var features_TehsilBoundary_2 = format_TehsilBoundary_2.readFeatures(json_TehsilBoundary_2,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_TehsilBoundary_2 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_TehsilBoundary_2.addFeatures(features_TehsilBoundary_2);
var lyr_TehsilBoundary_2 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_TehsilBoundary_2,
    style: style_TehsilBoundary_2,
    interactive: false,
    title: '<img src="styles/legend/TehsilBoundary_2.png" /> Tehsil Boundary'
});
var format_DistrictSanghar_3 = new ol.format.GeoJSON();
var features_DistrictSanghar_3 = format_DistrictSanghar_3.readFeatures(json_DistrictSanghar_3,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictSanghar_3 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictSanghar_3.addFeatures(features_DistrictSanghar_3);
var lyr_DistrictSanghar_3 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictSanghar_3,
    style: style_DistrictSanghar_3,
    interactive: true,
    title: 'District Sanghar<br />\
    <img src="styles/legend/DistrictSanghar_3_0.png" /> Sanghar<br />\
    <img src="styles/legend/DistrictSanghar_3_1.png" /> Shahdadpur<br />\
    <img src="styles/legend/DistrictSanghar_3_2.png" /> Sinjhoro<br />\
    <img src="styles/legend/DistrictSanghar_3_3.png" /> Tando Adam<br />'
});
var format_DistrictRahimYarKhan_4 = new ol.format.GeoJSON();
var features_DistrictRahimYarKhan_4 = format_DistrictRahimYarKhan_4.readFeatures(json_DistrictRahimYarKhan_4,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictRahimYarKhan_4 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictRahimYarKhan_4.addFeatures(features_DistrictRahimYarKhan_4);
var lyr_DistrictRahimYarKhan_4 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictRahimYarKhan_4,
    style: style_DistrictRahimYarKhan_4,
    interactive: true,
    title: 'District Rahim Yar Khan<br />\
    <img src="styles/legend/DistrictRahimYarKhan_4_0.png" /> Khanpur<br />\
    <img src="styles/legend/DistrictRahimYarKhan_4_1.png" /> Liaqatpur<br />\
    <img src="styles/legend/DistrictRahimYarKhan_4_2.png" /> Rahim Yar Khan<br />\
    <img src="styles/legend/DistrictRahimYarKhan_4_3.png" /> Sadiqabad<br />'
});
var format_DistrictQamberShahdadkot_5 = new ol.format.GeoJSON();
var features_DistrictQamberShahdadkot_5 = format_DistrictQamberShahdadkot_5.readFeatures(json_DistrictQamberShahdadkot_5,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictQamberShahdadkot_5 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictQamberShahdadkot_5.addFeatures(features_DistrictQamberShahdadkot_5);
var lyr_DistrictQamberShahdadkot_5 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictQamberShahdadkot_5,
    style: style_DistrictQamberShahdadkot_5,
    interactive: true,
    title: 'District Qamber Shahdadkot<br />\
    <img src="styles/legend/DistrictQamberShahdadkot_5_0.png" /> Kamber<br />\
    <img src="styles/legend/DistrictQamberShahdadkot_5_1.png" /> Miro Khan<br />\
    <img src="styles/legend/DistrictQamberShahdadkot_5_2.png" /> Nasirabad<br />\
    <img src="styles/legend/DistrictQamberShahdadkot_5_3.png" /> Shahdadkot<br />'
});
var format_DistrictNasirabad_6 = new ol.format.GeoJSON();
var features_DistrictNasirabad_6 = format_DistrictNasirabad_6.readFeatures(json_DistrictNasirabad_6,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictNasirabad_6 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictNasirabad_6.addFeatures(features_DistrictNasirabad_6);
var lyr_DistrictNasirabad_6 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictNasirabad_6,
    style: style_DistrictNasirabad_6,
    interactive: true,
    title: 'District Nasirabad<br />\
    <img src="styles/legend/DistrictNasirabad_6_0.png" /> Dera Murad Jamali<br />\
    <img src="styles/legend/DistrictNasirabad_6_1.png" /> Tamboo<br />'
});
var format_DistrictMuzaffargarh_7 = new ol.format.GeoJSON();
var features_DistrictMuzaffargarh_7 = format_DistrictMuzaffargarh_7.readFeatures(json_DistrictMuzaffargarh_7,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictMuzaffargarh_7 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictMuzaffargarh_7.addFeatures(features_DistrictMuzaffargarh_7);
var lyr_DistrictMuzaffargarh_7 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictMuzaffargarh_7,
    style: style_DistrictMuzaffargarh_7,
    interactive: true,
    title: 'District Muzaffargarh<br />\
    <img src="styles/legend/DistrictMuzaffargarh_7_0.png" /> Alipur<br />\
    <img src="styles/legend/DistrictMuzaffargarh_7_1.png" /> Jatoi<br />\
    <img src="styles/legend/DistrictMuzaffargarh_7_2.png" /> Kot Adu<br />\
    <img src="styles/legend/DistrictMuzaffargarh_7_3.png" /> Muzaffargarh<br />'
});
var format_DistrictLasbela_8 = new ol.format.GeoJSON();
var features_DistrictLasbela_8 = format_DistrictLasbela_8.readFeatures(json_DistrictLasbela_8,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictLasbela_8 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictLasbela_8.addFeatures(features_DistrictLasbela_8);
var lyr_DistrictLasbela_8 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictLasbela_8,
    style: style_DistrictLasbela_8,
    interactive: true,
    title: 'District Lasbela<br />\
    <img src="styles/legend/DistrictLasbela_8_0.png" /> Bela<br />\
    <img src="styles/legend/DistrictLasbela_8_1.png" /> Hub<br />\
    <img src="styles/legend/DistrictLasbela_8_2.png" /> Sonmiani<br />\
    <img src="styles/legend/DistrictLasbela_8_3.png" /> Uthal<br />'
});
var format_DistrictJafferabad_9 = new ol.format.GeoJSON();
var features_DistrictJafferabad_9 = format_DistrictJafferabad_9.readFeatures(json_DistrictJafferabad_9,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictJafferabad_9 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictJafferabad_9.addFeatures(features_DistrictJafferabad_9);
var lyr_DistrictJafferabad_9 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictJafferabad_9,
    style: style_DistrictJafferabad_9,
    interactive: true,
    title: 'District Jafferabad<br />\
    <img src="styles/legend/DistrictJafferabad_9_0.png" /> Gandakha<br />\
    <img src="styles/legend/DistrictJafferabad_9_1.png" /> jhat Pat<br />\
    <img src="styles/legend/DistrictJafferabad_9_2.png" /> Jhat Pat<br />\
    <img src="styles/legend/DistrictJafferabad_9_3.png" /> Usta Muhammad<br />'
});
var format_DistrictBadin_10 = new ol.format.GeoJSON();
var features_DistrictBadin_10 = format_DistrictBadin_10.readFeatures(json_DistrictBadin_10,
    {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:32642'});
var jsonSource_DistrictBadin_10 = new ol.source.Vector({
    attributions: ' ',
});
jsonSource_DistrictBadin_10.addFeatures(features_DistrictBadin_10);
var lyr_DistrictBadin_10 = new ol.layer.Vector({
    declutter: true,
    source: jsonSource_DistrictBadin_10,
    style: style_DistrictBadin_10,
    interactive: true,
    title: 'District Badin<br />\
    <img src="styles/legend/DistrictBadin_10_0.png" /> Badin<br />\
    <img src="styles/legend/DistrictBadin_10_1.png" /> Matli<br />\
    <img src="styles/legend/DistrictBadin_10_2.png" /> Talhar<br />\
    <img src="styles/legend/DistrictBadin_10_3.png" /> Tando Bago<br />'
});

lyr_GoogleSatellite_0.setVisible(true);
lyr_DistrictBoundary_1.setVisible(true);
lyr_TehsilBoundary_2.setVisible(true);
lyr_DistrictSanghar_3.setVisible(true);
lyr_DistrictRahimYarKhan_4.setVisible(true);
lyr_DistrictQamberShahdadkot_5.setVisible(true);
lyr_DistrictNasirabad_6.setVisible(true);
lyr_DistrictMuzaffargarh_7.setVisible(true);
lyr_DistrictLasbela_8.setVisible(true);
lyr_DistrictJafferabad_9.setVisible(true);
lyr_DistrictBadin_10.setVisible(true);
var layersList = [lyr_GoogleSatellite_0, lyr_DistrictBoundary_1, lyr_TehsilBoundary_2, lyr_DistrictSanghar_3, lyr_DistrictRahimYarKhan_4, lyr_DistrictQamberShahdadkot_5, lyr_DistrictNasirabad_6, lyr_DistrictMuzaffargarh_7, lyr_DistrictLasbela_8, lyr_DistrictJafferabad_9, lyr_DistrictBadin_10];
lyr_DistrictBoundary_1.set('fieldAliases', {
    'UN_DIST_N': 'UN_DIST_N',
    'WHO_DIST_C': 'WHO_DIST_C',
    'WHO_DIST_N': 'WHO_DIST_N',
    'GOV_DIST_N': 'GOV_DIST_N',
    'MAP_LABEL': 'MAP_LABEL',
    'Remarks': 'Remarks',
    'IDM_Priori': 'IDM_Priori',
    'GOV_DIV_N': 'GOV_DIV_N',
    'Target_u5_': 'Target_u5_',
    'WHO_PROV_C': 'WHO_PROV_C',
    'WHO_PROV_N': 'WHO_PROV_N',
    'Shape_Leng': 'Shape_Leng',
    'Shape_Area': 'Shape_Area',
    'Population': 'Population',
    'Pop_Den_pe': 'Pop_Den_pe',
    'Area': 'Area',
    'Rural_Popu': 'Rural_Popu',
    'Rural_Pop_': 'Rural_Pop_',
    'U1': 'U1',
    'U5': 'U5',
    'U15': 'U15',
    'WRA15_49': 'WRA15_49',
    'UeN_ML': 'UeN_ML',
});
lyr_TehsilBoundary_2.set('fieldAliases', {
    'GOV1_TEH_N': 'GOV1_TEH_N',
    'GOV2_TEH_N': 'GOV2_TEH_N',
    'WHO_TEH_C': 'WHO_TEH_C',
    'WHO_TEH_N': 'WHO_TEH_N',
    'MAP_LABEL': 'MAP_LABEL',
    'WHO_DIST_C': 'WHO_DIST_C',
    'WHO_DIST_N': 'WHO_DIST_N',
    'WHO_PROV_C': 'WHO_PROV_C',
    'WHO_PROV_N': 'WHO_PROV_N',
    'Shape_Leng': 'Shape_Leng',
    'Shape_Area': 'Shape_Area',
    'Population': 'Population',
    'Pop_densit': 'Pop_densit',
    'UEN_DIST_N': 'UEN_DIST_N',
    'UEN_DIST_C': 'UEN_DIST_C',
    'UEN_TEH_N': 'UEN_TEH_N',
    'UeN_ML': 'UeN_ML',
    'UeN_Teh_La': 'UeN_Teh_La',
});
lyr_DistrictSanghar_3.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictRahimYarKhan_4.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictQamberShahdadkot_5.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictNasirabad_6.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictMuzaffargarh_7.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictLasbela_8.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictJafferabad_9.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictBadin_10.set('fieldAliases', {
    'Source': 'Source',
    'District': 'District',
    'Tehsil': 'Tehsil',
    'Latitude': 'Latitude',
    'Longitude': 'Longitude',
    'Cluster': 'Cluster',
});
lyr_DistrictBoundary_1.set('fieldImages', {
    'UN_DIST_N': 'TextEdit',
    'WHO_DIST_C': 'TextEdit',
    'WHO_DIST_N': 'TextEdit',
    'GOV_DIST_N': 'TextEdit',
    'MAP_LABEL': 'TextEdit',
    'Remarks': 'TextEdit',
    'IDM_Priori': 'TextEdit',
    'GOV_DIV_N': 'TextEdit',
    'Target_u5_': 'TextEdit',
    'WHO_PROV_C': 'TextEdit',
    'WHO_PROV_N': 'TextEdit',
    'Shape_Leng': 'TextEdit',
    'Shape_Area': 'TextEdit',
    'Population': 'Range',
    'Pop_Den_pe': 'TextEdit',
    'Area': 'TextEdit',
    'Rural_Popu': 'Range',
    'Rural_Pop_': 'TextEdit',
    'U1': 'Range',
    'U5': 'Range',
    'U15': 'Range',
    'WRA15_49': 'Range',
    'UeN_ML': 'TextEdit',
});
lyr_TehsilBoundary_2.set('fieldImages', {
    'GOV1_TEH_N': 'TextEdit',
    'GOV2_TEH_N': 'TextEdit',
    'WHO_TEH_C': 'TextEdit',
    'WHO_TEH_N': 'TextEdit',
    'MAP_LABEL': 'TextEdit',
    'WHO_DIST_C': 'TextEdit',
    'WHO_DIST_N': 'TextEdit',
    'WHO_PROV_C': 'TextEdit',
    'WHO_PROV_N': 'TextEdit',
    'Shape_Leng': 'TextEdit',
    'Shape_Area': 'TextEdit',
    'Population': 'Range',
    'Pop_densit': 'TextEdit',
    'UEN_DIST_N': 'TextEdit',
    'UEN_DIST_C': 'Range',
    'UEN_TEH_N': 'TextEdit',
    'UeN_ML': 'TextEdit',
    'UeN_Teh_La': 'TextEdit',
});
lyr_DistrictSanghar_3.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictRahimYarKhan_4.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictQamberShahdadkot_5.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictNasirabad_6.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictMuzaffargarh_7.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictLasbela_8.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictJafferabad_9.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictBadin_10.set('fieldImages', {
    'Source': 'TextEdit',
    'District': 'TextEdit',
    'Tehsil': 'TextEdit',
    'Latitude': 'TextEdit',
    'Longitude': 'TextEdit',
    'Cluster': 'Range',
});
lyr_DistrictBoundary_1.set('fieldLabels', {
    'UN_DIST_N': 'no label',
    'WHO_DIST_C': 'no label',
    'WHO_DIST_N': 'no label',
    'GOV_DIST_N': 'no label',
    'MAP_LABEL': 'no label',
    'Remarks': 'no label',
    'IDM_Priori': 'no label',
    'GOV_DIV_N': 'no label',
    'Target_u5_': 'no label',
    'WHO_PROV_C': 'no label',
    'WHO_PROV_N': 'no label',
    'Shape_Leng': 'no label',
    'Shape_Area': 'no label',
    'Population': 'no label',
    'Pop_Den_pe': 'no label',
    'Area': 'no label',
    'Rural_Popu': 'no label',
    'Rural_Pop_': 'no label',
    'U1': 'no label',
    'U5': 'no label',
    'U15': 'no label',
    'WRA15_49': 'no label',
    'UeN_ML': 'no label',
});
lyr_TehsilBoundary_2.set('fieldLabels', {
    'GOV1_TEH_N': 'no label',
    'GOV2_TEH_N': 'no label',
    'WHO_TEH_C': 'no label',
    'WHO_TEH_N': 'no label',
    'MAP_LABEL': 'no label',
    'WHO_DIST_C': 'no label',
    'WHO_DIST_N': 'no label',
    'WHO_PROV_C': 'no label',
    'WHO_PROV_N': 'no label',
    'Shape_Leng': 'no label',
    'Shape_Area': 'no label',
    'Population': 'no label',
    'Pop_densit': 'no label',
    'UEN_DIST_N': 'no label',
    'UEN_DIST_C': 'no label',
    'UEN_TEH_N': 'no label',
    'UeN_ML': 'no label',
    'UeN_Teh_La': 'no label',
});
lyr_DistrictSanghar_3.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictRahimYarKhan_4.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictQamberShahdadkot_5.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictNasirabad_6.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictMuzaffargarh_7.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictLasbela_8.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictJafferabad_9.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictBadin_10.set('fieldLabels', {
    'Source': 'no label',
    'District': 'no label',
    'Tehsil': 'no label',
    'Latitude': 'no label',
    'Longitude': 'no label',
    'Cluster': 'inline label',
});
lyr_DistrictBadin_10.on('precompose', function (evt) {
    evt.context.globalCompositeOperation = 'normal';
});