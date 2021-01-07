$(document).ready(function () {
    
    $('.custom-file-input').on('change', function (e) {
        let inputFile = e.currentTarget;
        alert(inputFile);
        $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
    });
});
