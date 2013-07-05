<?php

function get_latest_tweet($currentUser) {
    session_start();
    require_once("../../../plugins/twitteroauth-master/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
    
    $twitteruser = $currentUser;
    $notweets = 30;
    $consumerkey = "vuSdazrx1adO29uiJQ5TsQ";
    $consumersecret = "FVbuk07uWG1AbPJGPqxqGsRLLcWlQ7OB3HTHdHw";
    $accesstoken = "1356308496-7G0brU2g3sCaUHquPYW3kvqg26NHOrlhmGJUaCG";
    $accesstokensecret = "Dn7QBexjJMbBl29TWHYlxCSTjfr8J4gWEpHaryMw";
    
    function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
      $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
      return $connection;
    }
    
    $connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
    
    $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
    
    echo json_encode($tweets);
}

$currentUser = $_GET['currentUser'];
get_latest_tweet($currentUser);

?>