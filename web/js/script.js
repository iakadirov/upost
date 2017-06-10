$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();

	$(document).on('click','#userSettings',function(e){
		if($('.settings')[0].style.display == 'none'){
			$('.settings').fadeIn();
		}else{
			$('.settings').fadeOut();
		}
	});

	$(document).on('click','.settings',function(e){
		e.stopPropagation();
	});

	$("body").click(function (event) {
		if ($(event.target).closest(".settings").length === 0) {
			$('.settings').fadeOut();
		}
	});

	$('.post2').css({"height":$('.post2').height()+"px"});
	$('.close-alert').click(function(){
		$(this).parent().remove();
	});
	$('body').on('click', '#mobileMenu li.button', function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open');
		}else{
			$(this).addClass('open');
		}
	});

	$('.signin-panel input, .signup-panel input').focus(function(){
		$(this).prev('label').animate({
		  top: "-2px"
		}, 100 );
		$(this).css({
		  borderColor: "#61718a"
		}, 100 );
    $(this).focusout(function () {
      if ($(this).val() == ''){
        $(this).prev('label').animate({
				  top: "20px"
				}, 100 );
				$(this).css({
				  borderColor: "#c3d2eb"
				}, 100 );
      }else{
      	$(this).css({
				  borderColor: "#61718a"
				}, 100 );
      }
    });
	});

	$("#header").headroom();

	$('body').on('click', '.grid-filter a', function(){
		gridColumn($(this));
	});

	
	if ($(window).width() <= 600){
		mobileNavbarVisible();
	}else{
		mobileNavbarHidden();
	}
	if ($(window).width() <= 1024 && $(window).width() > 600){
		var LiLength = $('header nav.top-nav ul.menu li.menu-li').length;
		navbarMobileAdaptive(3,LiLength);
	}
	if ($(window).width() > 1024){
		var Li2Length = $('header nav.top-nav ul.menu li.dropdown ul.dropdown-menu li').length;
		navbarMobileNoAdaptive(3,Li2Length);
	}

	$(window).resize(function(){
		$('.post2').css({"height":"100%"});
		$('.post2').css({"height":$('.post2').height()+"px"});
		if ($(window).width() <= 1024 && $(window).width() > 600){
			var LiLength = $('header nav.top-nav ul.menu li.menu-li').length;
			navbarMobileAdaptive(3,LiLength);
		}
		if ($(window).width() > 1024){
			var Li2Length = $('header nav.top-nav ul.menu li.dropdown ul.dropdown-menu li').length;
			navbarMobileNoAdaptive(3,Li2Length);
		}
		if ($(window).width() <= 600){
			mobileNavbarVisible();
		}else{
			mobileNavbarHidden();
		}
	});
	// var loaderTop = 1000;
	// $(window).scroll(function(){
	// 	var contentLoader = $("#contentLoader").offset();
	// 	loaderTop = $(window).scrollTop() - contentLoader.top;
	// 	if (loaderTop < 750){
	// 		$("#contentLoader").show();
	// 		setTimeout(function(){
	// 			$(".category-content").append('<figure class="category-block">'
	// 							+'<img src="img/m.jpg">'
	// 							+'<a href="#"><h2>2 O‘zbekiston Birinchi Prezidenti Islom Karimov tavallud sanasi munosabati bilan mamlakat bo‘ylab turli tadbirlar bo‘lib o‘tmoqda</h2></a>'
	// 							+'<ul>'
	// 								+'<a><img src="img/clock.png"> 1 daqiqa avval</a>'
	// 								+'<a href="#"><img src="img/tag.png"> Islom Karimov</a>'
	// 								+'<a href="#">Saqlab qo‘yish</a>'
	// 							+'</ul>'
	// 						+'</figure>');
	// 			$("#contentLoader").hide();
	// 		}, 1000);
	// 	}
	// });

});

/*var loading = false;
	$(window).scroll(function(){
		if((($(window).scrollTop()+$(window).height())+250)>=$(document).height()){
		  if(loading == false){
		  	loading = true;
		  	$('#contentLoader').show();
			  setTimeout(function(){
					for (var i = 10; i >= 1; i--) {
						$(".category-content").append('<figure class="category-block">'
									+'<img src="img/m.jpg">'
									+'<a href="#"><h2>'+i+' O‘zbekiston Birinchi Prezidenti Islom Karimov tavallud sanasi munosabati bilan mamlakat bo‘ylab turli tadbirlar bo‘lib o‘tmoqda</h2></a>'
									+'<ul>'
										+'<a><img src="img/clock.png"> 1 daqiqa avval</a>'
										+'<a href="#"><img src="img/tag.png"> Islom Karimov</a>'
										+'<a href="#">Saqlab qo‘yish</a>'
									+'</ul>'
								+'</figure>');
					}
					$("#contentLoader").hide();
			  	loading = false;
				}, 500);
		  }
		}
});*/


// (function() {
// 	var header = new Headroom(document.querySelector("#header"), {
// 	  tolerance: 5,
// 	  offset : 205,
// 	  classes: {
// 	    initial: "animated",
// 	    pinned: "slideDown",
// 	    unpinned: "slideUp"
// 	  }
// 	});
// 	header.init();

// 	var bttHeadroom = new Headroom(document.getElementById("btt"), {
// 	  tolerance : 0,
// 	  offset : 500,
// 	  classes : {
// 	      initial : "slide",
// 	      pinned : "slide--reset",
// 	      unpinned : "slide--down"
// 	  }
// 	});
// 	bttHeadroom.init();
// }());

function gridColumn(thisis){
	$(".category-blocks .category-content").css({'opacity':'0.2'});

	if (thisis.attr('id') == 'gridList'){
		if($(".category-blocks .category-content").hasClass('column')){
			$(".category-blocks .category-content").removeClass('column');
		}
	}
	if (thisis.attr('id') == 'gridColumn'){
		if(!$(".category-blocks .category-content").hasClass('column')){
			$(".category-blocks .category-content").addClass('column');
		}
	}

	$('.category-blocks .grid-filter a').removeClass('active');
	thisis.addClass('active');
	setTimeout(function(){
		$(".category-blocks .category-content").css({'opacity':'1'});
	}, 1000);
}

function navbarMobileAdaptive($list = 0,LiLength){
	if (LiLength == 10){
		for (var i = LiLength; i >= 0; i--){
			if (i >= (LiLength - $list)){
				$('header nav.top-nav ul.menu li.dropdown ul.dropdown-menu').prepend($("header nav.top-nav ul.menu li.menu-li").eq(i));
			}
		}
	}
}
function navbarMobileNoAdaptive($list = 0,Li2Length){
	if (Li2Length > 5){
		$('ul.menu li.dropdown ul.dropdown-menu li').each(function(i){
      if (i < $list){
      	$('ul.menu li.dropdown').before($(this));
      }
    });
	}
}

function mobileNavbarVisible(){
	$("#mobileMenu").remove();
	$('.top-nav .logo').before('<ul id="mobileMenu"><li class="button"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 459 459" xml:space="preserve"><g><g id="menu"><path d="M0,382.5h459v-51H0V382.5z M0,255h459v-51H0V255z M0,76.5v51h459v-51H0z"/></g></g></svg><ul></ul></li></ul>');
	$('ul.menu li.menu-li').each(function(i){
    $('ul#mobileMenu li.button ul').append($(this).clone());
  });
  $('ul.dropdown-menu li').each(function(i){
    $('ul#mobileMenu li.button ul').append($(this).clone());
  });
  $('ul.menu').hide();
}
function mobileNavbarHidden(){
	$("#mobileMenu").remove();
	$('ul.menu').show();
}

function addEvent(elem, type, handler){
  if(elem.addEventListener){
    elem.addEventListener(type, handler, false);
  } else {
    elem.attachEvent('on'+type, handler);
  }
  return false;
}

