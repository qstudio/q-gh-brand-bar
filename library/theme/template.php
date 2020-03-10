<?php

// namespace ##
namespace q\gh_brand_bar\theme;

// Import ##
use q\gh_brand_bar\core\helper as helper;

// Q ##
use q\core\options as options;

// load it up ##
\q\gh_brand_bar\theme\template::run();

/**
 * Template level UI changes
 *
 * @package   Q_GH_Brand_Bar
 */
class template extends \q_gh_brand_bar {

	/**
     * Instatiate Class
     *
     * @since       0.2
     * @return      void
     */
    public static function run()
    {

        // scripts add to the end to override old libraries
        \add_action( 'wp_enqueue_scripts', array( get_class(), 'wp_enqueue_scripts' ), 999999999 );

        // styles add to the beginning to prevent broken styles
        \add_action( 'wp_enqueue_scripts', array( get_class(), 'wp_enqueue_styles' ), 1 );

        // add body class identfier ##
        // add_filter( 'body_class', array( get_class(), 'body_class' ), 1, 1 );

        // add in brand bar ##
        \add_action( 'q_action_body_open', array ( get_class(), 'render' ), 3 );

    }


    public static function is_active()
    {

        // helper::log( 'Checking if BB is active' );
        // helper::log( options::get('plugin') );
        // return true;

        if (
            options::get( 'plugin' )
            && ! empty( options::get( 'plugin' ) )
            && is_object( options::get( 'plugin' ) )
            && isset( options::get( 'plugin' )->brandbar )
            && 1 == options::get( 'plugin' )->brandbar
        ) {

            // helper::log( 'Brand Bar UI active' );

            // seems good ##
            return true;
        
        }

        // helper::log( 'Brand Bar UI not active' );

        // inactive ##
        return false;    

    }


    /*
    public static function has_promo()
    {

        // helper::log( 'Checking if Promo is active' );
        // helper::log( options::get('plugin') );
        // return true;

        if (
            options::get( 'plugin' )
            && ! empty( options::get( 'plugin' ) )
            && is_object( options::get( 'plugin' ) )
            && isset( options::get( 'plugin' )->promo )
            && 1 == options::get( 'plugin' )->promo
        ) {

            // helper::log( 'Promo UI active' );

            // seems good ##
            return true;
        
        }

        // helper::log( 'Promo UI not active' );

        // inactive ##
        return false;    

    }
    */

    public static function has_ticker()
    {

        // helper::log( 'Checking if Ticker is active' );
        // helper::log( options::get('plugin') );
        // return true;

        if (
            options::get( 'plugin' )
            && ! empty( options::get( 'plugin' ) )
            && is_object( options::get( 'plugin' ) )
            && isset( options::get( 'plugin' )->ticker )
            && 1 == options::get( 'plugin' )->ticker
        ) {

            // helper::log( 'Ticker UI active' );

            // seems good ##
            return true;
        
        }

        // helper::log( 'Ticker UI not active' );

        // inactive ##
        return false;    

    }




    public static function wp_enqueue_styles()
    {

        // check if the feature has been activated in the admin ##
        if (
            ! self::is_active()
            // && ! self::has_promo()
            && ! self::has_ticker()
        ) {

            // kick out ##
            return false;

        }

        \wp_register_style( 'q-gh-bb-main-css', self::get_plugin_url( 'library/theme/scss/index.css' ), '', self::version );
        \wp_enqueue_style( 'q-gh-bb-main-css' );

        \wp_register_style( 'q-gh-bb-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700|Lato:400,700|Sanchez:300|Sanchez:400');
        \wp_enqueue_style( 'q-gh-bb-google-fonts' );

    }



    public static function wp_enqueue_scripts()
    {
        
        // check if the feature has been activated in the admin ##
        if (
            ! self::is_active()
            // && ! self::has_promo()
            && ! self::has_ticker()
        ) {

            // kick out ##
            return false;

        }

        // Register the script ##
        \wp_register_script( 'q-gh-bb-index-js', self::get_plugin_url( 'library/theme/javascript/index.js' ), array( 'jquery' ), self::version, true );
        \wp_register_script( 'q-gh-brand-bar-js', self::get_plugin_url( 'library/theme/javascript/q-gh-brand-bar.js' ), array( 'jquery' ), self::version, true );
        
        \wp_enqueue_script( 'q-gh-bb-index-js' );
        \wp_enqueue_script( 'q-gh-brand-bar-js' );

    }



    /**
    Add body class to allow each install to be identified uniquely

    @since      0.2
    @return     Array      array of classes passed to method, with any additions
    */
    public static function body_class( $classes )
    {
        
        // check if the feature has been activated in the admin ##
        if (
            ! self::is_active()
            && ! self::has_ticker()
        ) {

            // kick out ##
            return false;

        }

        // let's grab and prepare our site URL ##
        $identifier = strtolower( \get_bloginfo( 'name' ) );

        // add our class ##
        $classes[] = 'install-'.str_replace( array( '.', ' '), '-', $identifier );

        if ( \is_admin_bar_showing() ) {
            $classes[] = 'wpadminbar';
        }

        // return to filter ##
        return $classes;

    }




    /*
    public static function render_promo()
    {

        // check if the feature has been activated in the admin ##
        if (
            ! self::has_promo()
        ) {

            // kick out ##
            return false;

        }

?>
        <div class="q-bb q-bb-promo q-bsg">
            <i class="cross d-none d-md-block"></i>

            <div class="row">
                <div class="col-md-3 col-3 logo d-none d-md-block"><img src="<?php echo self::get_plugin_url( 'library/theme/img/logo.png' ) ?>" /> </div>

                <div class="content col-12 col-md-6 d-block justify-content-center pl-5">
                    <div class="title">Coronavirus Update</div>
                    <div class="d-none d-md-block">Currently, the CDC recommends avoiding non-essential travel to China and the U.S. Department of State issued a “do not travel to China” advisory...</div>
                </div>

                <div class="col-6 cta d-block d-md-none"><button class="btn cross">got it</button></div>
                <div class="col-md-3 cta col-6">
                    <a target="_blank" href="https://greenheart.org/blog/exchange/coronavirus-update/" target="_blank" class="btn cross">learn more</a>
                </div>
            </div>
        </div>
<?php

    }
    */


    
    /**
     * Render News Ticker
     */
    public static function render_ticker()
    {

        // check if the feature has been activated in the admin ##
        if (
            ! self::has_ticker()
        ) {

            helper::log( 'News Ticker not active, stopping render here.' );

            // kick out ##
            return false;

        }

        // test options ##
        // helper::log( options::get() );

        // let's get the dynamic data from options - this is forced as required, so we can trust it's there ##
        $title = options::get( 'plugin_ticker_title' );
        $url = options::get( 'plugin_ticker_url' );

?>  
        <div class="q-bsg q-consent">
            <div class="q-consent-bar q-bb-promo2 q-bb-ticker q-bsg">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-12 col-xs-12 content">
                            <span class="ticker-title"><?php echo $title; ?></span>
                            <span class="ticker-btn">
                                <a class="btn btn-border cross" href="<?php echo $url; ?>" target="_blank">LEARN MORE</a>
                            </span>   
                        </div>
<?php 

                        /* 
                        
                        // REMOVED THE CLOSE BUTTON
                        <div class="col-2 col-xs-2 col-md-1 cta d-flex">
                            <button class="btn cross btn-light">
                                <span class="txt-close">close</span>
                                <span class="x-close">x</span>
                            </button>
                        </div>
                        */
?>
                    </div>
                </div>
            </div>
        </div>
<?php

    }


	/**
     * Render Brand Bar - called from widget added to theme template
     *
     * @since       0.1
     * @return      HTML
     */
    public static function render()
    {

        // render ##
        // self::render_promo();

        // ticker
        self::render_ticker();

        // check if the feature has been activated in the admin ##
        if (
            ! self::is_active()
        ) {

            helper::log( 'Brand Bar not active, stopping render here.' );

            // kick out ##
            return false;

        }

?>
        <div class="widget widget-brand-bar brand-bar wrapper-outer handheld">
            <ul class="wrapper-inner wrapper-padding">
<?php

                // branches ##
                self::the_branches_link();

                // donate link ##
                self::the_donate_link();

?>
            </ul>
<?php

            // handheld open view ##
            self::the_branches_open();

?>
        </div>
<?php

        // desktop + tablet ##
        #} else {

?>
        <div class="widget widget-brand-bar brand-bar wrapper-outer desktop">
            <ul class="wrapper-inner wrapper-padding">
<?php

                // branches ##
                self::the_branches_link();

                // donate link ##
                self::the_donate_link();

?>
            </ul>
        </div>
<?php

        #}

    }



    /**
     * Get GH Branches
     *
     * @since       0.1
     * @return      string   HTML
     */
    public static function the_branches_link()
    {

        // build array of branches ##
        $array = array(

            'Greenheart'    => array (
                    'src'       => 'greenheart'
                ,   'url'       => 'https://www.greenheart.org/'
                ,   'alt'       => 'greenheart'
            ),
            'CCI Greenheart'    => array (
                    'src'       => 'greenheart-exchange'
                ,   'url'       => 'https://www.greenheartexchange.org/'
                ,   'alt'       => 'programs in U.S.'
            ),
            'Greenheart Travel' => array (
                    'src'       => 'greenheart-travel'
                ,   'url'       => 'https://www.greenhearttravel.org'
                ,   'alt'       => 'programs abroad'
            ),
            'Greenheart Shop' => array (
                    'src'       => 'greenheart-shop'
                ,   'url'       => 'http://www.greenheartshop.org'
                ,   'alt'       => 'fair trade'
            ),
            // 'Greenheart Ibiza' => array (
            //         'src'       => 'greenheart-ibiza'
            //     ,   'url'       => 'http://www.greenheartibiza.org'
            //     ,   'alt'       => 'Greenheart Ibiza'
            // ),
            // 'Greenheart Music' => array (
            //         'src'       => 'greenheart-music'
            //     ,   'url'       => 'http://www.greenheartmusic.com'
            //     ,   'alt'       => 'Greenheart Music'
            // )

        );

        // loop em out ##
        foreach ( $array as $branch ) {

?>
        <li class='<?php echo $branch["src"]; ?>'>
            <a href="<?php echo $branch["url"]; ?>" target="_blank" title="<?php echo $branch["alt"]; ?>">
                <?php echo $branch["alt"]; ?>
            </a>
        </li>
<?php

        } // get more ##


    }


    /**
     * Get Donate Link
     *
     * @since       0.1
     * @return      string   HTML
     */
    public static function the_donate_link()
    {

?>
        <li class="donate">
            <a href="https://greenheart.org/donate" target="_blank" title="<?php _e( "Donate" , 'q-gh-brand-bar' ); ?>">
                <?php _e( "Donate" , 'q-gh-brand-bar' ); ?>
            </a>
        </li>
<?php

    }


        /**
     * Branches open view
     *
     * @since       0.1
     * @return      string   HTML
     */
    public static function the_branches_open()
    {

?>
        <ul class="branches-open">
            <div class="branches-close"></div>
<?php

            // main GH branches ##
            self::the_branches_link();

            // donate ##
            self::the_donate_link();

            // GH logo ##
?>
            <li class="greenheart"><a href="https://www.greenheart.org" target="_blank" title="Greenheart International"></a></li>
        </ul>
<?php

    }


}