jQuery(function($) {'use strict',

//#main-slider
$(function(){
	$('#main-slider.carousel').carousel({
		interval: 8000
	});
});


// accordian
$('.accordion-toggle').on('click', function(){
	$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
	});

	$(this).closest('.panel-heading').toggleClass('active');
});

//Initiat WOW JS
new WOW().init();

// portfolio filter
$(window).load(function(){'use strict';
var $portfolio_selectors = $('.portfolio-filter >li>a');
var $portfolio = $('.portfolio-items');
$portfolio.isotope({
	itemSelector : '.portfolio-item',
	layoutMode : 'fitRows'
});

$portfolio_selectors.on('click', function(){
	$portfolio_selectors.removeClass('active');
	$(this).addClass('active');
	var selector = $(this).attr('data-filter');
	$portfolio.isotope({ filter: selector });
	return false;
});
});

// Contact form
var form = $('#main-contact-form');
form.submit(function(event){
	event.preventDefault();
	var form_status = $('<div class="form_status"></div>');
	$.ajax({
		url: $(this).attr('action'),

		beforeSend: function(){
			form.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Veuillez Patienter ... </p>').fadeIn() );
		}
	}).done(function(data){
		form_status.html('<p class="text-success">' + data.message + '</p>').delay(3000).fadeOut();
	});
});

setTimeout(function() { // start a delay
	var fade = document.getElementById("fade"); // get required element
	fade.style.opacity = 1; // set opacity for the element to 1
	var timerId = setInterval(function() { // start interval loop
		var opacity = fade.style.opacity; // get current opacity
		if (opacity == 0) { // check if its 0 yet
			clearInterval(timerId); // if so, exit from interval loop
		} else {
			fade.style.opacity = opacity - 0.05; // else remove 0.05 from opacity
		}
	}, 100); // run every 0.1 second
}, 5000); // wait to run after 5 seconds

//goto top
$('.gototop').click(function(event) {
	event.preventDefault();
	$('html, body').animate({
		scrollTop: $("body").offset().top
	}, 500);
});

//Pretty Photo
$("a[rel^='prettyPhoto']").prettyPhoto({
	social_tools: false
});
});
