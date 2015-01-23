<?php
/*
Template Name: Partners
*/

?><?php get_header();?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
   	   
  		<?php if ( has_post_thumbnail() ) { ?>
				<section class="sc-parallax" style="background-image:url(<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>
			);font-size:;" data-stellar-background-ratio="0.5" >
					           <div class="row"><div class="containerCentered">
							<h3></h3></div> <div class="sc-mask"></div>
					            <div class="container">
			<section class="sc-header-sub">
	       
			   	        <div class="containerCentered">
			   	            <div class="row">
			   	<h1 id="changingtext"><?php the_title(); ?></h1>
			   	        </div>
			   	    </section>
					                </div> 
					            </div>
					        </section>
     <?php } else { ?>  
	   
	    <section class="sc-header-sub">
	       
   	        <div class="containerCentered">
   	            <div class="row">
   	<h1 id="changingtext"><?php the_title(); ?></h1>
   	        </div>
   	    </section>
		<?php } ?>
		<div class="container box">
    

<div class="row">
  <div class="col-md-12">
	  
    <?php the_content(); ?>
  </div>
  <?php endwhile; ?>
  <?php endif; ?>
  </div></div>

<?php if(get_post_meta($post->ID, "_sc_meta_value_key", true) ) { ?>
<script>

jQuery(document).ready(function () {
(function($) {
  var repl = $('#changingtext span').text()
  var t=[ "<?php echo get_post_meta( $post->ID, '_sc_meta_value_key', true ); ?>",repl],
      $h1 = $("#changingtext"),
      $sp = $h1.find("span"),
      i=0,
      widths=[];

  $.each(t, function(i, v){
      var el = $('<span />', {text:v}).appendTo($h1);
      widths.push(el.width());
      el.remove();
  });
  
  $sp.css({opacity:0});
  
  (function loop(){
     i = ++i%t.length;    
     $sp.text(t[i]).animate({width:widths[i]}, 500, function(){
       $(this).animate({opacity:1},500).delay(3000).animate({opacity: 0}, 500, loop); 
      });     
  })(); 

})(jQuery);
});
</script>
<?php } ?>

<script type="text/javascript">
jQuery(function() {

jQuery(window).bind('load', function() {

    jQuery("#js_sort_items").hide();

    jQuery(".partners_sort_button").trigger('click');

});
});	
</script>

<?php get_footer();?>