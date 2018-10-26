// JavaScript Document
jQuery(document).ready(function($) {

	var C = $('.js-price').val(); 
	var K = $('.js-p-price').val();
	var F = $('.js-fee').val();
	var P = $('.js-percent').val();
	var T = $('.js-period').val();

	var cre = C - F;
	var per = P/12;
	var mes = T * 12;

	var type_price = 0;
	var type_summa = 0;

	var pfee = F * 100 / C;



	$('input[name=paymentType]').change(function(){
		if ($(this).val() == 'ann'){
			type_price = 0;
		}else{
			type_price = 1;
		}
	});

	$('input[name=paymentTypeSumm]').change(function(){
		if ($(this).val() == 'ann'){
			type_summa = 0;
		}else{
			type_summa = 1;
		}
	});

	/*block type*/
	/*$('.js-ann').click(function(e) {
		$('.js-dif').css('background', '#fff');
		$('.js-ann').css('background', '#ccc');

		type_price = 0;
	});
	$('.js-dif').click(function(e) {
		$('.js-dif').css('background', '#ccc');
		$('.js-ann').css('background', '#fff');

		type_price = 1;
	});

	$('.js-p-ann').click(function(e) {
		$('.js-p-dif').css('background', '#fff');
		$('.js-p-ann').css('background', '#ccc');

		type_summa = 0;
	});
	$('.js-p-dif').click(function(e) {
		$('.js-p-dif').css('background', '#ccc');
		$('.js-p-ann').css('background', '#fff');

		type_summa = 1;
	});*/

	/*block price*/
	var priceS = $('#tabSlider1').ionRangeSlider({
		min: 1000,
		max: 70000,
        from: 10000,
        to : 15000000,
		step: 100,
		onFinish: function(ui) {
			$('.js-price').val(ui.from);
			C = ui.from;

			pfee = F * 100 / C;
			fnPfee();
		}
	});
    
	$('.js-price').val($('#tabSlider1').data('from'));
    
	$('.js-price').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		C = $(this).val();
        inst = priceS.data('ionRangeSlider');
		inst.update({'from' : C}); 
        
		pfee = F * 100 / C;
		fnPfee();
	});

	var priceFeS = $('#tabSlider3').ionRangeSlider({
		from : 10,
        to : 30,
		min: 1,
		max: 30,
		step: 1,
		onFinish: function(ui) {
			$('.js-fee').val(ui.from);
			F = ui.from;
			pfee = F * 1 / C;
			fnPfee();
		}
	});
    
	$('.js-fee').val($('#tabSlider3').data('from'));
    
	$('.js-fee').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		F = $('.js-fee').val();
		
        inst = priceFeS.data('ionRangeSlider');
		inst.update({'from' : F}); 
        
		pfee = F * 100 / C;
		fnPfee();
	});

	function fnPfee() {
		$('.js-pfee').val((pfee).toFixed(2));
	}
	fnPfee();

	var prcS = $('#tabSlider4').ionRangeSlider({
	    from : 10,
        to : 30,
		min: 1,
		max: 30,
		step: 0.1,
		onFinish: function(ui) {
			$('.js-percent').val(ui.from);

			P = ui.from;
		}
	});
    
	$('.js-percent').val($('#tabSlider4').data('from'));
    
	$('.js-percent').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		P = $('.js-percent').val().replace(/,/, '.');
        inst = prcS.data('ionRangeSlider');
		inst.update({'from' : P}); 
	});

	var periodS = $('#tabSlider5').ionRangeSlider({
		from : 2,
        to : 30,
		min: 1,
		max: 30,
		step: 1,
		onFinish: function(ui) {
			$('.js-period').val(ui.from);
			T = ui.from;
		}
	});
	$('.js-period').val($('#tabSlider5').data('froms'));
	$('.js-period').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		T = $('.js-period').val();
		inst = periodS.data('ionRangeSlider');
		inst.update({'from' : T});
	});

	var pricePS = $('#tabSlider6').ionRangeSlider({
		from : 100000,
        to : 15000000,
		min: 100000,
		max: 15000000,
		step: 1000,
		onFinish: function(ui) {
			$('.js-p-price').val(ui.from);
			K = ui.from;
		}
	});
	$('.js-p-price').val($('#tabSlider6').data('from'));
    
	$('.js-p-price').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		K = $('.js-p-price').val();
		inst = pricePS.data('ionRangeSlider');
		inst.update({'from' : K});
	});

	var percentPS = $('#tabSlider7').ionRangeSlider({
		from : 2,
        to : 30,
		min: 1,
		max: 30,
		step: 1,
		onFinish: function(ui) {
			$('.js-p-percent').val(ui.from);
			P = ui.from;
		}
	});
	$('.js-p-percent').val($('#tabSlider7').data('from'));
    
	$('.js-p-percent').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		P = $('.js-p-percent').val().replace(/,/, '.');
		inst = percentPS.data('ionRangeSlider');
		inst.update({'from' : P});
	});

	var periodPS = $('#tabSlider8').ionRangeSlider({
		from : 15,
        to : 30,
		min: 1,
		max: 30,
		step: 1,
		onFinish: function(ui) {
			$('.js-p-period').val(ui.from);
			T = ui.from;
		}
	});
	$('.js-p-period').val($('#tabSlider8').data('from'));
	$('.js-p-period').keyup(function(e) {
		$(this).val($(this).val().replace(/[^\d,]/g, ''));

		T = $('.js-p-period').val();
		inst = percentPS.data('ionRangeSlider');
		inst.update({'from' : T});
	});

	/*count price*/

	$('.js-pri-count').click(function(e) {
		if(type_price == 0) {
			cre = C - F;
			per = P * 0.01;
			mes = T * 12;

			var k_annuitet = per/12 * (Math.pow((1 + per/12), mes)) / ((Math.pow((1 + per/12), mes)) - 1);

			var a_m_payment = Math.round(cre * k_annuitet);
			var a_m_percent = ((a_m_payment * 100) / C).toFixed(2);

			var a_t_payment = Math.round(a_m_payment * mes);
			var a_t_percent = ((a_t_payment * 100) / C).toFixed(2);

			var a_o_payment = Math.round(a_t_payment - cre);
			var a_o_percent = ((a_o_payment * 100) / cre).toFixed(2);

			$('.js-price-rub').empty().text(a_m_payment + ' руб.');
			$('.js-price-per').empty().text(' (' + a_m_percent + '% стоимости недвижимости)');

			$('.js-cost-rub').empty().text(a_t_payment + ' руб.');
			$('.js-cost-per').empty().text(' (' + a_t_percent + '% стоимости недвижимости)');

			$('.js-over-rub').empty().text(a_o_payment + ' руб.');
			$('.js-over-per').empty().text(' (' + a_o_percent + '% стоимости недвижимости)');

			/**/
			var date = new Date();
			var s_month = date.getMonth() + 1;
			var s_year = date.getFullYear();

			k_annuitet = per/12 * (Math.pow((1 + per/12), mes)) / ((Math.pow((1 + per/12), mes)) - 1);
			s_annuitet = cre * k_annuitet;

			$('.display-table tbody').empty();
            
			for (i = 1; i <= mes; i++) {
			    
				s_month++;
				if(s_month > 11) {
					s_month = 0;
					s_year++;
				}

				p_annuitet = cre * (per / 12);
				cre -= (s_annuitet - p_annuitet);
				ss_annuitet = s_annuitet - p_annuitet;
				//console.log(s_annuitet - p_annuitet);
				$('.display-table tbody').append('<tr><th width="5%">'+i+'</th><th width="20%">'+(s_month+1)+'.'+s_year+'</th><th width="15%" class="text-right">'+s_annuitet.toFixed(2)+'</th><th width="20%" class="text-right">'+ss_annuitet.toFixed(2)+'</th><th width="20%" class="text-right">'+p_annuitet.toFixed(2)+'</th><th width="15%" class="text-right">'+cre.toFixed(2)+'</th></tr>');
			}
		}else if(type_price == 1) {
			cre = C - F;
			per = P * 0.01;
			mes = T * 12;

			var k_differential = cre / mes;
			var t_differential = 0;
			var sp_differential = 0;
			var s_differential = [];

			for(var i = 0; i < mes; i++) {
				t_differential = t_differential + (k_differential + (cre - (k_differential * i)) * per / 12);
				s_differential.push(Number(k_differential + (cre - (k_differential * i)) * per / 12));
			}
			sp_differential = t_differential - cre;

			var d_m_payment = Math.round(s_differential[0]) +'-'+ Math.round(s_differential[s_differential.length-1]);
			var d_m_percent = (((s_differential[s_differential.length-1] + s_differential[0]) / 2 * 100)/cre).toFixed(2);

			var d_t_payment = Math.round(t_differential);
			var d_t_percent = ((t_differential * 100) / cre).toFixed(2);

			var d_o_payment = Math.round(d_t_payment - cre);
			var d_o_percent = ((d_o_payment * 100) / cre).toFixed(2);

			$('.js-price-rub').empty().text(d_m_payment + ' руб.');
			$('.js-price-per').empty().text(' (' + d_m_percent + '% стоимости недвижимости)');

			$('.js-cost-rub').empty().text(d_t_payment + ' руб.');
			$('.js-cost-per').empty().text(' (' + d_t_percent + '% стоимости недвижимости)');

			$('.js-over-rub').empty().text(d_o_payment + ' руб.');
			$('.js-over-per').empty().text(' (' + d_o_percent + '% стоимости недвижимости)');

			/**/
			var date = new Date();

			var s_month = date.getMonth() + 1;
			var s_year = date.getFullYear();

			$('.display-table tbody').empty();

			for (i = 1; i <= mes; i++) {
			 
				s_month++;
				if(s_month > 11) {
					s_month = 0;
					s_year++;
				}

				p_differential = cre * (per / 12);
				m_differential = k_differential + p_differential;
				cre -= k_differential;

				$('.display-table tbody').append('<tr><th width="5%">'+i+'</th><th width="20%">'+(s_month+1)+'.'+s_year+'</th><th width="15%" class="text-right">'+m_differential.toFixed(2)+'</th><th width="20%" class="text-right">'+k_differential.toFixed(2)+'</th><th width="20%" class="text-right">'+p_differential.toFixed(2)+'</th><th width="15%" class="text-right">'+ cre.toFixed(2) +'</th></tr>');
			}
		}
	});

	$('.js-sum-count').click(function(e) {
		if(type_summa == 0) {
			cre = K;
			per = P * 0.01;
			mes = T * 12;

			var k_annuitet = per/12 * (Math.pow((1 + per/12), mes)) / ((Math.pow((1 + per/12), mes)) - 1);

			var a_m_payment = Math.round(cre * k_annuitet);
			var a_m_percent = ((a_m_payment * 100) / cre).toFixed(2);

			var a_t_payment = Math.round(a_m_payment * mes);
			var a_t_percent = ((a_t_payment * 100) / cre).toFixed(2);

			var a_o_payment = Math.round(a_t_payment - cre);
			var a_o_percent = ((a_o_payment * 100) / cre).toFixed(2);

			$('.js-price-rub').empty().text(a_m_payment + ' руб.');
			$('.js-price-per').empty().text(' (' + a_m_percent + '% стоимости недвижимости)');

			$('.js-cost-rub').empty().text(a_t_payment + ' руб.');
			$('.js-cost-per').empty().text(' (' + a_t_percent + '% стоимости недвижимости)');

			$('.js-over-rub').empty().text(a_o_payment + ' руб.');
			$('.js-over-per').empty().text(' (' + a_o_percent + '% стоимости недвижимости)');

			var date = new Date();

			var s_month = date.getMonth() + 1;
			var s_year = date.getFullYear();

			k_annuitet = per/12 * (Math.pow((1 + per/12), mes)) / ((Math.pow((1 + per/12), mes)) - 1);
			s_annuitet = cre * k_annuitet;

			$('.display-table tbody').empty();

			for (i = 1; i <= mes; i++) {
				var monthyear = s_month + ', ' + s_year;

				s_month++;
				if(s_month > 11) {
					s_month = 0;
					s_year++;
				}

				p_annuitet = cre * (per / 12);
				cre -= (s_annuitet - p_annuitet);
				ss_annuitet = s_annuitet - p_annuitet;

				$('.display-table tbody').append('<tr><th width="5%">'+i+'</th><th width="20%">'+(s_month+1)+'.'+s_year+'</th><th width="15%" class="text-right">'+s_annuitet.toFixed(2)+'</th><th width="20%" class="text-right">'+ss_annuitet.toFixed(2)+'</th><th width="20%" class="text-right">'+p_annuitet.toFixed(2)+'</th><th width="15%" class="text-right">'+cre.toFixed(2)+'</th></tr>');
			}
		}else if(type_summa == 1) {
			cre = K;
			per = P * 0.01;
			mes = T * 12;

			var k_differential = cre / mes;
			var t_differential = 0;
			var sp_differential = 0;
			var s_differential = [];

			for(var i = 0; i < mes; i++) {
				t_differential = t_differential + (k_differential + (cre - (k_differential * i)) * per / 12);
				s_differential.push(Number(k_differential + (cre - (k_differential * i)) * per / 12));
			}
			sp_differential = t_differential - cre;

			var d_m_payment = Math.round(s_differential[0]) +'-'+ Math.round(s_differential[s_differential.length-1]);
			var d_m_percent = (((s_differential[s_differential.length-1] + s_differential[0]) / 2 * 100)/cre).toFixed(2);

			var d_t_payment = Math.round(t_differential);
			var d_t_percent = ((t_differential * 100) / cre).toFixed(2);

			var d_o_payment = Math.round(d_t_payment - cre);
			var d_o_percent = ((d_o_payment * 100) / cre).toFixed(2);

			$('.js-price-rub').empty().text(d_m_payment + ' руб.');
			$('.js-price-per').empty().text(' (' + d_m_percent + '% стоимости недвижимости)');

			$('.js-cost-rub').empty().text(d_t_payment + ' руб.');
			$('.js-cost-per').empty().text(' (' + d_t_percent + '% стоимости недвижимости)');

			$('.js-over-rub').empty().text(d_o_payment + ' руб.');
			$('.js-over-per').empty().text(' (' + d_o_percent + '% стоимости недвижимости)');

			/**/
			var date = new Date();

			var s_month = date.getMonth() + 1;
			var s_year = date.getFullYear();

			$('.display-table tbody').empty();

			for (i = 1; i <= mes; i++) {
				s_month++;
				if(s_month > 11) {
					s_month = 0;
					s_year++;
				}

				p_differential = cre * (per / 12);
				m_differential = k_differential + p_differential;
				cre -= k_differential;

				$('.display-table tbody').append('<tr><th width="5%">'+i+'</th><th width="20%">'+(s_month+1)+'.'+s_year+'</th><th width="15%" class="text-right">'+m_differential.toFixed(2)+'</th><th width="20%" class="text-right">'+k_differential.toFixed(2)+'</th><th width="20%" class="text-right">'+p_differential.toFixed(2)+'</th><th width="15%" class="text-right">'+cre.toFixed(2)+'</th></tr>');
			}
		}
	});

	//$('#tabSlider2,#tabSlider3,#tabSlider4,#tabSlider5,#tabSlider6,#tabSlider7,#tabSlider8').ionRangeSlider();

	$('.tab-header__item').on('click', function(event) {
		event.preventDefault();

		$('.tab-content__item').removeClass('active');

		$(this).addClass('active').siblings().removeClass('active')
		.closest('.tabs').find('.tab-content').children().eq($(this).index())
		.addClass('active');
	});

	$('.js-pay-btn').click(function() {
		$('.display-table').toggle('slow');
	});

	$('.js-save-btn').click(function(e) {
		window.print();
	});
});