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
		Copyright &copy; 2009 LIGHTSITES - All Rights Reserved - <a href="&#109;a&#105;l&#116;&#111;:&#108;&#105;&#103;&#104;&#116;&#115;&#105;&#116;&#101;&#115;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">lightsites@gmail.com</a> - 
<a href="http://www.web-design-directory.co.za">South African Web Design Companies</a> member	

		</div><!-- #footer-container -->
	</div><!-- #footer -->

<?php wp_footer(); ?>

<script type="text/javascript">
$('h1').FontEffect({ shadow:true  });
$('h4').FontEffect({ shadow:true  });
</script> 

</body>
</html>