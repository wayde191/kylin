<?php
/*
Plugin Name: x-emotions
Plugin URI: http://bluehua.org
Description: more emotions for you !
Author: emptyhua@gmail.com
Version: 0.1.4
Author URI: http://bluehua.org
*/

define( "X_EMOTION_VER" , "0.1.4" );

//是否在留言启用表情
$blue_emotions_enable_in_comments = true;



$emotion_dir = 'emotions/';


function blue_emotions_regplugin( $plugins ) {
	$plugins['xemotions'] = get_bloginfo( 'wpurl' ) . '/wp-content/plugins/x-emotions/editor_plugin.js';
	return $plugins;
}

function blue_emotions_addbutton( $buttons ) {
	$buttons[] = 'xemotions';
	return $buttons;
}

function blue_emotions_init_comment( ) {
	$emotion_root = get_bloginfo( 'wpurl') . '/wp-content/plugins/x-emotions/';
	echo '<script type="text/javascript">'
	. 'var xemotion_root = "'
	. $emotion_root
	. '";</script>';
	echo '<script type="text/javascript" src="' . $emotion_root . 'img/for_comment.js?ver=' . X_EMOTION_VER . '"></script>';
	echo '<link rel="stylesheet" href="'. $emotion_root . 'img/style.css?ver=' . X_EMOTION_VER . '" type="text/css" />';
}

function blue_emotions_parse_UBB( $comment ) {
	global $emotion_dir;
	$emotion_root = get_bloginfo( 'wpurl') . '/wp-content/plugins/x-emotions/' . $emotion_dir;
	$comment = preg_replace( "/\[([a-zA-Z0-9]+)::([a-zA-z0-9.]+)\]/i" , '<img class="xemotion" src="' . $emotion_root . "\\1/\\2" . '" />' , $comment );
	return $comment;
}

add_filter( 'mce_external_plugins' , 'blue_emotions_regplugin' , 99 );
add_filter( 'mce_buttons' , 'blue_emotions_addbutton' , 99 );

if ( $blue_emotions_enable_in_comments ) {
	add_action ( 'comment_form' , 'blue_emotions_init_comment' );
	add_filter( 'comment_text' , 'blue_emotions_parse_UBB' , 99 );
}
?>
