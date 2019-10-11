
let _lieux = [];
$("#create_sortie_lieu").prop("disabled", false);
 $("#create_sortie_ville").change(function() {

     $("#create_sortie_lieu").prop("disabled", false);
   var elemLieu =  $("#create_sortie_lieu")
     var api_url = $(this).attr("data-api");
   $.get( api_url+ "byVille/".concat($("#create_sortie_ville").val()), function(){
   }).done(
       function( lieux ){
           _lieux = lieux;
           if(_lieux.length===0){
               $(elemLieu).find('option').remove().end();
               $("#create_sortie_rue").empty();
               $("#create_sortie_cp").empty();
               $("#create_sortie_lat").empty();
               $("#create_sortie_lon").empty();
           }
        $(elemLieu).find('option').remove().end()
        $(lieux).each(function( index ) {
            elemLieu.attr("disabled",null)
            var option = new Option(lieux[index].libelle, lieux[index].id);
            $("#create_sortie_rue").text(_lieux[0].rue);
            $("#create_sortie_cp").text(_lieux[0].codePostal);
            $("#create_sortie_lat").text(_lieux[0].latitude);
            $("#create_sortie_lon").text(_lieux[0].longitude);


            $(elemLieu).append($(option));
        })
   }).fail( function( response ){
       // alert( 'fail' );
   }).always( function( response ){
       // alert( 'alway' );
   });
});

$("#create_sortie_lieu").change(function(){
    $("#create_sortie_rue").text(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].rue);
    $("#create_sortie_cp").text(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].codePostal);
    $("#create_sortie_lat").text(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].latitude);
    $("#create_sortie_lon").text(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].longitude);
});

$('body').on('click', '#btn-pop-lieu', popLieu );

function popLieu( event ){
    debugger;
}

