    const tableLieu = '#table-lieu';

// ADD
    $('body').on('click', '#btn-add-lieu', addLieu );

    function addLieu( event ){
        let inputLieu = $( '#inpt-add-lieu' );
        let inputLieuValue = inputLieu.val();

        let inputCodePostal = $( '#inpt-add-cp' );
        let inputCodePostalValue = inputCodePostal.val();

        let btnAdd = $( this );
        let url = btnAdd.attr( 'data-url' ) + '/ajouter/lieu/' + inputLieuValue + '/cp/' + inputCodePostalValue;

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

        let inputLocation = $( '#inpt-' + lieuId );
        inputLocation.prop( 'disabled', false );

        let inputStreet = $( '#inpt-rue-' + lieuId );
        inputStreet.prop( 'disabled', false );

        let inputLatitude = $( '#inpt-latitude-' + lieuId );
        inputLatitude.prop( 'disabled', false );

        let inputLongitude = $( '#inpt-longitude-' + lieuId );
        inputLongitude.prop( 'disabled', false );

        // let inputCity = $( '#inpt-ville-' + lieuId );
        // inputCity.prop( 'disabled', false );

        let btnSave = $( '#btn-save-lieu-' + lieuId );
        btnSave.removeClass( 'btn-common-disabled' );
        btnSave.prop( 'disabled', false );
    }

// SAVE
    $('body').on('click', '.btn-save-lieu', saveLieu );

    function saveLieu( event ){
        let btnSave = $( this );
        let lieuId = btnSave.attr( 'data-id' );
        let inputLieu = $( '#inpt-' + lieuId );
        let inputCodePostal = $( '#inpt-cp-' + lieuId );
        let btnAdd = $( this );
        let url = btnAdd.attr( 'data-url' ) + '/editer/' + lieuId + '/nom/' + inputLieu.val() + '/code-postal/' + inputCodePostal.val();
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
    $('body').on( 'input', '#inpt-lieu-search', searchLieu );

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
    $('body').on( 'input', '#recherche', autocompleteVille );

    function autocompleteVille( event ){
    debugger;
        let inptAutocomplete = $(this);
        let stringToComplete = inptAutocomplete.val();

        if( stringToComplete == null || stringToComplete == '' ) {
            stringToComplete = 'empty';
        }

        let url = inptAutocomplete.attr( 'data-url' ) + '/' + stringToComplete;

        $.get( url, function(){
            // alert( 'success' );
        }).done( function( response ){
            $('#recherche').autocomplete({
                source : response, // on inscrit la liste de suggestions
                minLength : 3 // on indique qu'il faut taper au moins 3 caractères pour afficher l'autocomplétion
            });
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }