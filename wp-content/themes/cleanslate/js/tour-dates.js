//JQuery Twitter Feed. Coded by Tom Elliott @ www.webdevdoor.com (2013) based on https://twitter.com/javascripts/blogger.js
//Requires JSON output from authenticating script: http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/
var tourDatesFeed = function(callback, currentBand) {
    
    var band = currentBand;
    var appID = 'AtomAplitterPR';
    var tourDatesRequestURL = 'http://api.bandsintown.com/artists/' + band + '/events.json?api_version=2.0&app_id=' + appID + '&callback=?';
    
    $j.getJSON(tourDatesRequestURL, function(feeds) {
        
        callback(feeds, currentBand);
        
    }).error(function(jqXHR, textStatus, errorThrown) {
        alert(textStatus + " - " + errorThrown);
    });
    
};

// Insert Tour Column HTML when tour dates are available
var insertTourColumn = function() {
    var tourColumn = '<!-- Tour Dates Column -->';
    tourColumn += '<div class="tour column">';
    tourColumn += '<!-- Header -->';
    tourColumn += '<h3>Tour</h3>';
    tourColumn += '</div>';
    
    $j(document).ready(function() {
        $j('body.artists .secondary .column').last().after(tourColumn);
    });
};

// Check for manually added tour dates
var tourDatesManualCheck = function(callback, currentBand, currentID) {
    
    var tourDatesManualRequestURL = templateDirectoryUrl + '/php/get-tour-dates-manual.php';
    
    $j.getJSON(tourDatesManualRequestURL, {
        id : currentID
    }, function(data) {
        
        var onTour = false;
        
        if( data.length > 0 ){
            onTour = true;
        }
        
        callback(onTour, currentBand, data);
        
    }).error(function(jqXHR, textStatus, errorThrown) {
        alert(textStatus + " - " + errorThrown);
    });
    
};