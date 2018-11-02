/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

jQuery(document).ready(function($){

    /**
     * productID popup
     */

    let productID = false;

    $('a.popup').click(function() {
        let t = $(this);
        let popupID = t.attr('href');

        if (popupID !== '#popup-data-checking') return;

        let id = t.attr('data-order-product');

        if (id) productID = id;
        else productID = false;

        $(popupID).find('form').show();
        $(popupID).find('.message-data-checking').remove();
    });

    /**
     * form Data Checking
     */

     $('body').on('submit', '#form-data-checking', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        var product = Number(productID)? '&product_id=' + Number(productID): '';

        $.ajax({
            type: 'post',
            data: t.serialize() + '&action=data-checking&nonce_code=' + spAjax.nonce + product,
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
                if (json.status == 'success') {
                    t.before('<p class="message-data-checking" style="color: green;">' + json.message + '</p>').hide();
                    if (json.paymentURL) document.location.href = json.paymentURL;
                }

                if (json.status == 'error') {
                    t.before('<p class="message-data-checking" style="color: red;">' + json.message + '</p>').hide();
                }

                if (!json.status)
                    t.before('<p class="message-data-checking" style="color: red;">' + json.message + '</p>').hide();
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