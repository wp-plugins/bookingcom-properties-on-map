<?php
/**
 * CORE SCRIPT
 * ----------------------------------------------------------------------------
 */


add_action( 'init', 'bdotcom_ohom_post_type' );
function bdotcom_ohom_post_type() {
        
    // set dashicons class for RVM post icon
    $menu_icon = 'dashicons-location-alt' ;
    
    // fallback for menu icon in case wp vesrsion previous then 3.8 ( dashicons era )
    if( version_compare( BDOTCOM_OHOM_WP_VERSION , '3.8', '<' ) ) {
        
        $menu_icon = BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/bdotcom_ohom_marker_icon.png' ;
        
    }    
    
    register_post_type( 'bdotcom_ohom',
        array(
        'labels' => array(
        'name' => __( 'Booking.com Properties On Map' ),
        'singular_name' => __( 'B.com Properties On Map Singular Name', BDOTCOM_OHOM_TEXT_DOMAIN ),
        'add_new' => __( 'Add New Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'add_new_item' => __( 'Add New Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'edit_item' => __( 'Edit Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'new_item' => __( 'New Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'view_item' => __( 'View This Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'search_items' => __( 'Search B.com Maps' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'not_found' => __( 'No Maps Found' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'not_found_in_trash' => __( 'No Maps Found in Trash' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'parent_item_colon' => __( 'Parent Maps Colon' , BDOTCOM_OHOM_TEXT_DOMAIN ),                
        'menu_name' => __( 'B.com Properties On Map' , BDOTCOM_OHOM_TEXT_DOMAIN )
        ),
        'description' => __( 'Display B.com Properties On Map' , BDOTCOM_OHOM_TEXT_DOMAIN ),
        'capabilities' => array(// only admin can add it
            'publish_posts' => 'manage_options',
            'edit_posts' => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'delete_posts' => 'manage_options',
            'delete_others_posts' => 'manage_options',
            'read_private_posts' => 'manage_options',
            'edit_post' => 'manage_options',
            'delete_post' => 'manage_options',
            'read_post' => 'manage_options',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_position' => 65, //After plugin menu 
        'menu_icon' => $menu_icon,         
        'supports' => array( 'title' )
        )
    );
    
    
    // Retrieve all default options from DB
    $options = get_option( 'bdotcom_ohom_options' ) ;
    $old_version = $options[ 'ver' ] ;
    
    // Update current plugin version or create it if do not exist
    if( empty( $old_version ) || version_compare( BDOTCOM_OHOM_PLUGIN_VERSION, $old_version, '>' ) ) {
       
        //this install defaults values
        $bdotcom_ohom_options = array( 
        
            'ver' => BDOTCOM_OHOM_PLUGIN_VERSION // actual version plugin number
               
        );
        
        update_option( 'bdotcom_ohom_options', $bdotcom_ohom_options ) ; 
            
            
    } //!empty ( $options['ver'] ) || version_compare( BDOTCOM_OHOM_PLUGIN_VERSION, 1.0, '>' )
        
}

add_action( 'add_meta_boxes' , 'bdotcom_ohom_meta_boxes_create' );
function bdotcom_ohom_meta_boxes_create() {
    
    add_meta_box( 'bdotcom_ohom_meta' , __( 'Settings For ' . get_the_title(), RVM_TEXT_DOMAIN ) , 'bdotcom_ohom_mb_function', 'bdotcom_ohom', 'normal', 'high' );
    
}


function bdotcom_ohom_mb_function( $post ) {
    
    $output = '' ; //initialize output
    $output_temp = '' ;
    $array_fields = bdotcom_ohom_fields_array() ;
    
    // Retrieve widget header background for further use ( i.e to show how logo stands out from the custom background)
    $bdotcom_ohom_mb_header_background_colour = get_post_meta( $post->ID, '_bdotcom_ohom_mb_header_background_colour', true );
    
    foreach( $array_fields as $field ) {
        
        $field_value = get_post_meta( $post->ID, '_' . $field[ 0 ], true );
        
        $output .= '<p><label for="' . $field[ 0 ] .'" ' . BDOTCOM_OHOM_LABEL_CLASS . '>' . $field[ 2 ] . '</label>' ;
        
        if( $field[ 7 ] == 'main' ) {
                
            // Add eventual class
            $bdotcom_ohom_mb_class = !empty( $field[ 8 ] ) ? 'class="' . $field[ 8 ] . '"' : '' ;
            
            if( $field[ 1 ] == 'select') {
                
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_type' ) {

                    $output .= '<select name="' . $field[ 0 ] . '" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . ' >' ;                                       
                    $output .= '<option value="select" ' . selected( 'select', $field_value, false ) . ' >' . __( 'select...' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    $output .= '<option value="city" ' . selected( 'city', $field_value, false ) . ' >' . __( 'city' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    $output .= '<option value="landmark" ' . selected( 'landmark', $field_value, false ) . ' >' . __( 'landmark' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    //$output .= '<option value="district" ' . selected( 'district', $field_value, false ) . ' >' . __( 'district' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    $output .= '<option value="region" ' . selected( 'region', $field_value, false ) . ' >' . __( 'region' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    $output .= '<option value="airport" ' . selected( 'airport', $field_value, false ) . ' >' . __( 'airport' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    

                }  // if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_type' )
                
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_link_target' ) {
                    
                    if( empty( $field_value ) ) {
                        
                        $field_value = BDOTCOM_OHOM_DEFAULT_LINK_TARGET ;
                        
                    }
                              
                    $output .= '<select name="' . $field[ 0 ] . '" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . '>' ;                  
                    $output .= '<option value="_blank" ' . selected( '_blank', $field_value, false ) . ' >' . __( '_blank' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;
                    $output .= '<option value="_top" ' . selected( '_top', $field_value, false ) . ' >' . __( '_top' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;                  
                                                    
                
                }  // if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_type' )
                
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_property_type' ) {
                    
                    if( is_array( unserialize( $field_value ) ) ) {
                        
                       $field_value_array = unserialize( $field_value ) ;

                    }
                    
                    else  { $field_value_array[]  = '' ;  }                
                    
                    $bdotcom_ohom_pt_array = bdotcom_ohom_pt_array() ;
                                
                    $output .= '<select  multiple="multiple" name="' . $field[ 0 ] . '[]" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . '>' ;// set as an array to serialize data
                    
                    
                    foreach( $bdotcom_ohom_pt_array as $key => $bdotcom_ohom_pt_value ) {
                        
                        if( in_array( $key , $field_value_array ) ) { $selected = 'selected="selected"' ; } else { $selected = '' ; }
                        
                        $output .= '<option value="' . $key . '" ' . $selected . ' >' . $bdotcom_ohom_pt_value . '</option>' ;
                        
                    }
                                                  
                
                }  // if( $field[ 0 ] == 'bdotcom_ohom_mb_property_type' )
                
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_stars' ) {
                    
                    
                    if( is_array( unserialize( $field_value ) ) ) {
                        
                       $field_value_array = unserialize( $field_value ) ;

                    } 
                    
                    else  { $field_value_array[]  = '' ;  }
                                     
                    $bdotcom_ohom_stars_array = bdotcom_ohom_stars_array() ;
                                
                    $output .= '<select  multiple="multiple" name="' . $field[ 0 ] . '[]" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . '>' ;// set as an array to serialize data

                    foreach( $bdotcom_ohom_stars_array as $key => $bdotcom_ohom_stars_value ) {
                        
                        if( in_array( $key , $field_value_array ) ) { $selected = 'selected="selected"' ; } else { $selected = '' ; }
                        
                        $output .= '<option value="' . $key . '" ' . $selected . ' >' . $bdotcom_ohom_stars_value . '</option>' ;
                        
                    }
                                                  
                
                }  // if( $field[ 0 ] == 'bdotcom_ohom_mb_stars' )
                

                if( $field[ 0 ] == 'bdotcom_ohom_mb_language' ) {
                                   
                    $output .= '<select name="' . $field[ 0 ] . '" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . '>' ; 
                    $output .= '<option value="select" ' . selected( 'select', $field_value, false ) . '>' . __( 'Let the browser choose...' , BDOTCOM_OHOM_TEXT_DOMAIN) . '</option>' ;                 
                    $output .= '<option value="en-gb" ' . selected( 'en-gb', $field_value, false ) . '>English (UK)</option>' ;
                    $output .= '<option value="en-us" ' . selected( 'en-us', $field_value, false ) . '>English (US)</option>' ;
                    $output .= '<option value="de" ' . selected( 'de', $field_value, false ) . '>Deutsch</option>' ;
                    $output .= '<option value="nl" ' . selected( 'nl', $field_value, false ) . '>Nederlands</option>' ;
                    $output .= '<option value="fr" ' . selected( 'fr', $field_value, false ) . '>Français</option>' ;
                    $output .= '<option value="es" ' . selected( 'es', $field_value, false ) . '>Español</option>' ;
                    $output .= '<option value="ca" ' . selected( 'ca', $field_value, false ) . '>Català</option>' ;
                    $output .= '<option value="it" ' . selected( 'it', $field_value, false ) . '>Italiano</option>' ;
                    $output .= '<option value="pt-pt" ' . selected( 'pt-pt', $field_value, false ) . '>Português (PT)</option>' ;
                    $output .= '<option value="pt-br" ' . selected( 'pt-br', $field_value, false ) . '>Português (BR)</option>' ;
                    $output .= '<option value="no" ' . selected( 'no', $field_value, false ) . '>Norsk</option>' ;
                    $output .= '<option value="fi" ' . selected( 'fi', $field_value, false ) . '>Suomi</option>' ;
                    $output .= '<option value="sv" ' . selected( 'sv', $field_value, false ) . '>Svenska</option>' ;
                    $output .= '<option value="da" ' . selected( 'da', $field_value, false ) . '>Dansk</option>' ;
                    $output .= '<option value="cs" ' . selected( 'cs', $field_value, false ) . '>Čeština</option>' ;
                    $output .= '<option value="hu" ' . selected( 'hu', $field_value, false ) . '>Magyar</option>' ;
                    $output .= '<option value="ro" ' . selected( 'ro', $field_value, false ) . '>Română</option>' ;
                    $output .= '<option value="ja" ' . selected( 'ja', $field_value, false ) . '>日本語</option>' ;
                    $output .= '<option value="zh-cn" ' . selected( 'zh-cn', $field_value, false ) . '>简体中文</option>' ;
                    $output .= '<option value="zh-tw" ' . selected( 'zh-tw', $field_value, false ) . '>繁體中文</option>' ;
                    $output .= '<option value="pl" ' . selected( 'pl', $field_value, false ) . '>Polski</option>' ;
                    $output .= '<option value="el" ' . selected( 'el', $field_value, false ) . '>Ελληνικά</option>' ;
                    $output .= '<option value="ru" ' . selected( 'ru', $field_value, false ) . '>Русский</option>' ;
                    $output .= '<option value="tr" ' . selected( 'tr', $field_value, false ) . '>Türkçe</option>' ;
                    $output .= '<option value="bg" ' . selected( 'bg', $field_value, false ) . '>Български</option>' ;
                    $output .= '<option value="ar" ' . selected( 'ar', $field_value, false ) . '>عربي</option>' ;
                    $output .= '<option value="ko" ' . selected( 'ko', $field_value, false ) . '>한국어</option>' ;
                    $output .= '<option value="he" ' . selected( 'he', $field_value, false ) . '>עברית</option>' ;
                    $output .= '<option value="lv" ' . selected( 'lv', $field_value, false ) . '>Latviski</option>' ;
                    $output .= '<option value="uk" ' . selected( 'uk', $field_value, false ) . '>Українська</option>' ;
                    $output .= '<option value="id" ' . selected( 'id', $field_value, false ) . '>Bahasa Indonesia</option>' ;
                    $output .= '<option value="ms" ' . selected( 'ms', $field_value, false ) . '>Bahasa Malaysia</option>' ;
                    $output .= '<option value="th" ' . selected( 'th', $field_value, false ) . '>ภาษาไทย</option>' ;
                    $output .= '<option value="et" ' . selected( 'et', $field_value, false ) . '>Eesti</option>' ;
                    $output .= '<option value="hr" ' . selected( 'hr', $field_value, false ) . '>Hrvatski</option>' ;
                    $output .= '<option value="lt" ' . selected( 'lt', $field_value, false ) . '>Lietuvių</option>' ;
                    $output .= '<option value="sk" ' . selected( 'sk', $field_value, false ) . '>Slovenčina</option>' ;
                    $output .= '<option value="sr" ' . selected( 'sr', $field_value, false ) . '>Srpski</option>' ;
                    $output .= '<option value="sl" ' . selected( 'sl', $field_value, false ) . '>Slovenščina</option>' ;
                    $output .= '<option value="vi" ' . selected( 'vi', $field_value, false ) . '>Tiếng Việt</option>' ;
                    $output .= '<option value="tl" ' . selected( 'tl', $field_value, false ) . '>Filipino</option>' ;
                    $output .= '<option value="is" ' . selected( 'is', $field_value, false ) . '>Íslenska</option>' ;
    
    
                }  // if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_type' )
            
            $output .= '</select>&nbsp;' . $field[ 3 ] ;
            
            if( $field[ 0 ] == 'bdotcom_ohom_mb_link_target' ) {

                $output .= '<span id="bdotcom_ohom_mb_info_box_target" style="display: none;">' ;
                $output .= __( '<strong>_blank</strong> opens links in a new browser page while <strong>_top</strong> opens in the same page' , BDOTCOM_OHOM_TEXT_DOMAIN) ;
                $output .= '</span>' ;                    
                
            } //if( $field[ 1 ] == 'bdotcom_ohom_mb_dest_id' ) 
            
            } //if( $field[ 1 ] == 'select' ) 
            
            
            if( $field[ 1 ] == 'text' ) {              
                    
                $output .= '<input name="' . $field[ 0 ] . '" id="' . $field[ 0 ] . '" ' . $bdotcom_ohom_mb_class . ' type="' . $field[ 1 ] . '" ';            
                if ( !empty( $field[ 4 ] ) ) { $output .= ' maxlength="'. $field[ 4 ]. '" '; }
                if ( !empty( $field[ 5 ] ) ) { $output .= ' size="' . $field[ 5 ] . '" '; }
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_id' && empty( $field_value ) ) {                    
                    
                    $output .= 'placeholder="' . __( 'e.g. -2140479 for Amsterdam', BDOTCOM_OHOM_TEXT_DOMAIN ) . '"' ;                   
                    
                } //if( $field[ 1 ] == 'bdotcom_ohom_mb_dest_id' )
                
                // Start : default vaòues in case of emty values
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_header_background_colour' && empty( $field_value ) ) {                   
                    
                    $field_value = BDOTCOM_OHOM_DEFAULT_HEADER_BACKGROUND_COLOUR ;                       
                    
                }
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_header_border_colour' && empty( $field_value ) ) {                   
                    
                    $field_value = BDOTCOM_OHOM_DEFAULT_HEADER_BORDER_COLOUR ;
                    
                }
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_header_text_colour' && empty( $field_value ) ) {                   
                    
                    $field_value = BDOTCOM_OHOM_DEFAULT_HEADER_TEXT_COLOUR ;
                    
                }
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_links_colour' && empty( $field_value ) ) {                   
                    
                    $field_value = BDOTCOM_OHOM_DEFAULT_HEADER_LINKS_COLOUR ;
                    
                } 
                                   
                // End :default vaòues in case of emty values 
                
                $output .= 'value="' . $field_value . '" />' . $field[ 3 ] ;
                
                if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_id' ) {                    
                    
                    $output .= '<span id="bdotcom_ohom_mb_info_box" style="display: none;">' ;
                    $output .= __( 'For more info on your destination ID, login to the <a href="https://admin.booking.com/partner/" target="_blank">Partner Center</a>. Check <em>&quot;URL constructor&quot;</em> section to find your destination ID. These IDs, also known as UFIs, are usually a negative number ( e.g. <strong>-2140479 is for Amsterdam</strong> , but can be positive ones in the US ) while regions, district and landmarks are always positive ( e.g. <strong>1408 is for Ibiza</strong> ).' , BDOTCOM_OHOM_TEXT_DOMAIN) ;
                    $output .= '</span>' ;                    
                    
                } //if( $field[ 1 ] == 'bdotcom_ohom_mb_dest_id' )               
                
            } //if( $field[ 1 ] == 'text' )
            
            if( $field[ 1 ] == 'radio' ) {                

                if( $field[ 0 ] == 'bdotcom_ohom_mb_logo_colour' ) {
                    
                    if( empty( $field_value ) ) {
                        
                        $field_value = BDOTCOM_OHOM_DEFAULT_LOGO_COLOUR ;                        
                    }                   
                                       
                    
                    if( empty( $bdotcom_ohom_mb_header_background_colour ) ) {
                        
                        $bdotcom_ohom_mb_header_background_colour = BDOTCOM_OHOM_DEFAULT_HEADER_BACKGROUND_COLOUR ;                        
                    }
                    
                    $output .= '<span id="bdotcom_ohom_mb_logo_wrapper" style="background-color: ' . $bdotcom_ohom_mb_header_background_colour .  ' ;display:inline-block;padding:5px;">' ;
                    $output .= '<img class="bdotcom_ohom_mb_logo" src="' . BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/booking_logo_285_blue.png" alt="Blue logo" /><input class="'  . $field[ 0 ] . '" name="'  . $field[ 0 ] . '" type="' . $field[ 1 ] . '"  value="blue"  ' . checked( 'blue', $field_value, false ) . ' />&nbsp;' ;
                    $output .= '<img class="bdotcom_ohom_mb_logo" src="' . BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/booking_logo_285_white.png" alt="White logo" /><input class="'  . $field[ 0 ] . '" name="'  . $field[ 0 ] . '" type="' . $field[ 1 ] . '"  value="white"  ' . checked( 'white', $field_value, false ) . ' />&nbsp;' ;
                    $output .= '</span>' ;    
                
                } //if( $field[ 0 ] == 'bdotcom_ohom_mb_dest_id' ) 
                
 
            } //if( $field[ 1 ] == 'radio' )  
            
            if( $field[ 1 ] == 'textarea' ) {                

                if( $field[ 0 ] == 'bdotcom_ohom_mb_html_field' ) {
                    
                    $bdotcom_ohom_mb_class = !empty( $field[ 8 ] ) ? 'class="' . $field[ 8 ] . '"' : '' ;
                    $output .= '<textarea '  . $bdotcom_ohom_mb_class . ' name="'  . $field[ 0 ] . '" >' . wp_unslash( $field_value ) . '</textarea>' . $field[ 3 ] ;
   
                
                } //if( $field[ 0 ] == 'bdotcom_ohom_mb_html_field' ) 
                
 
            } //if( $field[ 1 ] == 'textarea' ) 
            
            if( $field[ 1 ] == 'checkbox' ) {                

                if( $field[ 0 ] == 'bdotcom_ohom_mb_load_on_drag' ) {
                    
                    if( empty( $field_value ) ) { $field_value = BDOTCOM_OHOM_DEFAULT_LOAD_ON_DRAG ; }
                    $output .= '<input class="'  . $field[ 0 ] . '" id="'  . $field[ 0 ] . '" name="'  . $field[ 0 ] . '" id="' . $field[ 0 ] . '" type="' . $field[ 1 ] . '"  ' . checked( 'checked', $field_value, false ) . ' />'  . $field[ 3 ] ;
   
                
                } //if( $field[ 0 ] == 'bdotcom_ohom_mb_html_field' ) 
                
 
            } //if( $field[ 1 ] == 'checkbox' )
            
            
             
                   

        } //if( $field[ 7 ] == 'main' )
        
        $output .= '</p>' ;
        $output .= '<div style="clear:left;"></div>' ;
            
    } //foreach( $array_fields as $field )
    
    $output .= '<div id="bdotcom_ohom_shortcode" class="updated"><p>' . __( 'Use following shortcode to display this map in your posts or pages :' , BDOTCOM_OHOM_TEXT_DOMAIN ) . ' <strong>[bdotcom_ohom mapid="' . $post->ID .'"]</strong></p></div>'  ;
    
    echo $output ;
        
}


// Save data into DB
add_action( 'save_post' , 'bdotcom_ohom_mb_save_meta' );
function bdotcom_ohom_mb_save_meta( $post_id ) {
    
    $array_fields = bdotcom_ohom_fields_array() ;
    
    if( isset( $_POST[ 'bdotcom_ohom_mb_dest_type' ] ) && $_POST[ 'bdotcom_ohom_mb_dest_type' ] != 'select'  
    && isset( $_POST[ 'bdotcom_ohom_mb_dest_id' ] ) && !empty ( $_POST[ 'bdotcom_ohom_mb_dest_id' ] ) ) {
       
        foreach( $array_fields as $field ) {
            
            if( $field[ 0 ] == 'bdotcom_ohom_mb_property_type' ) {
                
                if( !empty( $_POST[  $field[ 0 ] ] ) ) {
                    
                   $_POST[  $field[ 0 ] ] = serialize( $_POST[ $field[ 0 ] ] ) ;
                     
                } else { $_POST[  $field[ 0 ] ] = '' ;  }              
                           
            }

            if( $field[ 0 ] == 'bdotcom_ohom_mb_load_on_drag' ) {
                
                $_POST[ $field[ 0 ] ] = !empty( $_POST[ $field[ 0 ] ] ) ? 'checked' : 'unchecked' ;           
                           
            }

            if( $field[ 0 ] == 'bdotcom_ohom_mb_stars' ) {
                
                if( !empty( $_POST[  $field[ 0 ] ] ) ) {
                    
                   $_POST[ $field[ 0 ] ] = serialize( $_POST[ $field[ 0 ] ] ) ;
                     
                } else { $_POST[  $field[ 0 ] ] = '' ;  }              
                          
            }

            if( $field[ 0 ] == 'bdotcom_ohom_mb_html_field' ) {
                
                update_post_meta( $post_id, '_' . $field[ 0 ] , htmlentities( wp_slash( $_POST[ $field[ 0 ] ] ) ) ) ;              
                          
            }
            
            else {           
                
                update_post_meta( $post_id, '_' . $field[ 0 ] , strip_tags( $_POST[ $field[ 0 ] ] ) ) ;
                
            }

            
        } //foreach( $array_fields as $field )
       
        
    } //if( isset( $_POST[ 'bdotcom_ohom_mb_dest_type' ] ) && $_POST[ 'bdotcom_ohom_mb_dest_type' ] != 'select'...
    
}


// property type array
function bdotcom_ohom_pt_array() {
    
    $pt_array = array( 
    204 => __( 'Hotels' , BDOTCOM_OHOM_TEXT_DOMAIN ) 
    , 203 => __( 'Hostels' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 205 => __( 'Motels' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 201 => __( 'Apartments' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 220 => __( 'Holiday homes' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 213 => __( 'Villas' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 221 => __( 'Lodges' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 216 => __( 'Guest houses' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 208 => __( 'Bed and breakfast' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 214 => __( 'Campsites' , BDOTCOM_OHOM_TEXT_DOMAIN ) 
    , 206 => __( 'Resorts' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 218 => __( 'Inns' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 209 => __( 'Ryokans' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 231 => __( 'Economy hotels' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 228 => __( 'Chalet' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 222 => __( 'Homestays' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 210 => __( 'Farm stays' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 223 => __( 'Country houses' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 212 => __( 'Holiday parks' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 215 => __( 'Boats' , BDOTCOM_OHOM_TEXT_DOMAIN ) ) ;                    

    return $pt_array ;
    
}

// stars array
function bdotcom_ohom_stars_array() {
    
    $stars_array = array( 
    0 => __( 'Unrated' , BDOTCOM_OHOM_TEXT_DOMAIN ) 
    , 1 => __( '1 star' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 2 => __( '2 stars' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 3 => __( '3 stars' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 4 => __( '4 stars' , BDOTCOM_OHOM_TEXT_DOMAIN )
    , 5 => __( '5 stars' , BDOTCOM_OHOM_TEXT_DOMAIN )
    ) ;                    

    return $stars_array ;
    
}

// Fields input arrays 
function bdotcom_ohom_fields_array() {
    
    $fields = array() ;
    // 'field name', 'input type',  'field label', 'field bonus expl.', 'input maxlenght', 'input size', 'required', 'which section belongs to?', 'css class' '
    $fields[ 'bdotcom_ohom_mb_affiliate_id' ] = array( 'bdotcom_ohom_mb_affiliate_id', 'text', __( 'Your affiliate ID', BDOTCOM_OHOM_TEXT_DOMAIN ) ,  __( '<span class="bdotcom_ohom_mb_field_descr">Your affiliate ID is a unique number that allows Booking.com to track commission. If you are not an affiliate yet, <a href="http://www.booking.com/content/affiliates.html" target="_blank">check our affiliate programme</a> and get an affiliate ID. It\'s easy and fast. Start earning money, <a href="https://secure.booking.com/partnerreg.html" target="_blank">sign up now!</a></span>', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_dest_type' ] = array( 'bdotcom_ohom_mb_dest_type', 'select', __( 'Destination type', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 1, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_dest_id' ] = array( 'bdotcom_ohom_mb_dest_id', 'text', __( 'Destination ID', BDOTCOM_OHOM_TEXT_DOMAIN ) , '<a href="#" id="bdotcom_ohom_mb_info_displayer" title="Info box"><img  style="border: none;" src="' . BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/bdotcom_ohom_info_icon.png" alt="info" /></a>', '', '', 1, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_property_type' ] = array( 'bdotcom_ohom_mb_property_type', 'select', __( 'Property type', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( '<span class="bdotcom_ohom_mb_field_descr">Hold down the control (<strong>ctrl for Windows</strong>) or command (<strong>cmd for MacOs</strong>) button to select multiple options: by default all will appear</span>', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_stars' ] = array( 'bdotcom_ohom_mb_stars', 'select', __( 'Stars rate', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( '<span class="bdotcom_ohom_mb_field_descr">Hold down the control (<strong>ctrl for Windows</strong>) or command (<strong>cmd for MacOs</strong>) button: by default all will appear</span>', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_link_target' ] = array( 'bdotcom_ohom_mb_link_target', 'select', __( 'Links target', BDOTCOM_OHOM_TEXT_DOMAIN ) , '<a href="#" id="bdotcom_ohom_mb_info_displayer_target" title="Info box"><img  style="border: none;" src="' . BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/bdotcom_ohom_info_icon.png" alt="info" /></a>', '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_language' ] = array( 'bdotcom_ohom_mb_language', 'select', __( 'Language', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_header_background_colour' ] = array( 'bdotcom_ohom_mb_header_background_colour', 'text', __( 'Header background colour', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_wp_color_picker bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_header_border_colour' ] = array( 'bdotcom_ohom_mb_header_border_colour', 'text', __( 'Header border colour', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_wp_color_picker bdotcom_ohom_mb_field' ) ;    
    $fields[ 'bdotcom_ohom_mb_header_text_colour' ] = array( 'bdotcom_ohom_mb_header_text_colour', 'text', __( 'Header text/links colour', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_wp_color_picker bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_links_colour' ] = array( 'bdotcom_ohom_mb_links_colour', 'text', __( 'Option panel links colour', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_wp_color_picker bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_logo_colour' ] = array( 'bdotcom_ohom_mb_logo_colour', 'radio', __( 'Logo colour', BDOTCOM_OHOM_TEXT_DOMAIN ) , '', '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_load_on_drag' ] = array( 'bdotcom_ohom_mb_load_on_drag', 'checkbox', __( 'Hotels loading when user drags the map', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( '(Active on maps 600px wide at least )', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_map_width' ] = array( 'bdotcom_ohom_mb_map_width', 'text', __( 'Map width ( px, em, % , rem allowed )', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( '<span class="bdotcom_ohom_mb_field_descr">If empty, it will fit the content area</span>', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;
    $fields[ 'bdotcom_ohom_mb_map_height' ] = array( 'bdotcom_ohom_mb_map_height', 'text', __( 'Map height ( px, em, % , rem allowed )', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( '<span class="bdotcom_ohom_mb_field_descr">If empty, it will be 480px</span>', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_field' ) ;    
    $fields[ 'bdotcom_ohom_mb_html_field' ] = array( 'bdotcom_ohom_mb_html_field', 'textarea', __( 'Title', BDOTCOM_OHOM_TEXT_DOMAIN ) , __( 'HTML or plain text', BDOTCOM_OHOM_TEXT_DOMAIN ), '', '', 0, 'main', 'bdotcom_ohom_mb_html_field bdotcom_ohom_mb_field' ) ; 
    
    return $fields;
    
}

// Adding custom columns to display maps list
add_filter( 'manage_edit-bdotcom_ohom_columns', 'add_new_bdotcom_ohom_columns' );
function add_new_bdotcom_ohom_columns( $bdotcom_ohom_columns ) {    

    $new_bdotcom_ohom_columns[ 'cb' ] = '<input type="checkbox" />';
    $new_bdotcom_ohom_columns[ 'title' ] = __( 'Map name', BDOTCOM_OHOM_TEXT_DOMAIN );
    $new_bdotcom_ohom_columns[ 'shortcode' ] = __( 'Shortcode', BDOTCOM_OHOM_TEXT_DOMAIN );
    $new_bdotcom_ohom_columns[ 'date' ] = __( 'Date', BDOTCOM_OHOM_TEXT_DOMAIN ); 
    return $new_bdotcom_ohom_columns;
    
}

//Populate shortcodes column
add_action( 'manage_bdotcom_ohom_posts_custom_column' , 'bdotcom_ohom_custom_columns', 10, 2 );
function bdotcom_ohom_custom_columns( $bdotcom_ohom_column, $post_id ) {
    switch ( $bdotcom_ohom_column ) {
        
    case 'shortcode' :        
        echo '[bdotcom_ohom mapid="' . $post_id . '"]' ;
        break;
        
    }
}

?>