<?php

    /** Hook plugin's action and filters **/
    function ts_buttons_like_init()
    {
        /* add css for buttons and social-buttons.js script to the DOM + jQuery cdn once; for shortcode */
        add_action ('wp_enqueue_scripts', 'css_buttons_like');
        // add_action ('wp_enqueue_scripts', 'some_js_scripts');
    }   //  end of ts_buttons_like_init

    add_action('plugins_loaded', 'ts_buttons_like_init');

    function css_buttons_like () 
    {
        $styles_url = TS_BUTTONS_LIKE_URL.'/assets/css/social-buttons.css';
        wp_register_style( 'like_buttons_css',  $styles_url);
        wp_enqueue_style( 'like_buttons_css' ); 
    }   //  end of css_buttons_like

//======================================================
    function likes_buttons_init ()
    {        
        // add_action ( 'wp_head', 'add_likes_block' );
        // add_action ( 'wp_footer', 'add_likes_block' );

        /* add a likes buttons block to front of the post's content (it displays when the post is open) */
        add_filter ( 'the_content', 'add_buttons_to_content' ); 
    }   //  end of buttons_init

    add_action ( 'init', 'likes_buttons_init' );

    function add_likes_block ()
    {
        $options = get_option('ts_buttons_like_opt');
        
        if ( isset( $options['checkbox'] ))
        {
                $likes_block = new LikesBlock( array( 'facebook' => true, 'vkontakte' => true, 'tw' => false, 'google' => true ));
                $likes_block = $likes_block->like_buttons_block ();
                echo $likes_block;
        }
    }   //  end of add_likes_block

    function add_buttons_to_content ( $content )
    {
        if ( is_single () or is_page ())
        {
            $content .= add_likes_block ();
        }
        return $content;
    }   //  end of add_buttons_to_content

//======================================================
    // function hw_footer () {  //test
    //     echo '<h2><i>hello world (footer)</i></h2>';
    // }

//    //  jquery + buttons js script
    // function some_js_scripts () 
    // {
//    	$buttons_like_url = '/wp-content/plugins/ts-buttons-like/assets/js/social-buttons.js';

    	// wp_deregister_script( 'jquery' );
    	// wp_deregister_script( 'buttons_like' );

	 	// wp_register_script( 'jquery', 'http://code.jquery.com/jquery-1.11.0.min.js' );
	 	// wp_register_script( 'jquery_migrate_plugin', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' );
   //  	wp_register_script( 'buttons_like', $buttons_like_url );
 		
 		// wp_enqueue_script( 'jquery' );
 		// wp_enqueue_script( 'jquery_migrate_plugin' );
 		// wp_enqueue_script( 'buttons_like', $buttons_like_url, $deps = array('jquery') );			//load a social-buttons.js script
   //  }

?>