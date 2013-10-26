<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
if(!$_GET['ajax']) {
 ?>

<?php wp_pagenavi(); ?>


<div style="padding:12px; padding-top:0px; ">

	<div style="float:left; width:650px; margin-right:20px;">	
	
		
	</div>
	
	
	<div style="float:left; width:260px;">	
	
	
	</div>

</div>

<!-- DISPLAY ITEMS --> 

<div style="clear:both;"></div>

	
<div style="clear:both;"></div>

<!-- BOTTOM ELEMENTS -->

 <div style="clear:both;"></div>


<div style="clear:both;"></div>

<br>

  
 </div>


<div class="footerbanner"></div>
<div class="container_12" id="Footer">
 
<p id="copyrightBar">

	Copyright © 2013 THE LETTERPRESS COMPANY - 
 
   
    
    Developed By <a href="mailto:warren@halo.co.za" target="_blank">Halo</a>    
    -  
    
    	<a href="/terms/">  Terms </a> | <a href="/privacy/">Privacy Policy</a> 
	
</p>
 
</div>

<?php 
}
wp_footer(); 
?>

</body></html>