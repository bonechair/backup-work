jQuery( document ).ready(function() {
			jQuery('.ui-tabs-panel').hide();
			jQuery('.ui-tabs-nav').hide();
			jQuery('.exit').hide();
			
			jQuery('html, body').animate({ scrollTop: 0 }, "slow");
			
			jQuery('.close-ajax-container').click(function () {
			
				jQuery('.profile').hide();	
				
		    });	
			jQuery('.like-button').click(function () {

		        jQuery('.ui-tabs-panel').hide();
		        jQuery('.ui-corner-top a').css('color', '#444');
				jQuery('#t-2').css('color', '#fff');
			 	jQuery('.ui-tabs-nav').show();
				jQuery('.exit').show();

					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	

				   	 jQuery('.portfolio-entry').show();	
					 
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');	
					 jQuery('.profile').hide();
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
					 jQuery('.profile').hide();
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
					 jQuery('.profile').hide();
			});
       
			var numItems = 3;
			var gold = 1;
			var silver = 1;
			var bronze = 1;
			
			function medald(s) {
				if(s == 'gold')gold--;
				if(s == 'silver')silver--;
				if(s == 'bronze')bronze--;
			}
			jQuery( '#fragment-2 .checkmark' ).each(function( index ) {
			  numItems--;
			  if(jQuery( this ).hasClass('gold'))medald('gold');
			  if(jQuery( this ).hasClass('silver'))medald('silver');
			  if(jQuery( this ).hasClass('bronze'))medald('bronze');
			});
			if(gold == 1 && silver == 1 && bronze == 0)jQuery('#nvotes2').html('(Gold & Silver Left)');
			if(gold == 1 && silver == 0 && bronze == 1)jQuery('#nvotes2').html('(Bronze & Gold Left)');
			if(gold == 0 && silver == 1 && bronze == 1)jQuery('#nvotes2').html('(Bronze & Silver Left)');

			if(gold == 1 && silver == 0 && bronze == 0)jQuery('#nvotes2').html('(Gold Left)');
			if(gold == 0 && silver == 0 && bronze == 1)jQuery('#nvotes2').html('(Bronze Left)');
			if(gold == 0 && silver == 1 && bronze == 1)jQuery('#nvotes2').html('(Silver Left)');
			
			if(numItems == 2){
				jQuery('#nvotes').html('1 vote');
			}else {
				jQuery('#nvotes').html(numItems + ' votes');
			}
			
			
			
		});