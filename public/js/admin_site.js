// ADD
    $('body').on('click', '#btn-add-site', addSite );

    function addSite( event ){
        debugger;
        let inputSite = $( '#inpt-add-site' );
        let inputSiteValue = inputSite.val();

        let btnAdd = $( this );
        let url = btnAdd.attr( 'data-url' ) + '/' + inputSiteValue;

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( '#table-site' ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }

// REMOVE
    $('body').on('click', '#btn-remove-site', removeSite );

    function removeSite( event ){
        debugger;
        let btnRemove = $( this );
        let url = btnRemove.attr( 'data-url' );

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( '#table-site' ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }