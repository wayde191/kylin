<?php
	//自定义变量,是否启用客户端缓存
	$emotion_enable_clientcache = false;
	
	$emotion_dir = 'emotions/';
	$emotion_temp_filename = 'cache_for_comment.php';

	function emotion_push_header( ) {
		global $emotion_enable_clientcache;
		if ( $emotion_enable_clientcache ) {
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			header( 'Expires: ' . gmdate ( "D, d M Y H:i:s" , time() + 3600*24) . ' GMT' );
		}
	}
	
	function build_emotion_header_files ( ) {
		global $tinyMCE_root;
        return  
        '<script type="text/javascript">'
        . "tinyMCEPopup = {};\n"
        . "tinyMCEPopup.editor = {};\n"
        . "tinyMCEPopup.editor.windowManager = {};\n"
        . "tinyMCEPopup.editor.windowManager.createInstance = function(){return null};\n"
        . '</script>'
        .  '<link rel="stylesheet" href="' . $tinyMCE_root . 'themes/advanced/skins/wp_theme/dialog.css" type="text/css" />'
		. '<script type="text/javascript" src="' . $tinyMCE_root  . 'utils/mctabs.js"></script>'
		. '<script type="text/javascript" src="img/for_comment_dialog.js?ver=' . X_EMOTION_VER . '"></script>'
		. '<link rel="stylesheet" href="img/style.css?ver=' . X_EMOTION_VER . '" type="text/css" />';
	}

	function build_emotion_theme_tab ( ) {
		global  $emotion_theme_name;

		$rt = '';
		$l = count ( $emotion_theme_name );
		for ( $i = 0 ; $i < $l ; $i ++ ) {
			$rt .= '<li id="emotion_tab_' . $i . '"' . ( $i === 0 ? ' class="current"' : '' ) . '><span>'
			 . "<a href=\"javascript:mcTabs.displayTab('emotion_tab_" . $i . "','emotion_panel_" . $i . "');\" onmousedown=\"return false;\">"
			. $emotion_theme_name[ $i ] . '</a></span></li>';
		}
		return $rt;
	}
	
	function build_emotion_theme_panel ( ) {
		global $emotion_theme_dir , $emotion_theme_pic;

		$rt = '';
		$l = count ( $emotion_theme_pic );
		if ( $l === 0 ) {
			$rt .=  '您还没有上传表情';
			return $rt;
		}
		for ( $i = 0 ; $i < $l ; $i ++ ) {
			$rt .=  '<div id="emotion_panel_' . $i . '" class="panel' . (  $i === 0 ? ' current' : '' ) . '">';
            $rt .= '<ul>';
			$rt .= build_emotion_theme_pics ( $emotion_theme_pic[ $i ] , $emotion_theme_dir[ $i ] );
            $rt .= '</ul>';
			$rt .= '</div>';
		}
		return $rt;
	}

	function build_emotion_theme_pics ( $pics,$dir ) {
		global $emotion_dir , $emotion_root;

		$rt = '';
		$l = count ( $pics );
		for ( $i = 0 ; $i < $l ; $i ++ ) {
			$rt .=  "<li><a href=\"javascript:xEmotions.insert('" . $dir . "','" . $pics[ $i ] . "');\">"
			. '<img src="' . $emotion_dir . $dir . '/' . $pics[ $i ] . '" /></a></li>';
		}
		return $rt;
	}	

	emotion_push_header();

	if ( !file_exists ( $emotion_dir . $emotion_temp_filename ) ) {
		require_once ( '../../../wp-blog-header.php' );
		require_once ( './cache.php' );
		if ( emotion_create_temp_file () ) {
			include ( $emotion_dir . $emotion_temp_filename ) ;
		}
	} else {
		include ( $emotion_dir . $emotion_temp_filename ) ;
	}

?>
