$(document).ready(function(){

   /*  new cycle, more info @ http://malsup.com/jquery/cycle/  */
   $('.cycle-1').cycle({ 
       fx:     'fade', 
       speed:   200, 
       timeout: 10000, 
       clip:   'zoom' 
	 });
		 
	/*  You can use this code to fade the controlicons in de head of the boxes */
    /*	
	$(".box-780-head img").fadeTo("slow", 0.5); 
	$(".box-780-head img").hover(function(){
			$(this).fadeTo("fast", 1.0); 
		},function(){
			$(this).fadeTo("fast", 0.5);
		});
    */
	
	/*  Remove the selected box  */
	$(".delete").click(function() {								
		if(confirm('This box will be removed, ok?')) {
				$(this).parents('li').animate({
					opacity: 0    
				},function () {
					$(this).remove();
				});
		}
		return false;
	  });
	
    /* Remove and highlighting the dialog boxes */
	/* succes */
	$(".del-x").click(function() {
				$(this).parents('.dialog-box-success').effect("highlight", {}, 400).animate({
					opacity: 0    
				},function () {
					$(this).remove();
				});
		return false;
	  });
	/* error */
	$(".del-x").click(function() {
				$(this).parents('.dialog-box-error').effect("highlight", {}, 400).animate({
					opacity: 0    
				},function () {
					$(this).remove();
				});
		return false;
	  });
	/* warning */
	$(".del-x").click(function() {
				$(this).parents('.alertbox').effect("highlight", {}, 400).animate({
					opacity: 0    
				},function () {
					$(this).remove();

				});
		return false;
	  });
	/* information */
	$(".del-x").click(function() {
				$(this).parents('.dialog-box-information').effect("highlight", {}, 400).animate({
					opacity: 0    
				},function () {
					$(this).remove();
				});
		return false;
	  });

    /* toggle selected box */
	$(".toggle").click(function(){
	   var id = $(this).attr('id');
		  $("#tog"+ id).slideToggle("slow");
		  
			 if ($('#'+ id + ' img.close').is(":hidden")){
				 $('#'+ id +' img.close').show();
				 $('#'+ id +' img.open').hide();
			  } else {
				 $('#'+ id + ' img.open').show();
				 $('#'+ id + ' img.close').hide();
			  }
	});

    /* This will give every even tr(row) a backgroundcolor */
    /* When hover a row it will light up */
	$("#tb-1 tr, #tb-2 tr").mouseover(function() {
		$(this).addClass("row-over");}).mouseout(function() {
			$(this).removeClass("row-over");
			});
	
           $("#tb-1 tr:even, #tb-2 tr:even").addClass("row");




});





	




