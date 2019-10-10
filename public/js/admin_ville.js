// ADD
    $('body').on('click', '#btn-add-ville', addVille );

    function addVille( event ){
        let inputVille = $( '#inpt-add-ville' );
        let inputVilleValue = inputVille.val();

        let inputCodePostal = $( '#inpt-add-cp' );
        let inputCodePostalValue = inputCodePostal.val();

        let origin  = $( this ).attr( 'data-origin' );
        let url     = $( this ).attr( 'data-url' )
                    .concat( '?' )
                    .concat( 'nom=', inputVilleValue )
                    .concat( '&')
                    .concat( 'cp=', inputCodePostalValue )
                    .concat( '&')
                    .concat( 'origin=', origin );

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( tableVille ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }

// REMOVE
    $('body').on('click', '.btn-remove-ville', removeVille );

    function removeVille( event ){
        // let btnRemove = $( this );
        let origin  = $( this ).attr( 'data-origin' );
        let url     =   $( this ).attr( 'data-url' )
                        .concat( '?')
                        .concat( 'origin=', origin );
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
    }


// EDIT
    $('body').on('click', '.btn-edit-ville', editVille );

    function editVille( event ){
        let btnEdit = $( this );
        btnEdit.prop( 'disabled', true );
        btnEdit.addClass( 'btn-common-disabled' );

        let villeId = btnEdit.attr( 'data-id' );
        let inputCity = $( '#inpt-' + villeId );
        inputCity.prop( 'disabled', false );

        let inputZipCode = $( '#inpt-cp-' + villeId );
        inputZipCode.prop( 'disabled', false );

        let btnSave = $( '#btn-save-ville-' + villeId );
        btnSave.removeClass( 'btn-common-disabled' );
        btnSave.prop( 'disabled', false );
    }

// SAVE
    $('body').on('click', '.btn-save-ville', saveVille );

    function saveVille( event ){
        let btnSave = $( this );
        let villeId = btnSave.attr( 'data-id' );
        let villeNom = $( '#inpt-' + villeId ).val();
        let villeCP = $( '#inpt-cp-' + villeId ).val();
        let origin  = $( this ).attr( 'data-origin' );
        let url     =   $( this ).attr( 'data-url' )
                        .concat( '?')
                        .concat( 'nom=', villeNom )
                        .concat( '&')
                        .concat( 'id=', villeId )
                        .concat( '&')
                        .concat( 'cp=', villeCP )
                        .concat( '&')
                        .concat( 'origin=', origin );

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
    }

// SEARCH
    $('body').on( 'input', '#inpt-search', searchVille );

    function searchVille( event ){
        let search =  $(this).val().trim();
        if( search == null || search == '' ) {
            search = 'empty';
        }
        let origin  =   $( this ).attr( 'data-origin' );
        let url     =   $(this).attr( 'data-url' )
                        .concat( '?')
                        .concat( 'search=', search )
                        .concat( '&')
                        .concat( 'origin=', origin );

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
    }