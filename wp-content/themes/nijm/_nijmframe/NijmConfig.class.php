<?php
class NijmConfig
{
    public array $version;
	public array $database;

	public array $site;
	
	public array $stylesheets;
	public array $javascripts;
	
	public function __construct()
	{
		// Database settings
		$this->version = array(
			'name' 		=> 'Eagle',
			'number' 	=> '1.0.0'
		);
		
		// Database settings
		$this->database['dsn'] = array(
			'phptype'  => 'mysqli',
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'hostspec' => DB_HOST,
			'database' => DB_NAME
		);

		// The stylesheets
		$this->stylesheets = array(
			'style'	=> array(
				'url'			=>  get_template_directory_uri(). '/style.css',
				'dependencies' 	=> false,
				'version'		=> null,
				'media'			=> 'screen'
			),
			'fonts'	=> array(
				'url'			=> 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Roboto:wght@300&display=swap',
				'dependencies' 	=> false,
				'version'		=> null,
				'media'			=> 'screen'
			),
			
			
		);
		
		// The Javascripts
		$this->javascripts = array(
			'jquery'	=> array(
				'url'			=> get_template_directory_uri() . '/assets/javascript/jquery.min.js',
				'dependencies' 	=> false,
				'version'		=> null,
				'loadInBottom'	=> true
			),
			'cookies'	=> array(
				'url'			=> get_template_directory_uri() . '/assets/javascript/cookies.js',
				'dependencies' 	=> array( 'jquery' ),
				'version'		=> null,
				'loadInBottom'	=> true
			),
			'functions'	=> array(
				'url'			=> get_template_directory_uri() . '/assets/javascript/functions.js',
				'dependencies' 	=> array( 'jquery' ),
				'version'		=> null,
				'loadInBottom'	=> true
			)
		);
		
		// Site settings
		$this->site = array(
		    'domain'                => 'nijm',
            'ext'                   => 'nl',
			'template'				=> 'nijm',

			'title' 				=> get_bloginfo('name'),
			'url' 					=> get_bloginfo('url'),
			'path' 					=> dirname(__FILE__).'/..',
			'cookieExpireTime' 		=> 30 * 24 * 60 * 60, // 30 dagen

			'timeZone' 				=> 'Europe/Amsterdam',

            'useCache'				=> false,
            'useCSSMinify'			=> false,
            'useHTMLMinify'			=> false,

			'post-formats'			=> false,
			'post-formats-types'	=> array( 'aside', 'image', 'link' ),
			
			'post-thumbnails'		=> true,
			'post-thumbnails-versions'	=> array(
				'thumbnail' => array( 'width' => 160, 'height' => 120, 'cropped' => true ),
				'normal' 	=> array( 'width' => 250, 'height' => 250, 'cropped' => true ),
                'blog' 		=> array( 'width' => 344, 'height' => 190, 'cropped' => true ),
			),

            'custom-background' 	    => false,
            'default-image'             => get_template_directory_uri() . '/assets/images/background.png',
            'default-background-color'  => 'FFFFFF',

			
			'custom-header'			=> true,
			'custom-header-options'	=> array(
				'width'			=> '',
				'flex-width'    => true,
				'height'		=> 300
			),
			
			// Can be used in template by calling wp_nav_menu()
			'menus'					=> true,
			'custom-menus'		=> array( // key, name
				'primary'	=> __( 'Main Menu' ),
				'footer' 	=> __( 'Footer Menu' )
			),
			
			'sidebars'			=> array(
			/*
				array(
					'name' 			=> __( 'Rechter zijbalk' ),
					'id' 			=> 'right-sidebar',
			 		'description' 	=> __( 'Widgets in dit blok zullen rechts op de website weergegeven worden.' ),
			        'before_widget' => '<div id="%1$s" class="widget %2$s">',
			        'after_widget' 	=> '</div></div>',
			        'before_title' 	=> '<strong class="title">',
			        'after_title' 	=> '</strong><div class="body">'
		      )*/
			),

			'useCSP'				=> true,
			'CSPAllowedSources'     => array(
				'default-src' => array(
					'\'self\'',
				),
				'media-src' => array(
					'*.w.org'
				),
				'script-src' => array(
					'\'self\'',
					'\'unsafe-inline\'',
					'\'unsafe-eval\'',
					'unpkg.com',
					'*.unpkg.com',
					'*.googletagmanager.com',
					'*.tagmanager.com',
					'*.google.com',
					'*.gstatic.com',
					'*.googleapis.com',
					'*.google-analytics.com',
					'*.jsdelivr.net',
					'*.polyfill.io',
					'*.trustindex.io',
				),
				'connect-src' => array(
					'\'self\'',
					'*.google-analytics.com',
					'*.doubleclick.net',
					'*.google.com'
				),
				'img-src' => array(
					'\'self\'',
					'data:',
					'*.gravatar.com',
					'*.googleusercontent.com',
					'*.gstatic.com',
					'*.google.com',
					'*.google.nl',
					'*.googleapis.com',
					'*.w.org',
					'*.google-analytics.com',
					'*.doubleclick.net',
					'*.googletagmanager.com',
					'*.trustindex.io',
				),
				'style-src' => array(
					'\'self\'',
					'\'unsafe-inline\'',
					'*.google.com',
					'*.googleapis.com',
					'*.jsdelivr.net',
					'*.gstatic.com',
					'*.trustindex.io',
				),
				'frame-src' => array(
					'\'self\'',
					'*.youtube.com',
					'*.google.com',
					'*.google.nl',
				),
				'font-src' => array(
					'\'self\'',
					'data:',
					'*.googleapis.com',
					'*.gstatic.com',
					'*.trustindex.io',
				),
				'frame-ancestors' => array(
					'\'self\'',
				),
				'base-uri' => array(
					'\'self\'',
				),
				'form-action' => array(
					'\'self\'',
					'*.mollie.com',
				),
				'object-src' => array(
					'\'self\'',
				)
			),

			'automatic-feed-links'	=> false
		);
	}
}