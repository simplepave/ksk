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

        let item = $(popupID).find('input.input_popup');

        item.each(function(e) {
            let t = $(this).val('');

            if (typeof t.attr('data-value') !== 'undefined')
                t.removeAttr('data-value');
        });

        $(popupID).find('.message-accepted').remove();
    });

    $('#popup-data-checking').on('focus', 'input[data-value]', function(e) {
        $(this).val($(this).attr('data-value')).removeAttr('data-value');
    });

    $('#popup-data-checking').on('change', 'input[name="cc"]', function(e) {
        $(this).parent('.check_box').find('.message-accepted').remove();
    });

    /**
     * form Data Checking
     */

     $('body').on('submit', '#form-data-checking', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        t.find('input[data-value]').each(function(e) {
            $(this).val($(this).attr('data-value')).removeAttr('data-value');
        });

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
                if (json.status == 'error') {
                    $.each(json.message, function(index, value) {
                        let item = t.find('input[name="' + index + '"]');

                        if (item.length) {
                            let message = '';

                            for (var obj in value) {
                                let i = Object.keys(value).indexOf(obj);
                                if (i === 0) {
                                    message = value[obj];
                                    break;
                                }
                            }
                            if (index === 'cc') {
                                let accepted = $('.message-accepted');

                                if (accepted.length) accepted.html(message);
                                else item.before('<span class="message-accepted">' + message + '</span>')
                            }
                            else
                                item.attr('data-value', item.val().trim()).val(message);
                        }
                    });
                }
                else {
                    let message = '';

                    $.each(json.message, function(index, value) {
                        let color = value.status? 'green': 'red';
                        message += '<p data-message="' + index + '" class="message-data-checking" style="color: ' + color + ';">' + value.title + '</p>';
                    });

                    t.before(message).hide();
                    if (json.paymentURL) document.location.href = json.paymentURL;
                }
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