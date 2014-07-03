/**
 * Created by Werdffelynir on 03.07.14.
 */

$(function() {

    $( "#width-slider" ).slider({
        range: "max",
        min: 360,
        max: 1680,
        value: 960,
        step: 10,
        slide: function( event, ui ) { $( "#width-amount" ).val( ui.value ); }
    });
    $( "#width-amount" ).val( $( "#width-slider" ).slider( "value" ) );

    $( "#padding-slider" ).slider({
        range: "max",
        min: 0,
        max: 50,
        value: 10,
        step: 5,
        slide: function( event, ui ) { $( "#padding-amount" ).val( ui.value ); }
    });
    $( "#padding-amount" ).val( $( "#padding-slider" ).slider( "value" ) );

    $( "#grid-slider" ).slider({
        range: "max",
        min: 2,
        max: 36,
        value: 12,
        step: 2,
        slide: function( event, ui ) { $( "#grid-amount" ).val( ui.value ); }
    });
    $( "#grid-amount" ).val( $( "#grid-slider" ).slider( "value" ) );

    $("#form-generator").submit(function(){
        var width = $('#width-amount').val();
        var padding = $('#padding-amount').val();
        var grid = $('#grid-amount').val();
        $.ajax({
            url:'main.php?p=form&width='+width+'&padding='+padding+'&grid='+grid,
            type: 'get',
            success:function(data){
                $('.result').html(data);
            },
            error:function(){
                alert('some error');
            }
        });

        return false;

    })




});




