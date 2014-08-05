jQuery(document).ready(function() {
	$("a").filter(function() {
        return this.hostname && this.hostname.replace('www.','') !== location.hostname.replace('www.','');
    }).attr('target', '_blank');
	
	
	var $j = jQuery.noConflict();

$j(document).ready(function() { //external attribute
    $j("a:not([@href*=http://www.google.com/])").not("[href^=#]")
    .addClass("external")
    .attr({ target: "_blank" });
});
});