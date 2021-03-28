jQuery(function () {
    'use strict';

    jQuery(document).ready(function () {
        jQuery('#submitEditPost').on('click', function (e) {
            e.preventDefault();
            let newGalleries = [];
            jQuery("img.preview-image").each(function( index ) {
                if (jQuery(this).attr('alt') !== undefined) {
                    newGalleries.push(jQuery(this).attr('alt') );
                }
            });
            jQuery('#newGalleries').val(JSON.stringify(newGalleries));

            jQuery.each(jQuery('input.money'), function (index, value) {
              jQuery(value).val(jQuery(value).val().replace(/[.]/g,""));
              jQuery(value).val(jQuery(value).val().replace(/[,]/,"."));
            });
            
            jQuery('#editPostForm').submit();
        });
        jQuery.each(jQuery('input.money'), function (index, value) {
            jQuery(value).val(formatMoney(jQuery(value).val(), 0,',','.'));
        });
        jQuery('input.int').on('change', function (e) {
            let input = jQuery(this).val().replace(/[.]/g,"");
            jQuery(this).val(formatMoney(input, 0,',','.'))
        });
        jQuery("input.money").on("keypress",function (event) {
            jQuery(this).val(jQuery(this).val().replace(/[^\d]/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        function formatMoney(n, c, d, t) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;

            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "jQuery1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        }
    })
});