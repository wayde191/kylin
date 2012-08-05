<?php
	$tinyMCE_root = get_bloginfo("wpurl") . '/wp-includes/js/tinymce/';
	$emotion_root = get_bloginfo("wpurl") . '/wp-content/plugins/x-emotions/' . $emotion_dir;
	$emotion_name_file = 'name.txt';
	$emotion_theme_dir = array();
	$emotion_theme_name = array();
	$emotion_theme_pic = array();
	

	function emotion_get_emotion( $dir_name ) {
		global $debug_mode , $emotion_theme_dir , $emotion_theme_pic , $emotion_theme_name , $emotion_name_file;
		
		if ( $name = file_get_contents ( $dir_name . '/' . $emotion_name_file ) ) {
			$emotion_theme_name[] = $name;
		} else {
			$emotion_theme_name[] = $dir_name;
		}

		if ( $dir = opendir ( $dir_name ) ) {
			$emotion_theme_dir[] = $dir_name;
			$pics = array();
			while ( false !== ( $file = readdir ( $dir ) ) ) {
				if ( !is_dir ( $file ) && preg_match ( "/(\.png|\.gif|\.jpg)$/i" , $file ) ) {
					$pics[] = basename ( $file );
				}
			}
		}
		$emotion_theme_pic[] = $pics;
	}

	function emotion_create_temp_file() {
		global $emotion_dir , $emotion_temp_filename , $emotion_theme_dir , $emotion_theme_pic ;
		

		if ( !chdir ( $emotion_dir ) ) {
			if ( !mkdir ( $emotion_dir  , 0777 ) ) return false;
		}

		if ( !is_writeable ( './' ) ) {
			if ( !chmod( './' , 777 ) ) return false;
		}

		$fp = fopen ( './' . $emotion_temp_filename , 'w');
		
		if( !$fp ) {
			return false;
		}

		if ( $dir = opendir ( './' ) ) {
			while ( false !== ( $file = readdir ( $dir ) ) ) {
				if ( is_dir ( $file ) && $file != '.' && $file != '..' ) emotion_get_emotion ( $file ) ;
			}

		} else {
			return false;
		}
		
		$print_cache = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
		. '<html xmlns="http://www.w3.org/1999/xhtml">'
		. '<head>'
		. '<title>xemotions</title>'
		. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'
		. build_emotion_header_files ()
		. '<base target="_self" />'
		. '</head>'
		. '<body>'
		. '	<div align="center">'
		. '		<div class="tabs">'
		. '			<ul>';
		$print_cache .= build_emotion_theme_tab();
		$print_cache .= '	</ul>'
		. '</div>'
		. '		<div id="emotions" class="panel_wrapper">';

		$print_cache .= build_emotion_theme_panel();

		$print_cache .= '<p style="clear:both;"></p></div>'
		. '</div>'
		. '</body>'
		. '</html>';

		fwrite ( $fp , $print_cache );
		fclose ( $fp );
		
		return true;
	}
?>