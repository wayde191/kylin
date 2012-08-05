<?php
/* THEME SETTINGS PAGE */

//Initialize theme options on load
function themolio_init_options() {
    if(false === themolio_get_options()) add_option('themolio_options', themolio_get_default_options());
    register_setting('themolio_options', 'themolio_options', 'themolio_validate_options');
}
add_action('admin_init', 'themolio_init_options');

//Retrieve theme options
function themolio_get_options() {
    return get_option('themolio_options', themolio_get_default_options());
}

//Return capability
function themolio_page_capability($capability) {
    return 'edit_theme_options';
}
add_filter('option_page_capability_themolio_options', 'themolio_page_capability');

//Enqueue stylesheets and dependent javascripts
function themolio_enqueue_scripts($hook_suffix) {
    wp_enqueue_script('jquery'); //Adding the JQuery script
    wp_enqueue_script('media-upload'); //Adding the media upload script
    wp_enqueue_script('thickbox'); //Adding the thickbox script for media upload
    wp_enqueue_style('thickbox'); //Adding the thickbox stylesheet for media upload
    wp_enqueue_script('themolio_color_picker', get_template_directory_uri() . '/inc/admin/jquery-colorpicker/jscolor.js', false, false);
    wp_enqueue_script('themolio_admin_js', get_template_directory_uri() . '/inc/admin/settings.js', array('jquery'), false);
    wp_enqueue_style('themolio_admin_css', get_template_directory_uri().'/inc/admin/settings.css', false, false, 'all');
}

//Add theme option page to the admin menu
function themolio_activate_options() {
    $themolio_theme_page = add_theme_page(__('Themolio Settings','themolio'), __('Themolio Settings','themolio'), 'edit_theme_options', 'themolio_options', 'themolio_options_page');
    if(!$themolio_theme_page) return;
    add_action('admin_print_styles-' . $themolio_theme_page, 'themolio_enqueue_scripts');
}
add_action('admin_menu', 'themolio_activate_options');

//Default dropdowns
function themolio_tab_list() {
    $tabs = array(
        'logo' => array('value' => 'logo', 'label' => __('Logo','themolio')),
        'layout' => array('value' => 'layout', 'label' => __('Layout','themolio')),
        'blog' => array('value' => 'blog', 'label' => __('Blog','themolio')),
        'social' => array('value' => 'social', 'label' => __('Social','themolio')),
    );
    return apply_filters('themolio_tab_list', $tabs);
}

function themolio_blog_style() {
    $blog_styles = array(
        'standard' => array('value' => 'standard', 'label' => __('Standard','themolio')),
        'grid' => array('value' => 'grid', 'label' => __('Grid','themolio')),
    );
    return apply_filters('themolio_blog_style', $blog_styles);
}

function themolio_grid_columns() {
    $columns = array(
        '2' => array('value' => '2', 'label' => __('Two','themolio')),
        '3' => array('value' => '3', 'label' => __('Three','themolio')),
        '4' => array('value' => '4', 'label' => __('Four','themolio')),
    );
    return apply_filters('themolio_grid_columns', $columns);
}

//Retrieve Default theme settings
function themolio_get_default_options() {
    $themolio_default_options = array(
        'mobile_friendly' => true,
        'logo_image' => '',
        'favicon_image' => '',
        'grid_cols' => 3,
        'blog_style' => 'grid',
        'show_excerpts' => false,
        'show_featured' => false,
        'show_search' => true,
        'show_page_meta' => true,
		'show_single_utility' => true,
		'facebook_user' => '',
        'twitter_user' => '',
        'enable_rss' => true,
    );
    return apply_filters('themolio_get_default_options', $themolio_default_options);
}

function themolio_options_page() {
    if(isset($_POST['settings-reset'])) {
        delete_option('themolio_options');
        add_settings_error('themolio_options','settings-reset-update',__('Default settings restored','themolio'),'updated');
    }
    ?>    
    <div class="settings-wrap"> <!-- Start of settings wrap -->
        <div class="icon32" id="icon-options-general"></div>
        <h1 class="settings-title"><?php _e('Themolio Settings','themolio'); ?></h1><br />
        <?php settings_errors(); ?>
        
        <?php $count = 1; ?>
        <?php foreach (themolio_tab_list() as $tab) { if($count == 1) $class = " current-tab"; else $class = ""; ?>
        <div id="settings-tab-<?php echo $tab['value']; ?>" class="settings-tab<?php echo $class; ?>">
            <?php echo $tab['label']; ?>
        </div>
        <?php $count++; } ?>
        <form class="settings-form" method="post" id="settings-form" action="options.php">
        <?php
            settings_fields('themolio_options');                   
            $themolio_options = themolio_get_options();                    
            $themolio_default_options = themolio_get_default_options();
        ?>        
        <div class="settings-section current-section" id="settings-logo">
            <p><label><?php _e('Upload logo','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="text" name="themolio_options[logo_image]" id="logo-upload" size="36" value="<?php echo esc_attr($themolio_options['logo_image']); ?>"/>
                <input id="logo-upload-button" type="button" class="upload_img button-secondary" value="<?php _e('Upload Logo Image','themolio'); ?>" />
            </p>
            <p><label><?php _e('Upload favicon','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="text" name="themolio_options[favicon_image]" id="favicon-upload" size="36" value="<?php echo esc_attr($themolio_options['favicon_image']); ?>"/>
                <input id="favicon-upload-button" type="button" class="upload_img button-secondary" value="<?php _e('Upload Favicon Image','themolio'); ?>" />
            </p>
        </div>
        <div class="settings-section" id="settings-layout">
            <p><label><?php _e('Responsive','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[mobile_friendly]" value="true" <?php checked(true,$themolio_options['mobile_friendly']); ?> />
                <span class="field-meta"><?php _e('Display responsive/mobile friendly layout for mobile devices','themolio'); ?></span>
            </p>
        </div>
        <div class="settings-section" id="settings-blog">
			<p><label><?php _e('Blog Style','themolio'); ?>:</label></p>
            <p class="fieldp">
                <select name="themolio_options[blog_style]">
                    <?php foreach (themolio_blog_style() as $blog_style) { ?>
                        <option value="<?php echo $blog_style['value']; ?>" <?php selected($themolio_options['blog_style'], $blog_style['value']); ?>><?php echo $blog_style['label']; ?></option>
                    <?php } ?>
                </select>
            </p>
			<p><label><?php _e('Grid Columns','themolio'); ?>:</label></p>
            <p class="fieldp">
                <select name="themolio_options[grid_cols]">
                    <?php foreach (themolio_grid_columns() as $grid_cols) { ?>
                        <option value="<?php echo $grid_cols['value']; ?>" <?php selected($themolio_options['grid_cols'], $grid_cols['value']); ?>><?php echo $grid_cols['label']; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p><label><?php _e('Blog excerpts','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[show_excerpts]" value="true" <?php checked(true,$themolio_options['show_excerpts']); ?> />
                <span class="field-meta"><?php _e('Display excerpts for non-single templates','themolio'); ?></span>
            </p>
            <p><label><?php _e('Featured images','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[show_featured]" value="true" <?php checked(true,$themolio_options['show_featured']); ?> />
                <span class="field-meta"><?php _e('Display featured images for non-single templates','themolio'); ?></span>
            </p>
            <p><label><?php _e('Search','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[show_search]" value="true" <?php checked(true,$themolio_options['show_search']); ?> />
                <span class="field-meta"><?php _e('Display default search box in sidebar','themolio'); ?></span>
            </p>
            <p><label><?php _e('Meta','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[show_page_meta]" value="true" <?php checked(true,$themolio_options['show_page_meta']); ?> />
                <span class="field-meta"><?php _e('Show meta information for pages','themolio'); ?></span>
            </p>
            <p><label><?php _e('Categories and Tags','themolio'); ?>:</label></p>
            <p class="fieldp">
                <input type="checkbox" name="themolio_options[show_single_utility]" value="true" <?php checked(true,$themolio_options['show_single_utility']); ?> />
                <span class="field-meta"><?php _e('Show tags and categories for single entries','themolio'); ?></span>
            </p>
        </div>
        <div class="settings-section" id="settings-social">
            <p><label><?php _e('Facebook','themolio'); ?>:</label></p>
            <p class="fieldp">
                <img style="vertical-align: middle;margin-right:10px;" src="<?php echo get_template_directory_uri(); ?>/inc/admin/images/facebook.png"/> 
                <input type="text" class="social-field" id="facebook-user" name="themolio_options[facebook_user]" value="<?php echo esc_attr($themolio_options['facebook_user']); ?>"/>
                <span class="field-meta"><?php _e('Enter your facebook user id','themolio'); ?></span>
            </p>
            <p><label><?php _e('Twitter','themolio'); ?>:</label></p>
            <p class="fieldp">
                <img style="vertical-align: middle;margin-right:10px;" src="<?php echo get_template_directory_uri(); ?>/inc/admin/images/twitter.png"/> 
                <input type="text" class="social-field" id="twitter-user" name="themolio_options[twitter_user]" value="<?php echo esc_attr($themolio_options['twitter_user']); ?>"/>
                <span class="field-meta"><?php _e('Enter your twitter user id','themolio'); ?></span>                
            </p>
            <p><label><?php _e('RSS','themolio'); ?>:</label></p>
            <p class="fieldp">
                <img style="vertical-align: middle;margin-right:10px;" src="<?php echo get_template_directory_uri(); ?>/inc/admin/images/rss.png"/> 
                <input type="checkbox" name="themolio_options[enable_rss]" value="true" <?php checked(true,$themolio_options['enable_rss']); ?> />
                <span class="field-meta"><?php _e('Show RSS icon','themolio'); ?></span>
            </p>
        </div>
        <?php submit_button('Save Settings','primary','settings-submit',false); ?>        
        </form>
        <form class="form" method="post" id="reset-form" style="text-align: right; margin-top: 10px;" onsubmit="return confirmAction()">
            <input type="submit" class="button-secondary" name="settings-reset" id="settings-reset" value="<?php _e('Reset Settings','themolio'); ?>" />            
        </form>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="text-align: right; margin-top: 10px;">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="43VU78ENDDKSU">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div> <!-- End of settings wrap -->
    <?php
}

function themolio_validate_options($input) {
    $output = $defaults = themolio_get_default_options();
    
    //Validating dropdowns and radio options
    if (isset($input['blog_style']) && array_key_exists($input['blog_style'], themolio_blog_style()))
	$output['blog_style'] = $input['blog_style'];
    if (isset($input['grid_cols']) && array_key_exists($input['grid_cols'], themolio_grid_columns()))
	$output['grid_cols'] = $input['grid_cols'];
        
    //Validating Image fields    
    if(trim($input['logo_image']) == "")
        $output['logo_image'] = $input['logo_image'];
    else {
        if(themolio_validate_image_url($input['logo_image']))
            $output['logo_image'] = $input['logo_image'];
        else
            add_settings_error('themolio_options', 'invalid-logo-image', __('Invalid logo image URL','themolio'), 'error');
    }
    if(trim($input['favicon_image']) == "") {
        $output['favicon_image'] = $input['favicon_image'];
    } else {
        if(themolio_validate_image_url($input['favicon_image'])) {
            if(themolio_validate_image_size($input['favicon_image'],16,16))
                $output['favicon_image'] = $input['favicon_image'];
            else
                add_settings_error('themolio_options', 'invalid-favicon-size', __('Favicon size cannot exceed 16 x 16 pixels','themolio'), 'error');
        } else
            add_settings_error('themolio_options', 'invalid-favicon-image', __('Invalid favicon image URL','themolio'), 'error');
    }
    
    //Validating Social site usernames
    if(themolio_validate_social_user($input['facebook_user']) or trim($input['facebook_user']) == "")
        $output['facebook_user'] = $input['facebook_user'];
    else
        add_settings_error('themolio_options', 'invalid-facebook-user', 'Invalid facebook username', 'error');
    if(themolio_validate_social_user($input['twitter_user']) or trim($input['twitter_user']) == "")
        $output['twitter_user'] = $input['twitter_user'];
    else
        add_settings_error('themolio_options', 'invalid-twitter-user', 'Invalid twitter username', 'error');
    
    //Validating all the checkboxes
    $chkboxinputs = array('mobile_friendly','show_excerpts','show_featured','show_breadcrumbs','show_search','show_page_meta','show_single_utility','enable_rss');
    foreach($chkboxinputs as $chkbox) {
        if (!isset($input[$chkbox]))
            $input[$chkbox] = null;                
        $output[$chkbox] = ($input[$chkbox] == true ? true : false);
    }
        
    return apply_filters('themolio_validate_options', $output, $input, $defaults);
}

/* Supporting validation functions */
function themolio_validate_color($color) {
    $exp = "/([A-Za-z0-9])/";
    if(!preg_match($exp,$color))
        return false;
    else
        return true;
}

function themolio_validate_image_url($url) {
    $exp = "/^https?:\/\/(.)*\.(jpg|png|gif|ico)$/i";
    if(!preg_match($exp,$url))
        return false;
    else
        return true;
}

function themolio_validate_image_size($url,$width,$height) {
    $size = getimagesize($url);
    if($size[0] > $width or $size[1] > $height)
        return false;
    else
        return true;
}

function themolio_validate_number($value,$min,$max) {
    if(is_numeric($value)) {
        $value = intval($value);        
        if($value < $min or $value > $max)
            return false;
        else
            return true;
    } else return false;
}

function themolio_validate_social_user($user) {
    $exp = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*$/";
    if(!preg_match($exp,$user))
        return false;
    else
        return true;
}

function themolio_validate_email($email) {
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        return false;
    }
    
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
        ?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
        $local_array[$i])) {
            return false;
        }
    }
    
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false;
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
            ?([A-Za-z0-9]+))$",
            $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}
?>