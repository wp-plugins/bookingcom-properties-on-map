<?php
/**
 * SHORTCODE SECTION
 * ----------------------------------------------------------------------------
 */


add_shortcode( 'bdotcom_ohom' , 'bdotcom_ohom_shortcode' ) ;
function bdotcom_ohom_shortcode( $attr ) {
    // $attr manages the shortcode parameter - [bdotcom_ohom mapid="xxxx" width="xxxx" height="xxxx"]
    
    $output = '' ;
    
    if( isset( $attr[ 'mapid' ] ) && is_numeric( $attr[ 'mapid' ] ) ) { // Check if mapid attr exists and if is numeric
        
        // Get the post id to chek wheter exists     
        $postid = get_post( $attr[ 'mapid' ]) ;
        $bdotcom_ohom_shortcode_width = isset( $attr[ 'width' ] ) ?  $attr[ 'width' ] : '' ;
        $bdotcom_ohom_shortcode_height = isset( $attr[ 'height' ] ) ?  $attr[ 'height' ] : '' ;
        
        // check if post exists and not permanently deleted
        if( !empty( $postid ) ) {
        
            //$output .= 'post_id= ' . $id ;  
            
            $bdotcom_map_id = esc_attr( $attr[ 'mapid' ] ) ; // sanitize entries

            $bdotcom_ohom_mb_dest_type = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_dest_type', true ) ;
            $bdotcom_ohom_mb_dest_id = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_dest_id', true ) ;
            $bdotcom_ohom_mb_affiliate_id = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_affiliate_id', true ) ;
            $bdotcom_ohom_mb_link_target = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_link_target', true ) ;
            $bdotcom_ohom_mb_logo_colour = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_logo_colour', true ) ;
            $bdotcom_ohom_mb_header_background_colour = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_header_background_colour', true ) ;
            $bdotcom_ohom_mb_header_border_colour = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_header_border_colour', true ) ;
            $bdotcom_ohom_mb_header_text_colour = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_header_text_colour', true ) ;
            $bdotcom_ohom_mb_links_colour = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_links_colour', true ) ;
            $bdotcom_ohom_mb_language = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_language', true ) ;
            $bdotcom_ohom_mb_load_on_drag = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_load_on_drag', true ) ;
            $bdotcom_ohom_mb_map_width = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_map_width', true ) ;
            $bdotcom_ohom_mb_map_height = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_map_height', true ) ;
            $bdotcom_ohom_mb_property_type = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_property_type', true ) ;
            $bdotcom_ohom_mb_stars = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_stars', true ) ;            
            $bdotcom_ohom_mb_html_field = get_post_meta( $bdotcom_map_id, '_bdotcom_ohom_mb_html_field', true ) ;
            
    
            if( !empty( $bdotcom_ohom_mb_property_type ) ) {
                
                $bdotcom_ohom_mb_property_type_array = unserialize( $bdotcom_ohom_mb_property_type ) ;
                $bdotcom_ohom_mb_property_type_codes = '';               
                
                foreach( $bdotcom_ohom_mb_property_type_array as $bdotcom_ohom_mb_pt_value) {
                    
                    $bdotcom_ohom_mb_property_type_codes = $bdotcom_ohom_mb_property_type_codes . 'ht_id=' . $bdotcom_ohom_mb_pt_value . ';' ;
                    
                }
                
                $bdotcom_ohom_mb_property_type = urlencode( $bdotcom_ohom_mb_property_type_codes ) ;
                
            }
            
            else { $bdotcom_ohom_mb_property_type = '' ;  }
            
            if( !empty( $bdotcom_ohom_mb_stars ) ) {
                
                $bdotcom_ohom_mb_stars_array = unserialize( $bdotcom_ohom_mb_stars ) ;
                $bdotcom_ohom_mb_stars_codes = '';               
                
                foreach( $bdotcom_ohom_mb_stars_array as $bdotcom_ohom_mb_stars_value) {
                    
                    $bdotcom_ohom_mb_stars_codes = $bdotcom_ohom_mb_stars_codes . 'class=' . $bdotcom_ohom_mb_stars_value . ';' ;
                    
                }
                
                $bdotcom_ohom_mb_stars =  urlencode( $bdotcom_ohom_mb_stars_codes ) ;
                
            } 
            
            else { $bdotcom_ohom_mb_stars = '' ;  }   

            
            if( !empty( $bdotcom_ohom_mb_property_type ) || !empty( $bdotcom_ohom_mb_stars )  ) {
                 
                $bdotcom_ohom_filters = ';nflt=' . $bdotcom_ohom_mb_property_type . $bdotcom_ohom_mb_stars ;
                 
            }
            
            $bdotcom_ohom_mb_load_on_drag = ( $bdotcom_ohom_mb_load_on_drag === 'checked' ) ? ';b_map_load_on_drag=1' : '' ;
            
            // Use shortcode width and height attribute if present
            if( isset( $bdotcom_ohom_shortcode_width ) && !empty( $bdotcom_ohom_shortcode_width )  ) { $bdotcom_ohom_mb_map_width = $bdotcom_ohom_shortcode_width ; }
            if( isset( $bdotcom_ohom_shortcode_height ) && !empty( $bdotcom_ohom_shortcode_height )  ) { $bdotcom_ohom_mb_map_height = $bdotcom_ohom_shortcode_height ; }
                            
            $bdotcom_ohom_mb_map_width = !empty( $bdotcom_ohom_mb_map_width ) ? 'width:' . esc_attr( $bdotcom_ohom_mb_map_width ) . ';' : 'width: ' . BDOTCOM_OHOM_DEFAULT_WIDTH . ';' ;           
            $bdotcom_ohom_mb_map_height = !empty( $bdotcom_ohom_mb_map_height ) ? 'height:' . esc_attr($bdotcom_ohom_mb_map_height ) . ';' : 'height: ' . BDOTCOM_OHOM_DEFAULT_HEIGHT . ';' ;            
                       
            $b_map_default_hostname = BDOTCOM_OHOM_DEFAULT_HOSTNAME ;
            $b_map_default_template = '?tmpl=' . BDOTCOM_OHOM_DEFAULT_TEMPLATE ;
            $b_map_dest_type = !empty( $bdotcom_ohom_mb_dest_type ) ? $bdotcom_ohom_mb_dest_type : BDOTCOM_OHOM_DEFAULT_DEST_TYPE ;
            $b_map_dest_type = ';dest_type=' . $b_map_dest_type ;
            $b_map_dest_id = !empty( $bdotcom_ohom_mb_dest_id ) ? $bdotcom_ohom_mb_dest_id : BDOTCOM_OHOM_DEFAULT_DEST_ID ;
            $b_map_dest_id = ';dest_id=' . esc_attr( $b_map_dest_id ) ;
            $b_map_aid = ';aid=' . BDOTCOM_OHOM_DEFAULT_AID ;                        
            $b_map_targetaid = !empty( $bdotcom_ohom_mb_affiliate_id ) ? $bdotcom_ohom_mb_affiliate_id : BDOTCOM_OHOM_DEFAULT_TARGET_AID ;
            $b_map_targetaid = ';b_map_targetaid=' . esc_attr( $b_map_targetaid) ;
            $b_map_link_target = ( !empty( $bdotcom_ohom_mb_link_target ) && $bdotcom_ohom_mb_link_target != BDOTCOM_OHOM_DEFAULT_LINK_TARGET ) ? ';b_map_link_target=' . esc_attr( $bdotcom_ohom_mb_link_target ) : '' ;
            $b_map_logo_colour = ( !empty( $bdotcom_ohom_mb_logo_colour ) && $bdotcom_ohom_mb_logo_colour != BDOTCOM_OHOM_DEFAULT_LOGO_COLOUR ) ? ';b_map_logo_colour=' . esc_attr( $bdotcom_ohom_mb_logo_colour ) : '' ;
            $b_map_header_background_colour = ( !empty( $bdotcom_ohom_mb_header_background_colour ) &&  $bdotcom_ohom_mb_header_background_colour != BDOTCOM_OHOM_DEFAULT_HEADER_BACKGROUND_COLOUR ) ? ';b_map_header_background_colour='. urlencode( esc_attr(  $bdotcom_ohom_mb_header_background_colour ) ) : '' ;            
            $b_map_header_border_colour = ( !empty( $bdotcom_ohom_mb_header_border_colour ) && $bdotcom_ohom_mb_header_border_colour != BDOTCOM_OHOM_DEFAULT_HEADER_BORDER_COLOUR ) ? ';b_map_header_border_colour=' . urlencode( esc_attr( $bdotcom_ohom_mb_header_border_colour ) ) : '' ;
            $b_map_header_text_colour = ( !empty( $bdotcom_ohom_mb_header_text_colour ) && $bdotcom_ohom_mb_header_text_colour != BDOTCOM_OHOM_DEFAULT_HEADER_TEXT_COLOUR ) ? ';b_map_header_text_colour=' . urlencode( esc_attr( $bdotcom_ohom_mb_header_text_colour ) ) : '' ;
            $b_map_links_colour = ( !empty( $bdotcom_ohom_mb_links_colour ) && $bdotcom_ohom_mb_links_colour != BDOTCOM_OHOM_DEFAULT_HEADER_LINKS_COLOUR ) ? ';b_map_links_colour=' . urlencode( esc_attr( $bdotcom_ohom_mb_links_colour ) ) : '' ;
            $b_map_language = ( !empty( $bdotcom_ohom_mb_language ) && $bdotcom_ohom_mb_language != 'select' ) ? ';lang=' . esc_attr( $bdotcom_ohom_mb_language ) : '' ;
            
            $iframe_params = $b_map_default_hostname . $b_map_default_template . $b_map_dest_type . $b_map_dest_id ;
            $iframe_params .= $b_map_aid . $b_map_targetaid . $b_map_link_target . $b_map_logo_colour . $b_map_header_background_colour ;
            $iframe_params .= $b_map_header_border_colour . $b_map_header_text_colour . $b_map_links_colour . $b_map_language . $bdotcom_ohom_mb_load_on_drag . $bdotcom_ohom_filters ;

            $output .= !empty( $bdotcom_ohom_mb_html_field ) ? force_balance_tags( html_entity_decode( wp_unslash( $bdotcom_ohom_mb_html_field ) ) ) : '' ;// fix issue in html with tags not closed
            $output .= '<iframe id="bdotcom_ohom_iframe_' . $bdotcom_map_id . '" class="bdotcom_ohom_iframe" src="' . $iframe_params . '" style="' . $bdotcom_ohom_mb_map_width . $bdotcom_ohom_mb_map_height . '" frameborder="no" scrolling="NO" scrollbar="NO"><div style="background-color:#003580;padding:10%;text-align:center;"><a href="' . BDOTCOM_OHOM_DEFAULT_HOSTNAME . '?aid=' . BDOTCOM_OHOM_DEFAULT_AID . '"><img style="width:100%;max-width:285px;margin:0 auto;border:0 none" src="' . BDOTCOM_OHOM_IMG_PLUGIN_DIR . '/booking_logo_285_blue.png" alt="Book your hotel on Booking.com" /></a></div></iframe>';         
              
       
        return $output ; 

        } //if( !empty( $postid ) )        
    

    } //if( isset( $attr ) ) 
    
        
} //function bdotcom_ohom_shortcode( $attr )

?>