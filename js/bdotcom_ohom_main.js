(function($) {
	$(function() {

		// show / hide info box
		$( '#bdotcom_ohom_mb_info_displayer' ).click( function( event ) { 
			event.preventDefault(); 
			$( '#bdotcom_ohom_mb_info_box' ).toggle(); 
		});
		
		// show / hide info box
		$( '#bdotcom_ohom_mb_info_displayer_target' ).click( function( event ) { 
			event.preventDefault(); 
			$( '#bdotcom_ohom_mb_info_box_target' ).toggle(); 
		});
		
		// fire the post update - check entires
	
		//create globals

		var error ;
		var error_message_array = [] ;
		var error_message_content = ''  ;	
		
		$( 'form#post' ).submit( function( event ) { 
			
			var bdotcom_ohom_mb_affiliate_id = $( '#bdotcom_ohom_mb_affiliate_id' ) ;
			var bdotcom_ohom_mb_dest_type = $( '#bdotcom_ohom_mb_dest_type' ) ;
			var bdotcom_ohom_mb_dest_id = $( '#bdotcom_ohom_mb_dest_id' ) ;
			var bdotcom_ohom_mb_map_width = $( '#bdotcom_ohom_mb_map_width' ) ;
			var bdotcom_ohom_mb_map_height = $( '#bdotcom_ohom_mb_map_height' ) ;
			
			var bdotcom_ohom_mb_affiliate_id_val = bdotcom_ohom_mb_affiliate_id.val() ;
			var bdotcom_ohom_mb_dest_type_val = bdotcom_ohom_mb_dest_type.val() ;
			var bdotcom_ohom_mb_dest_id_val = bdotcom_ohom_mb_dest_id.val() ;			
			var bdotcom_ohom_mb_map_width = bdotcom_ohom_mb_map_width.val() ;
			var bdotcom_ohom_mb_map_height = bdotcom_ohom_mb_map_height.val() ;
			
		
			//console.log('bdotcom_ohom_mb_affiliate_id.length: ' + bdotcom_ohom_mb_affiliate_id.length );
			
			// we'll perform form check JUST if we are in bdotcom_ohom post
			// In order to do that we need to check existance of fileds to check, otherwise the javascritp will be performed 
			// even in other plugins
			
			if( bdotcom_ohom_mb_affiliate_id.length && bdotcom_ohom_mb_dest_type.length && bdotcom_ohom_mb_dest_id.length ) {

				var fields_array = [ 
					[ 'Your affiliate ID', bdotcom_ohom_mb_affiliate_id_val, 'num', 0, 'affiliate_id' ] 
					, [ 'Destination type', bdotcom_ohom_mb_dest_type_val, 'sel', 1, 'dest_type' ]
					, [ 'Destination ID', bdotcom_ohom_mb_dest_id_val, 'num', 1, 'dest_id' ]
					, [ 'Map width', bdotcom_ohom_mb_map_width, 'text', 0, 'map_width' ]
					, [ 'Map height', bdotcom_ohom_mb_map_height, 'text', 0, 'map_height' ]
				] ;
	
				var error = false ;
				error_message_array = [] ; // empty the error message array
				error_message_content = '' ; // empty the error message content
				$( '#bdotcom_ohom_error_content' ).remove(); // destroy eventual existing div for error log
				
				//console.log( error_message_content );
				
				for( var i = 0 ; i < fields_array.length ; i++ ) {
					
					//console.log('i value:' + i );
					
					// This is for dest type and dest ID field					
					if( fields_array[ i ][ 3 ] && fields_array[ i ][ 1 ].trim().length == 0 ) {
						
						error = true ;
						error_message_array.push( fields_array[ i ][ 0 ] + ' cannot be empty' ) ;
						//console.log( 'error_message_array: ' + error_message_array );
						
					} // if( fields_array[ i ][ 3 ] && fields_array[ i ][ 1 ].trim().length === '' )
					
					else if( fields_array[ i ][ 2 ] === 'num' && isNaN( fields_array[ i ][ 1 ] ) ) {
						
						error = true ;
						error_message_array.push( fields_array[ i ][ 0 ] + ' must be a number' ) ;
						
					}
					
					// This is for width and height field
					else if( fields_array[ i ][ 2 ] === 'text' && fields_array[ i ][ 1 ].trim().length !== 0 && !isNaN( fields_array[ i ][ 1 ] ) ) {
						
						error = true ;
						error_message_array.push( fields_array[ i ][ 0 ] + ' needs units (i.e.: px, em, % , rem )' ) ;
						
					}
					
					else if( fields_array[ i ][ 4 ] === 'affiliate_id' && fields_array[ i ][ 1 ][ 0 ] == '4' ) {
						
						error = true ;
						error_message_array.push( fields_array[ i ][ 0 ] + ' : use affiliate ID instead of Partner ID. It should start with a \'3\' or \'8\' ' ) ;
						
					}
					
					else if( fields_array[ i ][ 4 ] === 'affiliate_id' && fields_array[ i ][ 1 ][ 0 ] == '-' ) {
						
						error = true ;
						error_message_array.push( fields_array[ i ][ 0 ] + ' must be a positive number' ) ;
						
					}
					
					else if( fields_array[ i ][ 1 ] === 'select' && fields_array[ i ][ 2 ] === 'sel' ) {
						
						error = true ;
						error_message_array.push( 'Please select a valid ' + fields_array[ i ][ 0 ] + ' from the list' ) ;
						
					} // if( fields_array[ i ][ 1 ] === 'select' && fields_array[ i ][ 2 ] === 'sel' )
					
					
				} // for( var i = 0 ; i < fields_array.length ; i++ )
				
				//console.log( error );
				
				if( error ) {
					
					for( var i = 0 ; i < error_message_array.length ; i++ ) {
						
						error_message_content = error_message_content + error_message_array[ i ] + '<br>';
						//console.log( error_message_content ) ;	
						
					}
					
					$( '#bdotcom_ohom_meta > div.inside' ).prepend('<div id=\"bdotcom_ohom_error_content\" class=\"bdotcom_ohom_error\">' + error_message_content + '</div>' ) ;
					
					return false ; //stop submitting and siplay errors box
					
					
				} 
				
				else {// let's rock 'n roll ... save into DB
					
					return true ; 
					 
				 }
				
			} //if( bdotcom_ohom_mb_affiliate_id_val != 'undefined' && bdotcom_ohom_mb_dest_type_val != 'undefined' && bdotcom_ohom_mb_dest_id_val != 'undefined' )	
			
		});
		
		/****************  colour picker *****************/
				
		$( '.bdotcom_ohom_wp_color_picker' ).wpColorPicker();

	});
})(jQuery);
		


