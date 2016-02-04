/**
 * Created by David on 24/06/2015.
 */

var mapgaz="";
var select = null;
var vectorLayer=null;
var selected_test =null;


function selectRow(id){
    $('[class="success"]').attr("class","");
    $("#"+id).attr("class","success");
    selectSingleClick.getFeatures().clear();
    var featureToSelect=null;
    //MEU FILTRO PESSOAL PARA ENCOTRAR A FEATURE QUE TEM POR ID O DA LINHA SELECCIONADA E SELECCIONA-LO
    vectorLayer.getSource().getFeatures().forEach(
        function bb(feature){
            if (feature.get('id')==id){
            featureToSelect=feature;
            }
        }
    )
    selectSingleClick.getFeatures().push(featureToSelect);
    $('#selected').html("<h4>#"+featureToSelect.get('id')+" "+featureToSelect.get('name')+"</h4> " +
    "<p>Criado em: "+featureToSelect.get('created_at')+"</p> ");

};


var selectSingleClick = new ol.interaction.Select();
var vectorSource = new ol.source.Vector({
    features: []
});

function createFeature(id, name, created_at, lat, long){

    var gaz_point = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([long, lat], 'EPSG:4326', 'EPSG:3857')),
        id: id,
        name: name,
        created_at: created_at
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
            center: [0, 0],
            zoom: 2
        })
    });



    mapgaz.addInteraction(selectSingleClick);
    selectSingleClick.on('select', function(e) {
        feat = e.selected[0];
        if (feat){
            $('#selected').html("<h4>#"+feat.get('id')+" "+feat.get('name')+"</h4> " +
            "<p>Criado em: "+feat.get('created_at')+"</p> ");
            selectRow(feat.get('id'));
        }else {
            $('#selected').html(" ");
        }
    });
};