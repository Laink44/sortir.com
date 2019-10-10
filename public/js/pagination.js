// PAGINATION
$( 'body' ).on( 'click', '.btn-pagination', routePaginator );

function routePaginator( event ){
    event.preventDefault();
    let href        = $( this ).attr( 'href' );
    let currentPage = $( this ).attr( 'data-currentpage' );
    let origin      = $( this ).attr( 'data-origin' );
    let search      =  $( '#inpt-search' ).val().trim();
    search          =   search || search.length !== 0
        ? $( '#inpt-search' ).val()  : 'empty';
    let url         =   href
        .concat( '?')
        .concat( 'search=', search)
        .concat( '&')
        .concat( 'origin=', origin)
        .concat( '&')
        .concat( 'currentpage=', currentPage);
debugger;
    $.get( url, function(){
        // alert( 'success' );
    }).done( function( response ){
        $( tableVille ).html( response );
    }).fail( function( response ){
        // alert( 'fail' );
    }).always( function( response ){
        // alert( 'alway' );
    });

    // let data = {
    //     'page'          : page,
    //     'search'        : search,
    //     'origin'        : origin,
    //     'currentpage'   : currentPage
    // };
    //
    // debugger;
    // $.ajax({
    //     url: href,
    //     data: data,
    //     type: "GET",
    //     success : function( response ){
    //         debugger;
    //         $( tableVille ).html( response );
    //     },
    //     error: function( xhr ) {
    //
    //     }
    // });
}