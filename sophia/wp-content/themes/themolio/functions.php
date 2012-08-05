<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php
$themolio_shortname = 'themolio';
require(get_template_directory().'/inc/admin/settings.php');
$themolio_options = themolio_get_options();
if(trim($themolio_options['grid_cols']) == '' or trim($themolio_options['grid_cols']) == 0) $themolio_options['grid_cols'] = 3;
require(get_template_directory().'/inc/Mobile_Detect.php');
$device = new Mobile_Detect();
if($device->isMobile() and $themolio_options['mobile_friendly']) {
    $isThemolioMobile = true;
    $wrapper_width = 380;
    $sidebar_width = 0;
    $content_width = ($wrapper_width - $sidebar_width);
} else {
    $isThemolioMobile = false;
    $wrapper_width = 1000;
    $sidebar_width = 230;
    $content_width = ($wrapper_width - $sidebar_width - 60); //60 subtracted for sidebar margin & padding
}
define('THEMOLIO_WRAPPER_WIDTH',$wrapper_width);
define('THEMOLIO_CONTAINER_WIDTH',$content_width);
define('THEMOLIO_SIDEBAR_WIDTH',$sidebar_width);
define('THEMOLIO_HEADER_HEIGHT',80);
define('THEMOLIO_GRID_IMAGE_WIDTH',ceil(THEMOLIO_WRAPPER_WIDTH/$themolio_options['grid_cols']));
add_action('after_setup_theme','themolio_theme_setup');
if(!function_exists('themolio_theme_setup')):
function themolio_theme_setup() {
    global $themolio_options;
    add_editor_style();
    load_theme_textdomain('themolio', get_template_directory() . '/languages');
    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";
    if(is_readable($locale_file))
        require_once($locale_file);
    add_theme_support('automatic-feed-links');
    register_nav_menu('primary', __('Primary Menu','themolio'));
    add_theme_support('post-formats', array('link', 'gallery', 'status', 'video', 'quote', 'image'));
    add_theme_support('post-thumbnails');
    add_image_size('grid-img',THEMOLIO_GRID_IMAGE_WIDTH, 9999);
    add_image_size('featured-img',THEMOLIO_CONTAINER_WIDTH, 9999);
    add_custom_background();
}
endif;

add_filter('use_default_gallery_style', '__return_false');

function themolio_widgets_init() {
    register_sidebar(array(
	'name' => __('Main Sidebar', 'themolio'),
	'id' => 'sidebar-1',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => "</div>",
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'themolio_widgets_init');

function themolio_load_head_scripts() {
    if(is_admin())
	return;
    if(is_singular() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');
    wp_enqueue_script('jquery');
    wp_register_script('themolio-js', get_template_directory_uri().'/js/theme-head.js','jquery');
    wp_enqueue_script('themolio-js');
}
add_action('wp_enqueue_scripts', 'themolio_load_head_scripts');

function themolio_load_styles() {
    global $themolio_options, $isThemolioMobile;
    $style = '';
    if($themolio_options['favicon_image'] != "") $style .= '<link rel="shortcut icon" href="'.$themolio_options['favicon_image'].'"/>'."\n";
    $style .= '<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/fonts/stylesheet.css" />'."\n";
    $style .= '<!--[if IE]>'."\n";
    $style .= "\t".'<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/ie.css" />'."\n";
    $style .= '<![endif]-->'."\n";
    if($isThemolioMobile)
        $style .= "\t".'<link rel="stylesheet" type="text/css" media="all" href="'.get_template_directory_uri().'/mobile-style.css" />'."\n";
    $style .= '<style type="text/css">'."\n";
    $style .= "\t".'html { margin-top: 0 !important; }'."\n";
    $style .= "\t".'* html body { margin-top: 0 !important; }'."\n";
    $style .= "\t".'.wrapper { width:'.THEMOLIO_WRAPPER_WIDTH.'px; }'."\n";
    $style .= "\t".'.container { width: '.THEMOLIO_CONTAINER_WIDTH.'px; }'."\n";
    $style .= "\t".'.full-width { width: 100%; }'."\n";
    $style .= "\t".'.sidebar { width: '.THEMOLIO_SIDEBAR_WIDTH.'px; }'."\n";
    $style .= "\t".'#header { height: '.THEMOLIO_HEADER_HEIGHT.'px; }'."\n";
    $style .= "\t".'.logo-image { max-height: '.(THEMOLIO_HEADER_HEIGHT-20).'px; max-width: '.(THEMOLIO_HEADER_HEIGHT-20).'px; }'."\n";
    if(get_theme_mod('background_color') == '') {
        $style .= "\t".'body { background-image: url('.get_template_directory_uri().'/images/background.png); background-repeat: repeat; }'."\n";
    }
    $style .= "\t".''."\n";
    $style .= '</style>'."\n";
    echo $style;
}
add_action('wp_head','themolio_load_styles');

function themolio_fullwidth_class() {
    global $themolio_options;
    if($themolio_options['blog_style'] == 'grid' or is_page_template('fullwidth-template.php')) echo ' full-width'; else echo '';
}

function themolio_page_menu_args($args) {
    $args['show_home'] = false;
    $args['menu_class'] = 'main-menu clearfix';
    return $args;
}
add_filter('wp_page_menu_args', 'themolio_page_menu_args');

function themolio_auto_excerpt_more($more) {
    global $themolio_options;
    return '<p><a class="more-link" href="'.esc_url(get_permalink()).'">' . __('Continue reading &raquo;', 'themolio') . '</a></p>';
}
add_filter('excerpt_more', 'themolio_auto_excerpt_more');

function themolio_custom_excerpt_more($output) {
    global $themolio_options;
    if (has_excerpt() && ! is_attachment()) {
        $output .= '<p><a class="more-link" href="'.esc_url(get_permalink()).'">' . __('Continue reading &raquo;', 'themolio') . '</a></p>';
    }
    return $output;
}
add_filter('get_the_excerpt', 'themolio_custom_excerpt_more');

function themolio_posted_on() {
    $posted_on = '<a class="entry-date" href="'.esc_url(get_permalink()).'" title="'.esc_attr(get_the_time()).'" rel="bookmark">'.date_i18n('jS M, y', strtotime(esc_html(get_the_date()))).'</a> ';
    $posted_on .= '<a class="entry-author" href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'" title="'.__('View all posts by ','themolio').get_the_author().'" rel="author">'.get_the_author().'</a>';
    echo $posted_on;
}

function themolio_theme_utility() {
    $utility_text = "";
    $categories_list = get_the_category_list(__(', ', 'themolio'));
    $tag_list = get_the_tag_list('', __(', ', 'themolio'));
    if($categories_list != "")
        $utility_text = __('<span class="utility-title">Posted in </span>','themolio').$categories_list;
    if($tag_list != "")
        $utility_text = __('<span class="utility-title">Tagged as </span>','themolio').$tag_list;
    if($categories_list != "" and $tag_list != "")
        $utility_text = __('<span class="utility-title">Posted in </span>','themolio').$categories_list.__(' and tagged as ','themolio').$tag_list;

    if($utility_text != "") {
        echo '<div class="entry-utility">';
        echo $utility_text;
        echo '</div>';
    }
}

function themolio_get_posts_per_col() {
    global $themolio_options, $posts;
    $posts_per_page = get_option('posts_per_page');
    $total_posts = count($posts);
    if($total_posts <= $posts_per_page) {
        $posts_per_col = ceil($total_posts/$themolio_options['grid_cols']);
    } else {
        $posts_per_col = ceil($posts_per_page/$themolio_options['grid_cols']);
    }
    return $posts_per_col;
}

function themolio_get_pagination($range = 4){
    global $paged, $wp_query;
    $max_page = 0;
    if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }
    if($max_page > 1){
        echo '<div class="navigation clearfix">'."\n";
        if(!$paged){
            $paged = 1;
        }
        if($paged != 1){
            echo "<a href=" . get_pagenum_link(1) . ">".__('First','themolio')."</a>";
        }
        previous_posts_link(' &laquo; ');
        if($max_page > $range){
            if($paged < $range){
                for($i = 1; $i <= ($range + 1); $i++){
                    echo "<a href='" . get_pagenum_link($i) ."'";
                    if($i==$paged) echo " class='current'";
                    echo ">".number_format_i18n($i)."</a>";
                }
            }
            elseif($paged >= ($max_page - ceil(($range/2)))){
                for($i = $max_page - $range; $i <= $max_page; $i++){
                    echo "<a href='" . get_pagenum_link($i) ."'";
                    if($i==$paged) echo " class='current'";
                    echo ">".number_format_i18n($i)."</a>";
                }
            }
            elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
                for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
                    echo "<a href='" . get_pagenum_link($i) ."'";
                    if($i==$paged) echo " class='current'";
                    echo ">".number_format_i18n($i)."</a>";
                }
            }
        }
        else{
            for($i = 1; $i <= $max_page; $i++){
                echo "<a href='" . get_pagenum_link($i) ."'";
                if($i==$paged) echo " class='current'";
                echo ">".number_format_i18n($i)."</a>";
            }
        }
        next_posts_link(' &raquo; ');
        if($paged != $max_page){
            echo " <a href=" . get_pagenum_link($max_page) . ">".__('Last','themolio')."</a>";
        }
        echo '</div>'."\n";
    }
}

function themolio_social_links() {
    global $themolio_options;
    $output = '';
    if(trim($themolio_options['facebook_user']) != '') $output .= '<a class="social-links" href="http://www.facebook.com/'.$themolio_options['facebook_user'].'"><img src="'.get_template_directory_uri().'/images/facebook_icon.png"/></a>';
    if(trim($themolio_options['twitter_user']) != '') $output .= '<a class="social-links" href="http://www.twitter.com/'.$themolio_options['twitter_user'].'"><img src="'.get_template_directory_uri().'/images/twitter_icon.png"/></a>';
    if($themolio_options['enable_rss']) $output .= '<a class="social-links" href="'.get_bloginfo('rss2_url').'"><img src="'.get_template_directory_uri().'/images/rss_icon.png"/></a>';
    return $output;
}

function themolio_post_image($postid, $posttitle='', $postexcerpt = '', $postcontent = '', $class = '') {
    global $themolio_options;
    $width = THEMOLIO_CONTAINER_WIDTH;
    $height = THEMOLIO_CONTAINER_WIDTH;
    if(has_post_thumbnail($postid)) {
	$thumb_attr = array(
	    'alt' => trim(strip_tags($postexcerpt)),
	    'title' => trim(strip_tags($posttitle))
	);
        return get_the_post_thumbnail($postid,$class,$thumb_attr);
    } else {
        $url = themolio_automatic_image($postcontent,$class);
        if(trim($url) != '')
	    return '<img src="'.$url.'" title="'.strip_tags($posttitle).'" alt="'.strip_tags($postexcerpt).'" style="width:'.$width.'px; height: '.$height.';"/>';
        else
            return "";
    }
}

function themolio_automatic_image($content, $class = '') {
    global $themolio_options;
    if(preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i',$content, $matches) > 0) {
        $pos1 = strpos($matches[0],'src=');
        $newUrl = substr_replace($matches[0],"",0,$pos1);
        $newUrl = str_replace('src="','',$newUrl);
        $imgUrl = $newUrl;
    } else if($class != 'grid-img' and $class != 'featured-img')
        $imgUrl = get_template_directory_uri().'/colors/'.$themolio_options['color_scheme'].'/images/default-'.$class.'.jpg';
    else $imgUrl = '';
    return $imgUrl;
}

function themolio_trim_words($str, $n, $delim='...') {
    $len = strlen($str);
    if ($len > $n) {
        preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
        return rtrim($matches[1]) . $delim;
    } else {
        return $str;
    }
}

if(!function_exists('themolio_list_comments')):
function themolio_list_comments($comment, $args, $depth) {
    global $isThemolioMobile;
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type):
        case 'pingback':
        case 'trackback':
    ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-ping">
            <span class="comment-author"><?php comment_author_link(); ?></span>
            <p class="ping-date"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s at %2$s','themolio'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('Edit','themolio'),', ',''); ?></p>
        </div>
    <?php
            break;
            default:
    ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <?php if($isThemolioMobile) $avatar_size = 32; else $avatar_size = 48; ?>
                <div class="comment-avatar"><?php echo get_avatar($comment, $avatar_size, get_template_directory_uri().'/images/gravatar_default.png'); ?></div>
                <div class="comment-meta">
                    <p><span class="comment-author"><?php echo get_comment_author_link(); ?></span><?php _e(' commented on ','themolio'); ?>
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s at %2$s','themolio'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('Edit','themolio'),', ',''); ?></p>
                    <p class="comment-reply"><?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'themolio'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></p>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                <div class="comment-status"><?php _e('Your comment is awaiting moderation','themolio'); ?></div>
                <?php endif; ?>
                <div class="comment-content"><?php comment_text(); ?></div>
            </div>
    <?php
        break;
    endswitch;
}
endif;
?>