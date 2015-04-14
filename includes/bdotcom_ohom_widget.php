<?php
/**
 * WIDGET SECTION
 * ----------------------------------------------------------------------------
 */

// use widgets_init action hook to execute custom function
add_action( 'widgets_init', 'bdotcom_ohom_register_widgets' );

 //register our widget
function bdotcom_ohom_register_widgets() {
    register_widget( 'bdotcom_ohom_widget' );
}

//rvm_widget class
class bdotcom_ohom_widget extends WP_Widget {

    //process the new widget
    function bdotcom_ohom_widget() {
        $widget_ops = array( 
            'classname' => 'bdotcom_ohom_widget', 
            'description' => __( 'Display accommodation on map available on Booking.com', BDOTCOM_OHOM_TEXT_DOMAIN ) 
            ); 
        $this->WP_Widget( 'bdotcom_ohom_widget', BDOTCOM_OHOM_PLUGIN_NAME, $widget_ops );
    }
    
    function form ( $instance ) {
        //here we need just the post/map aid and we're done, we can create the shortcode       
        
        //Create da loop through the maps post type    
    
        $loop = new WP_Query(
            array( 'post_type' => 'bdotcom_ohom' )
        );
        
        if ( $loop->have_posts() ) { ?>
            
            <select name="<?php echo $this->get_field_name( 'bdotcom_ohom_map_id' ); ?>">
                <option value="select" <?php if ( isset( $instance[ 'bdotcom_ohom_map_id' ] ) ) { selected( $instance[ 'bdotcom_ohom_map_id' ] , 'select' ); } ?>><?php _e( 'Select a map...', BDOTCOM_OHOM_TEXT_DOMAIN ) ?></option>
            
            <?php
            
                while ( $loop->have_posts() ) {
                    
                    $loop->the_post();
            ?>
                    <option value="<?php echo get_the_ID() ; ?>" <?php if ( isset( $instance[ 'bdotcom_ohom_map_id' ] ) ) { selected( $instance[ 'bdotcom_ohom_map_id' ] , get_the_ID() ); } ?>> <?php the_title(); ?> </option>
                
            <?php
            
                }//while ( $loop->have_posts() )
            
            ?>
            
            </select>         
           
        <?php } //if ( $loop->have_posts() )     
               
        
                
    } //function form ( $instance )


    function update( $new_instance, $old_instance ) {
                
            $instance = $old_instance;
            $instance[ 'bdotcom_ohom_map_id' ] = $new_instance[ 'bdotcom_ohom_map_id' ];            
            return $instance;
            
    }   

    
       //display the widget only if a map was selected
        function widget( $args, $instance ) {
            if( $instance[ 'bdotcom_ohom_map_id' ] != 'select' ) {
                
                extract( $args );
                echo $before_widget;               
                $bdotcom_ohom_mb_map_width = get_post_meta( $instance[ 'bdotcom_ohom_map_id' ], '_bdotcom_ohom_mb_map_width', true ) ;
                $bdotcom_ohom_mb_map_width = !empty ( $bdotcom_ohom_mb_map_width ) ? ' width="' . $bdotcom_ohom_mb_map_width . '"' : '' ;
                $bdotcom_ohom_mb_map_height = get_post_meta( $instance[ 'bdotcom_ohom_map_id' ], '_bdotcom_ohom_mb_map_height', true ) ;
                $bdotcom_ohom_mb_map_height = !empty ( $bdotcom_ohom_mb_map_height ) ? ' height="' . $bdotcom_ohom_mb_map_height . '"' : '' ; 
                // Use the shortcode to generate the map 
                echo do_shortcode('[bdotcom_ohom mapid="' . $instance[ 'bdotcom_ohom_map_id' ] . '" ' . $bdotcom_ohom_mb_map_width . $bdotcom_ohom_mb_map_height . ' ]') ;        
                echo $after_widget;
                
            }
        }
    

}
?>