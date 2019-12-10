/**
 * File to handle fixed top menu.
 */
document.addEventListener( "DOMContentLoaded", function() { // Make sure the DOMContent is loaded first (WP admin bar loads late)

	var lastScroll = 0;
	var adminBar = document.getElementById( 'wpadminbar' );
	var topMenu = document.getElementById( 'site-header' );

	// Offset the page (body) by the height of the topMenu
	if ( adminBar ) {
		document.body.style.marginTop = ( topMenu.offsetHeight + 32 ) + "px";
		topMenu.style.top = '32px';
	} else {
		document.body.style.marginTop = topMenu.offsetHeight + "px";
	}
	
	// As we scroll down, hide the top menu
	window.onscroll = function() {

		var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

		if ( scrollTop > lastScroll && scrollTop > topMenu.offsetHeight ) { // Scroll DOWN = hide

			topMenu.style.top = '-200px';

		} else { // Scroll UP = show

			if ( ! adminBar ) {
				topMenu.style.top = '0';
			} else {
				topMenu.style.top = '32px';
			}

		}

		lastScroll = scrollTop <= 0 ? 0 : scrollTop;

	}

}, false );
