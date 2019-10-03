// ADD
    $('body').on('click', '#btn-add-site', addSite );

    function addSite( event ){
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
    $('body').on('click', '.btn-remove-site', removeSite );

    function removeSite( event ){
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


// EDIT
    $('body').on('click', '.btn-edit-site', editSite );

    function editSite( event ){
        let btnEdit = $( this );
        btnEdit.prop( 'disabled', true );
        btnEdit.addClass( 'btn-common-disabled' );

        let siteId = btnEdit.attr( 'data-id' );
        let inputToEnable = $( '#inpt-' + siteId );
        inputToEnable.prop( 'disabled', false );

        let btnSave = $( '#btn-save-site-' + siteId );
        btnSave.removeClass( 'btn-common-disabled' );
        btnSave.prop( 'disabled', false );
    }

// SAVE
    $('body').on('click', '.btn-save-site', saveSite );

    function saveSite( event ){
        let btnSave = $( this );
        let siteId = btnSave.attr( 'data-id' );
        let inputSite = $( '#inpt-' + siteId );
        let url = btnSave.attr( 'data-url' ) + '/' + inputSite.val();

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

// SEARCH
    $('body').on( 'input', '#inpt-site-search', searchSite );

    function searchSite( event ){
        let inptSearch = $(this);
        let stringToSearch = inptSearch.val();

        if( stringToSearch == null || stringToSearch == '' ) {
            stringToSearch = 'empty';
        }

        let url = inptSearch.attr( 'data-url' ) + '/' + stringToSearch;

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