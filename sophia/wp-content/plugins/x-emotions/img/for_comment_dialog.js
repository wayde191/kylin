var xEmotions = {
	insert	:	function ( dir , file ) {
		parent.document.getElementById( 'comment' ).value += '[' + dir + '::' + file + ']';
		parent.hideEmotionDialog();
	}
};