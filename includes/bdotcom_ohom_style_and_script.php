<?php

/**
 * STYLE 'N SCRIPTS
 * ----------------------------------------------------------------------------
 */

// Initialize css for plugin initialization
add_action( 'init', 'bdotcom_ohom_add_styles' );
function bdotcom_ohom_add_styles() {   

    wp_register_style( 'bdotcom_ohom_settings_css', BDOTCOM_OHOM_CSS_PLUGIN_DIR .'/bdotcom_ohom_settings.css', '' , '1.0' );
    
}

// Make the style available just for plugin settings page
add_action('admin_enqueue_scripts', 'bdotcom_ohom_add_settings_styles');
function bdotcom_ohom_add_settings_styles( $hook ) {
    
    if( 'post.php' == $hook || 'post-new.php' == $hook ) {
        
        wp_enqueue_style( 'wp-color-picker' ); // default WP colour picker
        wp_enqueue_style( 'bdotcom_ohom_settings_css' );
    }
    
}

// Make the style available for public pages after main theme style
/*add_action( 'wp_enqueue_scripts', 'bdotcom_ohom_add_style', 11 );
function bdotcom_ohom_add_style() {
       
    wp_enqueue_style( '' ); 
    
}*/

//Register script to WP
add_action( 'init', 'bdotcom_ohom_add_scripts' );
function bdotcom_ohom_add_scripts() { 
 
    
    wp_register_script( 'bdotcom_ohom_main_js', BDOTCOM_OHOM_JS_PLUGIN_DIR .'/bdotcom_ohom_main.js', array( 'jquery' ), '', true ); 
    
    //Localize in javascript bdotcom_ohom_main_js
    /*wp_localize_script( 'bdotcom_ohom_main_js', 'objectL10n', array(        
        'marker_name' => __( 'Name', BDOTCOM_OHOM_TEXT_DOMAIN ),          
        //set the path for javascript files
        'images_js_path' => BDOTCOM_OHOM_IMG_PLUGIN_DIR //path for images to be called from javascript  
        ) );   */        
      
}

// Make the script available just for plugin post pages
add_action( 'admin_enqueue_scripts', 'bdotcom_ohom_add_settings_scripts' );
function bdotcom_ohom_add_settings_scripts( $hook ) {
    
    if( 'post.php' == $hook || 'post-new.php' == $hook ) {
        
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'bdotcom_ohom_main_js' );        
        wp_enqueue_script( 'wp-color-picker' );        
                
    }
    
}

// Make the scripts available for public pages
/*add_action( 'wp_enqueue_scripts', 'bdotcom_ohom_add_pub_scripts' );
function bdotcom_ohom_add_pub_scripts() {
       
    wp_enqueue_script( '' );
    
}*/

?>