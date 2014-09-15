<?php

 //========plugin settings configuration================

    /*register menu item*/
    function ts_buttons_like_admin_menu_setup () 
    {
        $menu_hook = add_submenu_page(
            'options-general.php',                  // $parent_slug
            'TS Buttons Like settings',            // $page_title
            'TS Buttons Like',                     // $menu_title
            'manage_options',                       // $capability
            'ts_buttons_like',                     // $menu_slug
            'ts_buttons_like_admin_page_screen'    // callback
        );
    }   //end of ts_buttons_like_admin_menu_setup

    add_action('admin_menu', 'ts_buttons_like_admin_menu_setup');

    /*display page content*/
    function ts_buttons_like_admin_page_screen () 
    {
        global $submenu;
        $page_data = array();

        foreach ($submenu['options-general.php'] as $i => $menu_item) 
        {
            if ($submenu['options-general.php'][$i][2] == 'ts_buttons_light')
                $page_data = $submenu['options-general.php'][$i];
        }
    ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php echo $page_data[3]; ?></h2>
            <form id="ts_buttons_like_options" action="options.php" method="post">
                <?php
                settings_fields ('ts_buttons_like_options');
                do_settings_sections ('ts_buttons_like');
                submit_button ('Save options', 'primary', 'ts_buttons_like_options_submit');            
                ?>
            </form>
        </div>
<?php
    } //end of ts_buttons_like_admin_page_screen

    /*TODO settings link in the plugin management screen*/
    function ts_buttons_like_settings_link ($actions, $file) 
    {
        if ( false !== strpos( $file, 'ts-buttons-like' ))
        {
            $actions['settings'] = '<a href="options-general.php?page=ts_buttons_like">Settings</a>';
        }
        return $actions;
    }   //end of ts_buttons_like_settings_link

    add_filter('plugin_action_links_', 'ts_buttons_like_settings_link', 2, 2);

/*==plugin settings init (for the menu page above)=========*/
    function ts_buttons_like_settings_init () 
    {
        register_setting (
            'ts_buttons_like_options',                  // $opt_group (same as $opt_name)
            'ts_buttons_like_opt'//,                    // $opt_name
            //'ts_buttons_like_options_callback'        // $sanitize_callback
        );
        add_settings_section (
            'ts_buttons_like_section',                 // $id
            'Likes buttons settings',                  // $title
            '',//'ts_buttons_like_desc',               // $callback
            'ts_buttons_like'                          // $menu_page
        );
        add_settings_field (
            'ts_buttons_like_header',                   // $id
            'Add the block of buttons to a header',     // $title
            'ts_buttons_like_checkbox',                 // $callback
            'ts_buttons_like',                          // $menu_page
            'ts_buttons_like_section'//,                // $settings_section
            //$header_checkbox_atts = array( 'name' => 'ts_buttons_like_opt[checkbox]' )  //TODO
         );    

    }   // end of ts_buttons_like_settings_init

    add_action ('admin_init', 'ts_buttons_like_settings_init');

    /*callback for add_settings_section*/
   // function ts_buttons_like_desc () {
   //     echo '<h4>Add the block of like Buttons</h4>';
   // }

    /*callback for add_settings_field*/
   function ts_buttons_like_checkbox () 
   {
        $options = get_option('ts_buttons_like_opt');
        $checkbox_state = '';

        if ( isset( $options['checkbox'] )) 
        {    
            $checkbox_state = 'checked';
        }    

        echo    '<label>
                    <input type="checkbox" name="ts_buttons_like_opt[checkbox]" value="1" ' 
                    .$checkbox_state.'/>
                </label>';   
    }   // end of ts_buttons_like_footer_out

?>