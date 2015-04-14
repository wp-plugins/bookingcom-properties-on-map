<?php
/**
     * Plugin Name: Booking.com Properties On Map
     * Plugin URI: http://www.booking.com/general.html?tmpl=docs/partners_affiliate_examples
     * Description: This plugin creates google maps to display hotels for Booking.com Affiliate Partners. If you’re not an Affiliate Partner yet, you can still implement the plugin. To get the most out of the plugin and earn commission, you’ll need to <a href="http://www.booking.com/content/affiliates.html" target="_blank">sign up for the Booking.com Affiliate Partner Programme.</a>
     * Version: 1.0
     * Author: Strategic Partnership Department at Booking.com
     * Author URI: http://www.booking.com/general.html?tmpl=docs/partners_affiliate_examples
     * License: GPLv2
     */
     
     
     /*  Copyright 2015  Strategic Partnership Department at Booking.com  ( email : wp-plugins@booking.com )
        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.
        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
        You should have received a copy of the GNU General Public License 
        along with this program; if not, write to the Free Software 
        Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */
    
/*Define constants and paths*/
define( 'BDOTCOM_OHOM_TEXT_DOMAIN' , 'bdotcom_ohom_text_domain' ) ; //If changed, please change even the .po and .mo files with new name
define( 'BDOTCOM_OHOM_PLUGIN_NAME' , 'Booking.com Properties On Map' ) ;
define( 'BDOTCOM_OHOM_PLUGIN_VERSION' , '1.0' ) ;
define( 'BDOTCOM_OHOM_PLUGIN_FILE' , plugin_basename( __FILE__ ) ) ;    
define( 'BDOTCOM_OHOM_PLUGIN_DIR_PATH' , plugin_dir_path( __FILE__ ) ) ;
define( 'BDOTCOM_OHOM_PLUGIN_DIR_URL' , plugin_dir_url( __FILE__ ) ) ;
define( 'BDOTCOM_OHOM_JS_PLUGIN_DIR', BDOTCOM_OHOM_PLUGIN_DIR_URL.'js' ) ;
define( 'BDOTCOM_OHOM_CSS_PLUGIN_DIR', BDOTCOM_OHOM_PLUGIN_DIR_URL.'css' ) ;
define( 'BDOTCOM_OHOM_IMG_PLUGIN_DIR', BDOTCOM_OHOM_PLUGIN_DIR_URL.'images' ) ;
define( 'BDOTCOM_OHOM_INC_PLUGIN_DIR', BDOTCOM_OHOM_PLUGIN_DIR_PATH.'includes' ) ;
define( 'BDOTCOM_OHOM_WP_VERSION' , get_bloginfo( 'version' ) ) ;
define( 'BDOTCOM_OHOM_PREFIX' , 'bdotcom_ohom_' ) ;
define( 'BDOTCOM_OHOM_LABEL_CLASS' , 'class="' . BDOTCOM_OHOM_PREFIX . 'label"' ) ;


/* default fallback values*/
define( 'BDOTCOM_OHOM_DEFAULT_AID', 807906 ) ; //default aid in case no affiliate aid provided
define( 'BDOTCOM_OHOM_DEFAULT_TARGET_AID', 304142 ) ; //default aid in case no affiliate aid provided
define( 'BDOTCOM_OHOM_DEFAULT_DEST_TYPE', 'city' ) ; //default city in case no dest type provided
define( 'BDOTCOM_OHOM_DEFAULT_DEST_ID', '-2140479' ) ; //default DEST ID in case no dest ID provided
define( 'BDOTCOM_OHOM_DEFAULT_HOSTNAME', '//www.booking.com/searchresults.html' ) ; //default hostname
define( 'BDOTCOM_OHOM_DEFAULT_TEMPLATE', 'bookingcom-properties-on-map' ) ; //default template 
define( 'BDOTCOM_OHOM_DEFAULT_LINK_TARGET' , '_blank' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_LANGUAGE' , 'en-gb' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_PROPERTY_TYPE' , 'all' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_HEADER_BACKGROUND_COLOUR' , '#003580' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_HEADER_BORDER_COLOUR' , '#FFFFFF' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_HEADER_TEXT_COLOUR' , '#ced5e0' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_HEADER_LINKS_COLOUR' , '#ced5e0' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_LOGO_COLOUR' , 'white' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_LOAD_ON_DRAG' , 'checked' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_WIDTH' , '100%' ) ;
define( 'BDOTCOM_OHOM_DEFAULT_HEIGHT' , '480px' ) ;



@include BDOTCOM_OHOM_INC_PLUGIN_DIR . '/bdotcom_ohom_style_and_script.php' ;
@include BDOTCOM_OHOM_INC_PLUGIN_DIR . '/bdotcom_ohom_core.php' ;
@include BDOTCOM_OHOM_INC_PLUGIN_DIR . '/bdotcom_ohom_shortcode.php' ;
@include BDOTCOM_OHOM_INC_PLUGIN_DIR . '/bdotcom_ohom_widget.php' ;

?>