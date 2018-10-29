// JavaScript Document
jQuery(document).ready(function($) {

    function fnPfee() {
        let i = (P * 0.01)/12, n = F * 12;
        let K = i * (Math.pow((1 + i), n)) / ((Math.pow((1 + i), n)) - 1);
        let A = K * S;

        let output = new Intl.
                        NumberFormat('ru-RU', {style: 'currency', currency: 'RUB'})
                        .format(A.toFixed(2));

        $('.js-payment').val(output);
    }

    setTimeout(fnPfee, 1000);

	var S = $('.js-price').val();
    var F = $('.js-fee').val();
	var P = $('.js-percent').val();

	/**
     * S => Сумма кредита
     */

	var priceS = $('#tabSlider1').ionRangeSlider({
		min: 1000,
		max: 100000000,
        from: 25000,
        to : 15000000,
		step: 5000,
		onChange: function(ui) {
			$('.js-price').val(ui.from);
			S = ui.from;
			fnPfee();
		}
	});

	$('.js-price').val($('#tabSlider1').data('from'));

	$('.js-price').keyup(function(e) {
        var s = $(this).val().replace(/[^\d]/g, '');
        if (s > 100000000) s = 100000000;
        $(this).val(s);

		S = $(this).val();
        inst = priceS.data('ionRangeSlider');
		inst.update({'from' : S});

		fnPfee();
	});

    /**
     * F => Срок кредита
     */

	var priceFeS = $('#tabSlider3').ionRangeSlider({
		from : 3,
        to : 30,
		min: 1,
		max: 30,
		step: 1,
		onChange: function(ui) {
			$('.js-fee').val(ui.from);
			F = ui.from;
			fnPfee();
		}
	});

	$('.js-fee').val($('#tabSlider3').data('from'));

	$('.js-fee').keyup(function(e) {
        var s = $(this).val().replace(/[^\d]/g, '');
        if (s > 30) s = 30;
        $(this).val(s);

		F = $(this).val();
        inst = priceFeS.data('ionRangeSlider');
		inst.update({'from' : F});

		fnPfee();
	});

    /**
     * P => Ставка
     */

	var percentPS = $('#tabSlider7').ionRangeSlider({
		from : 1.50,
        to : 30,
		min: 0.01,
		max: 30,
		step: 0.01,
		onChange: function(ui) {
			$('.js-percent').val(ui.from);
			P = ui.from;
            fnPfee();
		}
	});

	$('.js-percent').val($('#tabSlider7').data('from'));

	$('.js-percent').keyup(function(e) {
        var s = $(this).val().replace(/[^\d.]/g, '');

        let re = /^\d+\.?(\d{1,2})?$/;
        if (s && !re.test(s)) s = P;

        let ren = /^\d+\.0?$/;

        if (0 !== s.length && !ren.test(s))
            s = (s == '0.00')? '0.01': Number(s);

        if (s > 30) s = 30;
		$(this).val(s);

		P = $(this).val();
		inst = percentPS.data('ionRangeSlider');
		inst.update({'from' : P});

        fnPfee();
	});
});