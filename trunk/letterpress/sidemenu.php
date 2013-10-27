<div style="float:left;margin-right:24px;"><!--start categories--> 

<div style="clear:both;"></div>

<?php //echo do_shortcode('[accordionmenu id="unique67c6a36" accordionmenu="47"]	');?>

<div class="menubox_box">	

<?php
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
$emporium = 0;
$beskope = 0;

if($terms) {

	foreach ($terms as $term) {
		if($term->name == 'Bespoke') {
		
			$beskope = 1;
			
		}	
		if($term->name == 'Emporium') {
		
		  $emporium = 1;
		  
		}

	}    
}


if ( $emporium && !is_product_category(array('emporium', 'bespoke', 'invitations-bespoke', 'business', 'business-social-bespoke'))) {
?>
<ul id="sidemenu" style="letter-spacing:1px">

<li><h3>FILTER BY</h3></li>
<ul>
<li><a href="?">&#9633; BEST SELLERS</a></li>
<li><a href="?orderby=date">&#9633; NEWEST</a></li>
<li><a href="?orderby=popularity">&#9633; POPULARITY</a></li>
<li><a href="?orderby=rating">&#9633; RATING</a></li>
</ul>

<li><h3>TAGS</h3></li>
<ul>
<?php
$posttags = get_the_terms( $post->ID, 'product_tag' );
if ($posttags) {
  foreach($posttags as $tag) {
    echo '<li><a href="/product-tag/' . $tag->slug . '/">&#9633; ' . $tag->name . '</li>'; 
  }
}
?>
</ul>


<li><h3>PRICE</h3></li>
<ul>
<li><a href="?min_price=0&max_price=25">&#9633; CLASSIC ( From R25 )</a></li>
<li><a href="?min_price=25&max_price=35">&#9633; DELUXE ( From R35 )</a></li>
<li><a href="?min_price=35&max_price=45">&#9633; PREMIUM ( From R45 )</a></li>
<li><a href="?min_price=45&max_price=999999">&#9633; ABOVE</a></li>
</ul>
<li>
<? /**
<br>
<?php dynamic_sidebar( 'Left Hand Sidebar Emporium' ); ?>
</li>

**/
?>
</ul>	
<?php
}

else {
?>


<ul id="sidemenu">

<?php
$taxonomy     = 'product_cat';
$orderby      = 'name';
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$empty        = 0;

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);
?>

<?php $all_categories = get_categories( $args );

foreach ($all_categories as $cat) {  

    if($cat->category_parent == 0) {?>


<?php   $category_id = $cat->term_id;

if($emporium == 1 && $category_id == 25)continue;
if($beskope == 1 && $category_id == 21)continue;

        echo '<li><a  class="first-parent" href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>';


        $args2 = array(
          'taxonomy'     => $taxonomy,
          'child_of'     => 0,
          'parent'       => $category_id,
          'orderby'      => $orderby,
          'show_count'   => $show_count,
          'pad_counts'   => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li'     => $title,
          'hide_empty'   => $empty

        );

        $sub_cats = get_categories( $args2 );
        if($sub_cats) {
		echo "<ul>";
            foreach($sub_cats as $sub_category) {

        if($sub_cats->$sub_category == 0) {

            echo '<li><a class="second-parent" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>';
            
		}


		  $category_id3 = $sub_category->term_id;
          $args3 = array(
          'taxonomy'     => $taxonomy,
          'child_of'     => 0,
          'parent'       => $category_id3,
          'orderby'      => $orderby,
          'show_count'   => $show_count,
          'pad_counts'   => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li'     => $title,
          'hide_empty'   => $empty

        );

			$sub_cats3 = get_categories( $args3 );
			if($sub_cats3) {	
			echo "<ul>";			
			foreach($sub_cats3 as $sub_category3) {

			if($sub_cats3->$sub_category3 == 0) {

				echo '<li><a class="third-parent"href="'. get_term_link($sub_category3->slug, 'product_cat') .'"> < '. $sub_category3->name .'</a></li>';
				
				}
			}
				echo "<ul>";
			}
		}
        echo '</li></ul>';
        }
		else {
		 echo "<ul>";
		}
		?>

<?php   } 
 } ?>
			</ul>

<?php
}
?>

	<? /**	
	<ul id="menu-letterpresssidemenu" class="menu">
	<li id="menu-item-386" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-386"><a href="/bespoke">BESPOKE</a>
	<ul class="sub-menu">
		<li id="menu-item-155" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-155"><a href="/invitations/"> > INVITATIONS</a></li>
		<li id="menu-item-177" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-177"><a href="/business-social/"> > BUSINESS &amp; SOCIAL</a></li>
	</ul>
	</li>
	<li id="menu-item-386" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-386"><a href="/emporium">EMPORIUM</a>
	<ul class="sub-menu">
		<li id="menu-item-155" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-155"><a href="/product-category/emporium/invitations"> > INVITATIONS</a></li>
		<li id="menu-item-177" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-177"><a href="/product-category/emporium/envelopes"> > ENVELOPES</a></li>
	</ul>
	</li>	
	<li id="menu-item-141" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-141"><a href="#">SHOP ONLINE</a>
	<ul class="sub-menu">
		<li id="menu-item-108" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-108"><a href="/product-category/note-cards/"> > NOTE CARDS</a></li>
		<li id="menu-item-107" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-107"><a href="/product-category/journals/"> > JOURNALS</a></li>
		<li id="menu-item-132" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-132"><a href="/product-category/gift-enclosures/"> > GIFT ENCLOSURES</a></li>
		<li id="menu-item-131" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-131"><a href="/product-category/book-plates/"> > BOOK PLATES</a></li>
	</ul>
	</li>
	</ul>	
<?php					
		
		**/
?>	


</div>
</div><!--end categories-->