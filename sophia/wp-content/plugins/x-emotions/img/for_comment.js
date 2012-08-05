(function(){
	function $( s ) {
		return typeof s == 'string' ? document.getElementById( s ) : s ;
	}
	
	if ( !$( 'comment' ) ) return;
	
	var wraper = document.createElement ( 'div' );
	wraper.id = 'xemotion';
	wraper.style.position = 'relative';
	wraper.innerHTML = '<div><a href="#nogo" id="xemotion_button" onfocus="this.blur();"><img src="' + xemotion_root + 'img/icon.png" /></a></div><div id="xemotion_dialog_wraper" style="display:none;"><iframe frameborder="0" id="xemotion_dialog"></iframe></div>';
	$( 'comment' ).parentNode.insertBefore( wraper , $( 'comment' ) );
	
	window.showEmotionDialog = function(){
		$( 'xemotion_dialog_wraper' ).style.display = '';
		if ( !$( 'xemotion_dialog' ).getAttribute('src') ) {
			$( 'xemotion_dialog' ).src = xemotion_root + 'dialog_for_comment.php';
		}
	}
	
	window.hideEmotionDialog = function(){
		$( 'xemotion_dialog_wraper' ).style.display = 'none';
	}
	
	document.onmousedown = hideEmotionDialog;
	
	var hasShowDialog = false;
	
	$( 'xemotion_button' ).onclick = function( ) {
		if ( !hasShowDialog ) {
			hasShowDialog = true;
			showEmotionDialog();
		} else {
			hasShowDialog = false;
			hideEmotionDialog();
		}
	}
})();