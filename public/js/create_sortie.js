
let _lieux = [];
 $("#create_sortie_ville").change(function() {

   var elemLieu =  $("#create_sortie_lieu")
   $.get( "http://localhost/sortir.com/public/api/lieu/byVille/".concat($("#create_sortie_ville").val()), function(){
   }).done(
       function( lieux ){
           _lieux = lieux;
        $(elemLieu).find('option').remove().end()
        $(lieux).each(function( index ) {
            elemLieu.attr("disabled",null)
            var option = new Option(lieux[index].libelle, lieux[index].id);
            $("#create_sortie_rue").val(_lieux[0].rue);
            $("#create_sortie_cp").val(_lieux[0].codePostal);

            $(elemLieu).append($(option));
        })
   }).fail( function( response ){
       // alert( 'fail' );
   }).always( function( response ){
       // alert( 'alway' );
   });
});

$("#create_sortie_lieu").change(function(){
    $("#create_sortie_rue").val(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].rue);
    $("#create_sortie_cp").val(_lieux[$("#create_sortie_lieu").prop('selectedIndex')].codePostal);
});



