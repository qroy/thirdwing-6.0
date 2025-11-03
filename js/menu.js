jQuery(document).ready(function($) {
  var isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
  
  // 1. Menu button toggle
  $('.menu-toggle').click(function(e) {
    e.preventDefault();
    var $button = $(this);
    var $menuContainer = $('#menu-main');
    
    // Toggle menu visibility
    $button.toggleClass('is-active');
    $menuContainer.toggleClass('is-open');
    
    // Toggle aria-expanded
    var isExpanded = $button.attr('aria-expanded') === 'true';
    $button.attr('aria-expanded', !isExpanded);
    
    // Close all open submenus when closing main menu
    if (!$menuContainer.hasClass('is-open')) {
      $menuContainer.find('li.open').removeClass('open');
    }
  });
  
  // 1b. Local menu button toggle for #menu-local
  $('.local-toggle').click(function(e) {
    e.preventDefault();
    var $button = $(this);
    var $menuContainer = $('#menu-local-1');
    
    // Toggle menu visibility
    $button.toggleClass('is-active');
    $menuContainer.toggleClass('is-open');
    
    // Toggle aria-expanded
    var isExpanded = $button.attr('aria-expanded') === 'true';
    $button.attr('aria-expanded', !isExpanded);
    
    // Close all open submenus when closing menu
    if (!$menuContainer.hasClass('is-open')) {
      $menuContainer.find('li.open').removeClass('open');
    }
  });
  
  // 2. Close when clicking outside
  $(document).click(function(e) {
    var $target = $(e.target);
    
    if (!$target.closest('#menu-main').length && !$target.closest('.menu-toggle').length) {
      $('#menu-main li.open').removeClass('open');
      $('#menu-main').removeClass('is-open');
      $('.menu-toggle').removeClass('is-active').attr('aria-expanded', 'false');
    }
  });
  
    // Find all menu items with the classes "expanded" or "collapsed"
    $('#menu-main li.expanded, #menu-main li.collapsed').each(function() {
      var $item = $(this);
      var $link = $item.children('a').eq(0);
      var $submenu = $item.children('ul.menu').eq(0);
      
      if ($link.length && $submenu.length) {
        
        // Add duplicate link if it doesn't exist
        if (!$submenu.children('.menu-item-parent-duplicate').length) {
          var $duplicate = $link.clone();
          var $li = $('<li class="menu-item-parent-duplicate leaf first"></li>');
          $li.append($duplicate);
          $submenu.prepend($li);
		  		
		  // Remove 'first' class from the original first item
          $submenu.children('li').eq(1).removeClass('first');
        }
       
        // Prevent navigation on parent link
        $link.click(function(e) {
          e.preventDefault();
          
          if ($item.hasClass('open')) {
            $item.removeClass('open');
          } else {
            // Close all other open menus at same level
            $item.siblings('.open').removeClass('open');
            $item.addClass('open');
          }
        });
      }
    });
});