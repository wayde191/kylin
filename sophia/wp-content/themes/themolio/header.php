<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title>
<?php
global $page, $paged, $themolio_options, $isThemolioMobile;
wp_title('|', true, 'right');
bloginfo('name');
$site_description = get_bloginfo('description', 'display');
if ($site_description && (is_home() || is_front_page()))
    echo " | $site_description";
if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'themolio'), max($paged, $page));
?>
</title>
<?php if($isThemolioMobile): ?>
<meta name="viewport" content="width=device-width, initial-scale=0.8" />
<?php else: ?>
<meta name="viewport" content="width=device-width" />
<?php endif; ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33696366-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<body <?php body_class(); ?>>
    <div id="header">
        <div class="wrapper"> <!-- Start of wrapper -->
        <table class="tablayout" style="height: <?php echo THEMOLIO_HEADER_HEIGHT; ?>px;">
            <tr>
                <?php if($themolio_options['logo_image'] != ''): ?>
                <td class="tdleft" style="padding-right: 25px; width: <?php echo (THEMOLIO_HEADER_HEIGHT-30); ?>px;">
                    <img class="logo-image" src="<?php echo $themolio_options['logo_image']; ?>"/>
                </td>
                <?php endif; ?>
                <td class="tdleft" style="padding-right: 25px;">
                    <h1 class="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
                    <?php if(trim(get_bloginfo('description')) != ''): ?><p class="site-desc"><?php bloginfo('description'); ?></p><?php endif; ?>
                </td>
            </tr>
        </table>
        </div> <!-- end of wrapper -->
    </div>
    <div id="menu-container">
        <div class="wrapper"> <!-- Start of wrapper -->
        <?php wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'main-menu clearfix')); ?>
        </div> <!-- end of wrapper -->
    </div>
    <?php if($isThemolioMobile): ?>
    <div id="top-search">
        <div class="wrapper">
            <?php get_search_form(); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="wrapper">