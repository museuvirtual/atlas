/**
 * Created by David on 24/06/2015.
 */

$(function() {
    //IMG_1
    // Clear event
    $('.image-preview-clear#img_1').click(function(){
        $('.image-preview-filename#img_1').val("");
        $('.image-preview-clear#img_1').hide();
        $('.image-preview-input#img_1 input:file ').val("");
        $(".image-preview-input-title#img_1").text("Buscar");
        $("#img_prev_1").attr("src", "/img/noimage.jpg");
    });
    // Create the preview image
    $(".image-preview-input#img_1 input:file").change(function (){
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title#img_1").text("Modificar");
            $(".image-preview-clear#img_1").show();
            $(".image-preview-filename#img_1").val(file.name);
            $("#img_prev_1").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
    });
    //IMG_2
    // Clear event
    $('.image-preview-clear#img_2').click(function(){
        $('.image-preview-filename#img_2').val("");
        $('.image-preview-clear#img_2').hide();
        $('.image-preview-input#img_2 input:file ').val("");
        $(".image-preview-input-title#img_2").text("Buscar");
        $("#img_prev_2").attr("src", "/img/noimage.jpg");
    });
    // Create the preview image
    $(".image-preview-input#img_2 input:file").change(function (){
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title#img_2").text("Modificar");
            $(".image-preview-clear#img_2").show();
            $(".image-preview-filename#img_2").val(file.name);
            $("#img_prev_2").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
    });
    //IMG_3
    // Clear event
    $('.image-preview-clear#img_3').click(function(){
        $('.image-preview-filename#img_3').val("");
        $('.image-preview-clear#img_3').hide();
        $('.image-preview-input#img_3 input:file ').val("");
        $(".image-preview-input-title#img_3").text("Buscar");
        $("#img_prev_3").attr("src", "/img/noimage.jpg");
    });
    // Create the preview image
    $(".image-preview-input#img_3 input:file").change(function (){
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title#img_3").text("Modificar");
            $(".image-preview-clear#img_3").show();
            $(".image-preview-filename#img_3").val(file.name);
            $("#img_prev_3").attr("src", e.target.result);
        }
        reader.readAsDataURL(file);
    });
});