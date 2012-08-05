/** HEAD JAVASCRIPT **/

jQuery(document).ready(function() {
    //Animate Menu
    jQuery('.main-menu ul li').hover(function() {
        jQuery(this).find('ul:first').css({visibility:"visible",display:"none"}).slideDown(500);
    },
    function() {
        jQuery(this).find('ul:first').hide();
    });

    ////Adding Last class
    jQuery('li:last-child').addClass('last');
    jQuery('.entry-content *:last-child').addClass('last');
    jQuery('.comment-content *:last-child').addClass('last');
    jQuery('.widget p:last-child').addClass('last');
    jQuery('.widget div:last-child').addClass('last');
    jQuery('blockquote *:last-child').addClass('last');
    
});

function showComments() {
    jQuery('.comments-container').show();
}

function showCommentForm() {
    jQuery('.comments-container').hide();
}