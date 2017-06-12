jQuery(document).ready(function ($) {

    var pzmp_wcmg = $('.images');
    var pzmp_wcmg_zoom = $('.pzmp_magnifier_zoom');
    var pzmp_wcmg_image = $('.pzmp_magnifier_zoom img');

    var pzmp_wcmg_default_zoom = pzmp_wcmg.find('.pzmp_magnifier_zoom').attr('href');
    var pzmp_wcmg_default_image = pzmp_wcmg.find('.pzmp_magnifier_zoom img').attr('src');

    pzmp_wcmg.pzmp_magnifier(pzmppp_magnifier_options);

    $(document).on('found_variation', 'form.variations_form', function (event, variation) {
        var image_magnifier = variation.image_magnifier ? variation.image_magnifier : pzmp_wcmg_default_zoom;
        var image_src = variation.image_src ? variation.image_src : pzmp_wcmg_default_image;

        pzmp_wcmg_zoom.attr('href', image_magnifier);
        pzmp_wcmg_image.attr('src', image_src);
        pzmp_wcmg_image.attr('srcset', image_src);
        pzmp_wcmg_image.attr('src-orig', image_src);

        if (pzmp_wcmg.data('pzmp_magnifier')) {
            pzmp_wcmg.pzmp_magnifier('destroy');
        }

        pzmp_wcmg.pzmp_magnifier(pzmppp_magnifier_options);
    }).on('reset_image', function (event) {
        pzmp_wcmg_zoom.attr('href', pzmp_wcmg_default_zoom);
        pzmp_wcmg_image.attr('src', pzmp_wcmg_default_image);
        pzmp_wcmg_image.attr('srcset', pzmp_wcmg_default_image);
        pzmp_wcmg_image.attr('src-orig', pzmp_wcmg_default_image);

        if (pzmp_wcmg.data('pzmp_magnifier')) {
            pzmp_wcmg.pzmp_magnifier('destroy');
        }

        pzmp_wcmg.pzmp_magnifier(pzmppp_magnifier_options);
    })

    $('form.variations_form .variations select').trigger('change');
});