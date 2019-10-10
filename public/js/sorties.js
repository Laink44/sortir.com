$(function () {
    $(document).ready(function() {
        $(".loader").removeAttr("style").hide();
        // you may need to change this code if you are not using Bootstrap Datepicker
        $('.js-datepicker').datepicker({
            format: 'yyyy-mm-dd HH:mm'
        });

        $( "#find_sorties_NotRegisterFilter").change(function() {
            if( $( "#find_sorties_NotRegisterFilter").is(":checked")) {
                if ($("#find_sorties_RegisterFilter").is(":checked")){
                    $("#find_sorties_RegisterFilter").prop("checked", false);
                }
            }
        });

        $( "#find_sorties_RegisterFilter").change(function() {

            if($( "#find_sorties_RegisterFilter").is(":checked")) {

                if ($("#find_sorties_NotRegisterFilter").is(":checked")){
                    $("#find_sorties_NotRegisterFilter").prop("checked", false);
                }
            }
        });
    });
    $('form').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'table',
            data: $('form').serialize(),
            success: function (response) {
                console.log(response);
                $("#table-ville" ).html( response );
                hookSubcribe_unsubcribe();
            }
        });

    });


function hookSubcribe_unsubcribe() {
    $('.unregister').on('click', function (e) {
        var _data = { table_csrf_token: $('#table-sorties').attr('data-csrf'),
            sortie: parseInt($(this).attr("data-id"))};

        e.preventDefault();
        $(".loader").show();
        $.ajax({
            type: 'post',
            url: 'sortie/unregister',
            data: _data,
            success: function (response) {
                $(".loader").hide();
                $("#table-ville" ).html( response );
                hookSubcribe_unsubcribe();
            }
        });
    });

    $('.register').on('click', function (e) {
        var _data = { table_csrf_token: $('#table-sorties').attr('data-csrf'),
            sortie: parseInt($(this).attr("data-id"))};

        e.preventDefault();
        $(".loader").show();
        $.ajax({
            type: 'post',
            url: 'sortie/register',
            data: _data,
            success: function (response) {
                $(".loader").hide();
                $("#table-ville" ).html( response );
                hookSubcribe_unsubcribe();
            }
        });
    });

    $('.cancel').on('click', function (e) {
        var _data = { table_csrf_token: $('#table-sorties').attr('data-csrf'),
            sortie: parseInt($(this).attr("data-id"))};

        console.log(_data);
        e.preventDefault();
        $(".loader").show();
        $("#table-ville" ).hide();
        $.ajax({
            type: 'post',
            url: 'sortie/cancel',
            data: _data,
            success: function (response) {

                $("#table-ville" ).html( response );
                //$(".loader").hide()
                $("#table-ville" ).show();
                hookSubcribe_unsubcribe();
            }
        });
    });
}
    hookSubcribe_unsubcribe();
});