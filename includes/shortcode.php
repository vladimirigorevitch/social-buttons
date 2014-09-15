<?php

/* 	shortcode format [tsb-like fb="true" vk="true"] , false by default	*/

	function shortcode_buttons_like ($atts) 
	{
		/* a block of buttons will be displayed at the front of content of the open post page */
		if ( is_single () or is_page ())
		{
			$attributes = shortcode_atts( array(
						'facebook' => false,
						'vkontakte' => false,
						'google' => false	
			), $atts );


			$like_block = new LikesBlock( $attributes );
			$like_block = $like_block->like_buttons_block ();

	 		return $like_block;
 		}

//  //jQuery way below
// 		$id = get_the_id();
// 		$wrapper = 'jQuery("#post-'.$id.'").append(likesWrapperCreate());';	
// 		$result = '';

// 		foreach ($attributes as $key => $value) 
// 		{
// 			if ( $value ) 
// 			{
// 				$result .= 'jQuery(".likes-wrapper").append(socialButtonCreate("' .$key. '"));';
// 			}
// 		}
// 		if ( $result ) 
// 		{
// 			return '<script language="javascript" type="text/javascript">
// 						' .$wrapper.$result. '	
// 					</script>';	
// 		} 
// 		else 
// 		{
// 			return null;
// 		}
	}	//	end of shortcode_buttons_like

	add_shortcode ('tsb-like', 'shortcode_buttons_like');

?>