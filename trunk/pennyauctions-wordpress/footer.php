<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 */
?>
<?php wp_pagenavi(); ?>

<div id="primary" class="content-area portfolio">
<div id="content" class="site-content portfolio-text" role="main">
<?php if ( !is_user_logged_in() ) { ?>
<h2>You have to Login or Register before donating</h2>
<p><?php wp_loginout('http://www.triplegood.co.za'); ?></p>
<p><a href="http://www.triplegood.co.za/wp-login.php?action=register&redirect_to">Register Page</a></p>

<?php } else { ?>
<h2>Enter by donating or invites via Facebook or Gmail</h2>

 <p><?php echo do_shortcode( '[wsi-widget title="Every invite counts as a ticket entry"]' ) ?></p>  
 
 <h2>Every Dollar counts as one ticket entry.</h2>
 <p><?php echo do_shortcode( "[donateplus]" ) ?> </p>
 
 <p><?php wp_loginout('http://www.triplegood.co.za'); ?></p>
<?php } ?>
</div><!-- #content -->
</div><!-- #primary -->

</div><!-- #main -->	
<?php get_sidebar(); ?>
	
	</div><!-- #container -->
				<div class="clear">&nbsp;</div>		
				
			<div id="prefooter">


		
			<div id="prefooter-container"> 
<br />
<div class="clear">&nbsp;</div>	
				
			</div><!-- #prefooter-container -->


		</div><!-- #prefooter-->
	
	<div id="footer">
		<div id="footer-container">
		Copyright &copy; 2009 pennyauctions - All Rights Reserved. - <a href="&#109;a&#105;l&#116;&#111;:&#108;&#105;&#103;&#104;&#116;&#115;&#105;&#116;&#101;&#115;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">lightsites@gmail.com</a> - 

		</div><!-- #footer-container -->
	</div><!-- #footer -->

<?php wp_footer(); ?>

<script type="text/javascript">
$('h1').FontEffect({ shadow:true  });
$('h4').FontEffect({ shadow:true  });
</script> 

</body>
</html>