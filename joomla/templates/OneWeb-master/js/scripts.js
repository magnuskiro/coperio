/* Author:
Seth Warburton | @nternetinspired
*/

jQuery(document).ready(function(){

	// Prevent iOS from zooming onfocus
	// http://nerd.vasilis.nl/prevent-ios-from-zooming-onfocus/
	
	MBP.viewportMeta = jQuery('meta[name="viewport"]');
	MBP.preventZoom = function () {
	  jQuery('input, select, textarea').bind('focus blur', function(event) {
		MBP.viewportMeta.attr('content', 'width=device-width,initial-scale=1,maximum-scale=' + (event.type == 'blur' ? 10 : 1));
	  });
	};

});