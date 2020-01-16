humhub.module('gardian', function (module, require, $) {


    $('body').on('click','#download_dataset',function(e){

        console.log("OK");

        $('#loader').show();

        var datasets = [];
        $.each($("input[name='selection[]']:checked"), function(){
            datasets.push(JSON.parse($(this).val()));
        });
        $.post({
            url: './download',
            dataType: 'json',
            data: {datasets: datasets},
            success: function(data) {
                $('#loader').hide();
            },
            error: function (data) {
                $('#loader').hide();
            }
        });

    });
});
