/**
 * xemotions plugin.
 */

(function() {

	tinymce.create('tinymce.plugins.xemotions', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mcexEmotion', function() {
				ed.windowManager.open({
					file : url + '/dialog_for_editor.php',
					width : 500 + parseInt(ed.getLang('xemotions.delta_width', 0)),
					height : 400 + parseInt(ed.getLang('xemotions.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('xemotions', {title : 'xemotions', cmd : 'mcexEmotion' , image : url + '/img/icon.png'});
		},

		getInfo : function() {
			return {
				longname : 'x-emotions',
				author : 'emptyhua@gmail.com', // add Moxiecode?
				authorurl : 'http://bluehua.org',
				infourl : 'http://bluehua.org',
				version : '0.1'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('xemotions', tinymce.plugins.xemotions);
})();
