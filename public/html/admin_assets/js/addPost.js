jQuery.noConflict();

jQuery(document).ready(function () {
    jQuery('#uploadMultiple').on('change', function () {
        var filesAmount = this.files.length;

        for (var i = 0; i < filesAmount; i++) {
            var html = '<tr class="preview">' +
                    '<td class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><img width="70" height="70" class="preview-image"></td>' +
                    '<td  class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><a href="javascript:void(0)" class="btn btn-danger delete-image"><i class="fa fa-trash"></i></a></td>';
            jQuery('.files').append(html);
            jQuery('.files img.preview-image').last().attr('src', URL.createObjectURL(this.files[i]));
        }
    });

    jQuery(document).on('click', 'a.delete-image', function (e) {
        e.preventDefault();
        jQuery(this).closest('tr.preview').remove();
    });


    jQuery('#submitEditPost').on('click', function (e) {
        e.preventDefault();
        let newGalleries = [];
        jQuery("img.preview-image").each(function (index) {
            if (jQuery(this).attr('src') !== undefined) {
                newGalleries.push(jQuery(this).attr('src'));
            }
        });
        jQuery('#newGalleries').val(JSON.stringify(newGalleries));
        console.log(jQuery('#newGalleries').val());
        return false;
        jQuery('#editPostForm').submit();
    });
})
