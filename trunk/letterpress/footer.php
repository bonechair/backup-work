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


<div style="clear:both;"></div>

</div>
<?php
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
$emporium = false;

if($terms) {


	foreach ($terms as $term) {
		if($term->name == 'Emporium') {
		  $emporium = true;
		}
	}    
}

?>
<?php if ($emporium == true) {?>
<div class="footerbanner"><img src="/wp-content/themes/letterpress/img/footerbannerblack.png" width="960"></div>

<?php 
}
?>
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