humhub.module('gardian', function (module, require, $) {


    $('body').on('click','#download_dataset',function(e){
        $('#loader').show();

        var datasets = [];
        $.each($("input[name='selection[]']:checked"), function(){
            datasets.push(JSON.parse($(this).val()));
        });
        $.post({
            url: './search/download',
            dataType: 'json',
            data: {datasets: datasets},
            success: function(data) {

                if(data.notAccessible == "true"){
                    block = "Download Complete! Some files are restricted and cannot be stored";
                }else if(data.notAccessible == "false"){
                    block = "Download Complete!";
                }

                url = "https://labs.scio.systems/index.php/u/"+data.username+"/globusfiles/browse";

                link = "<a style=\"text-decoration: underline\" " +
                    "href="+url+"> here</a>";

                block = block+" Click "+link+" to explore the downloaded datasets!";
                block = '<div id="result-message">'+block+'</div>';


                $('#result-message').remove();
                $('#download-content').append(block);
                $('#download-results').show();

                $('#loader').hide();
            },
            error: function (data) {
                $('#loader').hide();
            }
        });

    });
});
