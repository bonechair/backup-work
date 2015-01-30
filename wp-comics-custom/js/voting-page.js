		jQuery(function() {
		
			jQuery('.ui-tabs-panel').hide();
			jQuery('.ui-tabs-nav').hide();
			jQuery('.exit').hide();
			
			jQuery('.like-button').click(function () {

		        jQuery('.ui-tabs-panel').hide();
		        jQuery('.ui-corner-top a').css('color', '#444');
				jQuery('#t-2').css('color', '#fff');
			 	jQuery('.ui-tabs-nav').show();
				jQuery('.exit').show();

					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();	
					 
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');						 
			});

			jQuery('.ui-corner-top a').click(function() { 
		           jQuery('.ui-tabs-panel').hide();
		           jQuery('.ui-corner-top a').css('color', '#444');
				   jQuery('#t-' + jQuery(this).attr("rel")).css('color', '#fff');
				   
				   var s = jQuery(this).attr("rel");
				   if(s == 1) {
				     jQuery('#fragment-1').fadeIn('slow');		 
				   }				   					   
				   if(s == 2) {
					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();	
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');	
				   	 jQuery('#f1').hide();						 
				     jQuery('#f2').show();	
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();						 
				   }
				   if(s == 3) {
				 	 jQuery(".close-ajax-container").trigger('click');
				     jQuery('#f2').hide();						 
				     jQuery('#f1').show();
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();					 
				     jQuery('#fragment-2').fadeIn('slow');		   
				     jQuery('.blackops').css('background', '#000');			   	   
				     jQuery('.blackops').css('opacity', 0.8);			   				 
				   }
				   if(s == 4) {
				     jQuery('#fragment-4').fadeIn('slow');			   
				   }				   

	
				   if( s != 1) {
				     jQuery('.ui-tabs-nav').show();
				     jQuery('.exit').show();
				   }
				   else {
				     jQuery('.ui-tabs-nav').hide();
				     jQuery('.exit').hide();
				   }
				   return false;
		       });			
			   
			jQuery('.next-tab, .prev-tab').click(function() { 
		           jQuery('.ui-tabs-panel').hide();
		           jQuery('.ui-corner-top a').css('color', '#444');
				   jQuery('#t-' + jQuery(this).attr("rel")).css('color', '#fff');
				     
				   var s = jQuery(this).attr("rel");
				   if(s == 1) {
				     jQuery('#fragment-1').fadeIn('slow');					 
				   }				   					   
				   if(s == 2) {
					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();		
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');
				   	 jQuery('#f1').hide();						 
				     jQuery('#f2').show();	
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();						 
				   }
				   if(s == 3) {
				   
				   	 jQuery(".close-ajax-container").trigger('click');
				   	 jQuery('#f2').hide();						 
				     jQuery('#f1').show();	
					 jQuery('#f4').hide();						 
				     jQuery('#f3').show();	
				     jQuery('#fragment-2').fadeIn('slow');			   	   
				     jQuery('.blackops').css('background', '#000');			   	   
				     jQuery('.blackops').css('opacity', 0.8);			   	   
				   }			   
				   if(s == 4) {
				     jQuery('#fragment-4').fadeIn('slow');			   
				   }	
				   if( s != 1) {
				     jQuery('.ui-tabs-nav').show();
				     jQuery('.exit').show();
				   }
				   else {
				     jQuery('.ui-tabs-nav').hide();
				     jQuery('.exit').hide();
				   }
				   return false;
		       });
       
			var numItems = jQuery('#fragment-2 .place').length;
			numItems = 3 - numItems;
		
			if(numItems == 2){
				jQuery('#nvotes').html('1 vote');
			}else {
				jQuery('#nvotes').html(numItems + ' votes');
			}
			
			
			
		});