/**
 * Created by David on 22/06/2015.
 */

/**
 * Elements that make up the popup.
 */
var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');
var mapgaz="";

/**
 * Add a click handler to hide the popup.
 * @return {boolean} Don't follow the href.
 */
closer.onclick = function() {
    overlay.setPosition(undefined);
    closer.blur();
    return false;
};


/**
 * Create an overlay to anchor the popup to the map.
 */
var overlay = new ol.Overlay(/** @type {olx.OverlayOptions} */ ({
    element: container,
    autoPan: true,
    autoPanAnimation: {
        duration: 250
    }
}));



var mousePositionControl = new ol.control.MousePosition({
    coordinateFormat: ol.coordinate.toStringHDMS,  //toStringXY
    projection: 'EPSG:4326',  //3857
    // comment the following two lines to have the mouse position
    // be placed within the map.
    className: 'custom-mouse-position',
    target: document.getElementById('mouse-position'),
    undefinedHTML: '&nbsp;'
});
var projection = ol.proj.get('EPSG:3857');

var ProvincesStyle = new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: 'rgba(120,120, 120, 1)',
            width: 1
        }),
        fill: new ol.style.Fill({
            color: 'rgba(0, 0, 255, 0.01)'
        })
    });

var provincias = new ol.layer.Vector({
    name: 'Provincias',
    source: new ol.source.Vector({
        format: new ol.format.GeoJSON,
        projection: projection,
        url: '/gis/provinces.geojson'
    }),
    style: ProvincesStyle
});


function displayFeatureInfo_1 (pixel) {

    var feature = mapgaz.forEachFeatureAtPixel(pixel, function (feature, layer) {
        return feature;
    });

    if (feature) {
        $('#municipe_div')[0].innerHTML= feature.get('municipe');
        $('#province_div')[0].innerHTML= feature.get('province');
    } else {
        $('#municipe_div')[0].innerHTML= 'desconhecido';
        $('#province_div')[0].innerHTML=  'desconhecida';
    }
};

var styles = [
    'Road',
    'Aerial',
    'AerialWithLabels'
];
var layers = [];
var i, ii;
for (i = 0, ii = styles.length; i < ii; ++i) {
    layers.push(new ol.layer.Tile({
        visible: false,
        preload: Infinity,
        source: new ol.source.BingMaps({
            key: 'AloMX-A3ZpYaAUlSQFsdJNhCvuHwG-bkb8Sf-vas5pueWP6jiFSRdEjBvJBb2g2A',
            imagerySet: styles[i]
            // use maxZoom 19 to see stretched tiles instead of the BingMaps
            // "no photos at this zoom level" tiles
            // maxZoom: 19
        })
    }));
}
layers.push(provincias);



function loadMap () {
    mapgaz = new ol.Map({
        controls: ol.control.defaults({
            attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                collapsible: false
            })
        }).extend([mousePositionControl]),
        layers: layers,
        overlays: [overlay],
        loadTilesWhileInteracting: true,
        target: 'map',
        view: new ol.View({
            center: ol.proj.transform([17, -11], 'EPSG:4326', 'EPSG:3857'),
            zoom: 5,
            minZoom: 5,
            extent:[1000000,-2000000,3000000,-500000]

        })
    });



    mapgaz.on('singleclick', function (evt) {
        var coordinate = evt.coordinate;
        coordinate2 = ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');
        var hdmslat = coordinate2[1];
        var hdmslong = coordinate2[0];

        $('#hemisferio_lat')[0].innerHTML= (ConvertDDToDMS(hdmslat).deg < 0) ? "South":"North";
        $('#latitude_deg')[0].value = Math.abs(ConvertDDToDMS(hdmslat).deg);
        $('#latitude_min')[0].value = ConvertDDToDMS(hdmslat).min;
        $('#latitude_sec')[0].value = ConvertDDToDMS(hdmslat).sec;

        $('#hemisferio_long')[0].innerHTML= (ConvertDDToDMS(hdmslong).deg < 0) ? "West":"East";
        $('#longitude_deg')[0].value = Math.abs(ConvertDDToDMS(hdmslong).deg);
        $('#longitude_min')[0].value =ConvertDDToDMS(hdmslong).min;
        $('#longitude_sec')[0].value = ConvertDDToDMS(hdmslong).sec;

        content.innerHTML = "Nova Localização";
        overlay.setPosition(coordinate);
        displayFeatureInfo_1(evt.pixel);
    });

    var select = document.getElementById('layer-select');
    function onChange() {
        var style = select.value;
        for (var i = 0, ii = layers.length; i < ii; ++i) {
            layers[i].setVisible(styles[i] === style);
        }
    }
    select.addEventListener('change', onChange);
    onChange();
}

function ConvertDDToDMS(dd)
{
    var deg = dd | 0; // truncate dd to get degrees
    var frac = Math.abs(dd - deg); // get fractional part
    var min = (frac * 60) | 0; // multiply fraction by 60 and truncate
    var sec = frac * 3600 - min * 60;
    sec=sec.toFixed(0);
    return {
        deg: deg,
        min:min,
        sec:sec
    }
}


