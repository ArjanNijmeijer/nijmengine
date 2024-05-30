<?php
session_start();
setlocale( LC_ALL, 'nl_NL' );

// Disable the default CSS and JS for WPML plugin
const ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS = true;
const ICL_DONT_LOAD_NAVIGATION_CSS = true;
const ICL_DONT_LOAD_LANGUAGES_JS = true;

// Create autoload array
$autoloadFiles = array(
    // Core classes
    'NijmConfig'            =>  dirname(__FILE__).'/NijmConfig.class.php',
    'Dataclass'         =>  dirname(__FILE__).'/core/Dataclass.class.php',
    'NijmEngine'        =>  dirname(__FILE__).'/core/NijmEngine.class.php',
    'NijmAdmin'        =>  dirname(__FILE__).'/core/NijmAdmin.class.php',
    'NijmMenuWalker'    =>  dirname(__FILE__).'/core/NijmMenuWalker.class.php',

    // Resources
    'Debug'        =>  dirname(__FILE__).'/resources/Nijm/Debug.class.php',
    'Validator'    =>  dirname(__FILE__).'/resources/Nijm/Validator.class.php',
);

// Register autoload function
spl_autoload_register( 'autoload' );

// The autoload function
function autoload( $className ): bool
{
    global $autoloadFiles;

    if( isset( $autoloadFiles[$className] ) )
    {
        require_once $autoloadFiles[$className];
        return true;
    }
    else
    {
        return false;
    }
}

$nijmengine = new NijmEngine;

// Remove WP Version From Styles
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}