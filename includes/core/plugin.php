<?php

namespace Q_GH_Brand_Bar\Core;

use Q_GH_Brand_Bar\Core\Helper as Helper;
use Q_GH_Brand_Bar\Theme\Template as Template;

/**
 * Class Plugin
 * @package Q_GH_Brand_Bar\Core
 */
class Plugin {

	// Settings ##
    protected $version = '0.4.3';
    static $device; // current device handle ( 'desktop || handheld' )##
    protected static $debug = true;

    /**
     * Instatiate Class
     *
     * @since       0.2
     * @return      void
     */
    public function __construct()
    {

    	// crank up cron ##
    	#$this->cron = new Cron();

    }


    /**
     * Hook into WP actions and filters
     *
     * @access public
     * @since 0.5
     * @return void
     */
    public function run_hooks()
    {

        // set text domain ##
        add_action( 'init', array( $this, 'load_plugin_textdomain' ), 1 );

        // front-end templates, styles and scripts ##
    	new Template();

        // AJAX callback methods ##
        #new Callback();

    }


	/**
	 * Fired when the plugin is activated.
	 */
	public function activate() {

	}


	/**
	 * Fired when the plugin is deactivated.
	 */
	public function deactivate() {

	}


	/**
     * Load Text Domain for translations
     *
     * @since       1.7.0
     *
     */
    public function load_plugin_textdomain()
    {

        // set text-domain ##
        $domain = 'q-gh-brand-bar';

        // The "plugin_locale" filter is also used in load_plugin_textdomain()
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        // try from global WP location first ##
        load_textdomain( $domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo' );

        // try from plugin last ##
        load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ).'languages/' );

    }

}