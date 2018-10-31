$(document).ready(function(){

	$('.icon-menu').click(function(event){
		$(this).toggleClass('active');
		$(this).next('div.nav_block').toggleClass('active');
	});

	$('.nav_block ul li a').on('click', function(){
		$('div.icon-menu').removeClass('active');
		$('div.nav_block').removeClass('active');
	});

	$(".popup").magnificPopup({removalDelay:300,type:"inline"});

    if ($('#order-payment').length) {
        $.magnificPopup.open({
            removalDelay: 300,
            items: {
                src: '#order-payment'
            },
            type: 'inline'
        });
    }

    if ($('#message-tinkoff-success').length) {
        $.magnificPopup.open({
            removalDelay: 300,
            items: {
                src: '#message-tinkoff-success'
            },
            type: 'inline'
        });
    }

    if ($('#message-tinkoff-error').length) {
        $.magnificPopup.open({
            removalDelay: 300,
            items: {
                src: '#message-tinkoff-error'
            },
            type: 'inline'
        });
    }

	$('.popup_gallery').magnificPopup({
		 delegate: 'a',
		 type: 'image',
		 gallery: {
			 enabled: true,
			 navigateByImgClick: true,
			 preload: [0, 1]
		 }
	});

	$('select').styler({ selectSearch: true });


	$('.check_box').hover(function(){
    	$('div.hidden_box').stop().fadeIn(150);
		$('div.check').toggleClass('active');
    		}, function () {
        $('div.hidden_box').stop().fadeOut(50);
		$('div.check').stop().removeClass('active');
   	});

	$(function (){
     	if($('#chose_file').length)
      		{
      	$('#chose_file').click(function(){
           	$('#chose_file_input').click();
      		return(false);
      	});
     	$('#chose_file_input').change(function(){
           	$('#chose_file_text').html($(this).val());
          	}).change();
       	}
  	});

});

$(document).ready(function() {
	var owl = $('.our_partners_slider');
    	owl.owlCarousel({
		margin:0,
		nav: true,
		loop: true,
		responsive:{
			0:{
               	items:1
         	},
			480:{
          		items:2
        	},
			 650:{
          		items:3
        	},
			690:{
          		items:4
        	},
         	930:{
          		items:6
        	},
         	1050:{
           		items:7
        	}
		}
	})
})

$(document).ready(function() {
	var owl = $('.reviews_slider');
    	owl.owlCarousel({
		margin:30,
		nav: true,
		loop: true,
		responsive:{
			0:{
				margin:0,
               	items:1
         	 },
         	780:{
          		items:2
        	},
         	1000:{
           		items:2
        	}
		}
	})
})

$(document).ready(function() {
	var owl = $('.reviews_more_slider');
    	owl.owlCarousel({
		margin:0,
		nav: true,
		loop: true,
		items:1
	})
})