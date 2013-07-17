//JQuery Twitter Feed. Coded by Tom Elliott @ www.webdevdoor.com (2013) based on https://twitter.com/javascripts/blogger.js
//Requires JSON output from authenticating script: http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/

var twitterFeed = function(getTweetsURL, currentProfile, noOfTweets) {
    
    $j(document).ready(function () {
        var displaylimit = noOfTweets;
        var twitterprofile = currentProfile;
        var showdirecttweets = true;
        var showretweets = false;
        var showtweetlinks = false;
        var showprofilepic = false;
        var showretweetindicator = false;
        
        var loadingHTML = '';
        
        loadingHTML += '<div id="loading-container">Loading...</div>';
        
        $j('#twitter-feed').html(loadingHTML);
        
        var tweetsRequestUrl = getTweetsURL + '?currentUser=' + currentProfile;
        
        $j.getJSON(tweetsRequestUrl, 
            function(feeds) {   
               // alert(feeds);
                var feedHTML = '';
                var displayCounter = 1;         
                for (var i=0; i<feeds.length; i++) {
                    var tweetscreenname = feeds[i].user.name;
                    var tweetusername = feeds[i].user.screen_name;
                    var profileimage = feeds[i].user.profile_image_url_https;
                    var status = feeds[i].text; 
                    var isaretweet = false;
                    var isdirect = false;
                    var tweetid = feeds[i].id_str;

                    //If the tweet has been retweeted, get the profile pic of the tweeter
                    if(typeof feeds[i].retweeted_status != 'undefined'){
                       profileimage = feeds[i].retweeted_status.user.profile_image_url_https;
                       tweetscreenname = feeds[i].retweeted_status.user.name;
                       tweetusername = feeds[i].retweeted_status.user.screen_name;
                       tweetid = feeds[i].retweeted_status.id_str;
                       status = feeds[i].retweeted_status.text; 
                       isaretweet = true;
                     };


                     //Check to see if the tweet is a direct message
                     if (feeds[i].text.substr(0,1) == "@") {
                         isdirect = true;
                     }

                    // console.log(feeds[i]);

                     //Generate twitter feed HTML based on selected options
                     if (((showretweets == true) || ((isaretweet == false) && (showretweets == false))) && ((showdirecttweets == true) || ((showdirecttweets == false) && (isdirect == false)))) { 
                        if ((feeds[i].text.length > 1) && (displayCounter <= displaylimit)) {
                            
                            if (showtweetlinks == true) {
                                status = addlinks(status);
                            }
                            
                            feedHTML += '<div class="twitter-article">';                                                          
                            
                            feedHTML += '<div class="twitter-text"><p><span class="tweet-time"><a href="https://twitter.com/'+tweetusername+'/status/'+tweetid+'" target="_blank"></a></span><br/>'+status+'</p>';

                            if ((isaretweet == true) && (showretweetindicator == true)) {
                                feedHTML += '<div id="retweet-indicator"></div>';
                            }
                            
                            feedHTML += '</div>';
                            
                            if (displayCounter === feeds.length) {
                                feedHTML += '<div class="tweetprofilelink">Follow <a href="https://twitter.com/'+tweetusername+'" target="_blank">@'+tweetusername+'</a></div>';
                            }
                            
                            feedHTML += '</div>';
                            
                            displayCounter++;
                        }   
                     }
                }
                
                $j('#twitter-feed').html(feedHTML);
                
        }).error(function(jqXHR, textStatus, errorThrown) {
            if (errorThrown == "Not Found") {
                errorThrown = "not found: tweets php script";
            }
           alert(textStatus + " - " + errorThrown);
        });


        //Function modified from Stack Overflow
        function addlinks(data) {
            //Add link to all http:// links within tweets
             data = data.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
                return '<a href="'+url+'" >'+url+'</a>';
            });

            //Add link to @usernames used within tweets
            data = data.replace(/\B@([_a-z0-9]+)/ig, function(reply) {
                return '<a href="http://twitter.com/'+reply.substring(1)+'" style="font-weight:lighter;" target="_blank">'+reply.charAt(0)+reply.substring(1)+'</a>';
            });
            //Add link to #hastags used within tweets
            data = data.replace(/\B#([_a-z0-9]+)/ig, function(reply) {
                return '<a href="https://twitter.com/search?q='+reply.substring(1)+'" style="font-weight:lighter;" target="_blank">'+reply.charAt(0)+reply.substring(1)+'</a>';
            });
            return data;
        }
        
    });
    
};