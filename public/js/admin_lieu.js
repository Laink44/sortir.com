    const tableLieu = '#table-lieu';
    const slash = '/';

// ADD
    $('body').on( 'click', '#btn-add-lieu', addLieu );

    function addLieu( event ){
        // NomLieu
        let nom         = $( '#inpt-add-lieu' ).val();
        // Rue
        let rue         = $( '#inpt-add-rue' ).val();
        // Latitude
        let latitude    = $( '#inpt-add-latitude' ).val();
        // Longitude
        let longitude   =  $( '#inpt-add-longitude' ).val();
        // Ville
        let villeId     = $( '#inpt-add-ville' ).val();

        let origin      = $( this ).attr( 'data-origin' );
        let url         =   $( this ).attr( 'data-url' )
                            .concat( '?' )
                            .concat( 'nom=', nom )
                            .concat( '&')
                            .concat( 'rue=', rue )
                            .concat( '&')
                            .concat( 'latitude=', latitude )
                            .concat( '&')
                            .concat( 'longitude=', longitude )
                            .concat( '&')
                            .concat( 'villeid=', villeId )
                            .concat( '&')
                            .concat( 'origin=', origin );

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( tableLieu ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }

// REMOVE
    $('body').on('click', '.btn-remove-lieu', removeLieu );

    function removeLieu( event ){
        let origin  = $( this ).attr( 'data-origin' );
        let url     =   $( this ).attr( 'data-url' )
                        .concat( '?')
                        .concat( 'origin=', origin );
        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( tableLieu ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }


// EDIT
    $('body').on('click', '.btn-edit-lieu', editLieu );

    function editLieu( event ){
        debugger;
        let btnEdit = $( this );
        btnEdit.prop( 'disabled', true );
        btnEdit.addClass( 'btn-common-disabled' );

        let lieuId = btnEdit.attr( 'data-id' );

        // Nom
        let inputLocation = $( '#inpt-nom-' + lieuId );
        inputLocation.prop( 'disabled', false );
        // Rue
        let inputStreet = $( '#inpt-rue-' + lieuId );
        inputStreet.prop( 'disabled', false );
        // Latitude
        let inputLatitude = $( '#inpt-latitude-' + lieuId );
        inputLatitude.prop( 'disabled', false );
        // Longitude
        let inputLongitude = $( '#inpt-longitude-' + lieuId );
        inputLongitude.prop( 'disabled', false );

        let btnSave = $( '#btn-save-lieu-' + lieuId );
        btnSave.removeClass( 'btn-common-disabled' );
        btnSave.prop( 'disabled', false );
    }

// SAVE
    $('body').on('click', '.btn-save-lieu', saveLieu );

    function saveLieu( event ){
        // ID lieu
        let lieuId = $( this ).attr( 'data-id' );
        // NomLieu
        let nom = $( '#inpt-nom-'.concat( lieuId ) ).val().trim();
        while ( nom.slice(-1) == '.') {
            nom = nom.substr( 0, nom.length - 1 );
        }
        // Rue
        let rue = $( '#inpt-rue-'.concat( lieuId ) ).val().trim();
        while ( rue.slice(-1) == '.') {
            rue = rue.substr( 0, rue.length - 1 );
        }
        // Latitude
        let latitude = $( '#inpt-latitude-'.concat( lieuId ) ).val().trim();
        // Longitude
        let longitude = $( '#inpt-longitude-'.concat( lieuId ) ).val().trim();

        let origin  = $( this ).attr( 'data-origin' );
        let url     =   $( this ).attr( 'data-url' )
            .concat( '?')
            .concat( 'nom=', nom )
            .concat( '&')
            .concat( 'id=', lieuId )
            .concat( '&')
            .concat( 'rue=', rue )
            .concat( '&')
            .concat( 'latitude=', latitude )
            .concat( '&')
            .concat( 'longitude=', longitude )
            .concat( '&')
            .concat( 'origin=', origin );
        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( tableLieu ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }

// SEARCH
    $('body').on( 'input', '#inpt-search', searchLieu );

    function searchLieu( event ){
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
            $( tableLieu ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }

// AUTOCOMPLETE
    $('body').on( 'input', '#inpt-add-ville', autocompleteVille );

    function autocompleteVille( event ){
        let inptAutocomplete = $(this);
        let stringToComplete = inptAutocomplete.val();

        if( stringToComplete == null || stringToComplete == '' ) {
            stringToComplete = 'empty';
        }

        let url = inptAutocomplete.attr( 'data-url' ) + '/' + stringToComplete;

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $( '#inpt-add-ville' ).autocomplete({
                source : response, // on inscrit la liste de suggestions
                minLength : 3 // on indique qu'il faut taper au moins 3 caractères pour afficher l'autocomplétion
            });
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }