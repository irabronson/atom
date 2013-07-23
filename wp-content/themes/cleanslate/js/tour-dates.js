// Request tour dates from Band in Town API
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

// Check for manually added tour dates
var tourDatesManualCheck = function(callback, currentBand, currentID) {
    
    var tourDatesManualRequestURL = templateDirectoryUrl + '/php/get-tour-dates-manual.php';
    
    $j.getJSON(tourDatesManualRequestURL, {
        id : currentID
    }, function(data) {
        
        var onTour = false;
        
        if( data ){
            onTour = true;
        }
        
        callback(onTour, currentBand, data);
        
    }).error(function(jqXHR, textStatus, errorThrown) {
        alert(textStatus + " - " + errorThrown);
    });
    
};