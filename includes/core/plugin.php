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
    protected $version = '0.4.22';
    static $device; // current device handle ( 'desktop || handheld' )##
    protected static $debug = true;
    static $name = 'q-gh-bb';
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

        // admin menu
        add_action('admin_menu', array($this, 'admin_menu'));

        // front-end templates, styles and scripts ##
    	new Template();

        // AJAX callback methods ##
        #new Callback();

    }

    public function admin_menu()
    {
        add_options_page( 'Branding Bar', 'Branding Bar', 'manage_options', self::$name, function() {

        // validate
        if ($_POST && isset($_POST['action']) && self::$name === $_POST['action'] ) {
            // sanitize
            $settings['promo'] = intval($_POST['settings']['promo']);

            // save
            if ( update_option(self::$name, $settings) ) {
                print '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
            }
        }

        $settings = get_option(self::$name);
        ?>
            <h1>Branding Bar Settings</h1>

            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th>
                            Show Promo Bar
                        </th>
                        <td>
                            Off
                            <input type="radio" name="settings[promo]" value="0" checked />
                            On
                            <input type="radio" name="settings[promo]" value="1" <?php checked( $settings['promo'], 1 ); ?> />
                        </td>
                    </tr>
                </table>

                <input name="nonce" type="hidden" value="<?php echo esc_attr( wp_create_nonce( self::$name ) ); ?>" />
                <input name="action" type="hidden" value="<?php echo esc_attr(self::$name); ?>" />
                <input type="submit" class="button-primary" value="Save" />
            </form>
        <?php
        });
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