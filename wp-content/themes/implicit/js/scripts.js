jQuery.noConflict(); 	
"use strict";	
//DOCUMENT.READY
jQuery(document).ready(function() { 
	//add bootstrap classes to wordpress generated elements
	jQuery('.avatar-70, .avatar-50, .avatar-40').addClass('img-circle');
	jQuery('.comment-reply-link').addClass('btn');
	jQuery('#reply-form input#submit').addClass('btn');
	
	//hide various jQuery elements until they are loaded
	jQuery('#sticky-menus').show();
	jQuery('.headliner').show();	
	
	//superfish
	jQuery('#section-menu ul').superfish({
		hoverClass:  'over',
		delay:       400,
		speed:       100,
		speedOut:    0,
		disableHI:   true,
		autoArrows:  false
	});
	jQuery('.utility-menu ul').superfish({
		hoverClass:  'over',
		delay:       500,
		animation:   {height:'show'},
		speed:       160,
		disableHI:   true,
		autoArrows:  false
	});			
	
	if(jQuery(window).width() > 782) {		
		jQuery(".trending-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			hotSpotScrollingStep: 4,
			hotSpotScrollingInterval: 5
		});		
	} else {
		jQuery(".trending-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "",
			hotSpotScrolling: false,
			touchScrolling: true
		});
	}
	jQuery(".trending-content .scrollableArea").addClass("loop");
	//pinterest
	if(jQuery('#pinterest-social-tab').length > 0) {
		(function(d){
			var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
			p.type = 'text/javascript';
			p.async = true;
			p.src = '//assets.pinterest.com/js/pinit.js';
			f.parentNode.insertBefore(p, f);
		}(document));
	}	
	//facebook
	if(jQuery('#facebook-social-tab').length > 0) {
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&status=0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}	
	//HD images		
	if (window.devicePixelRatio == 2) {	
		var images = jQuery("img.hires");		
		// loop through the images and make them hi-res
		for(var i = 0; i < images.length; i++) {		
			// create new image name
			var imageType = images[i].src.substr(-4);
			var imageName = images[i].src.substr(0, images[i].src.length - 4);
			imageName += "@2x" + imageType;		
			//rename image
			images[i].src = imageName;
		}
	}
	//placeholder text for IE9
	jQuery('input, textarea').placeholder();
	
	//insert content menu items
	jQuery(jQuery('#content-anchor-inner').find('.content-section-divider').get().reverse()).each(function () {
		var id = jQuery(this).attr('id');
		var label = jQuery(this).data('label');
		jQuery( '#content-anchor-wrapper' ).after( '<li><a href="#' + id + '">' + label + '</a></li>' );		
	});	
	//scrollspy	
	if(jQuery('#wpadminbar').length > 0) {
		fromTop = 92;
	} else {
		fromTop = 60;	
	}
	//attach scrollspy
	jQuery('body').scrollspy({ target: '.contents-menu', offset: fromTop });
	//functions that need to run after ajax buttons are clicked
	dynamicElements();
	affixContentsMenu();
});
//WINDOW.LOAD
jQuery(window).load(function() {
	jQuery('.it-widget-tabs').css({'opacity': '1'});
	//tabs - these must go in window.load so pinterest will work inside a tab
	jQuery('.widgets-wrapper .it-social-tabs').tabs({ fx: { opacity: 'toggle', duration: 150 } });
	jQuery('#footer .it-social-tabs').tabs({ active: 2, fx: { opacity: 'toggle', duration: 150 } });		
	jQuery('.share-wrapper').show();
	jQuery('.sharing-wrapper-single').css({'opacity': '1'});
	jQuery('.billboard-avatar').css({'opacity': '1'});
	disqusContentsMenu();		
});
//WINDOW.RESIZE
jQuery(window).resize(function() {
	if(!isTouchDevice()) {
		//adjustStickyNav(true);
		reshowStickyNav();
	}	
	autoSizeText();	
	resizeUtilityMenu();
	jQuery('.video_frame').fitVids();
	jQuery('.activity-inner').fitVids();			
});	
//WINDOW.SCROLL
var lastScrollTop = 0;
jQuery(window).scroll(function() {
	var st = jQuery(this).scrollTop();		
	//back to top arrow
	if (st < 100) {
		jQuery("#back-to-top").fadeOut();
	} else {
		jQuery("#back-to-top").fadeIn();
	}
	//affix sticky nav		
	if (st > lastScrollTop){
		var direction = 'down';
	} else {
		var direction = 'up';
	}
	//affixStickyNav(direction);
	lastScrollTop = st;
	affixContentsMenu();	
});
//applied to elements within ajax panels
function dynamicElements() {
	//setup scroller	
	if(jQuery(window).width() > 782) {		
		jQuery(".scroller-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "always",
			hotSpotScrollingStep: 4,
			hotSpotScrollingInterval: 5
		});		
	} else {
		jQuery(".scroller-content").smoothDivScroll({
			manualContinuousScrolling: true,
			visibleHotSpotBackgrounds: "",
			hotSpotScrolling: false,
			touchScrolling: true
		});
	}
	jQuery(".scroller-content .scrollableArea").addClass("loop");			
	//active hover
	jQuery(".add-active").hover(
		function() {
			jQuery(this).addClass("active");
		},
		function() {
			jQuery(this).removeClass("active");
		}
	);
	//over hover
	jQuery(".add-over").hover(
		function() {
			jQuery(this).addClass("over");
		},
		function() {
			jQuery(this).removeClass("over");
		}
	);
	//more arrow animations
	jQuery('.longform-wrapper').hover(
		function() {
			jQuery(this).find('.longform-more span').stop().animate({
				left: '40px'
			}, 800, 'easeOutExpo');
		},
		function() {
			jQuery(this).find('.longform-more span').stop().animate({
				left: '0px'
			}, 400, 'easeOutExpo');
		}
	);
	//image hovers
	jQuery(".active-image").hover(
		function() {
			jQuery(this).find('img').stop().animate({ opacity: .4 }, 150);
		},
		function() {
			jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
		}
	);
	jQuery(".the_content").hover(
		function() {
			jQuery(this).find('img').stop().animate({ opacity: .4 }, 150);
		},
		function() {
			jQuery(this).find('img').stop().animate({ opacity: 1.0 }, 500);
		}
	);
	//show various jquery text elements
	jQuery('.trending-content').show();
	jQuery('.scroller-content').show();
	jQuery('.top-ten-content').show();
	jQuery('.topten-widget .article-title').show();
	jQuery('.widget_d .article-title').show();		
	//jQuery tooltips	
	if(jQuery(window).width() > 1005) {				
		jQuery('.info').tooltip();	
		jQuery('.info-top').tooltip();	
		jQuery('.info-bottom').tooltip({ placement: 'bottom' });
		jQuery('.info-left').tooltip({ placement: 'left' });
		jQuery('.info-right').tooltip({ placement: 'right' });
	}
	//jQuery popovers
	jQuery('.popthis').popover();
	//jQuery alert dismissals
	jQuery('.alert').alert();
	//jQuery fitvids
	jQuery('.video_frame').fitVids();
	jQuery('.activity-inner').fitVids();		
	loadAddThis();
	//if items are dynamically added on page load, need to account for new width
	resizeUtilityMenu();		
	adjustStickyNav(false);	
	autoSizeText();	
}
//utility menu page builder		
function resizeUtilityMenu() {
	//bookmark positioning			
	if(jQuery('.utility-menu-full').length > 0) {
		var stickyNav = jQuery('#sticky-nav');
		var utilityMenu = jQuery('.utility-menu-full');
		var windowWidth = jQuery(window).width();
		var navWidth = 0;
		if(stickyNav.length > 0 && stickyNav.position.left==0) {
			navWidth = 200;
		}			
		var maxWidth = windowWidth - navWidth;
		if (utilityMenu.width() >= maxWidth) {
			jQuery('.utility-menu-compact').show();		
			jQuery('.utility-menu-full').hide();			
		}			
	}
}

//makes adjustments to the sticky nav - called in several instances
function adjustStickyNav(hide) {		
	if(jQuery('#sticky-nav').length > 0) {			
		//variables
		var windowWidth = jQuery(window).width();
		var windowHeight = jQuery(window).height();
		var stickyBar = jQuery('#sticky-bar');
		var stickyNav = jQuery('#sticky-nav');
		var newArticles = jQuery('.new-articles.post-container');
		var placeholder = jQuery('#section-menu .placeholder');
		if(windowWidth < 440) stickyNav.animate({left: '0px'}, 200, 'linear');	
		
		//width
		if(windowWidth < 991) {
			//add classes to make sticky nav hidden
			stickyBar.addClass('auto-hidden');
			//jQuery('#sticky-nav').addClass('scroll');
			stickyNav.addClass('auto-hidden');	
			//jQuery('.new-articles.post-container').addClass('scroll');
			newArticles.addClass('auto-hidden');
			jQuery('.after-nav').addClass('auto-hidden');
			//if sticky nav is already toggled open, hide it (if hide variable is passed in)
			if(hide) {
				stickyNav.fadeOut(400);			
				newArticles.fadeOut(400);
				jQuery(".nav-toggle").removeClass('open');
				jQuery('.new-articles.selector').removeClass('active');
			}
		} else {
			//remove the auto-hidden specific stuff
			if(!stickyNav.hasClass('nav-hidden')) {
				stickyNav.fadeIn(150);
			}
			stickyBar.removeClass('auto-hidden');
			stickyNav.removeClass('auto-hidden');
			newArticles.removeClass('auto-hidden');
			jQuery('.after-nav').removeClass('auto-hidden');						
		}		
		
		var stickyOffset = stickyNav.offset().top;
		var stickyHeight = stickyOffset;
		jQuery("#sticky-nav-inner").children().each(function(){
			if(jQuery(this).is(':visible')) {
				stickyHeight = stickyHeight + jQuery(this).outerHeight();
			}
		});		
		//alert('stickyheight=' + stickyHeight);
		if(stickyHeight > windowHeight) {
			stickyNav.addClass('scroll');
		} else {
			stickyNav.removeClass('scroll');
		}
	}		
}	
//when window is resized larger it might need to be shown again
function reshowStickyNav() {	
	if(jQuery('#sticky-nav').length > 0) {	
		var windowWidth = jQuery(window).width();
		var stickyNav = jQuery('#sticky-nav');	
		if(windowWidth > 991 && !stickyNav.hasClass('nav-hidden')) {
			stickyNav.fadeIn(150);
		}
	}
}
//fix nav to bottom of screen
function affixStickyNav(direction) {
	//only applies if not already fixed
	var stickyNav = jQuery('#sticky-nav');
	var nav = jQuery('#sticky-nav-inner');
	if(jQuery(stickyNav).hasClass('scroll')) {
		if(direction=='down') {
			if(jQuery(window).scrollTop() >= (nav.offset().top + nav.height() - jQuery(window).height() + 0)) {
				jQuery(nav).addClass('fixed');
			}
		} else {
			jQuery(nav).removeClass('fixed');	
		}
	}
}
//set contents menu position
function affixContentsMenu() {
	//bookmark positioning			
	if(jQuery('.contents-menu-wrapper').length > 0) {			
		if(jQuery('#wpadminbar').length > 0) {
			topOffset = 92;
		} else {
			topOffset = 60;	
		}		
		var contentsMenu = jQuery('.contents-menu-wrapper');	
		var menuOffset = contentsMenu.offset().top - topOffset;			
		if(jQuery(this).scrollTop() > menuOffset) {
			if(!contentsMenu.hasClass('fixed')) {
				contentsMenu.addClass('fixed');	
				if(contentsMenu.hasClass('active')) {					
					contentsMenu.css({'left': '0px'});					
				} else {					
					contentsMenu.css({'left': '-120px'});					
				}
			}
		} else {
			if(contentsMenu.hasClass('fixed')) {
				contentsMenu.removeClass('fixed');
				if(contentsMenu.hasClass('active')) {
					contentsMenu.css({'left': '0px'});
				} else {
					contentsMenu.css({'left': '-120px'});
				}
			}
		}
		//unfix at bottom of long form posts
		var comments = jQuery('.longform-post #comments');
		if(comments.length > 0 && contentsMenu.hasClass('fixed')) {	
			var commentsTop = comments.offset().top;	
			var docViewTop = jQuery(window).scrollTop();
			var docViewBottom = docViewTop + jQuery(window).height();		
			if(commentsTop + 200 < docViewBottom) {
				contentsMenu.removeClass('fixed');
			}
		}			
	}
}
//make adjustments to the submenu	
function adjustSubMenu(div) {
	var submenu = jQuery(div).children('ul');
	if(jQuery(submenu).length > 0) {			
		var windowHeight = jQuery(window).height();
		var windowWidth = jQuery(window).width();
		var menuHeight = 50; //top and bottom padding of parent
		jQuery(submenu).children().each(function(){
			menuHeight += parseInt(jQuery(this).outerHeight(true));
		});
		if(jQuery(submenu).hasClass('scroll')) {
			//positioned absolutely so we can use offset
			var menuOffset = jQuery(submenu).offset().top;
		} else {
			//positioned fixed so we need top margin instead
			var menuOffset = parseInt(jQuery(submenu).css('marginTop'));				
		}
		menuHeight += menuOffset;
		if(menuHeight > windowHeight) {
			jQuery(submenu).addClass('scroll');
			jQuery('#sticky-nav').addClass('scroll');
			jQuery('.new-articles.post-container').addClass('scroll');
		} else {
			jQuery(submenu).removeClass('scroll');
			jQuery('#sticky-nav').removeClass('scroll');
			jQuery('.new-articles.post-container').removeClass('scroll');
			//need to adjust sticky nav again since we removed scroll (it might need it for other reasons)
			if(windowWidth > 439) adjustStickyNav(false);
		}
	}	
}
//make any necessary submenu adjustments on menu item hover
jQuery('body').on('mouseenter', '#section-menu .standard-menu > ul > li', function(e) {
	adjustSubMenu(this);	
});	
//move stickynav left on mobile for standard menu
jQuery('body').on('mouseenter', '#section-menu .standard-menu > ul', function(e) {
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if(windowWidth < 440) stickyNav.animate({left: '-100px'}, 200, 'linear');		
});	
jQuery('body').on('mouseleave', '#section-menu .standard-menu > ul', function(e) {
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if(windowWidth < 440) stickyNav.animate({left: '0px'}, 200, 'linear');		
});	
//move sticky nav left on mobile for mega mehu
jQuery('body').on('mouseenter', '.mega-menu > ul', function(e) {
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if(windowWidth < 440) stickyNav.animate({left: '-60px'}, 200, 'linear');		
});	
jQuery('body').on('mouseleave', '.mega-menu > ul', function(e) {
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if(windowWidth < 440) stickyNav.animate({left: '0px'}, 200, 'linear');		
});	
//hide sticky nav stuff when clicked out of
jQuery(".after-header").click(function() {
	jQuery('#sticky-social-dropdown').hide();	
	jQuery('#sticky-social').removeClass('active');
	jQuery('#sticky-account-dropdown').hide();	
	jQuery('#sticky-account').removeClass('active');
});
jQuery(".after-nav").click(function() {
	var newArticles = jQuery('.new-articles.post-container');
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if(windowWidth > 600) {
		if(stickyNav.hasClass('nav-hidden') || stickyNav.hasClass('auto-hidden')) {
			stickyNav.fadeOut(400);
			jQuery(".nav-toggle").removeClass('open');
		}		
		newArticles.fadeOut(400);		
		jQuery('.new-articles.selector').removeClass('active');
	}
});
//only need to animate back to starting position once entire sticky-nav loses focus
jQuery('body').on('mouseleave', '#sticky-nav', function(e) {		
	var stickyNav = jQuery('#sticky-nav');
	var windowWidth = jQuery(window).width();
	if((windowWidth < 601) && (stickyNav.is(':visible'))) {
		stickyNav.fadeOut(400);
		showNewArticles(true);
	}		
});	
jQuery('.contents-menu-toggle').click(function() {		
	var contentsMenu = jQuery('.contents-menu-wrapper');	
	if(contentsMenu.hasClass('active')) {		
		contentsMenu.animate({left: '-120px'}, 200, 'linear');
		jQuery(this).animate({right: '-29px'}, 200, 'linear');
		contentsMenu.removeClass('active');		
	} else {		
		contentsMenu.animate({left: '0px'}, 200, 'linear');
		jQuery(this).animate({right: '0px'}, 200, 'linear');
		contentsMenu.addClass('active');
	}	
});
//if disqus is active need to adjust anchor link from comments to disqus thread
function disqusContentsMenu() {
	if (jQuery("#disqus_thread").length > 0){
		jQuery("#comments-anchor-wrapper a").attr("href", "#disqus_thread");
	}	
}
/**
* Check a href for an anchor. If exists, and in document, scroll to it.
* If href argument ommited, assumes context (this) is HTML Element,
* which will be the case when invoked by jQuery after an event
*/
function scroll_if_anchor(href) {
	href = typeof(href) == "string" ? href : jQuery(this).attr("href");		
	//do not interfere with bootstrap carousels
	if(jQuery(href).length > 0 && !jQuery(this).hasClass('no-scroll')) {			
		if(jQuery('#wpadminbar').length > 0) {
			fromTop = 92;
		} else {
			fromTop = 60;	
		}					
		// If our Href points to a valid, non-empty anchor, and is on the same page (e.g. #foo)
		// Legacy jQuery and IE7 may have issues: http://stackoverflow.com/q/1593174
		if(href.indexOf("#") == 0) {
			var $target = jQuery(href);
	
			// Older browser without pushState might flicker here, as they momentarily
			// jump to the wrong position (IE < 10)
			if($target.length) {
				jQuery('html, body').animate({ scrollTop: $target.offset().top - fromTop });
				if(history && "pushState" in history) {
					history.pushState({}, document.title, window.location.pathname + href);
					return false;
				}
			}
		}
	}
}
// When our page loads, check to see if it contains an anchor
scroll_if_anchor(window.location.hash);
// Intercept all anchor clicks
jQuery("body").on("click", "a", scroll_if_anchor);		

//new articles effects 
jQuery(".new-articles.selector").hover(
	function() {
		jQuery(this).addClass('over');
	},
	function() {
		jQuery(this).removeClass('over');
	}
);
jQuery(".new-articles.selector").click(function() {
	showNewArticles(false);
});	
function showNewArticles(hide) {
	var stickyNav = jQuery('#sticky-nav');
	var container = jQuery('.new-articles.post-container');
	var windowWidth = jQuery(window).width();
	if(windowWidth < 601) {
		if(container.is(":visible") || hide) {
			container.fadeOut(400);
			jQuery(".new-articles.selector").removeClass('active');
			if(windowWidth < 440) stickyNav.animate({left: '0px'}, 200, 'linear');		
		} else {
			container.fadeIn(150);
			jQuery(".new-articles.selector").addClass('active');
			if(windowWidth < 440) stickyNav.animate({left: '-60px'}, 200, 'linear');
		}
	} else {
		if(container.is(":visible") || hide) {
			container.fadeOut(400);
			jQuery(".new-articles.selector").removeClass('active');	
		} else {
			container.fadeIn(150);
			jQuery(".new-articles.selector").addClass('active');
		}
	}	
}
//search form highlight
jQuery("#menu-search").click(function() {	
	jQuery(this).addClass('active');
});
jQuery("#menu-search").focusout(function() {	
	jQuery(this).removeClass('active');
});
jQuery("#nav-search").click(function() {	
	jQuery(this).addClass('active');
});
jQuery("#nav-search").focusout(function() {	
	jQuery(this).removeClass('active');
});
//search form submission
jQuery("#searchformtop input").keypress(function(event) {
	if (event.which == 13) {
		event.preventDefault();
		var len = jQuery("#s").val().length;
		if(len >=3) {
			jQuery("#searchformtop").submit();
		} else {
			alert("Search term must be at least 3 characters in length");	
		}
	}
});
//show account info
jQuery("#sticky-account").click(function() {
	jQuery('#sticky-account-dropdown').animate({				 
		height: 'toggle'				 
	}, 100, 'linear' );	
	jQuery(this).toggleClass('active');
	jQuery('#sticky-social-dropdown').hide();	
	jQuery('#sticky-social').removeClass('active');
});
//show social badges
jQuery("#sticky-social").click(function() {
	jQuery('#sticky-social-dropdown').animate({				 
		height: 'toggle'				 
	}, 100, 'linear' );	
	jQuery(this).toggleClass('active');
	jQuery('#sticky-account-dropdown').hide();	
	jQuery('#sticky-account').removeClass('active');
});
//toggle login/register forms
jQuery("#sticky-login").click(function() {
	jQuery('.sticky-login-form').fadeIn(400);	
	jQuery(this).addClass('active');
	jQuery('.sticky-register-form').hide();	
	jQuery('#sticky-register').removeClass('active');
});
jQuery("#sticky-register").click(function() {
	jQuery('.sticky-register-form').fadeIn(400);
	jQuery(this).addClass('active');
	jQuery('.sticky-login-form').hide();	
	jQuery('#sticky-login').removeClass('active');
});	
//submit button hover effects
jQuery(".sticky-submit").hover(function() {
	jQuery(this).toggleClass("active");
});
//login form submission
jQuery(".sticky-login-form #user_pass").keypress(function(event) {
	if (event.which == 13) {
		jQuery(".sticky-form-placeholder .loading").show();
		jQuery('form.sticky-login-form').css({'opacity': '.15'});
		event.preventDefault();
		jQuery(".sticky-login-form").submit();
	}		
});
jQuery("#sticky-login-submit").click(function() {
	jQuery(".sticky-form-placeholder .loading").show();
	jQuery('form.sticky-login-form').css({'opacity': '.15'});
	jQuery(".sticky-login-form").submit();
});
//register form submission
jQuery(".sticky-register-form #user_email").keypress(function(event) {
	if (event.which == 13) {
		jQuery(".sticky-form-placeholder .loading").show();
		jQuery('form.sticky-register-form').css({'opacity': '.15'});
		event.preventDefault();
		jQuery(".sticky-register-form").submit();
	}
});
jQuery("#sticky-register-submit").click(function() {
	jQuery(".sticky-form-placeholder .loading").show();
	jQuery('form.sticky-register-form').css({'opacity': '.15'});
	jQuery(".sticky-register-form").submit();
});
//hide check password message
jQuery(".check-password").click(function() {
	jQuery(this).animate({				 
		height: 'toggle'				 
	}, 100, 'linear' );	
});		
//addthis setup
function loadAddThis() {
	addthis.init();
}
//show sticky nav
jQuery('.nav-toggle').click(function() {
	var stickynav = jQuery('#sticky-nav');
	if(stickynav.is(":visible")) {
		stickynav.fadeOut(400);
		jQuery('.nav-toggle').removeClass('open');	
	} else {
		stickynav.fadeIn(150);
		jQuery('.nav-toggle').addClass('open');
	}
});
//get in touch highlight
jQuery(".connect-email").click(function() {	
	jQuery(this).addClass('active');
});
jQuery(".connect-email").focusout(function() {	
	jQuery(this).removeClass('active');
});
//email subscribe form submission
jQuery("#feedburner_subscribe button").click(function() {		
	jQuery("#feedburner_subscribe").submit();		
});
//scroll all #top elements to top
jQuery("a[href='#top']").click(function() {
	jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	return false;
});	
//image darkening
jQuery('body').on('mouseenter', '.darken img, .the-content a img', function(e) {
	jQuery(this).animate({ opacity: .4 }, 150);
}).on('mouseleave', '.darken img, .the-content a img', function(e) {
	jQuery(this).animate({ opacity: 1.0 }, 500);
});
//reaction mouseovers
jQuery('body').on('mouseenter', '.reaction.clickable', function(e) {
	jQuery(this).addClass('active');
}).on('mouseleave', '.reaction', function(e) {
	jQuery(this).removeClass('active');
});	
// user comment rating panel display
jQuery('body').on('mouseover', '#respond .rating-wrapper.rateable', function(e) {
	jQuery(this).addClass('over');
	jQuery(this).find('.form-selector-wrapper').fadeIn(100);		
});
jQuery('body').on('mouseleave', '#respond .rating-wrapper', function(e) {	
	jQuery(this).stop().delay(100)
				.queue(function(n) {
					jQuery(this).removeClass('over');
					n();
				});	
	jQuery(this).find('.form-selector-wrapper').stop().fadeOut(500);		
});	
// user comment rating
jQuery( "#respond .form-selector" ).on( "slidestop", function( event, ui ) {
	var divID = jQuery(this).parent().parent().parent().attr("id");	
	var rating = jQuery(this).parent().siblings('.rating-value').html();
	jQuery('#' + divID + ' .theme-icon-check').delay(100).fadeIn(100);
	jQuery('#' + divID + ' .hidden-rating-value').val(rating);
});	

/***************************************
UTILITY FUNCTIONS
***************************************/

//utility for determining touch devices
function isTouchDevice() {
  return 'ontouchstart' in window // works on most browsers 
	  || window.navigator.msMaxTouchPoints > 0; // works on ie10
};
//utility for animating rotation
jQuery.fn.animateRotate = function(angle, duration, easing, complete) {
	var args = jQuery.speed(duration, easing, complete);
	var step = args.step;
	return this.each(function(i, e) {
		args.step = function(now) {
			jQuery.style(e, 'transform', 'rotate(' + now + 'deg)');
			if (step) return step.apply(this, arguments);
		};

		jQuery({deg: 0}).animate({deg: angle}, args);
	});
};

//adjust font sizes
var autoSizeText;
autoSizeText = function() {	
  var el, elements, _i, _len, _results;
  elements = jQuery('.textfill');
  //console.log(elements);
  if (elements.length < 0) {
	return;
  }
  _results = [];
  for (_i = 0, _len = elements.length; _i < _len; _i++) {
	el = elements[_i];
	_results.push((function(el) {
	  var reduceText, enlargeText, _results1;
	  if(el.scrollHeight > el.offsetHeight) {		  		  
		  reduceText = function() {			  
			var elNewFontSize;
			elNewFontSize = (parseInt(jQuery(el).css('font-size').slice(0, -2)) - 1) + 'px';
			return jQuery(el).css('font-size', elNewFontSize);
		  };
		  _results1 = [];
		  while (el.scrollHeight > el.offsetHeight) {
			_results1.push(reduceText());
		  }
		  /*
	  } else {
		  enlargeText = function() {
			var elNewFontSize;
			elNewFontSize = (parseInt(jQuery(el).css('font-size').slice(0, -2)) + 1) + 'px';				
			return jQuery(el).css('font-size', elNewFontSize);								
		  };
		  _results1 = [];
		  while (innerHeight < el.offsetHeight) {				
			innerHeight = jQuery(el).children('.title-text').height();
			_results1.push(enlargeText());				
		  }
		  */
	  }
	  return _results1;
	})(el));
  }
  return _results;
};