jQuery.noConflict(); 
	
"use strict";
	
(function ($) {
    $(function () {
		//user view count
		$(document).ready(function(e) { 
			var postID = $('#page-content').data('postid');
			$.post(itAjax.ajaxurl, {
				action: 'itajax-view',
				postID: postID
			}, function (response) {
				jQuery('.control-box .view-count').html(response.content);
			});
		});
		// post share panel
		$('body').on('click', '.share-button.side', function(e){
			
			//get variables
			var postID = $(this).data('postid');
			var labels = $(this).data('labels');			
			var container = $(this).parent();
			var share = $(this).siblings('.share-content');
			var loading = container.parent().find('.loading');	
			var position = container.position();
			
			//deal with other panels on the page
			$('.sticky-nav-loop .share-panel').not(container).css('left', '-110px');
			$('.sticky-nav-loop .share-panel').not(container).children('.share-button.open').children('span').animateRotate(-180, 200, 'linear');
			$('.sticky-nav-loop .share-panel').not(container).children('.share-button').removeClass('open');
			
			//deal with the current panel
			if(position.left=='-110') {
				$(this).children('span').animateRotate(225, 400, 'linear');					
				container.animate({
					left: '0px'
				}, 200, 'linear');
				$(this).addClass('open');
				if (share.contents().length == 0) loading.delay(100).show(0);							
			} else {
				$(this).children('span').animateRotate(-180, 400, 'linear');
				loading.hide();
				container.animate({
					left: '-110px'
				}, 200, 'linear');
				$(this).removeClass('open');
			}
			
			//set local variable
			var _this = this;
			
			if (share.contents().length == 0) {
				
				//do ajax stuff
				$.post(itAjax.ajaxurl, {
					action: 'itajax-share',
					postID: postID,
					labels: labels				
				}, function (response) {
					//hide loading graphic				
					loading.hide();
					//populate the panel
					share.html(response.content);
					//initialize addthis	
					addthis.toolbox('.addthis_toolbox');
					//replace google+ question mark with plus instead (google+ does not yet support custom counds)
					container.find('.addthis_counter_google_plusone_share').children('.addthis_counter').children('.addthis_button_expanded').html('+');					
					//refresh tooltips on dynamically added content					
					jQuery('.info-left').tooltip({ placement: 'left' });
					jQuery('.info-right').tooltip({ placement: 'right' });		
				});				
			}			
		});
		//grid post share panel
		$('body').on('click', '.share-button.share-grid', function(e){
			
			//get variables
			var postID = $(this).data('postid');
			var labels = $(this).data('labels');
			var container = $(this).siblings('.overlay-info-wrapper');
			var sharepanel = $(this).siblings('.share-panel');
			var share = sharepanel.find('.share-content');
			var loading = $(this).siblings('.loading');
			var play = $(this).siblings('.overlay-play');	
			var position = container.position();
			var _this = this;
			
			//deal with other panels on the page
			$('.articles .overlay-play').not(play).css('top', '170px');
			$('.articles .share-button').not(this).css('top', '195px');
			$('.articles .wide .overlay-play').css('top', '207px');
			$('.articles .wide .share-button').css('top', '232px');
			$('.articles .share-button').not(this).children('span').animateRotate(-180, 0, 'linear');
			$('.articles .share-button').not(this).removeClass('open');
			$('.articles .overlay-info-wrapper').not(container).css('top', '-27px');
			$('.articles .overlay-info-wrapper').not(container).removeClass('open');
			$('.articles .share-panel').not(sharepanel).hide();
			$('.articles .wide .overlay-image-wrapper').find('.category-icon-wrapper').css('top', '225px');
			$('.articles .loading').not(loading).hide();
			//deal with the current panel
			if(position.top != '213') {
				$(this).children('span').animateRotate(-180, 500, 'linear');
				loading.hide();				
				container.animate({
					top: '-27px'
				}, 400, 'linear');
				$(this).animate({
					top: '195px'
				}, 400, 'linear');
				$(play).animate({
					top: '170px'
				}, 400, 'linear');
				container.addClass('open');
				$(this).addClass('open');
				sharepanel.fadeOut(100);
				if (share.contents().length == 0) loading.delay(100).show(0);							
			} else {
				$(this).children('span').animateRotate(225, 500, 'linear');	
				if(share.contents().length==0) loading.show();					
				container.animate({
					top: '-150px'
				}, 400, 'linear');
				$(this).animate({
					top: '72px'
				}, 400, 'linear');
				$(play).animate({
					top: '47px'
				}, 400, 'linear');
				container.removeClass('open');
				$(this).removeClass('open');
				sharepanel.fadeIn(900);
			}			
			
			if (share.contents().length == 0) {
				
				//do ajax stuff
				$.post(itAjax.ajaxurl, {
					action: 'itajax-share',
					postID: postID,
					labels: labels			
				}, function (response) {
					//hide loading graphic				
					loading.hide();
					//populate the panel
					share.html(response.content);
					//initialize addthis	
					addthis.toolbox('.addthis_toolbox');
					//replace google+ question mark with plus instead (google+ does not yet support custom counds)
					container.find('.addthis_counter_google_plusone_share').children('.addthis_counter').children('.addthis_button_expanded').html('+');					
					//refresh tooltips on dynamically added content					
					jQuery('.info-top').tooltip({ placement: 'top' });	
				});				
			}			
		});
		//grid post share panel
		$('body').on('click', '.share-button.share-blog', function(e){
			
			//get variables
			var postID = $(this).data('postid');
			var labels = $(this).data('labels');
			var container = $(this).siblings('.overlay-info-wrapper');
			var sharepanel = $(this).siblings('.share-panel');
			var share = sharepanel.find('.share-content');
			var loading = $(this).siblings('.loading');
			var play = $(this).siblings('.overlay-play');
			var cat = $(this).siblings('.overlay-image-wrapper').find('.category-icon-wrapper');	
			var position = container.position();
			var _this = this;
			
			//deal with other panels on the page
			$('.articles .overlay-play').not(play).css('top', '170px');
			$('.articles .share-button').not(this).css('top', '195px');
			$('.articles .wide .overlay-play').not(play).css('top', '207px');
			$('.articles .wide .share-button').not(this).css('top', '232px');
			$('.articles .share-button').not(this).children('span').animateRotate(-180, 0, 'linear');
			$('.articles .share-button').not(this).removeClass('open');
			$('.articles .overlay-info-wrapper').not(container).css('top', '-27px');
			$('.articles .overlay-info-wrapper').not(container).removeClass('open');
			$('.articles .share-panel').not(sharepanel).hide();
			$('.articles .wide .overlay-image-wrapper').find('.category-icon-wrapper').not(cat).css('top', '225px');
			$('.articles .loading').not(loading).hide();
			//deal with the current panel
			if(position.top != '250') {
				$(this).children('span').animateRotate(-180, 500, 'linear');
				loading.hide();				
				container.animate({
					top: '-27px'
				}, 400, 'linear');
				$(this).animate({
					top: '232px'
				}, 400, 'linear');
				$(play).animate({
					top: '207px'
				}, 400, 'linear');
				$(cat).animate({
					top: '225px'
				}, 400, 'linear');
				container.addClass('open');
				$(this).addClass('open');
				sharepanel.fadeOut(100);
				if (share.contents().length == 0) loading.delay(100).show(0);							
			} else {
				$(this).children('span').animateRotate(225, 500, 'linear');	
				if(share.contents().length==0) loading.show();					
				container.animate({
					top: '-150px'
				}, 400, 'linear');
				$(this).animate({
					top: '109px'
				}, 400, 'linear');
				$(play).animate({
					top: '84px'
				}, 400, 'linear');
				$(cat).animate({
					top: '102px'
				}, 400, 'linear');
				container.removeClass('open');
				$(this).removeClass('open');
				sharepanel.fadeIn(900);
			}			
			
			if (share.contents().length == 0) {
				
				//do ajax stuff
				$.post(itAjax.ajaxurl, {
					action: 'itajax-share',
					postID: postID,
					labels: labels			
				}, function (response) {
					//hide loading graphic				
					loading.hide();
					//populate the panel
					share.html(response.content);
					//initialize addthis	
					addthis.toolbox('.addthis_toolbox');
					//replace google+ question mark with plus instead (google+ does not yet support custom counds)
					container.find('.addthis_counter_google_plusone_share').children('.addthis_counter').children('.addthis_button_expanded').html('+');					
					//refresh tooltips on dynamically added content					
					jQuery('.info-top').tooltip({ placement: 'top' });	
				});				
			}			
		});
		// like button
		$('body').on('click', 'a.do-like', function(e){
			$(this).removeClass('do-like');
			$(this).find('.icon').css({'opacity': '.15'});
			var postID = $(this).data('postid');
			var likeaction = $(this).data('likeaction');
			var location = $(this).closest('.container-fluid').data('location');	 
			var _this = this;
			$.post(itAjax.ajaxurl, {
				action: 'itajax-like',
				postID: postID,
				likeaction: likeaction,
				location: location
			}, function (response) {
				$(_this).addClass('do-like');
				$(_this).find('.icon').css({'opacity': '1'});
				$('a.like-button.' + postID + ' .numcount').html(response.content);
				if(likeaction=='like') {
					$('a.like-button.' + postID + ' .icon').removeClass('like').addClass('unlike');
					$('a.like-button.' + postID).data('likeaction', 'unlike');
				} else {
					$('a.like-button.' + postID + ' .icon').removeClass('unlike').addClass('like');
					$('a.like-button.' + postID).data('likeaction', 'like');
				}
				$('#ajax-error').hide();
			});
		});		
		// menu top level item mouseovers		
		var timeout;		
		$('body').on('mouseover', '.mega-menu li.unloaded', function(e) {
			
			var loop = $(this).data('loop');
			var thumbnail = $(this).data('thumbnail');
			var numarticles = $(this).data('numarticles');
			var object = $(this).data('object');
			var objectid = $(this).data('objectid');
			var object_name = $(this).data('object_name');
			var type = $(this).data('type');
			var _this = this;
			
			timeout = setTimeout(function(){
			
				$(_this).children(".mega-loader").show();
				
				$.post(itAjax.ajaxurl, {
					action: 'itajax-menu-terms',
					object: object,
					objectid: objectid,
					object_name: object_name,
					loop: loop,
					thumbnail: thumbnail,
					numarticles: numarticles,
					type: type
				}, function (response) {
					$(_this).children(".mega-content").html(response.content);		
					$('#ajax-error').hide();
					$(_this).children(".mega-loader").hide();
					dynamicElements();	
					$(_this).addClass('loaded').removeClass('unloaded');
				});				
			 }, 400);
		});
		$('body').on('mouseleave', '.mega-menu li.unloaded', function(e) {
			clearTimeout(timeout);
		});
		$(".mega-menu li").hover(
			function() {
				$(this).children(".mega-content").show();
			},
			function() {
				$(this).children(".mega-content").hide();
				$(this).children(".mega-loader").hide();		
			}
		);
		// menu second-level item mouseovers
		$('body').on('mouseover', '.mega-menu a.list-item.inactive', function(e) {
			
			var loop = $(this).parent().parent().parent().parent().data('loop');
			var thumbnail = $(this).parent().parent().parent().parent().data('thumbnail');
			var numarticles = $(this).parent().parent().parent().parent().data('numarticles');
			var object = $(this).parent().parent().parent().parent().data('object');
			var object_name = $(this).parent().parent().parent().parent().data('object_name');
			var size = $(this).data('size');
			var width = $(this).data('width');
			var height = $(this).data('height');
			var sorter = $(this).data('sorter');
			var _this = this;
			
			timeout = setTimeout(function(){
			
				$(".mega-menu .post-list .loading").show();
				$(".mega-menu .overlay-panel").animate({opacity: "0.15"}, 0);	
				$(_this).addClass('active').removeClass('inactive');
				$(_this).siblings().addClass('inactive').removeClass('active');
				
				$.post(itAjax.ajaxurl, {
					action: 'itajax-sort',
					sorter: sorter,
					object: object,
					object_name: object_name,
					loop: loop,
					thumbnail: thumbnail,
					numarticles: numarticles,
					size: size,
					width: width,
					height: height
				}, function (response) {
					$(_this).parent().siblings(".post-list").html(response.content);				
					$('#ajax-error').hide();
					$(".mega-menu .post-list .loading").hide();
					$(".mega-menu .overlay-panel").animate({opacity: "1"}, 500);	
					dynamicElements();	
				});				
			 }, 400);
		});
		$('body').on('mouseleave', '.mega-menu a.list-item.inactive', function(e) {
			clearTimeout(timeout);
		});			
		// don't allow clicking on mobile unless menu is already shown
		$('body').on('click', '.mega-menu-item > a:not(.over)', function (e) {
			e.preventDefault();
		});
		$('body').on('click', '.mega-menu a.list-item:not(.active)', function(e) {
			e.preventDefault();
		});
		// main loop sorting
		$('body').on('click', '.sortbar .sort-metrics a', function(e){	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');	
						
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var layout = $(this).parent().data('layout');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');
			var sorter = $(this).data('sorter');
			var numarticles = $(this).parent().data('numarticles');
			var paginated = $(this).parent().data('paginated');
			var timeperiod = $(this).parent().data('timeperiod');
			var increment = $(this).parent().data('increment');
			var start = $(this).parent().data('start');
			var title = $(this).data('original-title');
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;
			
			container.find(".load-more-wrapper").hide();
			container.find(".loading.load-sort").show();
			container.find(".loop").animate({opacity: "0.15"}, 0);	
			container.find(".sortbar .label-text").not(".static").animate({opacity: "0.15"}, 0);
					
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				loop: loop,
				location: location,
				layout: layout,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				numarticles: numarticles,
				increment: increment,
				start: start,				
				paginated: paginated,
				title: title,
				timeperiod: timeperiod,
				currentquery: currentquery
			}, function (response) {				
				container.find(".loading").hide();
				container.find(".loop").animate({opacity: "1"}, 500);
				container.find(".sortbar .label-text").animate({opacity: "1"}, 500);
				container.find(".loop").html(response.content);
				if(response.updatepagination==1) {
					container.find(".pagination-wrapper").html(response.pagination);
					container.find(".pagination-wrapper.mobile").html(response.paginationmobile);
				}
				container.find(".sortbar .label-text").not(".static").html(title);
				container.find(".pagination").data("sorter", sorter);
				container.find(".load-more-wrapper").data("paginated", 1);
				container.find(".load-more-wrapper").data("sorter", sorter);
				if(response.pages > 1) {
					container.find(".load-more-wrapper").show();
					container.find(".last-page").hide();
				}
				$("#ajax-error").hide();
				//sort button clicked is within the trending slider
				if($(_this).closest('.trending').length > 0) {
					$(".trending-content").smoothDivScroll("jumpToElement", "first");
				}
				dynamicElements();
			});
		});	
		// sections sorting
		$('body').on('click', '.sortbar .sort-sections a', function(e){	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');				
			
			var sorter = $(this).data('sorter');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var layout = $(this).parent().data('layout');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');	
			var numarticles = $(this).parent().data('numarticles');
			var size = $(this).parent().data('size');
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;	
			
			container.find(".loading.load-sort").show();
			container.find(".loop").animate({opacity: "0.15"}, 0);	
					
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				loop: loop,
				location: location,
				layout: layout,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				size: size,
				numarticles: numarticles,
				currentquery: currentquery
			}, function (response) {				
				container.find(".loading").hide();
				container.find(".loop").animate({opacity: "1"}, 500);
				container.find(".loop").html(response.content);		
				$("#ajax-error").hide();
				dynamicElements();
			});
		});		
		// main loop pagination
		$('body').on('click', '.pagination a', function(e){
			$(this).addClass('active');
			$(this).siblings().removeClass('active');
			
			$('html, body').animate({
				scrollTop: $(this).parent().parent().parent().offset().top - 100
			}, 300);
			
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var layout = $(this).parent().data('layout');
			var sorter = $(this).parent().data('sorter');
			var thumbnail = $(this).parent().data('thumbnail');
			var rating = $(this).parent().data('rating');
			var meta = $(this).parent().data('meta');
			var icon = $(this).parent().data('icon');
			var award = $(this).parent().data('award');
			var badge = $(this).parent().data('badge');
			var authorship = $(this).parent().data('authorship');
			var excerpt = $(this).parent().data('excerpt');
			var numarticles = $(this).parent().data('numarticles');
			var increment = $(this).parent().data('increment');
			var start = $(this).parent().data('start');
			var paginated = $(this).data('paginated');
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;
			
			container.find(".loading.load-sort").show();
			container.find(".loop").animate({opacity: "0.15"}, 0);	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				loop: loop,
				location: location,
				layout: layout,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				numarticles: numarticles,
				increment: increment,
				start: start,			
				paginated: paginated,
				currentquery: currentquery
			}, function (response) {
				container.find(".loading").hide();
				container.find(".loop").animate({opacity: "1"}, 500);
				container.find(".loop").html(response.content);
				if(response.updatepagination==1) {
					container.find(".pagination-wrapper").html(response.pagination);
					container.find(".pagination-wrapper.mobile").html(response.paginationmobile);
				}
				container.find('.sortbar .sort-buttons').data('paginated', paginated);
				$('#ajax-error').hide();
				//add to browser history
				//history.pushState({}, document.title, window.location.pathname + window.location.hash);
				dynamicElements();
			});
		});		
		// infinite load more
		$('body').on('click', '.load-more-wrapper', function(e){
			var loop = $(this).data('loop');
			var location = $(this).data('location');
			var layout = $(this).data('layout');
			var sorter = $(this).data('sorter');
			var thumbnail = $(this).data('thumbnail');
			var rating = $(this).data('rating');
			var meta = $(this).data('meta');
			var icon = $(this).data('icon');
			var award = $(this).data('award');
			var badge = $(this).data('badge');
			var authorship = $(this).data('authorship');
			var excerpt = $(this).data('excerpt');
			var numarticles = $(this).data('numarticles');
			var increment = $(this).data('increment');
			var start = $(this).data('start');
			var numpages = $(this).data('numpages');
			var paginated = $(this).data('paginated') + 1;
			var container = $(this).closest('.post-container');
			var currentquery = container.data('currentquery');
			var _this = this;
			
			$(this).hide();
			container.find(".loading.load-infinite").show();	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				loop: loop,
				location: location,
				layout: layout,
				thumbnail: thumbnail,
				rating: rating,
				meta: meta,
				award: award,
				badge: badge,
				authorship: authorship,
				icon: icon,
				excerpt: excerpt,
				sorter: sorter,
				numarticles: numarticles,
				increment: increment,
				start: start,	
				numpages: numpages,			
				paginated: paginated,
				currentquery: currentquery
			}, function (response) {
				if(numpages > paginated && response.pages > paginated) {
					$(_this).show();
					container.find(".last-page").hide();
				} else {
					container.find(".last-page").show();
				}
				container.find(".loading").hide();
				container.find(".loop").append(response.content);
				$(_this).data('paginated', paginated);
				$('#ajax-error').hide();
				dynamicElements();
			});
		});
		// recommended filtering
		$('body').on('click', '#recommended .sort-buttons a', function(e){
			$("#recommended .loading").show();
			$("#recommended .loop").animate({opacity: "0.15"}, 0);	
			$(this).addClass('active');
			$(this).siblings().removeClass('active');
			
			var postID = $(this).parent().data('postid');
			var loop = $(this).parent().data('loop');
			var location = $(this).parent().data('location');
			var rating = $(this).parent().data('rating');
			var numarticles = $(this).parent().data('numarticles');
			var sorter = $(this).data('sorter');
			var method = $(this).data('method');
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-sort',
				postID: postID,
				loop: loop,
				location: location,
				rating: rating,
				numarticles: numarticles,				
				sorter: sorter,
				method: method
			}, function (response) {
				$("#recommended .loading").hide();
				$("#recommended .loop").animate({opacity: "1"}, 500);
				$("#recommended .loop").html(response.content);
				$('#ajax-error').hide();
				dynamicElements();
			});
		});		
		// star user ratings
		$('.rating-wrapper .rateit').bind('rated reset', function (e) {
			 var ri = $(this);
			
			 var noupdate = ri.data('noupdate');
			 var rating = ri.rateit('value');
			 var postID = ri.data('postid');
			 var meta = ri.data('meta');
			 var divID = ri.parent().parent().parent().attr('id');
			 var metric = 'stars';
			 var unlimitedratings = ri.data('unlimitedratings');
		
			 //disable rating ability after user submits rating
			 if(unlimitedratings != 1) {
				ri.rateit('readonly', true);
			 }
			 
			 if(noupdate==1) {
				 var divID = $(this).parent().parent().parent().attr("id");
				 $('#' + divID + ' .hidden-rating-value').val(rating);
			 } else {	
			 
			 	$.post(itAjax.ajaxurl, {
					action: 'itajax-user-rate',
					postID: postID,
					meta: meta,
					rating: rating,
					metric: metric,
					divID: divID
				}, function (response) {
					$('.user-rating .rated-legend').addClass('active');
					$('.ratings .total .user_rating > div').stop().delay(200)
						.fadeOut(200)
						.delay(500)
						.queue(function(n) {
							$(this).html(response.totalrating);
							n();
						}).fadeIn(400);
					 $('#' + response.divID + ' .theme-icon-check').delay(200).fadeIn(100);	
					 $('.user-container	.meter').css('-webkit-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('-moz-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('-o-transform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('msTransform','rotate(' + response.amount + ')');
					 $('.user-container	.meter').css('transform','rotate(' + response.amount + ')');					 
					 if(response.cssfill == 'showfill') {
						 $('.user-container .meter-slice').addClass('showfill');
						 if($('.user-container .meter-slice .meter.fill').length > 0) {
							$('.user-container .meter-slice .meter.fill').show();
							$('.user-container .meter-slice .meter.fill').css('-webkit-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('-moz-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('-o-transform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('msTransform','rotate(' + response.amount + ')');
							$('.user-container .meter-slice .meter.fill').css('transform','rotate(' + response.amount + ')');							
						 } else {
							$('.user-container .meter-slice').append('<div class="meter fill" style="-webkit-transform:rotate(' + response.amount + ');-moz-transform:rotate(' + response.amount + ');-o-transform:rotate(' + response.amount + ');-ms-transform:rotate(' + response.amount + ');transform:rotate(' + response.amount + ');"></div>');
						 }
					 } else {
						  $('.user-container .meter-slice').removeClass('showfill');
						  $('.user-container .meter-slice .meter.fill').hide();
					 }	
					 // hide comment ratings after top ratings are added
				 	 jQuery('#respond .rating-wrapper').hide();
					 jQuery('.hidden-rating-value').val('');
				});
			 }
		 });
	
		// update user ratings
		$( ".user-rating .form-selector" ).on( "slidestop", function( event, ui ) {
			var meta = $(this).parent().parent().parent().data('meta');
			var divID = $(this).parent().parent().parent().attr("id");			
			var postID = $(this).parent().parent().parent().data('postid');
			var rating = ui.value;
			var metric = $(this).parent().parent().parent().data('metric');	
			
			$.post(itAjax.ajaxurl, {
				action: 'itajax-user-rate',
				postID: postID,
				meta: meta,
				rating: rating,
				metric: metric,
				divID: divID
			}, function (response) {
				$('.ratings .rated-legend').addClass('active');
				$('#' + response.divID + '_wrapper').addClass('active');
				 if(response.unlimitedratings != 1) {
					$('#' + response.divID + '_wrapper').removeClass('rateable');
				 }				 
				 $('#' + response.divID + ' .rating-value').fadeOut(100)
					.delay(100)
					.queue(function(n) {
						$(this).html(response.newrating);
						n();
					}).fadeIn(150);
				 $('.ratings .total .user_rating > div').stop().delay(200)
					.fadeOut(200)
					.delay(500)
					.queue(function(n) {
						$(this).html(response.totalrating);
						n();
					}).fadeIn(400);
				 $('#' + response.divID + ' .theme-icon-check').delay(200).fadeIn(100);	
				 $('.user-container	.meter').css('-webkit-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('-moz-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('-o-transform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('msTransform','rotate(' + response.amount + ')');
				 $('.user-container	.meter').css('transform','rotate(' + response.amount + ')');				 
				 if(response.cssfill == 'showfill') {
					 $('.user-container .meter-slice').addClass('showfill');
					 if($('.user-container .meter-slice .meter.fill').length > 0) {
						$('.user-container .meter-slice .meter.fill').show();
					 	$('.user-container .meter-slice .meter.fill').css('-webkit-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('-moz-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('-o-transform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('msTransform','rotate(' + response.amount + ')');
						$('.user-container .meter-slice .meter.fill').css('transform','rotate(' + response.amount + ')');
					 } else {
					 	$('.user-container .meter-slice').append('<div class="meter fill" style="-webkit-transform:rotate(' + response.amount + ');-moz-transform:rotate(' + response.amount + ');-o-transform:rotate(' + response.amount + ');-ms-transform:rotate(' + response.amount + ');transform:rotate(' + response.amount + ');"></div>');
					 }
				 } else {
					  $('.user-container .meter-slice').removeClass('showfill');
					  $('.user-container .meter-slice .meter.fill').hide();
				 }	
				 // hide comment ratings after top ratings are added
				 jQuery('#respond .rating-wrapper').hide();
				 jQuery('.hidden-rating-value').val('');					
			});			
		});
		
		// reaction button
		$('body').on('click', '.reaction.clickable', function(e){
			var postID = $('.reactions-wrapper').data('postid');
			var unlimitedreactions = $('.reactions-wrapper').data('unlimitedreactions');
			var reaction = $(this).data('reaction'); 
			var _this = this;
			$('.reaction-percentage').stop().animate({opacity: ".1"}, 100);
			$(this).addClass('selected');
			$(this).siblings().removeClass('selected');
			if(unlimitedreactions==0) {
				$(this).removeClass('clickable');
				$(this).siblings().addClass('clickable');
			}
			$.post(itAjax.ajaxurl, {
				action: 'itajax-reaction',
				postID: postID,
				reaction: reaction,
				unlimitedreactions: unlimitedreactions
			}, function (response) {
				if(unlimitedreactions==1) $(_this).addClass('clickable');
				$.each(response, function(key, value) {
					$('.reaction-percentage.' + key).html(value);
					var c = parseInt(value.replace('%',''));
					c = Math.round(c / 10);
					$('.reaction-percentage.' + key).removeClass().addClass('size' + c).addClass('reaction-percentage').addClass(key);					
				});
				$('.reaction-percentage').stop().animate({opacity: "1"}, 1200);
				$('#ajax-error').hide();
			});
		});
		
	});
}(jQuery));