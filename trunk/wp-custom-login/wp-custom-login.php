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
			// Initialize Settings
			require_once(sprintf("%s/wp-custom-login/settings.php", dirname(__FILE__)));
			$WP_Custom_Login_Settings = new WP_Custom_Login_Settings();

			// Register custom post types
			require_once(sprintf("%s/wp-custom-login/post-types/wp-custom.php", dirname(__FILE__)));

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

//for pages

		
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
			$settings_link = '<a href="options-general.php?page=WP_Custom_Login">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}


	} // END class WP_Custom_Login
	
		// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Custom_Login', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Custom_Login', 'deactivate'));

	// instantiate the plugin class
	$WP_Custom_Login = new WP_Custom_Login();

} // END if(!class_exists('WP_Custom_Login'))
			
add_filter( 'page_template', 'change_page_template' );
function change_page_template( )
{
    if ( is_page_template('wp-custom-login/templates/page-custom-login.php') ) {
        $page_template = dirname(__FILE__) . '/wp-custom-login/templates/page-custom-login.php';
    }
    if ( is_page_template('wp-custom-login/templates/page-custom-password.php') ) {
        $page_template = dirname(__FILE__) . '/wp-custom-login/templates/page-custom-password.php';
    }	
    return $page_template;
}	