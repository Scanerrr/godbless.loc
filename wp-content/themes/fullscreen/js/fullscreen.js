jQuery(document).ready(function(){

// Fade
    jQuery(".thumbs img").fadeTo("slow", 0.3); // This sets the opacity of the thumbs to fade down to 60% when the page loads
    jQuery(".thumbs img").hover(function(){
        jQuery(this).stop().fadeTo("slow", 1.0); // This sets 100% on hover
    },function(){
        jQuery(this).stop().fadeTo("slow", 0.3); // This should set the opacity back to 30% on mouseout
    });

// Slide - keyboard arrow keys scrolling
jQuery(document).keydown(function(e) { 
   var screen_width = jQuery(window).width();
   var thumbs_width = jQuery(".thumbs").width();
//right arrow key
if(e.keyCode == 39 && (thumbs_width > screen_width)) {    	 		jQuery(".thumbs").stop().animate({left:'-'+(parseFloat(jQuery(".thumbs").width())-parseFloat(jQuery(window).width()))+'px'},{queue:false,duration:300});  
		    jQuery('.go-right').fadeTo('slow', 0.40);
		    jQuery('.go-left').show();
		    jQuery('.go-left').fadeTo('slow', 1.0);
		    return false; 
		}
	    });

jQuery(document).keydown(function(e) {
   var screen_width = jQuery(window).width();
   var thumbs_width = jQuery(".thumbs").width(); 
	//left arrow key
	if(e.keyCode == 37 && (thumbs_width > screen_width)) {
	    jQuery(".thumbs").stop().animate({left:'0'},{queue:false,duration:300});
	    jQuery('.go-left').fadeTo('slow', 0.40);
	    jQuery('.go-right').show();
	    jQuery('.go-right').fadeTo('slow', 1.0);
	    return false;
		}
    });

// Display nav arrow if there are more images        
jQuery('.thumbs').ready(function() {
   var screen_width = jQuery(window).width();
   var thumbs_width = jQuery(".thumbs").width();
   if( screen_width > thumbs_width ) { jQuery('.go-right').hide(); }
	
 });

 				
// Slide
	jQuery('.go-right').click(function() {	 		jQuery(".thumbs").stop().animate({left:'-'+(parseFloat(jQuery(".thumbs").width())-parseFloat(jQuery(window).width()))+'px'},{queue:false,duration:300});  
	    jQuery(this).fadeTo('slow', 0.20);
	    jQuery('.go-left').show();
	    jQuery('.go-left').fadeTo('slow', 1.0);
	    return false;
    });
    jQuery('.go-left').click(function() {
	    jQuery(".thumbs").stop().animate({left:'0'},{queue:false,duration:300});
	    jQuery(this).fadeTo('slow', 0.20);
	    jQuery('.go-right').show();
	    jQuery('.go-right').fadeTo('slow', 1.0);
	    return false;
    });

// Scroll
    jQuery('.thumbs').mousedown(function (event) {
        jQuery(this)
            .data('down', true)
            .data('x', event.clientX)
            .data('scrollLeft', this.scrollLeft);
            
        return false;
    }).mouseup(function (event) {
        jQuery(this).data('down', false);
    }).mousemove(function (event) {
        if (jQuery(this).data('down') == true) {
            this.scrollLeft = jQuery(this).data('scrollLeft') + jQuery(this).data('x') - event.clientX;
        }
    }).mousewheel(function (event, delta) {
        this.scrollLeft -= (delta * 30);
    }).css({
        'overflow' : 'hidden',
        'cursor' : '-moz-grab'
    });
});

jQuery(window).mouseout(function (event) {
    if (jQuery('.home-thumbs').data('down')) {
        try {
            if (event.originalTarget.nodeName == 'BODY' || event.originalTarget.nodeName == 'HTML') {
                jQuery('.home-thumbs').data('down', false);
            }                
        } catch (e) {}
    }

jQuery("#dialog").dialog({
	autoOpen: false,
	modal: true,
	width: 600,
	height: 400,
	buttons: {
		close: function() { 
			jQuery(this).dialog("close"); 
		} 
	}
});

jQuery("#dialog_link").click(function(){
	jQuery("#dialog").dialog("open");
	return false;
});
});

jQuery(document).ready(function(){

jQuery("ul.sf-menu").supersubs({ 
	minWidth:    12,
	maxWidth:    27,
	extraWidth:  1
	}).superfish({
		delay:       500,
		animation:   {opacity:"show",height:"show"},
		speed:       "fast",
		autoArrows:  true,
		dropShadows: true
	});

});