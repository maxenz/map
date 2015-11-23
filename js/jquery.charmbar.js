/**
*
* Charming Bar - Charm Bar Plugin
* URL: http://grimmdev.com
* Version: 1.0
* Author: Grimmdev
* Author URL: http://www.grimmdev.com
*
*/

(function($) {
  $.fn.charmbar = function(options) {
		var defaults = {
			bg: "rgb(18,18,18)",
			time: 600
		};
		var options = $.extend(defaults, options);
	var sh = ($(window).height() - 500) / 2;
	var cp = 0;
    // the plugin functionality goes in here
	$(this).append('<div class="placeholder"></div>');
	$('div.placeholder').append('<div class="charmbar"></div>');
	$('div.charmbar').append('<div class="charmcontainer"></div>');
	$('div.charmcontainer').css('margin-top',sh);
	$('div.charmcontainer').append('<a href="#" id="MOVILES" class="o1"></a>');
	$('div.charmcontainer').append('<a href="#" id="INCIDENTES" class="o2"></a>');
	$('div.charmcontainer').append('<a href="#" id="BASES OPERATIVAS" class="o3"></a>');
	$('div.charmcontainer').append('<a href="#" id="PERFILES" class="o5"></a>');
	$('div.charmcontainer').append('<a href="#" id="OTROS" class="o6"></a>');
	$('div.charmcontainer').append('<a href="#" id="HERRAMIENTAS" class="o4"></a>');
	$('div.charmcontainer a').each(function(index) { $(this).css('top',cp); cp += 85; });
	$('div.charmbar').css('background',options.bg);
	$("div.placeholder").hover(
  function () {
    $('div.charmbar').stop().animate({ right: 0 },options.time);
		$('div.charmbar a').each(function(index){
        $(this).stop().delay(50*index).animate({ right: 0 },500);}); 
  },
  function () {
    $('div.charmbar').stop().animate({ right: '-85px'},options.time);
		$('div.charmbar a').each(function(index){
        $(this).stop().delay(50*index).animate({right: '-85px' },500);});
  });
  }
})(jQuery);