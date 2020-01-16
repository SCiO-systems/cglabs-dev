humhub.module('gardian', function (module, require, $) {


    $('#download_dataset').on('click',function(e){

        console.log("OK");

        var datasets = [];
        $.each($("input[name='selection[]']:checked"), function(){
            datasets.push(JSON.parse($(this).val()));
        });
        $.post({
            url: './download',
            dataType: 'json',
            data: {datasets: datasets},
            success: function(data) {
            },
        });

    });
});
