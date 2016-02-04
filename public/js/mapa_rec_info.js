/**
 * Created by David on 01/07/2015.
 */

var mapgaz="";
var select = null;
var vectorLayer=null;



var vectorSource = new ol.source.Vector({
    features: []
});

function createFeature(id, lat, long){

    var gaz_point = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857')),
        id: id
    });
    vectorSource.addFeature(gaz_point)
};

function loadFeaturesToMap(){

    vectorLayer = new ol.layer.Vector({
        source: vectorSource
    });

    mapgaz.addLayer(vectorLayer);
    var extent = vectorLayer.getSource().getExtent();
    mapgaz.getView().fitExtent(extent, mapgaz.getSize());
    if (mapgaz.getView().getZoom()>7){
        mapgaz.getView().setZoom(7);
    }
}



function loadMap () {
    mapgaz = new ol.Map({
        controls: ol.control.defaults({
            attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                collapsible: false
            })
        }),
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        target: 'map',
        view: new ol.View({
            center: [17, -12],
            zoom: 7
        })
    });
};