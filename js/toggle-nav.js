(function ($jq) {
jQuery(document).ready(function() {
    jQuery('.toggle-nav').click(function(e) {
        jQuery(this).toggleClass('nav-active');
        jQuery('#menu-main').toggleClass('nav-active');
        e.preventDefault();
    });
});
})(jQuery);

(function ($jq) {
jQuery(document).ready(function() {
    jQuery('.toggle-tabs').click(function(e) {
        jQuery(this).toggleClass('nav-active');
        jQuery('#menu-local-tasks').toggleClass('nav-active');
        e.preventDefault();
    });
});
})(jQuery);