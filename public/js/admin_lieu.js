    const tableLieu = '#table-lieu';
    const slash = '/';

// ADD
    $('body').on( 'click', '#btn-add-lieu', addLieu );

    function addLieu( event ){
        // url
        let url =   $( this ).attr( 'data-url' );
        url = url.concat( slash , 'ajouter' , slash );
        // NomLieu
        let inputLieu = $( '#inpt-add-lieu' );
        let inputLieuValue = inputLieu.val();
        url = url.concat( inputLieuValue );
        // Rue
        let inputRue = $( '#inpt-add-rue' );
        let inputRueValue = inputRue.val();
        url = url.concat( slash , inputRueValue );
        // Latitude
        let inputLatitude = $( '#inpt-add-latitude' );
        let inputLatitudeValue = inputLatitude.val();
        url = url.concat( slash , inputLatitudeValue );
        // Longitude
        let inputLongitude = $( '#inpt-add-longitude' );
        let inputLongitudeValue = inputLongitude.val();
        url = url.concat( slash , inputLongitudeValue );
        // Ville
        let inputVille = $( '#inpt-add-ville' );
        let inputVilleValue = inputVille.val();
        url = url.concat( slash , inputVilleValue );

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
        let btnRemove = $( this );
        let url = btnRemove.attr( 'data-url' );
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
        let lieuId = $( this ).attr( 'data-id' );

        // url
        let url = $( this ).attr( 'data-url' );
        url = url.concat( slash , 'editer' , slash );
        url = url.concat( lieuId );
        // NomLieu
        let inputLieu = $( '#inpt-nom-'.concat( lieuId ) );
        let inputLieuValue = inputLieu.val().trim();
        while ( inputLieuValue.slice(-1) == '.') {
            inputLieuValue = inputLieuValue.substr( 0, inputLieuValue.length - 1 );
        }
        url = url.concat( slash , inputLieuValue );
        // Rue
        let inputRue = $( '#inpt-rue-'.concat( lieuId ) );
        let inputRueValue = inputRue.val().trim();
        while ( inputRueValue.slice(-1) == '.') {
            inputRueValue = inputRueValue.substr( 0, inputLieuValue.length - 1 );
        }
        url = url.concat( slash , inputRueValue );
        // Latitude
        let inputLatitude = $( '#inpt-latitude-'.concat( lieuId ) );
        let inputLatitudeValue = inputLatitude.val().trim();
        url = url.concat( slash , inputLatitudeValue );
        // Longitude
        let inputLongitude = $( '#inpt-longitude-'.concat( lieuId ) );
        let inputLongitudeValue = inputLongitude.val().trim();
        url = url.concat( slash , inputLongitudeValue );
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

// SEARCH
    $('body').on( 'input', '#inpt-location-search', searchLieu );

    function searchLieu( event ){
        debugger;
        let inptSearch = $(this);
        let stringToSearch = inptSearch.val();

        if( stringToSearch == null || stringToSearch == '' ) {
            stringToSearch = 'empty';
        }

        let url = inptSearch.attr( 'data-url' ) + '/' + stringToSearch;

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