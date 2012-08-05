jQuery(document).ready(function() {
    
    //Loading current tab using cookie
    if(getCookie("currtab") != "" && getCookie("currtab") != null) {
        jQuery('.settings-tab').removeClass('current-tab');
        var currtab = getCookie("currtab");
        jQuery('#' + currtab).addClass('current-tab');
        var currsection = currtab.replace('settings-tab','settings');
        jQuery('.settings-section').hide();
        jQuery('#' + currsection).show();
    }
    
    //Animating tabs
    jQuery('.settings-tab').click(function() {
        var tabid = jQuery(this).attr("id");
        var currentid = jQuery(".current-tab").attr("id");
        var secid = tabid.replace('-tab','');
        if(currentid != tabid) {
            jQuery('.settings-section').hide();
            jQuery('#' + secid).show();
            jQuery('.settings-tab').removeClass('current-tab');
            jQuery(this).addClass('current-tab');
        }        
    });
    
    //Upload image script
    var formfieldID;    
    jQuery('.upload_img').click(function() {
	var btnId = jQuery(this).attr("id");
	formfieldID = btnId.replace("-button","");
	tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	return false;
    });    
    window.send_to_editor = function(html) {
	imgurl = jQuery('img',html).attr('src');
	jQuery('#' + formfieldID).val(imgurl);
	jQuery('#' + formfieldID + '-error').html("");
        tb_remove();
    }
    
    //Setting cookie to remember last tab
    jQuery('#settings-submit').click(function() {
        var currentTabId = jQuery('.current-tab').attr("id");
        setCookie("currtab",currentTabId,3);
    });
});

function confirmAction() {
    var confirmation = confirm("Do you want to delete your settings and restore to default settings ?");
    return confirmation;
}

function setCookie(name,value,secs) {
    if (secs) {
	var date = new Date();
	date.setTime(date.getTime()+(secs*1000));
	var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}