jQuery.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);
  if (this.length) {
    callback.call(this, args);
  }
  return this;
};

/*! .isOnScreen() returns bool */
jQuery.fn.isOnScreen = function(){

    var win = jQuery(window);

    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};

/*----------------------------------------------------
/* Header Search
/*---------------------------------------------------*/
jQuery(document).ready(function($){
    var $header = $('#header');
    var $input = $header.find('.hideinput, .header-search .fa-search');
    $header.find('.fa-search').hover(function(e){
        $input.addClass('active').focus();
    }, function() {
       
    });
    $('.header-search .hideinput').click(function(e) {
        e.stopPropagation();
    });
}).click(function(e) {
    jQuery('#header .hideinput, .header-search .fa-search').removeClass('active');
});

jQuery(document).ready(function($){
    $('.header-search .fa-search').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
});

/*----------------------------------------------------
/* Scroll to top
/*--------------------------------------------------*/
jQuery(document).ready(function($) {
  //move-to-top arrow
  jQuery("body").prepend("<a href='#' id='move-to-top' class='animate to-top'><i class='fa fa-angle-up'></i></a>");
  var scrollDes = 'html,body';  
  /*Opera does a strange thing if we use 'html' and 'body' together so my solution is to do the UA sniffing thing*/
  if(navigator.userAgent.match(/opera/i)){
    scrollDes = 'html';
  }
  //show ,hide
  jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 160) {
      jQuery('#move-to-top').addClass('filling').removeClass('hiding');
    } else {
      jQuery('#move-to-top').removeClass('filling').addClass('hiding');
    }
  });
  // scroll to top when click 
  jQuery('#move-to-top').click(function(e) {
        e.preventDefault();
    jQuery(scrollDes).animate({ 
      scrollTop: 0
    },{
      duration :500
    });
  });
});

/*----------------------------------------------------
/* Responsive Navigation
/*--------------------------------------------------*/
if (mts_customscript.responsive && mts_customscript.nav_menu != 'none') {
    jQuery(document).ready(function($){
        // merge if two menus exist
       
            var menu_wrapper = $('#'+'navigation')
                .clone().attr('class', 'mobile-menu ' + mts_customscript.nav_menu)
                .wrap('<div id="mobile-menu-wrapper" />').parent().hide()
                .appendTo('body');
        
    
        $('.toggle-mobile-menu').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#mobile-menu-wrapper').show();
            $('body').toggleClass('mobile-menu-active');
        });
        
        // prevent propagation of scroll event to parent
        $(document).on('DOMMouseScroll mousewheel', '#mobile-menu-wrapper', function(ev) {
            var $this = $(this),
                scrollTop = this.scrollTop,
                scrollHeight = this.scrollHeight,
                height = $this.height(),
                delta = (ev.type == 'DOMMouseScroll' ?
                    ev.originalEvent.detail * -40 :
                    ev.originalEvent.wheelDelta),
                up = delta > 0;
        
            var prevent = function() {
                ev.stopPropagation();
                ev.preventDefault();
                ev.returnValue = false;
                return false;
            }
        
            if (!up && -delta > scrollHeight - height - scrollTop) {
                // Scrolling down, but this will take us past the bottom.
                $this.scrollTop(scrollHeight);
                return prevent();
            } else if (up && delta > scrollTop) {
                // Scrolling up, but this will take us past the top.
                $this.scrollTop(0);
                return prevent();
            }
        });
    }).click(function() {
        jQuery('body').removeClass('mobile-menu-active');
    });
}
/*----------------------------------------------------
/* Remove active state for nav links which uses #
/*--------------------------------------------------*/
jQuery(document).ready(function($){
    jQuery('.primary-navigation .menu-item').each(function() {
        var $this = jQuery(this);
        if ($this.find('a').first().attr('href').indexOf("#") != -1) {
            $this.removeClass('current-menu-item');
        }
    });
});

/*----------------------------------------------------
/* Smooth scroll
/*--------------------------------------------------*/
jQuery(document).ready(function($) { 
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
    });
});

/*----------------------------------------------------
/*  Dropdown menu
/* ------------------------------------------------- */
jQuery(document).ready(function($) { 
  $('#navigation ul.sub-menu, #navigation ul.children').hide(); // hides the submenus in mobile menu too
  $('#navigation li').hover( 
    function() {
      $(this).children('ul.sub-menu, ul.children').slideDown('fast');
    }, 
    function() {
      $(this).children('ul.sub-menu, ul.children').hide();
    }
  );
});

/*---------------------------------------------------
/*  Vertical ( widget ) menus/lists
/* -------------------------------------------------*/
jQuery(document).ready(function($) {

    $('.widget_nav_menu, .widget_product_categories, .widget_pages').addClass('toggle-menu');
    $('.toggle-menu ul.sub-menu, .toggle-menu ul.children').addClass('toggle-submenu');
    $('.toggle-menu .current-menu-item, .toggle-menu .current-cat, .toggle-menu .current_page_item').addClass('toggle-menu-current-item');
    $('.toggle-menu .menu-item-has-children, .toggle-menu .cat-parent, .toggle-menu .page_item_has_children').addClass('toggle-menu-item-parent');

    $('.toggle-menu').each(function() {
        var $this = $(this);

        $this.find('.toggle-submenu').hide();

        $this.find('.toggle-menu-current-item').last().parents('.toggle-menu-item-parent').addClass('active').children('.toggle-submenu').show();
        $this.find('.toggle-menu-item-parent').append('<span class="toggle-caret"><i class="fa fa-angle-down"></i></span>');
    });
    

    $('.toggle-caret').click(function(e) {
        e.preventDefault();
        $(this).parent().toggleClass('active').children('.toggle-submenu').slideToggle('fast');
    });
});

/*----------------------------------------------------
/* Crossbrowser input placeholder fix
/*---------------------------------------------------*/
jQuery(document).ready(function($){
    $(function() {
        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    });
});