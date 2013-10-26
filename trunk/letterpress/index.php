<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); 

?>


<div class="container_12" id="MainContentArea">

<!--<br /><br /> -->
<?php
 include("sidemenu.php");
?>
	<div style="float:left; width:589px; margin-right:20px;">	<!--start middle column-->
	
	
 
<div id="featured-item"><ul id="featured-itemContent">


<li style="display: list-item; opacity: 0.902031;" class="featured-itemImage"> 
               
 <a href="http://localhost/letterpress/bookplates/" style="text-decoration:none;">

	<img src="The%20Letterpress%20Company_files/letterpress_letters.jpg" alt="featured">                 
  <span style="display: block;">                       
     <strong>Bookplates</strong>            
        <b>90x70mm
 30 book plates 
 3 designs (quiver tree, baobab tree, Eastern Cape palm)
 10 of each design
 Olive, midnight blue, rainforest inks
 Cream, smooth paper 120gsm
.. </b> 
                       
                 	<em class="price"><br>

			R99.00
 			</em>  
		 
               
     </span>
     </a>
    </li>
    
 
                

<li class="clear featured-itemImage"></li></ul></div>
<!-- END ShopperPress Slider -->

<div class="frontcontent">
<h2>YOUR STYLE AND BEAUTY PRECEDE YOU</h2> 
<p>Let your stationery make a memorable entrance when you cannot personally deliver your message.</p>

<p>For social and business communication or simply everyday elegance, 
our luxury letterpress stationery is breathtaking to behold and a joy to
 receive.</p>

<p>As South Africa's only luxury letterpress printer, we treat your 
stationery like a work of art, starting with the quality of the 
"canvas". Our plush, fine papers are imported from some of the oldest 
paper mills in the world (in Italy, France, the UK, and America) and as a
 rapidly renewable resource, cotton papers make it possible to enjoy the
 ultimate luxury stationery in good conscience.</p>

<p>Befitting a purchase of luxury stationery, all orders are packaged in
 hand-lined, indigo linen presentation boxes and tied with satin ribbon 
in our distinctive cerise and saffron colours.</p>

<p>Luxury stationery makes a much-covetted gift and The Letterpress 
Company's products come all dressed-up and ready for presenting.</p>

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
</div><div class="clearfix"></div></div>


<div style="float:right; width:180px; position:relative; right:0px;" class="rightstuff">	<!--start right column-->
	

<div class="menubox_box">
		
<h2><span style="background-color: #927D84;color: #FFFFFF;font-family: Georgia,'Times New Roman',Times,serif;font-size: 0.8em;letter-spacing: 2.7px;padding: 2px;">NEWS FROM OUR BLOG</span></h2> 


<?php
// The Query
query_posts( $args );

// The Loop
while ( have_posts() ) : the_post();
?>
  <div class="post">
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
  <small><?php the_date(); ?></small> 
</div>
<div class="sidebar-post" style="margin-top:5px;"><p>
<?php the_excerpt(); ?></p>
<a href="<?php the_permalink(); ?>"><small style="color:#927D84; font-family: 'Trebuchet MS',Arial,Helvetica,sans-serif;font-size: 10px;margin-bottom: 10px;">Read full post</small></a>
</div>
<br>
<?php
  endwhile;

// Reset Query
wp_reset_query();

?>	
 
<?php get_sidebar(); ?>			
	</div><!--end right column-->
	</div><!--end right column-->



<?php get_footer(); ?>