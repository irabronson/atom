var startTourSlideshow = function() {
    
    // Remove null elements
    $j.each($j('#on-tour-slideshow .artist'), function() {
        if ( $j(this).hasClass('on-tour') ) {
            // do nothing
        } else {
            $j(this).remove();
        }
    });
    
    // Start Cycle slideshow
    $j('#on-tour-slideshow').cycle({
        fx:       'fade',
        speed:    500,
        timeout:  4000,
        after:     function() {
            
            // Remove old caption
            $j('#slideshow-caption .current').remove();
            
            // Insert new caption and Fade In
            $j('#slideshow-caption').append('<p class="next"></p>');
            $j('#slideshow-caption .next').hide().html(this.alt).fadeIn(500);
            
            // Update new caption to old caption and Fade Out
            // This is directly based on the speed and timeout settings above
            $j('#slideshow-caption .next').addClass('current').removeClass('next').delay(3500).fadeOut();
        }
    });
    
    // Initially was hidden in CSS
    $j('#on-tour-slideshow-container').css('visibility', 'visible');
    
};