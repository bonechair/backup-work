<?php
/*
Plugin Name: Ajax Portfolio
Plugin URI: http://www.wpthemers.net
Description: Ajax Portfolio Grid for WordPress
Version: 2.0.0 RC1
Author: WP Themers
Author Email: support@wpthemers.net
*/
/*--------------------------------------------*
 * DO NOT EDIT THIS LINE
 *--------------------------------------------*/
if(!defined('GF_ENABLE_SETTINGS')) {
	define('GF_ENABLE_SETTINGS', FALSE);
}

/*--------------------------------------------*
 * Include Includes
 *--------------------------------------------*/

require_once 'lib/BFI_Thumb.php';
require_once 'lib/gravity-fields/gravity-fields.php';

/*--------------------------------------------*
 * Main Class
 *--------------------------------------------*/
class AjaxPortfolio {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'Ajax Portfolio';
	const slug = 'ajax_portfolio';

	public $atts;
	private $entries;


	/**
	 * Constructor
	 */
	function __construct() {
		
		add_action( 'init', array( &$this, 'init_ajax_portfolio' ) );
		add_action( 'admin_footer', array( &$this, 'shortcode_editor_html' ), 1000 );
		add_action( 'gf_setup', array( $this, 'setup_ui' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_site_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_assets' ) );
		// Setup the event handler for generating html for the ajax
		add_action( 'wp_ajax_nopriv_get_portfolio', array( &$this, 'get_portfolio' ) );
		add_action( 'wp_ajax_get_portfolio', array( &$this, 'get_portfolio' ) );
		add_action( 'wp_ajax_nopriv_infinte_items', array( &$this, 'infinte_items' ) );
		add_action( 'wp_ajax_infinte_items', array( &$this, 'infinte_items' ) );
	}

	

	function init_ajax_portfolio() {
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Register the tinyMce buttons
		add_filter( 'mce_external_plugins', array( &$this, 'add_buttons' ), 1000 );
		add_filter( 'mce_buttons', array( &$this, 'register_buttons' ), 1000 );
		// Register the shortcode [ajax_portfolio]
		add_shortcode( 'ajax_portfolio', array( &$this, 'render_shortcode' ) );
		// Add Thumbnail support for themes
		add_theme_support( 'post-thumbnails' );
	}

	function load_site_assets() {

		//wp_enqueue_style( 'gravity_mediaelement' );
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'gravity_plug_mediaelement_css', plugins_url( 'asset/mejs/mediaelementplayer.css', __FILE__ ) );
		wp_enqueue_style( self::slug.'frontend_css', plugins_url( 'asset/frontend/css/style.css', __FILE__ ) );
		
		wp_enqueue_script( 'gravity_plug_modernizr', plugins_url( 'asset/frontend/js/modernizr.js', __FILE__ ), array( 'jquery' ), '2.7.1', true );
		wp_enqueue_script( 'gravity_plug_easing', plugins_url( 'asset/frontend/js/jquery.easing.min.js', __FILE__ ), array( 'jquery' ), '1.3', true );
		wp_enqueue_script( 'gravity_plug_mousewheel', plugins_url( 'asset/frontend/js/jquery.mousewheel.min.js', __FILE__ ), array( 'jquery' ), '3.1.8', true );
		wp_enqueue_script( 'gravity_plug_waitforimages', plugins_url( 'asset/frontend/js/jquery.waitforimages.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'gravity_plug_throttledresize', plugins_url( 'asset/frontend/js/jquery.throttledresize.min.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'gravity_plug_actual', plugins_url( 'asset/frontend/js/jquery.actual.min.js', __FILE__ ), array( 'jquery' ), '1.0.16', true );
		wp_enqueue_script( 'gravity_plug_transit', plugins_url( 'asset/frontend/js/jquery.transit.min.js', __FILE__ ), array( 'jquery' ), '0.9.9', true );
		wp_enqueue_script( 'gravity_plug_withinviewport', plugins_url( 'asset/frontend/js/jquery.withinViewport.js', __FILE__ ), array( 'jquery' ), '0.0.2', true );
		wp_enqueue_script( 'gravity_plug_sgallery', plugins_url( 'asset/frontend/js/jquery.sgallery.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'gravity_plug_flexslider', plugins_url( 'asset/frontend/js/jquery.flexslider.min.js', __FILE__ ), array( 'jquery' ), '2.2.2', true );
		wp_enqueue_script( 'gravity_plug_isotope', plugins_url( 'asset/frontend/js/isotope.min.js', __FILE__ ), array( 'jquery' ), '2.0.0', true );
		wp_enqueue_script( 'gravity_plug_mediaelement', plugins_url( 'asset/mejs/mediaelement-and-player.min.js', __FILE__ ) );
		wp_enqueue_script( self::slug.'frontend_js', plugins_url( 'asset/frontend/js/custom.js', __FILE__ ), array( 'jquery' ), '1.2', true );
		wp_localize_script( self::slug.'frontend_js', 'ajp', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'flashName' => plugins_url( 'asset/mejs/flashmediaelement.js', __FILE__ ) ) );
	}

	function load_admin_assets() {
		wp_enqueue_style( self::slug.'backend_css', plugins_url( 'asset/backend/css/style.css', __FILE__ ) );
	}

	function shortcode_editor_html() {
		include 'views/editor-html.php';
	}

	function setup_ui() {
		GF_Postmeta::factory( 'Portfolio Settings', array(
				'portfolio'
			) )
		->add_fields( array(
				GF_Field::factory( 'repeater', 'slider' )
				->set_title( __( 'Slideshow', 'ajax_portfolio' ) )
				->add_fields( 'image', __( 'Image', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'image', 'image' )
					) )
				->add_fields( 'gallery', __( 'Gallery', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'select', 'columns' )
						->add_options( array(
								'2' => __( '2 Columns', 'ajax_portfolio' ),
								'3' => __( '3 Columns', 'ajax_portfolio' ),
								'4' => __( '4 Columns', 'ajax_portfolio' ),
								'5' => __( '5 Columns', 'ajax_portfolio' ),
								'6' => __( '6 Columns', 'ajax_portfolio' )
							) )
						,
						GF_Field::factory( 'repeater', 'gallery' )
						->add_fields( 'image', __( 'Gallery Item', 'ajax_portfolio' ) , array(
								GF_Field::factory( 'image', 'image' )
							) )

					) )
				->add_fields( 'video', __( 'Video Hosting Platforms', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'text', 'video_url' )
						->set_help_text( __( 'Paste the Video URL', 'ajax_portfolio' ) )
						->set_description( __( 'Suppoted formats : YouTube, Vimeo, DailyMotion, Viddler, WordPress.tv', 'ajax_portfolio' ) )
					) )
				->add_fields( 'svideo', __( 'Self Hosted Video', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'image', 'poster' )
						->set_title( __( 'Video Poster', 'ajax_portfolio' ) ),
						GF_Field::factory( 'text', 'mp4_url' )
						->set_title( __( 'MP4 Video Source', 'ajax_portfolio' ) ),
						GF_Field::factory( 'text', 'webm_url' )
						->set_title( __( 'WebM Video Source', 'ajax_portfolio' ) ),
						GF_Field::factory( 'text', 'flv_url' )
						->set_title( __( 'FLV Video Source', 'ajax_portfolio' ) )
					) )
				->add_fields( 'audio', __( 'Audio Hosting Platforms', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'text', 'audio_url' )
						->set_help_text( __( 'Paste the Audio URL', 'ajax_portfolio' ) )
						->set_description( __( 'Suppoted formats : Rdio, SoundCloud, Spotify', 'ajax_portfolio' ) )
					) )
				->add_fields( 'saudio', __( 'Self Hosted Audio', 'ajax_portfolio' ) , array(
						GF_Field::factory( 'image', 'poster' )
						->set_title( __( 'Audio Poster', 'ajax_portfolio' ) ),
						GF_Field::factory( 'text', 'mp3_url' )
						->set_title( __( 'MP3 Audio Source', 'ajax_portfolio' ) ),
						GF_Field::factory( 'text', 'ogg_url' )
						->set_title( __( 'Ogg Audio Source', 'ajax_portfolio' ) )
					) ),
				GF_Field::factory( 'richtext', 'custom_caption' ),
				GF_Field::factory( 'select', 'desc_position' )
				->set_title(__( 'Description Postion', 'ajax_portfolio' ))
				->add_options( array(
						'right' => __( 'Right', 'ajax_portfolio' ),
						'left' => __( 'Left', 'ajax_portfolio' ),
						'bottom' => __( 'Bottom', 'ajax_portfolio' ),
						'hide' => __( 'Hide', 'ajax_portfolio' )
					)
				)
					
			) );
	}

	function add_buttons( $plugin_array ) {
		$plugin_array['ajp'] = plugins_url( 'asset/backend/js/editor-plugin.js', __FILE__ );
		return $plugin_array;
	}

	function register_buttons( $buttons ) {
		array_push( $buttons, 'ajp' );
		return $buttons;
	}

	function render_shortcode( $atts ) {
		$this->atts = shortcode_atts( array(
				'categories'=> '',
				'columns'  => '4',
				'thumb_size' => 'medium',
				'thumb_width' => '400',
				'thumb_height' => '300',
				'padding' => '0',
				'items'  => '16',
				'sort'   => 'yes',
				'orderby' => 'date',
				'order'  => 'DESC',
				'caption' => 'no',
				'prevnext' => 'no',
				'paginate' => 'no',
				'post_type' => 'portfolio',
				'taxonomy'  => 'portfolio_category',
				'animation' => '2'
			), $atts );

		return $this->create_grid_html();
	}


	function sort_buttons( $params ) {
		//get all categories that are actually listed on the page
		
		$tax_selected = explode(',', $this->atts['categories']);
		
		$categories = get_terms( $params['taxonomy'], 'orderby=name&hide_empty=0' );
		$count = count( $categories );
		$output  = "<div class='sort_width_container clearfix' ><div id='js_sort_items' >";
		$output .= "<div class='sort_by_cat clearfix'>";
		$output .= "<span class='sort_label'>".__( 'All', 'ajax_portfolio' )."</span>";
		$output .= "<ul class='sort_list'>";
		$output .= "<li><a href='#' data-filter='*' class='all_sort_button active_sort'>".__( 'All', 'ajax_portfolio' )."</a></li>";
		if ( $count > 0 ) {
			foreach ( $categories as $category ) {
				if(in_array($category->term_id, $tax_selected)) {
					$output .= "<li><a href='#' data-filter='.".$category->slug."_sort' class='".$category->slug."_sort_button' >".$category->name."</a></li>";
				}
			}
		}
		$output .= "</ul>";
		$output .= "</div></div></div>";
		return $output;
	}

	//get the categories for each post and create a string that serves as classes so the javascript can sort by those classes
	function sort_cat_string( $the_id, $params ) {
		$sort_classes = "";
		$item_categories = get_the_terms( $the_id, $params['taxonomy'] );
		if ( is_object( $item_categories ) || is_array( $item_categories ) ) {
			foreach ( $item_categories as $cat ) {
				$sort_classes .= $cat->slug.'_sort ';
			}
		}
		return $sort_classes;
	}
	
	function query_entries($params = array()){
		$query = array();
		if ( empty( $params ) ) $params = $this->atts;

		if ( !empty( $params['categories'] ) ) {
			$terms  = explode( ',', $params['categories'] );
		}
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page ) $page = 1;
		//if we find categories perform complex query, otherwise simple one
		if ( isset( $terms[0] ) && !empty( $terms[0] ) && !is_null( $terms[0] ) && $terms[0] != "null" ) {
			$query = array(
				'orderby'  => $params['orderby'],
				'order'  => $params['order'],
				'paged'  => $page,
				'posts_per_page' => $params['items'],
				'post_type' => $params['post_type'],
				'tax_query' => array(  
					array(  'taxonomy'  => $params['taxonomy'],
							'field'  => 'id',
							'terms'  => $terms,
							'operator'  => 'IN')
					)
			); // End query args array
		}
		else {
			$query = array( 'paged'=> $page, 'posts_per_page' => $params['items'], 'post_type' => $params['post_type'] );
		}
		
		$new_query = new WP_Query($query);
		
		return $new_query;
	}
	
	function create_grid_entry($the_id = false) {
		$output = '';
		$padding_adjust_style = $this->atts['padding'] ? 'style="padding: '.$this->atts['padding'].'px"' : '';
		$post_class = "portfolio-entry portfolio-overlay";
		$sort_class = $this->sort_cat_string( $the_id, $this->atts );
		if ( has_post_thumbnail( $the_id ) ) {
			$thumb = get_post_thumbnail_id( $the_id );
			if($this->atts['thumb_size'] == 'custom') {
				$img_url = wp_get_attachment_url( $thumb );
				$post_image = bfi_thumb( $img_url, array( 'width' => $this->atts['thumb_width'], 'height' => $this->atts['thumb_height'], 'crop' => true ) );
			} else {
				$img_url = wp_get_attachment_image_src( $thumb, $this->atts['thumb_size'] );
				$post_image = $img_url[0];
			}
		}
		else {
			$post_image = 'http://dummyimage.com/'.$this->atts['thumb_width'].'x'.$this->atts['thumb_height'].'/eee/333.png';
		}
		
		//$post_image = aq_resize( $img_url, 410, 310, true, true );
		
		$link = get_permalink( $the_id );
		$title = get_the_title( $the_id );
		//$term = strip_tags( get_the_term_list( $the_id, $taxonomy, '', ', ', '' ) );
		$output .= "<div id='entry-{$the_id}' class='{$post_class} {$sort_class}' {$padding_adjust_style}>";
		$output .= "<div data-permalink='{$link}' data-post-id='{$the_id}' class='portfolio-image project-load'>";
		$output .= "<img class='entry-image' src='{$post_image}' alt='{$title}'>";
		if($this->atts['caption'] == 'yes') {
			$caption_text = get_post_meta( $the_id, 'custom_caption', true );
			if ( !empty( $caption_text ) )
				$output .= "<div class='img-overlay'><div>{$caption_text}</div></div>";
			else
				$output .= "<div class='img-overlay'><div><h2 class='overlay-title'>{$title}</h2></div></div>";
		} else {
			$output .= "<div class='img-overlay'><div class='dashicons dashicons-plus'></div></div>";
		}
		$output .= "</div>";
		$output .= "</div>";
		return $output;
	}
	
	function create_grid_html( $params = array() ) {
		global $post;
		$entries = $this->query_entries();
		$output = '';
		$margin_adjust_style = $this->atts['padding'] ? 'style="margin: -'.$this->atts['padding'].'px"' : '';
		$pagination_class = 'pagination-'.$this->atts['paginate'];
		$animation = $this->atts['animation'];
		if ( $entries->have_posts() ) :
			$postCount = $entries->found_posts;
			$output .= "<div class='portfolio-grid {$pagination_class}'>";
			$output .= "<div class='portfolio-loader'><div></div></div>";
			$output .= $this->atts['sort'] == "yes" ? $this->sort_buttons( $this->atts ) : "";
			$output .= "<div class='ajax-container'>";
			$output .= "<div class='ajax-controls'>";
			$output .= $this->atts['prevnext'] == "yes" ? "<a href='#' class='prev-ajax-container'><i class='dashicons dashicons-arrow-left-alt'></i></a>" : "";
			$output .= "<a href='#' class='close-ajax-container'><i class='dashicons dashicons-no'></i></a>";
			$output .= $this->atts['prevnext'] == "yes" ? "<a href='#' class='next-ajax-container'><i class='dashicons dashicons-arrow-right-alt'></i></a>" : "";
			$output .= "</div></div>";
			$output .= "<div id='portfolio-grid-frame' class='portfolio-grid-container isotope' data-effect='effect-{$animation}' data-post-count='{$postCount}' data-columns='{$this->atts["columns"]}' {$margin_adjust_style} >";
			while ( $entries->have_posts() ) : $entries->the_post();
				$output.= $this->create_grid_entry($post->ID);
			endwhile;
			$output .= "</div>";
			if($this->atts['paginate'] != 'no') {
				if($pagination = $this->pagination($entries->max_num_pages)){
					$output .= "<div class='portfolio-pagination'>{$pagination}</div>";	
				}
			}
			$output .= "</div>";
		endif;
		return $output;
	}

	function infinte_items() {
		
	}

	function get_portfolio() {
		if ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ):
			$html = $this->project_html( $_POST['id'] );
		die( $html );
		else:
			die( 0 );
		endif;
	}

	function pagination( $pages = '', $wrapper = 'div' ) {
		global $paged;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		$output    = "";
		$prev      = $paged - 1;
		$next      = $paged + 1;
		$range     = 2; // only edit this if you want to show more page-links
		$showitems = ( $range * 2 ) + 1;
		if ( $pages == '' ) {
			global $wp_query;
			//$pages = ceil(wp_count_posts($post_type)->publish / $per_page);
			$pages = $wp_query->max_num_pages;
			if ( !$pages ) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if ( is_single() ) {
			$method = "$this->post_pagination_link";
		}
		if ( 1 != $pages ) {
			$output .= "<$wrapper class='pagination'>";
			$output .= ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) ? "<a href='" . $method( 1 ) . "'>&laquo;</a>" : "";
			$output .= ( $paged > 1 && $showitems < $pages ) ? "<a href='" . $method( $prev ) . "'>&lsaquo;</a>" : "";
			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					$output .= ( $paged == $i ) ? "<span class='current'>" . $i . "</span>" : "<a href='" . $method( $i ) . "' class='inactive' >" . $i . "</a>";
				}
			}
			$output .= ( $paged < $pages && $showitems < $pages ) ? "<a href='" . $method( $next ) . "'>&rsaquo;</a>" : "";
			$output .= ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) ? "<a href='" . $method( $pages ) . "'>&raquo;</a>" : "";
			$output .= "</$wrapper>\n";
		}
		return $output;
	}
	function post_pagination_link( $link ) {
		$url = preg_replace( '!">$!', '', _wp_link_page( $link ) );
		$url = preg_replace( '!^<a href="!', '', $url );
		return $url;
	}


	function project_html( $id = false ) {
		$query = array();
		global $wp_embed;
		if ( empty( $id ) )
			return false;
		query_posts( array(
				'post_type' => array( 'wp-comics', 'portfolio' ),
				//'post_type' => 'portfolio',
				'p' => $id
			) );
		$html = '';
		if ( have_posts() ):
			while ( have_posts() ):
				the_post();
			$the_id                  = get_the_ID();
		$size                    = 'full';
		$current_post['title']   = get_the_title();
		$current_post['content'] = get_the_content();
		// Apply the default wordpress filters to the content
		$current_post['content'] = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $current_post['content'] ) );
		$slides                  = get_post_meta( $the_id, 'slider', false );
		$slides                  = $slides[0];
		$rand                    = mt_rand();
		$slideshow               = '';
		foreach ( $slides as $slide ):
			switch ( $slide['type'] ) {
			case 'gallery':
				$gallery_images = $slide['gallery'];
				$gallery_cols   = $slide['columns'];
				$thumb_width    = round( 100 / $gallery_cols, 4 );
				$small_items    = $big_items = "";
				$counter        = 0;
				$width          = 400;
				$height         = 300;
				foreach ( $gallery_images as $gallery_image ):
					$attachment_id = $gallery_image['image'];
				if ( empty( $attachment_id ) )
					continue;
				$img_url    = wp_get_attachment_url( $attachment_id, 'full' );
				$post_image = bfi_thumb( $img_url, array( 'width' => $width, 'height' => $height, 'crop' => true ) );

				$full_image   = wp_get_attachment_image_src( $attachment_id, 'full' );
				$full_image   = $full_image[0];
				$small_items .= '<li class="item"><a href="' . $full_image . '"><img src="' . $post_image . '" alt=""></a></li>';
				$big_items   .= '<li class="item"><a href="' . $full_image . '"><img src="' . $full_image . '" alt=""></a></li>';
				endforeach;
				$output  = '<div class="gallery-block" id="gallery-' . $rand . '">';
				$output .= '<div class="gallery-inner">';
				$output .= '<ul class="items-small clearfix">' . $small_items . '</ul>';
				$output .= '<ul class="items-big">' . $big_items . '</ul>';
				$output .= '<div class="controls"><span class="prev"><i class="dashicons dashicons-arrow-left-alt"></i></span><span class="grid"><i class="dashicons dashicons-screenoptions"></i></span><span class="next"><i class="dashicons dashicons-arrow-right-alt"></i></span></div>';
				$output .= "</div>";
				$output .= "</div>";
				$output .= "<style type='text/css'>";
				$output .= "#gallery-" . $rand . " .items-small .item{width:{$thumb_width}%;}";
				$output .= "</style>";
				$slideshow = "<li class='project_slide slide-type-gallery'>" . $output . "</li>";
				break;
			case 'image':
				$attachment_id = $slide['image'];
				if ( empty( $attachment_id ) )
					continue;
				$image = wp_get_attachment_image_src( $attachment_id, $size );
				$image = $image[0];
				$slideshow .= "<li class='project_slide slide-type-image'><div><img src='{$image}' alt='' /></div></li>";
				break;
			case 'video':
				$video_url = $slide['video_url'];
				if ( empty( $video_url ) )
					continue;
				$output = '';
				$output = $wp_embed->run_shortcode( "[embed]" . trim( $video_url ) . "[/embed]" );
				if ( $output )
					$slideshow .= "<li class='project_slide slide-type-video'><div class='portfolio-responsive-media'>{$output}</div></li>";
				break;
			case 'svideo':
				$output = $poster = '';
				$source = array();
				if ( isset( $slide['mp4_url'] ) && !empty( $slide['mp4_url'] ) ) {
					$file_extension = substr( $slide['mp4_url'], strrpos( $slide['mp4_url'], '.' ) + 1 );
					if ( ( $file_extension == 'mp4' ) || ( $file_extension ) == 'MP4' )
						$source['mp4'] = $slide['mp4_url'];
				}
				if ( isset( $slide['webm_url'] ) && !empty( $slide['webm_url'] ) ) {
					$file_extension = substr( $slide['webm_url'], strrpos( $slide['webm_url'], '.' ) + 1 );
					if ( ( $file_extension == 'webm' ) || ( $file_extension ) == 'WEBM' )
						$source['webm'] = $slide['webm_url'];
				}
				if ( isset( $slide['flv_url'] ) && !empty( $slide['flv_url'] ) ) {
					$file_extension = substr( $slide['flv_url'], strrpos( $slide['flv_url'], '.' ) + 1 );
					if ( ( $file_extension == 'flv' ) || ( $file_extension ) == 'FLV' )
						$source['flv'] = $slide['flv_url'];
				}
				if ( empty( $source ) )
					continue;
				$attachment_id = $slide['poster'];
				if ( !empty( $attachment_id ) ) {
					$poster = wp_get_attachment_image_src( $attachment_id, $size );
					$poster = $poster[0];
				}
				$uid    = 'player_' . mt_rand();
				$poster = 'poster="' . $poster . '"';
				$output .= '<video controls="" width="640" height="360" class="video" ' . $poster . ' id="' . $uid . '" >';
				foreach ( $source as $type => $source_url ) {
					$output .= "<source src='{$source_url}' type='video/{$type}' />";
				}
				$output .= '</video>';
				if ( $output )
					$slideshow .= "<li class='project_slide slide-type-self-video'><div>{$output}</div></li>";
				break;
			case 'saudio':
				$output = $poster = '';
				$source = array();
				if ( isset( $slide['mp3_url'] ) && !empty( $slide['mp3_url'] ) ) {
					$file_extension = substr( $slide['mp3_url'], strrpos( $slide['mp3_url'], '.' ) + 1 );
					if ( ( $file_extension == 'mp3' ) || ( $file_extension ) == 'MP3' )
						$source['mp3'] = $slide['mp3_url'];
				}
				if ( isset( $slide['ogg_url'] ) && !empty( $slide['ogg_url'] ) ) {
					$file_extension = substr( $slide['ogg_url'], strrpos( $slide['ogg_url'], '.' ) + 1 );
					if ( ( $file_extension == 'ogg' ) || ( $file_extension ) == 'OGG' )
						$source['ogg'] = $slide['ogg_url'];
				}
				if ( empty( $source ) )
					continue;
				$attachment_id = $slide['poster'];
				if ( !empty( $attachment_id ) ) {
					$poster = wp_get_attachment_image_src( $attachment_id, $size );
					$poster = $poster[0];
				}
				$uid    = 'player_' . mt_rand();
				$poster = 'poster="' . $poster . '"';
				$output .= '<audio class="audio" ' . $poster . ' controls id="' . $uid . '" >';
				foreach ( $source as $type => $source_url ) {
					$output .= "<source src='{$source_url}' type='audio/{$type}' />";
				}
				$output .= '</audio>';
				if ( $output )
					$slideshow .= "<li class='project_slide slide-type-self-audio'><div>{$output}</div></li>";
				break;
			case 'audio':
				$audio_url = $slide['audio_url'];
				if ( empty( $audio_url ) )
					continue;
				$output = '';
				$output = $wp_embed->run_shortcode( "[embed]" . trim( $audio_url ) . "[/embed]" );
				if ( $output )
					$slideshow .= "<li class='project_slide slide-type-audio'><div class='portfolio-responsive-media'>{$output}</div></li>";
				break;
			}
		endforeach;
		extract( $current_post );
		if ( empty( $slideshow ) ):
			$full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $the_id ), 'full' );
		$full_image = $full_image[0];
		$slideshow .= "<li class='project_slide'><div><img src='{$full_image}' alt='' /></div></li>";
		endif;
		
		$project_position = get_post_meta( $the_id, 'desc_position', true ) ? get_post_meta( $the_id, 'desc_position', true ) : 'right';
		
		$html .= "<div id='ajax_project_{$the_id}' class='ajax_project clearfix project_position_{$project_position}' data-project_id='{$the_id}'>";
		$html .= "<div class='project_media'>";
		$html .= "<div class='project_flexslider'>";
		$html .= "<ul class='project_slides'>";
		$html .= $slideshow;
		$html .= "</ul>";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<div class='project_description'>";
		$html .= "<h2 class='title'>{$title}</h2>";
		$html .= $content;
		$html .= ' <a href="' . $_SERVER['HTTP_REFERER'] . '&bronze_id=' . $the_id . '"><input type="button" value="bronze" class="bronze" ref="' . $the_id . '"></a>';
		$html .= ' <a href="' . $_SERVER['HTTP_REFERER'] . '&silver_id=' . $the_id . '"><input type="button" value="silver" class="silver" ref="' . $the_id . '"></a>';
		$html .= ' <a href="' . $_SERVER['HTTP_REFERER'] . '&gold_id=' . $the_id . '"><input type="button" value="gold" class="gold" ref="' . $the_id . '"></a>';
		$html .= ' </div>';
		$html .= "</div>";
		endwhile;
		endif;
		wp_reset_query();
		if ( $html )
			return $html;
	}

}

new AjaxPortfolio();