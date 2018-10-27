/**
 * SimplePAVE
 * info@simplepave.ru
 */

jQuery(document).ready(function($){

    /**
     * Woo Order
     */

     $('body').on('submit', '#woo-order-form', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        $.ajax({
            type: 'post',
            data: t.serialize() + '&action=woo-order&nonce_code=' + spAjax.nonce,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                btn.addClass('working')
                .css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                btn.removeClass('working')
                .css({'filter': 'none'});
            },
            success: function(json) {
                if (json.response)
                    t.prev().css('color', 'green').text(json.message);
                else
                    t.prev().css('color', 'red').text(json.message);

                t.remove();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /**
     * Feedback Mail form
     */

     $('body').on('submit', '#feedback-form', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        $.ajax({
            type: 'post',
            data: t.serialize() + '&action=feedback&nonce_code=' + spAjax.nonce,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                btn.addClass('working')
                .css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                btn.removeClass('working')
                .css({'filter': 'none'});
            },
            success: function(json) {
                if (json.response)
                    t.prev().css('color', 'green').text(json.message);
                else
                    t.prev().css('color', 'red').text(json.message);

                t.remove();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /**
     * Order Write Mail form
     */

     $('body').on('submit', '#order-form, #write-form', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        $.ajax({
            type: 'post',
            data: t.serialize() + '&action=order-write&nonce_code=' + spAjax.nonce,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                btn.addClass('working')
                .css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                btn.removeClass('working')
                .css({'filter': 'none'});
            },
            success: function(json) {
                if (json.response)
                    t.prev().css('color', 'green').text(json.message);
                else
                    t.prev().css('color', 'red').text(json.message);

                t.remove();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /**
     * Phone
     */

    var phonemask = $('.phone-mask');
    if (phonemask.length)
    phonemask.inputmask({
        mask: '+7 (999) 999-99-99',
        clearMaskOnLostFocus: true,
        clearIncomplete: true
    });
});