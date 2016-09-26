/*----------------------------------------------------
/*  Dropdown menu
/* ------------------------------------------------- */
jQuery(document).ready(function($) {
    
    function mtsDropdownMenu() {
        var wWidth = $(window).width();
        if(wWidth > 865) {
            $('#navigation ul.sub-menu, #navigation ul.children').hide();
            var timer;
            var delay = 100;
            $('#navigation li').hover( 
              function() {
                var $this = $(this);
                timer = setTimeout(function() {
                    $this.children('ul.sub-menu, ul.children').slideDown('fast');
                }, delay);
                
              },
              function() {
                $(this).children('ul.sub-menu, ul.children').hide();
                clearTimeout(timer);
              }
            );
        } else {
            $('#navigation li').unbind('hover');
            $('#navigation li.active > ul.sub-menu, #navigation li.active > ul.children').show();
        }
    }

    mtsDropdownMenu();

    $(window).resize(function() {
        mtsDropdownMenu();
    });
});

jQuery(document).ready(function($) {
	// Create the dropdown base
   $("<select />").appendTo("#navigation");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("#navigation select");
      
      // Populate dropdown with menu items
      $("#navigation > ul > li:not([data-toggle])").each(function() {
      
      	var el = $(this);
      
      	var hasChildren = el.find("ul"),
      	    children    = el.find("li > a");
       
      	if (hasChildren.length) {
      	
      		$("<optgroup />", {
      			"label": el.find("> a").text()
      		}).appendTo("#navigation select");
      		
      		children.each(function() {
      		      			
      			$("<option />", {
					"value"   : $(this).attr("href"),
      				"text": " - " + $(this).text()
      			}).appendTo("optgroup:last");
      		
      		});
      		      	
      	} else {
      	
      		$("<option />", {
	           "value"   : el.find("> a").attr("href"),
	           "text"    : el.find("> a").text()
	       }).appendTo("#navigation select");
      	
      	} 
             
      });
 
      $("#navigation select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	
	//END -- Menus to <SELECT>
}); //END -- JQUERY document.ready

/*----------------------------------------------------
/* Make all anchor links smooth scrolling
/*--------------------------------------------------*/
jQuery(document).ready(function($) {
 // scroll handler
  var scrollToAnchor = function( id, event ) {
    // grab the element to scroll to based on the name
    var elem = $("a[name='"+ id +"']");
    // if that didn't work, look for an element with our ID
    if ( typeof( elem.offset() ) === "undefined" ) {
      elem = $("#"+id);
    }
    // if the destination element exists
    if ( typeof( elem.offset() ) !== "undefined" ) {
      // cancel default event propagation
      event.preventDefault();

      // do the scroll
      // also hide mobile menu
      var scroll_to = elem.offset().top;
      $('html, body').removeClass('mobile-menu-active').animate({
              scrollTop: scroll_to
      }, 600, 'swing', function() { if (scroll_to > 46) window.location.hash = id; } );
    }
  };
  // bind to click event
  $("a").click(function( event ) {
    // only do this if it's an anchor link
    var href = $(this).attr("href");
    if ( href && href.match("#") && href !== '#' ) {
      // scroll to the location
      var parts = href.split('#'),
        url = parts[0],
        target = parts[1];
      if ((!url || url == window.location.href.split('#')[0]) && target)
        scrollToAnchor( target, event );
    }
  });
});
