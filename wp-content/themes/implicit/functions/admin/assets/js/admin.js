jQuery.noConflict();

var alliAdmin = {
	
	init : function() {
		alliAdmin.optionTabs();
		alliAdmin.tooltipHelp();
		alliAdmin.footerSave();
		alliAdmin.resetConfirm();
		alliAdmin.demoConfirm();
		alliAdmin.optionSave();
		alliAdmin.saveSidebar();
		alliAdmin.sidebarDelete();
		alliAdmin.layoutSelect();
		alliAdmin.multiDropdown();
		alliAdmin.builder();
		alliAdmin.builderSelect();
		alliAdmin.optionToggle();
		alliAdmin.optionsToggleSlide();
		alliAdmin.wpMedia();
		alliAdmin.colorPicker();
		
		alliAdmin.menuAdd();
		alliAdmin.menuEdit();
		alliAdmin.menuCancel();
		alliAdmin.menuDelete();
		alliAdmin.menuSort();
		
		alliAdmin.shortcodeSelect();
		alliAdmin.shortcodeMultiply();
		alliAdmin.shortcodeInsert();		
	},
	
	ajaxSubmit : function(postData) {		
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			data: postData,
			beforeSend: function(x) {
		        if(x && x.overrideMimeType) {
		            x.overrideMimeType('application/json;charset=UTF-8');
		        }
		    },
			success: function(data) {				
				alliAdmin.processJson(data);
			}
		});
	},
	
	optionSave : function() {
		jQuery('.it_admin_save').click(function(e){
			//jQuery('form#it_admin_form').submit();
		});
		jQuery('form#it_admin_form').submit(function(e){
			
			if(jQuery('#import_options')[0].value.length>20) {				
				jQuery('form#it_admin_form').prepend( jQuery("<input>", { type: "hidden", name:"it_import_options", val: true }) );
				return true;
			}
			
			if(jQuery('#it_full_submit').val() == 1){				
				
				return true;
				
			} else {
				
				jQuery('#ajax-feedback').css({display:'block'});

				//tinyMCE.triggerSave();

				var formData = jQuery(this),
					optionSave = jQuery("<input>", { type: "text", name:"it_option_save", val: true }),
					postData = formData.add(optionSave).serialize();				
				
				alliAdmin.ajaxSubmit(postData);

				e.preventDefault();
			}
		});
	},
	
	resetConfirm : function () {
		jQuery('.it_reset_button').click(function(e){
			if (confirm(objectL10n.resetConfirm)){
				jQuery('#it_full_submit').val(1);
			} else {
				e.preventDefault();
			}
		});
	},
	
	demoConfirm : function () {
		jQuery('.it_demo_button').click(function(e){
			if (confirm(objectL10n.demoConfirm)){
				jQuery('#it_full_submit').val(1);
			} else {
				e.preventDefault();
			}
		});
	},
	
	processJson : function(data) {

		if(data.success == 'saved_sidebar')
		{
			alliAdmin.addSidebar(data);
		}

		if(data.success == 'deleted_sidebar')
		{
			alliAdmin.deleteSidebar(data);
		}

		if(data.success == 'options_saved')
		{
			alliAdmin.menuRefresh();
		}
			
		if(jQuery.browser.safari){ bodyelem = jQuery('body') } else { bodyelem = jQuery('html') }
		  bodyelem.animate({
		    //scrollTop:0
		  }, 'fast', function() {
			
			jQuery('#message').empty();
			
			var el = jQuery('#message').append(data.message),
			    timer = ( data.image_error ) ? 15000 : 3000;
			
			el.fadeIn();

			jQuery('#ajax-feedback').fadeOut('fast');

			el.queue(function(){
			  setTimeout(function(){
			    el.dequeue();
			  }, timer ); 
			}); 
			el.fadeOut();
			
		});
	},
	
	footerSave : function(field) {
		jQuery('.it_footer_submit').click(function(e){
			if(jQuery('#import_options')[0].value.length>20) { 
				jQuery('form#it_admin_form').prepend( jQuery("<input>", { type: "hidden", name:"it_import_options", val: true }) );
				return true;
			}
			
		if(jQuery.browser.safari){ bodyelem = jQuery('body') } else { bodyelem = jQuery('html') }
		  bodyelem.animate({
		    scrollTop:0
		  }, 'fast', function() {
			jQuery('form#it_admin_form').submit();
		  });
		e.preventDefault();
		});
	},
	
	optionTabs : function() {
		jQuery('.it_tab').css('display','none');
		jQuery('.it_tab:first').css('display','block');
		jQuery('#it_admin_tabs li:first').addClass('current');
		
		jQuery('#it_admin_tabs li a').click(function(e){
		
			jQuery('#it_admin_tabs li').removeClass('current');
			jQuery(this).parent().addClass('current');
		
			var clicked_tab = jQuery(this).attr('href');

			jQuery('.it_tab').css('display','none');
		
			jQuery(clicked_tab).css('display','block');
						
			jQuery('.it_admin_save').css('display','block');
			jQuery('.it_reset_button').css('display','inline');
			jQuery('.it_demo_button').css('display','inline');
			jQuery('.it_footer_submit').css('display','inline');
			
			e.preventDefault();
		});
	},
	
	layoutSelect : function() {
		var el = jQuery('.layout_option_set');
		
		el.each(function(){
			var _this = jQuery(this),
			    _input = _this.find(':input');
			
			jQuery(_this).find('a').each(function(){
				if(jQuery(this).attr('rel')==_input.val()){
					jQuery(this).addClass('selected');
				}
				
				jQuery(this).click(function(e){
					if(jQuery(this).hasClass('selected')){
						jQuery(this).removeClass('selected');
						jQuery(_input).val('');
					} else {
						jQuery(_input).val(jQuery(this).attr('rel'));
						jQuery(_this).find('.selected').removeClass('selected');
						jQuery(this).addClass('selected');
					}

					e.preventDefault();
				});
				
			});
			
		});
	},
	
	multiDropdown : function() {
		var el = jQuery(".multidropdown");
		
		el.each(function() {
			var _this = jQuery(this),
			    selects = jQuery(this).children('select'),
			    name = jQuery(this).attr("id");
			
			selects.each(function(i) {
				if(jQuery(this).val() != ''){
					var newname = name + '['+i+']';
					jQuery(this).attr('id', newname);
					jQuery(this).attr('name', newname);
				}
				
				jQuery(this).unbind('change').bind('change',function() {
					if (jQuery(this).val() && selects.length == i + 1) {
						jQuery(this).clone().val("").appendTo(_this);
					} else if (!(jQuery(this).val())
							&& !(selects.length == i + 1)) {
						jQuery(this).remove();
					}
					alliAdmin.multiDropdown();
				});

			})

		})
	},
	
	builder : function() {
		var el = jQuery(".builder");
		
		el.each(function() {
			var _this = jQuery(this),
			    selects = jQuery(this).children('select'),
			    name = jQuery(this).attr('id');
			
			var i = 0;
			selects.each(function() {
				if(jQuery(this).val() != ''){
					var j = i - 1;
					if(jQuery(this).hasClass('cat_select')) {
						var newname = name + '['+j+'][cat]';
					} else if (jQuery(this).hasClass('tag_select')) {
						var newname = name + '['+j+'][tag]';
					} else {
						var newname = name + '['+i+']';
						i = i + 1;
					}
					jQuery(this).attr('id', newname);
					jQuery(this).attr('name', newname);
				}
				
				jQuery(this).unbind('change').bind('change',function() {
					if (jQuery(this).val() && selects.length == i + 1) {
						jQuery(this).clone().val("").appendTo(_this);
					} else if (!(jQuery(this).val())
							&& !(selects.length == i + 1)) {
						jQuery(this).remove();
					}
					alliAdmin.builder();
				});

			})

		})
	},
	
	builderSelect : function() {
		
		jQuery('.builder_selector select').each(function(){
			it_select_fields(this);
		});
		
		jQuery('body').on('change', '.builder_selector select', function(){			
			it_select_fields(this);			
		});	
		
		function it_select_fields(selector){
			
			var selected = jQuery(selector).val();
			
			jQuery(selector).parent().parent().siblings().not('.menu-item-actions').each(function(){
				var el = jQuery(this);
				
				if ( el.hasClass(selected) || el.hasClass('all') ) {					
					jQuery(this).css({display: 'block'}).addClass('builder_selected');
				} else {
					jQuery(this).css({display: 'none'}).removeClass('builder_selected');
				}
			});	
		}
	},
	
	clearSliderHeight : function() {
		jQuery('#it_slideshow_tab').css({height: ''});
	},
	
	refreshSliderHeight : function() {
		jQuery('#it_slideshow_tab').css({
		      height: function(index, value) {
		        return parseFloat(value);
		      }
		});
	},
	
	refreshMenuKeys : function (_this) {
		var _this = _this,
		    addKeys = new Array;
		
		sliderIDs = _this.find('li')
		sliderIDs.each(function(i) {
			var thisID = jQuery(this).attr('id').match(/\d+/g);
			addKeys.push(thisID);
		});
		addKeys.push('#');
		_this.parent().find('.menu-keys').val(addKeys.toString());
	},
	
	menuAdd : function() {
		jQuery('body').on('click', '.it_add_menu', function(e){
			
			alliAdmin.clearSliderHeight();

			var _this = jQuery(this).parent().parent(),
				 append = _this.find('.menu-to-edit'),
				 menuItem = _this.find('.sample-to-edit li'),
				 menuEdit = append.find('li'),
				 count = menuEdit.length,
				 allIds = new Array;
			
			menuEdit.each( function() {
				if(jQuery(this).attr('id')){
					menuEditId = jQuery(this).attr('id').match(/\d+/g);
					if(menuEditId){
						allIds.push(parseInt(menuEditId));
					}
				}
			});
			
			var newID = ( jQuery(append).css('display') == 'none' )? count : count+1,
			    template = menuItem;
			
			while (jQuery.inArray(newID, allIds) != -1 ) {
				newID++;
			}
			
			var newClone = template.clone()

				.attr('id',template.attr('id').replace('#',newID))
				.find('*').each( function() {

					if( jQuery(this).hasClass('item-title') ) {
						var newTitle = jQuery(this).text().replace(/\d+/g,newID);
						jQuery(this).text(newTitle);
					}

					var attrId = jQuery(this).attr('id');
					if (attrId) jQuery(this).attr('id', attrId.replace('#',newID));

					var attrHref = jQuery(this).attr('href');
					if (attrHref) jQuery(this).attr('href', attrHref.replace('#',newID));

					var attrFor = jQuery(this).attr('for');
					if (attrFor) jQuery(this).attr('for', attrFor.replace('#',newID));

					var attrName = jQuery(this).attr('name');
					if (attrName) jQuery(this).attr('name', attrName.replace('#',newID));

				}).end();

			var newAppend = jQuery(append).append(function(index, html) {
				if( jQuery(this).css('display') == 'none' ){
					jQuery(_this).find('.menu_clear').css('display','block');
					jQuery(this).empty();
					jQuery(this).css('display','block');
				}
				
				return newClone;
			});

			if(newAppend) {
				alliAdmin.clearSliderHeight();
				
				var _regex = new RegExp( "(.*)menu-item-settings-" + newID, "i"),
				    _match,
				    _item;
				
				append.find('li').children().filter(function() {
				    _find = this.id.match(_regex);
					if(_find){
						_match = _find;
					}
				});
				
				if(_match){
					_item = jQuery('#'+_match[0]).parent();
					
					jQuery('#'+_match[0]).slideToggle('fast', function() {
					    alliAdmin.refreshSliderHeight();
					});

					if(_item.hasClass('menu-item-edit-inactive')){
						_item.removeClass('menu-item-edit-inactive');
						_item.addClass('menu-item-edit-active');
					}else{
						_item.removeClass('menu-item-edit-active');
						_item.addClass('menu-item-edit-inactive');
					}
				}

				alliAdmin.refreshMenuKeys(append);			
			}
			alliAdmin.colorPicker();
			alliAdmin.multiDropdown();

			e.preventDefault();
		});
	},
	
	menuSort : function() {
		jQuery(".menu-to-edit").sortable({
			handle: '.menu-item-handle',
			placeholder: 'sortable-placeholder',

			start: function() {
				jQuery('#wpwrap').css('overflow','hidden');
			},
			update: function(event, ui) {
				_this = jQuery(this);
				alliAdmin.refreshMenuKeys(_this);
			}
			
		});
	},
	
	menuEdit : function() {
		jQuery('body').on('click', '.item-edit', function(e) {
			
			jQuery.fx.off = false;

			alliAdmin.clearSliderHeight();

			var settings = jQuery(this).attr('href');
			var item = jQuery('#'+settings).parent();
			
			jQuery('#'+settings).slideToggle('fast', function() {
			    alliAdmin.refreshSliderHeight();
			});

			if(item.hasClass('menu-item-edit-inactive')){
				item.removeClass('menu-item-edit-inactive');
				item.addClass('menu-item-edit-active');
			}else{
				item.removeClass('menu-item-edit-active');
				item.addClass('menu-item-edit-inactive');
			}
			
			e.preventDefault();
		});
	},
	
	menuCancel : function() {
		jQuery('body').on('click', '.slider_cancel', function(e) {
			
			alliAdmin.clearSliderHeight();

			var settings = jQuery(this).attr('href');
			var item = jQuery('#'+settings).parent();
			
			jQuery('#'+settings).slideToggle('fast', function() {
			    alliAdmin.refreshSliderHeight();
			});

			if(item.hasClass('menu-item-edit-inactive')){
				item.removeClass('menu-item-edit-inactive');
				item.addClass('menu-item-edit-active');
			}else{
				item.removeClass('menu-item-edit-active');
				item.addClass('menu-item-edit-inactive');
			}

			e.preventDefault();
		});
	},
	
	menuDelete : function() {
		jQuery('body').on('click', '.slider_deletion', function(e) {
			
			var _this = jQuery(this).parent().parent().parent().parent();
			
			var sliderRM = jQuery(this).attr('id').replace('delete-','');
			var el = _this.find('#'+sliderRM);

			el.addClass('deleting').animate({
					opacity : 0,
					height: 0
				}, 350, function() {
					el.remove();
					alliAdmin.refreshMenuKeys(_this);
					alliAdmin.clearSliderHeight();
					if(jQuery(_this).is(':empty')){
						jQuery(_this).parent().find('.menu_clear').css('display','none');
						jQuery(_this).css('display','none');
					}
				});

			e.preventDefault();
		});
	},
	
	menuRefresh : function() {
		jQuery('.slideshow_option_set').find('li').each(function(i) {
				var newID = i+1;
				jQuery(this).find('.item-title').text('Slideshow '+newID);
		});
		
		jQuery('.sociable_option_set select option:selected').each(function(i) {
			icon = jQuery(this).parent().attr('id').match(/edit-menu-sociable-icon-([0-9]+)/);
			if( icon ) {
				custom = jQuery(this).parent().parent().parent().parent().children().eq(2).find('input').val();
				
					_text = jQuery(this).text();
					jQuery(this).parent().parent().parent().parent().parent().find('.item-title').text(_text);
				
			}
		});
	},
	
	optionToggle : function() {
		var toggle = jQuery('.toggle_true'),
		    val;

		toggle.each(function() {

			if(jQuery(this).is('select')){
				val = jQuery(this).val();
			}else{
				_this = jQuery(this);
				chk = _this.attr('checked');

				if(chk){
					val = jQuery(this).val();
				}
			}

			var nameMatch = jQuery(this).attr('name').match(/\[[^\]]*/),
				_name = ( nameMatch )? nameMatch[0].replace( '[', '') : jQuery(this).attr('name'),
				el = jQuery('*[class^="'+_name+'_"]'),
			    attrID = _name + '_' +val;

			el.each(function() {
				if(jQuery(this).hasClass(attrID)){
					jQuery(this).css({display:"block"});
				}else{
					jQuery(this).css({display:"none"});
				}
			});

			jQuery(this).change(function() {
				var _id = jQuery(this).attr('id');
				
				if(_id == 'slider_custom_1' || _id == 'slider_custom_2' || _id == 'homepage_slider') {
					alliAdmin.clearSliderHeight();
				}
				
				var nameMatch = jQuery(this).attr('name').match(/\[[^\]]*/),
					_name = ( nameMatch )? nameMatch[0].replace( '[', '') : jQuery(this).attr('name'),
				    attrID = _name + '_' +jQuery(this).val();
				
				
				el.each(function() {
					if(jQuery(this).hasClass(attrID)){
						jQuery(this).css({display:'block'});
					}else{
						jQuery(this).css({display:'none'});
					}
				});

				if(_id == 'slider_custom_1') {
					alliAdmin.refreshSliderHeight();
				}
				
			});

		});
	},
	
	optionsToggleSlide : function() {
		
		jQuery('.option_toggle a').click(function(e){
			
			var val = '',
			    isSlider = ( jQuery(this).parent().hasClass('slider_option_toggle') ) ? true : false; 
			
			if( jQuery(this).find('span').text() == '[+]' ){
				jQuery(this).find('span').text('[-]');
			} else {
				jQuery(this).find('span').text('[+]');
			}
			
			if( isSlider ) {
				var slider = jQuery('*[id^="slider_custom_"]'),
				    val;

				slider.each(function() {
					_this = jQuery(this);
					chk = _this.attr('checked');
					if( chk == true){
						val = jQuery(this).val();
					}
				});

				alliAdmin.clearSliderHeight();
			}
			
			jQuery.fx.off = true;
			jQuery(this).parent().toggleClass('active').next().toggle('fast', function() {
				jQuery.fx.off = true;
				
				if( isSlider ) {
					alliAdmin.refreshSliderHeight();
				}
				
			});
			jQuery.fx.off = false;
			e.preventDefault();
		});
	},
	
	wpMedia : function() {
		// Prepare the variable that holds our custom media manager.
		 var it_media_frame;
		 var formlabel = 0;
		 
		 // Bind to our click event in order to open up the new media experience.
		 jQuery('body').on('click', '.upload_button', function(e){
			 // Prevent the default action from occuring.
			 e.preventDefault();
			 // Get our Parent element
			 formlabel = jQuery(this).parent();
			 // If the frame already exists, re-open it.
			 if ( it_media_frame ) {
				 it_media_frame.open();
				 return;
			 }
			 it_media_frame = wp.media.frames.it_media_frame = wp.media({		 
				 //Create our media frame
				 className: 'media-frame it-media-frame',
				 multiple: false, //Disallow Mulitple selections
				 library: {
				 	type: 'image' //Only allow images
				 },
			 });
			 it_media_frame.on('select', function(){
				 // Grab our attachment selection and construct a JSON representation of the model.
				 var media_attachment = it_media_frame.state().get('selection').first().toJSON();
				 
				 // Send the attachment URL to our custom input field via jQuery.			 
				 formlabel.find('input[type="text"]').val(media_attachment.url);
			 });
			 
			 // Now that everything has been set, let's open up the frame.
			 it_media_frame.open();
		 });
		
	},
	
	fixField : function(field) {
		str = jQuery(field).val();
		jQuery(field).val(str.replace(/[^a-zA-Z_0-9]+/ig,''));
	},
	
	saveSidebar : function() {
		jQuery('.it_add_sidebar').click(function(e){
			
			if( !jQuery("#custom_sidebars").val() ){
				alert(objectL10n.sidebarEmpty);
			}
			
			if( jQuery("#custom_sidebars").val() ) {
				
				jQuery('#ajax-feedback').css({display:'block'});
				
				var _this = jQuery('#sidebar-to-edit'),
				    sidebarEdit = _this.find('li'),
				    count = sidebarEdit.length,
				    newID = ( _this.css('display') == 'none' )? count : count+1,
				    allIds = new Array;
				
				sidebarEdit.each( function() {
					if(jQuery(this).attr('id')){
						sidebarEditId = jQuery(this).attr('id').match(/\d+/g);
						if(sidebarEditId){
							allIds.push(parseInt(sidebarEditId));
						}
					}
				});

				while (jQuery.inArray(newID, allIds) != -1 ) {
					newID++;
				}
				
				var _wpNonce = jQuery('input[name=it_admin_wpnonce]'),
					allInputs = jQuery("#custom_sidebars"),
					action = jQuery('input[name=action]'),
					sidebarAction = jQuery('<input>', { type: 'text', name:'it_sidebar_save', val: true }),
					sidebarId = jQuery('<input>', { type: 'text', name:'it_sidebar_id', val: newID }),
					postData = _wpNonce.add(allInputs).add(action).add(sidebarAction).add(sidebarId).serialize();

				alliAdmin.ajaxSubmit(postData);
			}

			e.preventDefault();
		});
	},	
	
	addSidebar : function(data) {		
		var _this = jQuery('#sidebar-to-edit'),
			menuItem = jQuery('#sample-sidebar-item li'),
			template;
			
		if( jQuery(_this).css('display') == 'none' ){
			jQuery(_this).parent().find('.menu_clear').css('display','block');
			jQuery(_this).empty();
			jQuery(_this).css('display','block');
		}
						
		template = menuItem;

		template.clone()
			.attr('id',template.attr('id').replace(':',data.sidebar_id))

			.find('*').each( function() {
				jQuery(this).find('.sidebar-title').text(data.sidebar);

				var attrId = jQuery(this).attr('rel');
				if (attrId) jQuery(this).attr('rel', attrId.replace(':',data.sidebar_id));

			}).end()
			.appendTo(jQuery('#sidebar-to-edit'));

		jQuery('input[name=sidebar_action]').val('');
		jQuery('#custom_sidebars').val('');
	},
	
	sidebarDelete : function() {
		jQuery('body').on('click', '.delete_sidebar', function(e) {

			if (confirm(objectL10n.sidebarDelete)) {
				
				jQuery('#ajax-feedback').css({display:'block'});

				var sidebar = jQuery(this).attr('rel'),
					sidebarId = sidebar.match(/\d+/g);
					sidebarDelete = jQuery('#' +sidebar).find('.sidebar-title').text();
					
				var _wpNonce = jQuery('input[name=it_admin_wpnonce]'),
					allInputs = jQuery('<input>', { type: 'text', name:'it_sidebar_delete', val: sidebarDelete }),
					sidebarRm = jQuery('<input>', { type: 'text', name:'sidebar_id', val: parseInt(sidebarId) }),
					action = jQuery('input[name=action]'),
					postData = _wpNonce.add(allInputs).add(sidebarRm).add(action).serialize();

				alliAdmin.ajaxSubmit(postData);

				e.preventDefault();

			} else {

				e.preventDefault();
			}

		});
	},
	
	deleteSidebar : function(data) {
		var el = jQuery('#sidebar-item-' +data.sidebar_id);

		el.addClass('deleting').animate({
				opacity : 0,
				height: 0
			}, 350, function() {
				el.remove();
				_this = jQuery('#sidebar-to-edit');

				if(jQuery(_this).is(':empty')){
					jQuery(_this).parent().find('.menu_clear').css('display','none');
					jQuery(_this).css('display','none');
				}
			});
	},
	
	tooltipHelp : function() {
		jQuery('.it_option_help a').click(function(e){
			e.preventDefault();
		});
		
		jQuery('body').on('mouseover', '.it_option_help a', function(){
		   if (!jQuery(this).hasClass("tooledUp")){
		      jQuery(this).tooltip({ delay: 0, predelay: 0, relative: true, offset: [0, -130],  relative: true, tipClass: 'it_help_tooltip' });
		      jQuery(this).tooltip().show();
		      jQuery(this).addClass("tooledUp");
		      }
		});
	},
	
	colorPicker : function() {
		var myOptions = {			
			defaultColor: false,
			change: function(event, ui){},
			clear: function() {},
			hide: true,
			palettes: true
		};
		jQuery('.wp-color-picker').wpColorPicker(myOptions);
	},	
	
	/**
	 * Shorcodes functions
	 */
	shortcodeSelect : function() {
		jQuery('.shortcode_selector select').val('');
		jQuery('.shortcode_type_selector select').val('');
		
		jQuery('.shortcode_selector select').change(function(){
			var selected = 'shortcode_'+jQuery(this).val();
			
			jQuery('.shortcode_wrap').each(function(){
				var el = jQuery(this),
				    _id = el.attr('id');
				
				if ( _id == selected ) {
					jQuery(this).children().each(function(){
						var _class = jQuery(this).attr('class');
						if( ( _class != 'shortcode_type_selector' ) && ( el.hasClass( 'shortcode_has_types' ) ) ) {
							jQuery(this).css({display: 'none'});
						}
					});
					jQuery(this).css({display: 'block'}).addClass('shortcode_selected');
				} else {
					jQuery(this).css({display: 'none'}).removeClass('shortcode_selected');
				}
			});
			
			var val = jQuery('#'+selected).find('.shortcode_type_selector select').val();
			if( val ) {
				jQuery('.shortcode_atts_'+val).css({display: 'block'});
			}
			
		});
		
		
		jQuery('.shortcode_wrap').each(function(){
			var el = jQuery(this);
			var selector = el.find('.shortcode_type_selector select');
			
			selector.change(function(){
				var val = 'shortcode_atts_'+jQuery(this).val()
				
				el.children().each(function(){
					var _this = jQuery(this);
					if( ( _this.hasClass( val ) ) ){ 
						_this.css({display: 'block'});
					} else {
						if ( !_this.hasClass( 'shortcode_type_selector' ) ){
							_this.css({display: 'none'});
						}
					}
				});
			});
		});
	},
	
	shortcodeMultiply : function() {
		jQuery('body').on('change', '.shortcode_selected .shortcode_multiplier select', function(){
			
			var _html = new Array(),
			    cloneCount = jQuery(this).val(),
				 _id;
			
			jQuery('.shortcode_selected').each(function(){
				_id = jQuery(this).attr('id');
				
				jQuery(this).children().each(function(){
					var _this = jQuery(this);
					
					if( ( _this.is(':visible') ) && ( !_this.hasClass( 'shortcode_type_selector' ) ) && ( !_this.hasClass( 'shortcode_multiplier' ) ) && ( !_this.hasClass( 'shortcode_dont_multiply' ) ) ) {
						if( !_this.hasClass( 'clone' ) ) {
							_html.push(_this.addClass( 'clone' ).clone());
							_this.removeClass( 'clone' );
						}
						if( _this.hasClass( 'clone' ) ) {
							_this.remove();
						}
					}
				});
			});
			
			var i=0;
				while ( i<cloneCount ) {
					for ( j in _html ) {
						var newClone = _html[j].clone().find('*').each( function() {
							var titleReplace = jQuery(this).hasClass('it_option_header');
							if( titleReplace ) {
								text = jQuery(this).html();
								text = text.replace('1', i+2);
								jQuery(this).html(text);
							}
						}).end();
						jQuery('#' + _id).append(newClone);
					}
				  i++;
				 }
			});
	},
	
	shortcodeInsert : function() {
		jQuery('#shortcode_send').click(function(){
			
			var scSelected = jQuery('.shortcode_selected'),
			    _val = ( scSelected.find('.shortcode_type_selector').length ) ? scSelected.find('.shortcode_type_selector select').val() : jQuery('.shortcode_selector select').val();
			
			if( !_val )
				return false;
				
			var str = '',
				atts = '',
				_nestedVal = '';
				_nestedName = '';
				scSelectedAtts = 'shortcode_atts_'+_val,
				carriageReturn = false,
				rich = (typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden(),
				_return = (rich) ? '<br />' : '\n';
			
			var shortCode = new Array(),
				optionalWrap = new Array(),
				multiDropdown = new Array(),
				chkBoxes = new Array(),
				scAtts = new Array(),
				scContent = new Array(),
				multiplyAtts = new Array();
			
			var attsCount = 0,
				contentCount = 0,
				attsMultiplyCount = 0,
				contentMultiplyCount = 0;
			
			jQuery('.'+scSelectedAtts).each(function(i){
				_this = jQuery(this);
				_input = _this.find('.it_option :input');
				_nestedVal = scSelected.find('input[type=hidden]').val();
				_nestedName = scSelected.find('input[type=hidden]').attr('name');
				if(_nestedName){
					_nestedName = _nestedName.match(/sc_nested_(.*)/);
				}
				
				// standard shortcodes
				if( (!_this.hasClass('shortcode_multiplier')) && (!_this.hasClass('shortcode_multiply')) ){
					
					if(_this.hasClass('shortcode_carriage_return')){
						carriageReturn = true;
					}
					
					atts = _input.attr('id').match(/[^-]+/gi);
					
					// shortcode content
					if(atts[2] == 'content'){
						shortCode.push(atts[1]);
						scContent.push(_input.val());
						contentCount++;
					}
					
					// shortcode atts
					if( (atts[2] != 'content') && (_input.val()) ){
						
						// multidropdown atts
						if( _input.parent().hasClass('multidropdown') ){
							multiLength = _this.find('.it_option :input').length;
							_input.each(function(i){
								if(jQuery(this).val()) {
									multiDropdown.push(jQuery(this).val());
								}
								if( (i == multiLength -1) && (multiDropdown.length >0) ){
									atts = _input.parent().attr('id').match(/[^-]+/gi);
									scAtts.push(' ' + atts[2].replace(']', '') + '="' + multiDropdown.join(',') + '"');
									multiDropdown = new Array();
								}
							});
							
						} else if(_input[0].type == 'checkbox'){
							chkBoxLength = _this.find('.it_option :checkbox').length;
							_input.each(function(i){
								if( (jQuery(this).attr('checked')) && (!_this.hasClass('shortcode_optional_wrap')) ){
									chkBoxes.push(jQuery(this).val());
								}
								if ( (i == chkBoxLength - 1) && (chkBoxes.length >0) ){
									scAtts.push(' ' + atts[2] + '="' + chkBoxes.join(',') + '"');
									chkBoxes = new Array();
								} else {
									if(_this.hasClass('shortcode_optional_wrap')){
										optionalWrap.push(true);
										if(jQuery(this).attr('checked')){
											optionalWrap.push(atts[2]);
										}
									}
								}
							});
							
						} else if(_input[0].type == 'radio'){
							_input.each(function(i){
								if(jQuery(this).attr('checked')){
									scAtts.push(' ' + atts[2].replace(/_[0-9]*/,'') + '="' + jQuery(this).val() + '"');
								}
							});
								
						} else {
							// all other atts
							if(_input.val()){
								scAtts.push(' ' + atts[2] + '="' + _input.val() + '"');
							} else {
								scAtts.push('');
							}
						}

						attsCount++;
					}
				}
				
				// multiplied shortcode atts
				if( _nestedName || optionalWrap ){
					if( _this.hasClass('shortcode_multiply') ){
						atts = _input.attr('id').match(/[^-]+/gi);
						
						// multiplied shortcode content
						if(atts[2] == 'content'){
							shortCode.push(atts[2]);
							scContent.push(_input.val());
							contentMultiplyCount++;
						}
						
						// multiplied shortcode atts
						if(atts[2] != 'content'){
							if(_input.val()){
								multiplyAtts.push(' ' + atts[2] + '="' + _input.val() + '"');
							} else {
								multiplyAtts.push('');
							}
							attsMultiplyCount++;
						}
						
					} else {

						// contact form shortcode
						if(_val == 'contactform'){
							if( i <= 4 ) {
								if( i==0 ) str += '[' + _val;

								if( (_input[0].type == 'checkbox') ) {
									_input.each(function(i){
										_chk = jQuery(_input[i]);
										if(_chk.attr('checked')){
											atts = _chk.val().match(/[^-]+/gi);
											str += ' ' + atts[0] + '="' + atts[1] + '"';
										}
									});

								} else if ( ( _input.val() ) && ( _input[0].type != 'checkbox' ) ) {
									str += ' ' + atts[2] + '="' + _input.val() + '"';
								}

								if( i==4 )	str += ']' + _return;

							} else {

								if(!_this.hasClass('contactform_clone')){
									str += '[' + _this.find('.it_option_header').text().toLowerCase();
									_input.each(function(i){
										_id = jQuery(this).attr('id');
										if(_id){
											atts = _id.match(/[^-]+/gi);
											if( ( this.type == 'checkbox' ) && ( jQuery(this).attr('checked') ) ) {
												str += ' ' + atts[2] + '="' + jQuery(this).val() + '"';
											} else if ( ( jQuery(this).val() ) && ( this.type != 'checkbox' ) ) {
												str += ' ' + atts[2] + '="' + jQuery(this).val() + '"';
											}
										}
									});
									str += ']' + _return;
									contentMultiplyCount++;
								}
							}
						}
					}
					
					
				}
				
			});
			
			
			// scroll to top on shortcode send to editor
			if(jQuery.browser.safari){ bodyelem = jQuery('body') } else { bodyelem = jQuery('html') }
			  bodyelem.animate({
			    scrollTop:0
			  }, 'fast' );
			
			
			// return contact form shortcode
			if(_val == 'contactform'){
				if(contentMultiplyCount>0)
					str += '[/' + _val + ']' + _return;

				return send_to_editor(str);
			}
			
			// return nested or optionally wrapped shortcodes
			if( _nestedName || optionalWrap.length >0 ){
				for(var i in shortCode){
					attsNum = attsMultiplyCount/contentMultiplyCount;

					slice1 = attsNum*i;
					slice2 = (attsNum*i)+attsNum;
					
					if(optionalWrap.length >0){
						str += '[' + _val + multiplyAtts.slice(slice1,slice2).join('') + ']'+ scContent[i] + '[/' + _val + ']' + _return;
					} else {
						str += '[' + _nestedVal + multiplyAtts.slice(slice1,slice2).join('') + ']'+ scContent[i] + '[/' + _nestedVal + ']' + _return;
					}
				}
				
				if(optionalWrap.length >0){
					if(optionalWrap.length == 2){
						return send_to_editor('[' + optionalWrap[1] + ']' + _return + str + '[/' + optionalWrap[1] + ']' + _return);
					} else {
						return send_to_editor(str);
					}
				} else {
					return send_to_editor('[' + _val + scAtts.join('') + ']' + _return + str + '[/' + _val + ']' + _return);
				}
			}
			
			// return shortcodes with content
			if(shortCode.length >0){
				for(var i in shortCode){
					attsNum = attsCount/contentCount;

					slice1 = attsNum*i;
					slice2 = (attsNum*i)+attsNum;

					if(carriageReturn){
						str += '[' + shortCode[i] + scAtts.slice(slice1,slice2).join('') +']' + _return + scContent[i] + _return + '[/' + shortCode[i] + ']' + _return;
					} else {
						str += '[' + shortCode[i] + scAtts.slice(slice1,slice2).join('') +']' + scContent[i] + '[/' + shortCode[i] + ']' + _return;;
					}
				}
				
				return send_to_editor(str);
			}

			// return all other shortcodes
			return send_to_editor('[' + _val + scAtts.join('') + ']');
				
		});

	},
	
	customDropdowns : function() {
		/**
		 * Font Select
		 */
		var isIE = ( jQuery.browser.msie ) ? true : false;

		if( isIE ){
			jQuery('.typography_option_set .it_option').append('<iframe class="fontiehack" src="javascript:false;" marginwidth="0" marginheight="0" align="bottom" scrolling="no" style="position:absolute; right:0; top:0px; display:block; filter:alpha(opacity=0);"></iframe><div class="font_select"></div>');
		}else{
			jQuery('.typography_option_set .it_option').append('<div class="font_select"></div>');
		}
		
		jQuery('.font_select').click(function(e) {
			
			if( isIE ){
				var fonts = jQuery(this).prev().prev(),
					fontImages = fonts;
			}else{
				var fonts = jQuery(this).prev(),
					fontImages = fonts.prev();
			}
				
			var fontList = fonts.find('option'),
			    fontTitle = '',
			    fontClass;
			
			if(fontImages.hasClass('font_images')){
				if(fontImages[0].style.display != 'block'){
					jQuery('.font_images').css('display','none');
					jQuery('.pattern_images').css('display','none');
					document.onclick = function() {
						document.onclick = function() {
							jQuery('.font_images').css('display','none');
							jQuery('.pattern_images').css('display','none');
							document.onclick = null;
						}
					}
				
					fontImages.css('display','block');
				}
				return;
			}
				
			fontList.each(function(){
				fontClass = this.text.replace(/ /g, '').toLowerCase();
				fontTitle += '<a title=\'' +this.value+ '\' href="#" class="single_font ' +fontClass+ '">' +this.text+ '</a>';
			});
			
			jQuery('.font_images').css('display','none');
			jQuery('.pattern_images').css('display','none');
			document.onclick = function() {
				document.onclick = function() {
					jQuery('.font_images').css('display','none');
					jQuery('.pattern_images').css('display','none');
					document.onclick = null;
				}
			}
			
			jQuery('<div class="font_images">' +fontTitle+ '</div>').insertBefore(jQuery(this).prev()).css('display','block');
			
			e.preventDefault();
		});
		
		/**
		 * Patten select
		 */
		jQuery('.preset_pattern').click(function(e) {
			var patterns  = jQuery(this).prev().prev();
			
			if(patterns[0].style.display != 'block'){
				jQuery('.font_images').css('display','none');
				jQuery('.pattern_images').css('display','none');
				document.onclick = function() {
					document.onclick = function() {
						jQuery('.font_images').css('display','none');
						jQuery('.pattern_images').css('display','none');
						document.onclick = null;
					}
				}
				
				patterns.css('display','block');
			}
			
			e.preventDefault();
		});
	},
	
	customSelects : function(e) {
		// Font select
		jQuery('.typography_option_set').on('click', '.single_font', function(e){
			if(jQuery.browser.msie) {
				jQuery(this).parent().prev().val(jQuery(this).attr('title'));
			}else{
				jQuery(this).parent().next().val(jQuery(this).attr('title'));
			}
			
			jQuery('.font_images').css('display','none');
			e.preventDefault();
		});
		
		// Pattern select
		jQuery('.single_pattern').click(function(e) {
			jQuery(this).parent().next().val(jQuery(this).attr('title'));
			jQuery('.pattern_images').css('display','none');
			e.preventDefault();
		});
	}
	
	
}// end alliAdmin

jQuery(document).ready(function(){
	alliAdmin.init();	
});
