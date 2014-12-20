$j(document).ready(function() {
    
    // Create month names array
    var m_names = new Array("January", "February", "March", 
    "April", "May", "June", "July", "August", "September", 
    "October", "November", "December");
    
    // Format dates from json data
    var formatDate = function(date) {
        
        var d = new Date(date);
        var day = d.getDate();
        var month = d.getMonth();
        var year = d.getFullYear();
        var dateFormatted = m_names[month].substr(0,3) + ' ' + day;
        
        return dateFormatted;
        
    };
    
    // Label the band "On Tour" if tour dates available
    var showTourDatesManual = function(onTour, currentBand, tourDates) {
        
        if( onTour === true ){
            
            // Un-hide tour column
            $j('body.artists .tour').show();
            
            var data = '<p>' + tourDates + '</p>';
            
            // // Append tour dates list to Tour Column
            $j('body.artists .tour').append(data);
        }
        
    };
    
    var showTourDatesFeed = function(feeds, currentBand) {
        
        // Only show Tour Column if "On Tour"
        // Check manually if error or no results
        if( feeds.errors ){
            
            // Check for manually added tour dates
            tourDatesManualCheck(showTourDatesManual, currentBand, currentID);
            
        } else if( feeds.length > 1 ){
            
            // Un-hide tour column
            $j('body.artists .tour').show();
            
            var data = '<ul>';
            
            for (var i=0; i<feeds.length; i++) {
                
                var date = feeds[i].datetime;
                var dateFormatted = formatDate(date);
                var location = feeds[i].formatted_location;
                var venue = feeds[i].venue.name;
                
                data += '<li>' + dateFormatted + ' ' + venue + ' ' + location + '</li>';
            }
            
            data += '</ul>';
            
            // Append tour dates list to Tour Column
            $j('body.artists .tour').append(data);
        } else {
            
            // Check for manually added tour dates
            tourDatesManualCheck(showTourDatesManual, currentBand, currentID);
        }
        
    };
    
    tourDatesFeed(showTourDatesFeed, currentBand);
});