(function ($jq) {
jQuery(document).ready(function() {
    jQuery('.toggle-nav').click(function(e) {
        jQuery(this).toggleClass('nav-active');
        jQuery('ul.menu').toggleClass('nav-active');
        e.preventDefault();
    });
});
})(jQuery);

(function ($jq) {
jQuery(document).ready(function() {
    jQuery('.toggle-tabs').click(function(e) {
        jQuery(this).toggleClass('tabs-active');
        jQuery('.tabs.primary').toggleClass('tabs-active');
        e.preventDefault();
    });
});
})(jQuery);