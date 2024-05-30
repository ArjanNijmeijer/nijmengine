<?php
class NijmEngine
{
	private $custom_post_types = array();
	private $config = array();
	private $settings = array();

	public function __construct()
	{
		// Store config object for further use in this class
		$this->config = new NijmConfig;

		// Create specific admin settings page
		if( is_admin() )
		{
			$this->settings = new NijmAdmin;
		}

		// Theme Setup
		$this->theme_setup();

		// Adding actions
		$this->add_actions();
	}

	/**
	 *  Initial theme setup
	 */
	private function theme_setup() : void
	{
		// Let WordPress manage the document title.
		// By adding theme support, we declare that this theme does not use a
		// hard-coded <title> tag in the document head, and expect WordPress to
		// provide it for us.
		add_theme_support( 'title-tag' );

		// Switch default core markup for search form, comment form, and comments
		// to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Default background image support
		if( $this->config->site['custom-background'] )
		{
            $args = array(
                'default-color' => $this->config->site['default-background-color'],
                'default-image' => $this->config->site['default-background-image'],
            );

			add_theme_support( 'custom-background', array( 'default-image', $args ) );
		}
		else
		{
			remove_theme_support( 'custom-background' );
		}

		// Feed links support
		if( $this->config->site['automatic-feed-links'] )
		{
			add_theme_support( 'automatic-feed-links' );
		}

		// Add menus
		if( $this->config->site['menus'] )
		{
			add_theme_support( 'menus' );
		}

		// Add theme support post-thumbnails
		if( $this->config->site['post-thumbnails'] )
		{
			add_theme_support( 'post-thumbnails' );

			foreach($this->config->site['post-thumbnails-versions'] AS $id => $options)
			{
				add_image_size( $id, $options['width'], $options['height'], $options['cropped'] );
			}
		}

		// Add support for custom header images
		if( $this->config->site['custom-header'] )
		{
			$defaults = array(
				'default-image'          => '',
				'random-default'         => false,
				'width'                  => $this->config->site['custom-header-options']['width'],
				'height'                 => $this->config->site['custom-header-options']['height'],
				'flex-height'            => false,
				'flex-width'             => false,
				'default-text-color'     => '',
				'header-text'            => false,
				'uploads'                => true,
				'wp-head-callback'       => '',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
			);

			add_theme_support( 'custom-header', $defaults );
			
			// Remove unwanted items
			remove_action( 'wp_head',      'rest_output_link_wp_head'              );
			remove_action( 'wp_head',      'wp_oembed_add_discovery_links'         );
			remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
		}

		// Change default admin footer text
		add_filter( 'admin_footer_text', array( $this, 'custom_footer_admin' ) );

		// This theme styles the visual editor to resemble the theme style,
		// specifically font, colors, icons, and column width.
		// add_editor_style( array( 'style.css' ) );


		// Switches default core markup for search form, comment form,
		// and comments to output valid HTML5.
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		//TODO: Theme localization
		//load_theme_textdomain(THEME_DOMAIN);
		//load_theme_textdomain(THEME_DOMAIN, get_template_directory() . '/languages');

		// Set content width for custom media information
		if( !isset( $content_width ) ) $content_width = 900;
	}
	
	public function custom_footer_admin() : void
	{
			 echo '<p>&copy; </span> Copyright 2008-'.date('Y').' -  <a href="https://nijm.nl" title="NIJM Webdesign en Hosting">NIJM Webdesign &amp; Hosting</a>.</p>';
	}

	/**
	 *  Addding different actions
	 */
	private function add_actions() : void
	{
        if( is_admin() ){
            // Create Custom Admin Widget
            add_action('wp_dashboard_setup', array( $this, 'dashboard_widgets' ) );
        }

        // Remove Wordpress version from theme
        add_filter( 'the_generator', array( $this , 'void' ) );

        // Add Custom Admin Logo
        add_action('login_enqueue_scripts', array( $this, 'login_logo' ) );

		// Check if we should minify our output
		if( $this->config->site['useHTMLMinify'] )
		{
			add_action( 'get_header', array( $this, 'minify_html' ) );
		}

		// Check if we should add some caching rules
		if( $this->config->site['useCache'] )
		{
			add_action( 'mod_rewrite_rules', array( $this, 'enable_cache' ) );
		}

		// Use Content Security Policy
		if( $this->config->site['useCSP'] ){
			add_action( 'mod_rewrite_rules', array( $this, 'extended_htaccess_contents' ) );
		}

		// Redirect fix
		add_action( 'mod_rewrite_rules', array( $this, 'fix_rewrite' ) );

		// Register sidebar
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'disable_wp_emojicons' ) );

		// Create Custom Post types
        add_action( 'init', array( $this, 'create_post_types' ) );

		// Register widgets
		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );

		// Enqueue and add custom styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );

        // Add hsts header and scripts
        add_action( 'send_headers', array( $this, 'add_hsts_header') );
	}

	/**
	 *  Register sidebars
	 */
	public function register_sidebar() : void
	{
		if( count( $this->config->site['sidebars'] ) > 0 )
		{
			foreach( $this->config->site['sidebars'] AS $sidebar )
			{
				// Register sidebar
				register_sidebar( $sidebar );
			}
		}
	}

	/**
	 *  Register all menus
	 */
	public function register_menus() : void
	{
		// Register menus
		register_nav_menus( $this->config->site['custom-menus'] );
	}

	/**
	 *  Load all CSS en JS files
	 */
	public function load_scripts() : void
	{
		// Register the stylesheets
		$stylesheets = $this->config->stylesheets;

		// Register the javascripts
		$javascripts = $this->config->javascripts;

		// Remove the default jquery library
		wp_deregister_script( 'jquery' );

		//Add stylesheets to the theme
		foreach( $stylesheets AS $key => $stylesheet )
		{
			wp_register_style( $key, ( $stylesheet['url'] ), $stylesheet['dependencies'], $stylesheet['version'], $stylesheet['media'] );
			wp_enqueue_style( $key );
		}

		// Check to see if we have to minify all CSS files
		if( $this->config->site['useCSSMinify'] )
		{
			global $wp_styles;

			// Name and location of the cached css file
			$cacheFileName = 'style'.date( 'ym' ).'.css';
			$cacheFile = dirname( __FILE__ ).'/../../assets/stylesheet/'.$cacheFileName;

			// If the file does not exist we need to create it
			if( !file_exists( $cacheFile ) )
			{
				$fileToDelete = glob( dirname( __FILE__ ).'/../../assets/stylesheet/*.css' );

				foreach( $fileToDelete as $file )
				{
				    unlink( $file );
				}

				$fileString = '';

				// Collect all existing CSS files within the queue (including plugins CSS)
				foreach( $wp_styles->queue as $style )
				{
					// QF: cannot use file_get_contents with HTTPS at the moment.
					$src = str_replace( $this->config->site['url'], dirname( __FILE__ ).'/../../../../..', $wp_styles->registered[ $style ]->src);
					$minify = file_get_contents( $src  );

					// remove tabs, spaces, newlines, etc.
					$minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );
					$minify = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minify );

					// Add minified CSS to the CSS string
					$fileString .= $minify;

					// Deregister the style
					wp_deregister_style( $style );
				}

				// Create the new combined and minified CSS file from string
				$cssFile = fopen( $cacheFile, 'w') or die( 'Unable to create cachefile!' );
				fwrite( $cssFile, $fileString );
				fclose( $cssFile );
			}

			// Because our cached minified CSS file contains all CSS files we should deregister all.
			foreach( $wp_styles->queue as $style )
			{
				wp_deregister_style( $style );
			}

			// Add cached minified file
			wp_register_style( 'minfied-styles', ( get_template_directory_uri(). '/assets/stylesheet/' . $cacheFileName . '#asyncload' ), false, date('Ymd'), 'screen' );
			wp_enqueue_style( 'minfied-styles' );
		}

		//Add javascript to the theme
		foreach($javascripts AS $key => $javascript)
		{
			wp_register_script( $key, $javascript['url'], $javascript['dependencies'], $javascript['version'], array( 'in_footer' => $javascript['loadInBottom'], 'strategy' => 'defer' ) );
			wp_enqueue_script( $key );
		}
	}

    /**
     *  Add hsts header
     */
    function add_hsts_header() {
        // Set the validity of the header, 6 months is a good starting point.
        $ageInSeconds = 31536000;

        // Render the header.
        header( 'Strict-Transport-Security: max-age=' . $ageInSeconds . '; includeSubDomains;' );
    }

	/**
	 *  Create Custom Posttypes with Nijm Magic
	 */
	public function create_post_types() : void
	{
		foreach ( glob( dirname( __FILE__ ) . '/../modules/*/classes/*.class.php' ) as $filename ) {
			require_once( $filename );

			$file = explode( '/', $filename );
			$file = end( $file );

			$className = explode( '.', $file );
			$className = reset( $className );

			$item = new $className;

			$this->custom_post_types[ $className ] = $item;

			register_post_type( $item->id, $item->values );
		}
	}


    /**
     * Custom get_header function
     */
    public function get_header() : void
    {
        do_action( 'get_header' );

        $template = $this->config->site['path'] . '/template/header.php';

        load_template( $template );

        add_action( 'get_header', array( $this, 'get_header' ) );
    }

    /**
     *  Custom get_content function
     */
    public function get_content() : void
    {
        do_action( 'get_content' );

        if( is_home() || is_category() )
        {
            $template =  $this->config->site['path'] . '/template/blog.php';
        }
        else if( is_author() )
        {
            $template =  $this->config->site['path'] . '/template/author.php';
        }
        else
        {
            $template =  $this->config->site['path'] . '/template/content-default.php';
        }

        load_template( $template );

        add_action( 'get_content', array( $this, 'get_content' ) );
    }

    /**
     *  Custom get_sidebar function
     */
    public function get_sidebar() : void
    {
        do_action( 'get_sidebar' );

        $template = $this->config->site['path'] . '/template/sidebar.php';

        load_template( $template );

        add_action( 'get_sidebar', array( $this, 'get_sidebar' ) );
    }

    /**
     *  Custom get_footer function
     */
    public function get_footer() : void
    {
        do_action( 'get_footer' );

        $template =  $this->config->site['path'] . '/template/footer.php';

        load_template( $template );

        add_action( 'get_footer', array( $this, 'get_footer' ) );
    }

	/**
	 * Below here custom functions to create a white labeled wordpress installation!
	 * This does not belong here! Create custom classes?
	 */
	public function disable_wp_emojicons() : void
	 {
		 // all actions related to emojis
		 remove_action( 'admin_print_styles', 'print_emoji_styles' );
		 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		 remove_action( 'wp_print_styles', 'print_emoji_styles' );
		 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		 // filter to remove TinyMCE emojis
		add_filter( 'init', array( $this, 'disable_wp_emojicons' ) );
	}

	public function dashboard_widgets() : void
	{
		global $wp_meta_boxes;
		wp_add_dashboard_widget( 'custom_help_widget', 'Hulp & Support', array( $this, 'dashboard_help' ) );
	}

	public function dashboard_help() : void
	{
		echo '<p>Welkom bij het beheerscherm van je website. Wanneer je vragen hebt kun je ons bereiken via de volgende methoden:</p>
			
			  <ul>
				<li>Telefoon of WhatsApp: 06-12 715 083</li>
				<li>E-mail: <a href="mailto:info@nijm.nl" target="_blank" title="info@nijm.nl">info@nijm.nl</a></li>
				<li>Website : <a href="https://nijm.nl" target="_blank" title="NIJM Webdesign &amp; Hosting">nijm.nl</a></li>
			  </ul>
			';
	}

	public function login_logo() : void {
		echo '<style>
			.login #login h1 a {
				background-image: url("https://nijm.nl/wp-content/themes/nijm/assets/images/nijm-logo.png");
				background-size: contain;
    			height: 64px;
				margin: 0px auto 20px auto;
				width: 300px;
			} </style>';
	}

	public function minify_html() : void
	{
		ob_start( array( $this, 'minify_html_finish' ) );
	}

	public function minify_html_finish( $html ) : string
	{
		$raw = strlen( $html );

        $html = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $html );
		//$html = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $html );
		$html = preg_replace('/\s+/', ' ', $html );
		$html = preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $html );
		$compressed = strlen( $html );

		$savings = ( $raw-$compressed ) / $raw * 100;
		$savings = round($savings, 2);

		$queryNumbers = get_num_queries();
		$timer = timer_stop(1);

		$html .= '<!-- This template is made by Nijm Webdesign &amp; Hosting and build on NijmEngine. --> '
                .'<!--Stats: '.$queryNumbers.' queries. '.$timer.'  seconds. -->'
				.'<!--Compression, size saved '.$savings.'%. From '.$raw.' bytes to '.$compressed.' bytes-->';

        return $html;
	}

	/**
     * Minify HTML function
     */
    public function enable_cache( $htaccesRules )  : string
    {
        $htaccesRules = '<IfModule mod_deflate.c>
                  AddOutputFilterByType DEFLATE application/javascript
                  AddOutputFilterByType DEFLATE application/rss+xml
                  AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
                  AddOutputFilterByType DEFLATE application/x-font
                  AddOutputFilterByType DEFLATE application/x-font-opentype
                  AddOutputFilterByType DEFLATE application/x-font-otf
                  AddOutputFilterByType DEFLATE application/x-font-truetype
                  AddOutputFilterByType DEFLATE application/x-font-ttf
                  AddOutputFilterByType DEFLATE application/x-javascript
                  AddOutputFilterByType DEFLATE application/xhtml+xml
                  AddOutputFilterByType DEFLATE application/xml
                  AddOutputFilterByType DEFLATE font/opentype
                  AddOutputFilterByType DEFLATE font/otf
                  AddOutputFilterByType DEFLATE font/ttf
                  AddOutputFilterByType DEFLATE image/svg+xml
                  AddOutputFilterByType DEFLATE image/x-icon
                  AddOutputFilterByType DEFLATE text/css
                  AddOutputFilterByType DEFLATE text/html
                  AddOutputFilterByType DEFLATE text/javascript
                  AddOutputFilterByType DEFLATE text/plain
                  AddOutputFilterByType DEFLATE text/xml
            
                  BrowserMatch ^Mozilla/4 gzip-only-text/html
                  BrowserMatch ^Mozilla/4\.0[678] no-gzip
                  BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
                  Header append Vary User-Agent
                </IfModule>' . " \n\r " . $htaccesRules;


        $htaccesRules = '
                    ## EXPIRES CACHING ##
                    <IfModule mod_expires.c>
                    ExpiresActive On
                    ExpiresByType image/jpg "access 1 year"
                    ExpiresByType image/jpeg "access 1 year"
                    ExpiresByType image/gif "access 1 year"
                    ExpiresByType image/png "access 1 year"
					ExpiresByType image/icon "access 1 year"
					ExpiresByType image/x-icon "access 1 year"
					ExpiresByType image/svg+xml "access 1 year"
					ExpiresByType image/webp "access 1 year"
					ExpiresByType image/avif "access 1 year"
                    ExpiresByType text/css "access 1 year"
                    ExpiresByType text/html "access 1 year"
					ExpiresByType text/javascript "access 1 year"
					ExpiresByType text/x-javascript "access 1 year"
                    ExpiresByType application/pdf "access 1 year"
					ExpiresByType application/javascript "access 1 year"
                    ExpiresByType application/x-shockwave-flash "access 1 year"
					ExpiresByType application/font-woff "access 1 year" 
					ExpiresByType application/font-woff2 "access 1 year"
					ExpiresByType application/font-sfnt "access 1 year"
					ExpiresByType application/vnd.ms-fontobject "access 1 year"
                    ExpiresDefault "access 1 month"
                    </IfModule>
                    ## EXPIRES CACHING ##
                ' . " \n\r " . $htaccesRules;
  
        $htaccesRules = '## 1 MONTH FOR STATIC ASSETS  ##
            <filesMatch ".(css|jpg|jpeg|png|gif|js|ico|svg|woff2|js)$">
                Header set Cache-Control "max-age=2592000, public"
            </filesMatch>' . " \n\r " . $htaccesRules;


        // $htaccesRules = $htaccesRules . "\n\r Header set Content-Security-Policy \"default-src 'none'; media-src 'self' *.cloudfront.net *.w.org; script-src 'self' 'unsafe-inline' 'unsafe-eval' *.google.com *.gstatic.com *.googleapis.com videopress.com *.googletagmanager.com *.cloudfront.net *.google-analytics.com *.mijnjungheinrich.nl; connect-src 'self' *.googleapis.com *.luckyorange.net *.visitors.live; img-src 'self' data: *.gravatar.com *.cloudfront.net *.gstatic.com *.google.com *.google.nl *.googleapis.com *.w.org *.google-analytics.com *.mijnjungheinrich.nl *.doubleclick.net; style-src 'self' 'unsafe-inline' *.cloudfront.net *.google.com *.googleapis.com; font-src 'self' data: *.googleapis.com *.gstatic.com; frame-src 'self' *.youtube.com *.google.com videopress.com *.mijnjungheinrich.nl; \"\n Header always append X-Frame-Options SAMEORIGIN \n Header set X-XSS-Protection: \"1; mode=block\" \n  Header set X-Content-Type-Options: \"nosniff\" \n\r";

        return $htaccesRules;
    }

	/**
	 * Fixes a double redirect issue in WordPress default htaccess
	 */
	public function fix_rewrite( $htaccesRules )  : string
    {
        $htaccesRules = '
         ## REWRITE FIX ##
         <IfModule mod_rewrite.c>
            RewriteEngine on

            RewriteCond %{HTTP_HOST} ^www\.' . $this->config->site['domain'] . '\.' . $this->config->site['ext'] . ' [NC]
            RewriteRule ^(.*)$ https://' . $this->config->site['domain'] . '.' . $this->config->site['ext'] . '/$1 [L,R=301]
         </IfModule>' . " \n\r " . $htaccesRules;

        return $htaccesRules;
    }

	/**
	 * Use Content security policy
	 */
	public function extended_htaccess_contents( $htaccesRules ) : string
	{
		return $htaccesRules . "Header set Content-Security-Policy \" default-src https " . implode(' ',  $this->config->site['CSPAllowedSources']['default-src'] ) . "; media-src " . implode(' ',  $this->config->site['CSPAllowedSources']['media-src'] ) . "; script-src " . implode(' ',  $this->config->site['CSPAllowedSources']['script-src'] ) . "; connect-src " . implode(' ',  $this->config->site['CSPAllowedSources']['connect-src'] ) . "; img-src " . implode(' ',  $this->config->site['CSPAllowedSources']['img-src'] ) . "; style-src " . implode(' ',  $this->config->site['CSPAllowedSources']['style-src'] ) . "; font-src " . implode(' ',  $this->config->site['CSPAllowedSources']['font-src'] ) . "; frame-src " . implode(' ',  $this->config->site['CSPAllowedSources']['frame-src'] ) . "; frame-ancestors " . implode(' ',  $this->config->site['CSPAllowedSources']['frame-src'] ) . "; base-uri " . implode(' ',  $this->config->site['CSPAllowedSources']['base-uri'] ) . "; form-action " . implode(' ',  $this->config->site['CSPAllowedSources']['form-action'] ) . "; object-src " . implode(' ',  $this->config->site['CSPAllowedSources']['object-src'] ) . ";  \"\n  
								Header always append X-Frame-Options SAMEORIGIN \n 
								Header set X-XSS-Protection: \"1; mode=block\" \n 
								Header set X-Powered-By: \"NIJM Webdesign & Hosting\" \n 
								Header always set Referrer-Policy \"same-origin\" \n   
								Header set X-Content-Type-Options: \"nosniff\" ";
	}

	/**
     * Let's start the website and load it
     */
    public function start( ) : void
    {
        $this->get_header( );

        $this->get_content( );

        $this->get_footer( );
    }


	public function void() { return ''; }
}