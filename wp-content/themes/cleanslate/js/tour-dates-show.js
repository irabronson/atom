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
            
            // Add column for Tour
            insertTourColumn();
            
            var data = '<ul>';
            
            // Using tourDates array passed as argument
            // Cycle through manually added tour dates
            for (var i=0; i<tourDates.length; i++) {
                var tourDate = tourDates[i]['tour_date'];
                var tourLocation = tourDates[i]['tour_location'];
                    
                data += '<li class="tour-date">' + tourDate + '</li>'
                data += '<li class="tour-location">' + tourLocation + '</li>';
                
            }
            
            data += '</ul>';
            
            // Append tour dates list to Tour Column
            $j('body.artists .tour').append(data);
        }
        
    };
    
    var showTourDatesFeed = function(feeds, currentBand) {
        
        // Only Tour Column if "On Tour"
        if( feeds.length > 1 ){
            
            // Add column for Tour
            insertTourColumn();
            
            var data = '<ul>';
            
            for (var i=0; i<feeds.length; i++) {
                
                var date = feeds[i].datetime;
                var dateFormatted = formatDate(date);
                var location = feeds[i].formatted_location;
                
                data += '<li class="tour-date">' + dateFormatted + '</li>'
                data += '<li class="tour-location">' + location + '</li>';
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