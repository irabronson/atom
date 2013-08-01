// Homepage function to trigger On Tour Labelling
$j(document).ready(function() {
    
    // Start artists array
    var artists = new Array();
    
    var onTourCount = 0;
    
    var artistsCount = 1;
    
    // Label the band if on tour
    var labelOnTour = function(onTour, currentBand) {
        
        var artistSelector = '.artist[data-band="' + currentBand + '"]';
        
        // Add .on-tour class to bands on tour
        if( onTour === true ){
            $j(artistSelector).addClass('on-tour');
            
            onTourCount++;
        }
        
        // If there is an "On Tour" symbol,
        // Show it the first time there is a band on tour
        if( $j('body.home .on-tour-symbol').length > 0 && onTourCount === 1 ) {
            $j('body.home .on-tour-symbol').show();
        }
        
        // At the end of the Artists elements in page
        if( $j('.artist').length === artistsCount ) {
            
            // Applies to On Tour Slideshow using Cycle plugin
            if( $j('#on-tour-slideshow').length > 0 ) {
                startTourSlideshow();
            }
        }
        
        artistsCount++;
    };
    
    // Success callback for tourDatesFeed() function
    var tourDatesFeedCheck = function(feeds, currentBand) {
        
        // If have tour dates, set onTour to true
        if( feeds.length > 1 ) {
            
            var onTour = true;
            
            labelOnTour(onTour, currentBand);
            
        } else {
            // Check for manually added tour dates
            var currentID = artists[currentBand]['id'];
            tourDatesManualCheck(labelOnTour, currentBand, currentID);
        }
        
    };
    
    // Check if a band is On Tour
    var checkOnTour = function() {
        
        $j('.artist').each(function() {
            
            // Set band variable
            var currentBand = $j(this).attr('data-band');
            var currentID = $j(this).attr('data-id');
            
            // Set Artist Post ID
            artists[currentBand] = {
                id: currentID
            };
            
            // Run external function with tourDatesCheck as callback
            tourDatesFeed(tourDatesFeedCheck, currentBand);
            
        });
    };
    
    // Only runs on the home, artists and about page
    checkOnTour();
    
});