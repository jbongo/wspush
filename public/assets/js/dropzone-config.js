var total_photos_counter = 0;

Dropzone.options.fileupload = {
    // uploadMultiple: true,
    parallelUploads: 20,
    maxFilesize: 20,
    //previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Supprimer',
    dictFileTooBig: 'Cette image depasse 20MB',
    acceptedFiles : 'image/*',
    timeout: 20000,
 
    init: function () {
        this.on("removedfile", function (file) {
            $.post({
                url: '/images-delete',
                data: {id: file.name, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    total_photos_counter--;
                    $("#counter").text("# " + total_photos_counter);
                }
            });
        });
    },
    success: function (file, done) {
        total_photos_counter++;
        $("#counter").text("# " + total_photos_counter);
    }
};