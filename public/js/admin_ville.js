    const tableVille = '#table-ville';

// ADD
    $('body').on('click', '#btn-add-ville', addVille );

    function addVille( event ){
        let inputVille = $( '#inpt-add-ville' );
        let inputVilleValue = inputVille.val();

        let inputCodePostal = $( '#inpt-add-cp' );
        let inputCodePostalValue = inputCodePostal.val();

        let btnAdd = $( this );
        let url = btnAdd.attr( 'data-url' ) + '/ajouter/ville/' + inputVilleValue + '/cp/' + inputCodePostalValue;

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
        let btnRemove = $( this );
        let url = btnRemove.attr( 'data-url' );

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
        let inputVille = $( '#inpt-' + villeId );
        let inputCodePostal = $( '#inpt-cp-' + villeId );
        let btnAdd = $( this );
        let url = btnAdd.attr( 'data-url' ) + '/editer/' + villeId + '/nom/' + inputVille.val() + '/code-postal/' + inputCodePostal.val();
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
    $('body').on( 'input', '#inpt-ville-search', searchVille );

    function searchVille( event ){
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
            $( tableVille ).html( response );
        }).fail( function( response ){
            // alert( 'fail' );
        }).always( function( response ){
            // alert( 'alway' );
        });
    }