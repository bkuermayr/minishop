/*$(document).ready(function(){
    $('#productimages').on('change',function(){
        var filesToUpload = $(this).prop('files');
        
        for(let i = 0; i < filesToUpload.length; i++) {
            var file = filesToUpload[i];
            var fileType = file.type;
            var match = ['image/jpeg', 'image/png', 'image/jpg'];
            if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))){
                $(".errorImg").html('<br/>Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
                $('#productimages').val('');
                return false;
            }
        }
    
        log(filesToUpload);
        $.ajax({
            url:'../forms/createarticle.php',
            type: 'post',
            data: filesToUpload.serialize(),
            success: function(result) {
                log(result);
            },
            failure: function(error) {
                log(error);
            }
        });
    });
});

function log(text) {
    console.log(text);
}*/
