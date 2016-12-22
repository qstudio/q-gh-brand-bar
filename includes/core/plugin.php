<?php

namespace Q_GH_Brand_Bar\Core;

use Q_GH_Brand_Bar\Core\Helper as Helper;
#use Q_GH_Brand_Bar\Admin\UI as Admin;
use Q_GH_Brand_Bar\Theme\Template as Template;
#use Q_GH_Brand_Bar\Plugin\Q_search as Q_Search;
#use Q_GH_Brand_Bar\AJAX\Callback as Callback;
#use Q_GH_Brand_Bar\Plugin\Gravity_Forms as Gravity_Forms;
#use Q_GH_Brand_Bar\Type\Taxonomy as Taxonomy;
#use Q_GH_Brand_Bar\Type\Post_Type as Post_Type;
#use Q_GH_Brand_Bar\Cron\Schedule as Cron;
#use Q_GH_Brand_Bar\Cron\Fetch_Students as Fetch_Students;
#use Q_GH_Brand_Bar\Cron\Update_Students as Update_Students;

/**
 * Class Plugin
 * @package Q_GH_Brand_Bar\Core
 */
class Plugin {

	// Settings ##
    protected $version = '0.3.1';
    static $device; // current device handle ( 'desktop || handheld' )##
	#protected $max_students = 5; // max number of students that can be saved ##
    #protected $form_id = 26; // 4 .. ID of Gravity Form
    #protected $cron = false; // hold instance of Cron object ##
    protected static $debug = true;
    #protected $wsdl_url = 'http://54.174.220.251:8086/cci_gh_go/services/findForm?WSDL'; // WSDL URL ##

    #protected $cache = true; // build transient cache of each student profile ##

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

    	// admin hooks and scripts ##
        #new Admin();

        // front-end templates, styles and scripts ##
    	new Template();

        // filter q-search defaults ##
        #new Q_search();

        // AJAX callback methods ##
        #new Callback();

        // Update Gravity Form
        #new Gravity_Forms();

        // Cron routine to fetch new profile data from GO - runs every 30 mins ##
        #new Fetch_Students();

        // Cron routine to update student profiles stored inside WordPress - runs every 60 mins ##
        #new Update_Students();

    }


	/**
	 * Fired when the plugin is activated.
	 */
	public function activate() {

		// set-up cron ##
		#if ( $this->cron ) $this->cron->wp_schedule_event( 'thirty', 'q_mos_fetch_students' );
		#if ( $this->cron ) $this->cron->wp_schedule_event( 'hourly', 'q_mos_update_students' );

		// Update the rewrite rules
		#flush_rewrite_rules();

	}


	/**
	 * Fired when the plugin is deactivated.
	 */
	public function deactivate() {

		// take down cron ##
		#if ( $this->cron ) $this->cron->wp_clear_scheduled_hook( 'q_mos_fetch_students' );
		#if ( $this->cron ) $this->cron->wp_clear_scheduled_hook( 'q_mos_update_students' );

		#flush_rewrite_rules();

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