<div style="float:left; width:155px; margin-right:24px;"><!--start categories-->
<div class="grid_2 Left">    

<div style="clear:both;"></div>

<?php //echo do_shortcode('[accordionmenu id="unique67c6a36" accordionmenu="47"]	');?>

<div class="menubox_box">	

<?php
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
$slug = get_post( $post->ID )->post_name;
	$emporium = false;
	$bespoke = false;
	if ($slug == 'emporium')$emporium = true;
	if ($slug == 'bespoke')$bespoke = true;
if($terms) {


	foreach ($terms as $term) {
		if($term->name == 'Emporium') {
		  $emporium = true;
		}
	}    
}

if ($emporium == true) {
?>
	<?php //dynamic_sidebar( 'Left Hand Sidebar Emporium' ); ?>
<?php
}
else if ($bespoke == true) {
?>
	<?php //dynamic_sidebar( 'Left Hand Sidebar Bespoke' ); ?>
<?php
}
else {
?>
	<?php //dynamic_sidebar( 'Left Hand Sidebar Bespoke' ); ?>
<?php
}
?>
<ul id="iceverticalmenu" class="iceverticalmenu">

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

        echo '<li class="first-parent"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';


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

            echo '<li class="second-parent"><a href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a></li>';
            
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

				echo '<li class="third-parent"><a href="'. get_term_link($sub_category3->slug, 'product_cat') .'"> < '. $sub_category3->name .'</a></li>';
				
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
</div><!--end categories-->