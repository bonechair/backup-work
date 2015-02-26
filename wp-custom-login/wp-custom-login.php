<?php
/*
Plugin Name: WP Custom Login
Plugin URI: lightsites@gmail.com
Description: Wp Custom Login
Version: 1.0
Author: Louis Christian Stoltz
*/

if(!class_exists('WP_Custom_Login'))
{
	class WP_Custom_Login
	{
        /**
         * The array of templates that this plugin tracks.
         */
        protected $templates;
	
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{

		/**
			$post_type = 'wp-custom-login';
    		register_post_type($post_type,
    			array(
    				'labels' => array(
    					'name' => "Custom Login",
    					'singular_name' => __(ucwords(str_replace("_", " ", $post_type)))
    				),
    				'public' => true,
    				'has_archive' => true,
    				'description' => __("This is WP Custom Post Type"),
    				'supports' => array('title', 'editor', 'excerpt','thumbnail','custom-fields'),
    			)
    		);
		**/	
			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
        
				// Add your templates to this array.
                $this->templates = array(
                        'wp-custom-login/templates/page-custom-login.php'     		=> 'Custom Login',
                        'wp-custom-login/templates/page-custom-password.php'     	=> 'Custom Forgotten Password',
                ); 
		                // Create the key used for the themes cache
                $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

                // Retrieve the cache list. 
				// If it doesn't exist, or it's empty prepare an array
                $templates = wp_get_theme()->get_page_templates();
                if ( empty( $templates ) ) {
                        $templates = array();
                } 

                // New cache, therefore remove the old one
                wp_cache_delete( $cache_key , 'themes');

                // Now add our template to the list of templates by merging our templates
                // with the existing templates array from the cache.
                $templates = array_merge( $templates, $this->templates );

                // Add the modified cache to allow WordPress to pick it up for listing
                // available templates
                wp_cache_add( $cache_key, $templates, 'themes', 1800 );

			} // END public function __construct
		
		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			//$settings_link = '<a href="options-general.php?page=WP_Custom_Login">Settings</a>';
			//array_unshift($links, $settings_link);
			//return $links;
		}

	} // END class WP_Custom_Login
	
		// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Custom_Login', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Custom_Login', 'deactivate'));

	// instantiate the plugin class
	$WP_Custom_Login = new WP_Custom_Login();

} // END if(!class_exists('WP_Custom_Login'))
		

if(!class_exists('L_Custom_Templates'))
{
	/**
	 * A PostTypeTemplate class that provides 3 additional meta fields
	 */
	class L_Custom_Templates
	{
		const POST_TYPE	= "wp-custom";

		
    	/**
    	 * The Constructor
    	 */
    	public function __construct()
    	{
    		// register actions
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'admin_init'));
    	} // END public function __construct()

    	/**
    	 * hook into WP's init action hook
    	 */
    	public function init()
    	{
    		// Initialize Post Type
    		$this->create_post_type();
    		add_action('save_post', array(&$this, 'save_post'));
    	} // END public function init()

    	/**
    	 * Create the post type
    	 */
    	public function create_post_type() {
		
    		register_post_type(self::POST_TYPE,
    			array(
    				'labels' => array(
    					'name' => "Custom",
    					'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
    				),
    				'public' => true,
    				'has_archive' => true,
    				'description' => __("This is WP Custom Post Type"),
    				'supports' => array('title', 'editor', 'excerpt','thumbnail','custom-fields'),
    			)
    		);

			register_taxonomy(
				'custom-category',
				self::POST_TYPE,
				array(
					'label' => __( 'Category' ),
					'rewrite' => array( 'slug' => 'custom-category' ),
					'hierarchical' => true,
				)
			);
		}

    	/**
    	 * Save the metaboxes for this custom post type
    	 */
    	public function save_post($post_id)
    	{
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    		{
    			foreach($this->_meta as $field_name)
    			{
    				// Update the post's meta field
    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
    			}
    		}
    		else
    		{
    			return;
    		} // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    	} // END public function save_post($post_id)

    	/**
    	 * hook into WP's admin_init action hook
    	 */
    	public function admin_init()
    	{			
    		// Add metaboxes
    		//add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
    	} // END public function admin_init()
			
    	/**
    	 * hook into WP's add_meta_boxes action hook
    	 */
    	public function add_meta_boxes()
    	{

    		// Add this metabox to every selected post
    		add_meta_box( 
    			sprintf('WP_Custom_Login_Profile_%s_section', self::POST_TYPE),
    			sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
    			array(&$this, 'add_inner_meta_boxes'),
    			self::POST_TYPE
    	    );	

    	} // END public function add_meta_boxes()

		/**
		 * called off of the add meta box
		 */		
		public function add_inner_meta_boxes($post)
		{		
			// Render the job order metabox
			//include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));			
		} // END public function add_inner_meta_boxes($post)

	} // END class L_Custom_Templates
	
		// instantiate the plugin class
	$L_Custom_Templates = new L_Custom_Templates();

	
} // END if(!class_exists('L_Custom_Templates'))

add_filter( 'page_template', 'change_page_template' );
function change_page_template( )
{
    if ( is_page_template('wp-custom-login/templates/page-custom-login.php') ) {
        $page_template = dirname(__FILE__) . '/templates/page-custom-login.php';
    }
    if ( is_page_template('wp-custom-login/templates/page-custom-password.php') ) {
        $page_template = dirname(__FILE__) . '/templates/page-custom-password.php';
    }	
    return $page_template;
}

/**

		<div style="width:390px;margin:35px auto 25px auto;padding:0px;">
		<h3 style="color:#3886a5;margin:0;padding:10px 0 10px 0;font-size:26px;">Custom Login Centre</h3>
			<form name="loginform" id="loginform" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
				<p style="padding-left:5px!important;text-align:left!important;">
					<label>Username<br />
					<input type="text" name="log" id="user_login" class="input" value="" size="60" />
					</label>

					<label>
					Password<br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="60" style="margin:0!important;" />
					<a href="<?php echo get_option('home'); ?>/lostpassword" title="Password Lost and Found">Forget your password?</a>
					</label>
				</p>
				
				<? //This can be replaced with checkbox. ?>
				<input name="rememberme" type="hidden" id="rememberme" value="forever" />

				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" style="width:200px;" />
					<input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/register" />
					<input type="hidden" name="testcookie" value="1" />
					<p><a href="<?php echo get_option('home'); ?>/register" title="Register">Not registered? Register here</a></p>
				</p>
			</form>
        </div>
**/